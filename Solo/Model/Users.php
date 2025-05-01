<?php
/**
 * @package   solo
 * @copyright Copyright (c)2014-2025 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

namespace Solo\Model;


use Awf\Container\Container;
use Awf\Mvc\DataModel;
use Awf\Text\Language;
use Awf\Text\Text;
use RuntimeException;

class Users extends DataModel
{
	/**
	 * Public constructor
	 *
	 * @param   Container  $container  Configuration parameters
	 */
	public function __construct(?\Awf\Container\Container $container = null, ?Language $language = null)
	{
		$this->tableName   = '#__ak_users';
		$this->idFieldName = 'id';

		parent::__construct($container, $language);

		$this->addBehaviour('filters');
	}

	/**
	 * Prevent the deletion of the default backup profile
	 *
	 * @param   integer  $id  The profile ID which is about to be deleted
	 *
	 * @throws  RuntimeException  When some wise guy tries to delete the default backup profile
	 */
	public function onBeforeDelete($id)
	{
		if ($id == 1)
		{
			throw new RuntimeException(Text::_('SOLO_USERS_ERR_CANNOTDELETEDEFAULT'), 403);
		}
	}

	public function save($data = null, $orderingFilter = '', $ignore = null)
	{
		// Stash the primary key
		$oldPKValue = $this->{$this->idFieldName};

		// Call the onBeforeSave event
		if (method_exists($this, 'onBeforeSave'))
		{
			$this->onBeforeSave($data);
		}

		$this->behavioursDispatcher->trigger('onBeforeSave', [&$this, &$data]);

		// Bind any (optional) data. If no data is provided, the current record data is used
		if (!is_null($data))
		{
			$this->bind($data, $ignore);
		}

		// Is this a new record?
		if (empty($oldPKValue))
		{
			$isNewRecord = true;
		}
		else
		{
			$isNewRecord = $oldPKValue != $this->{$this->idFieldName};
		}

		// Get the user object
		$userManager = $this->container->userManager;
		$user        = $userManager->getUser($this->id);

		// Check the validity of the data
		if (empty($data['username']))
		{
			throw new RuntimeException(Text::_('SOLO_USERS_ERR_NOUSERNAME'), 500);
		}

		if (empty($data['email']))
		{
			throw new RuntimeException(Text::_('SOLO_USERS_ERR_NOEMAIL'), 500);
		}

		if (!empty($data['password']))
		{
			if ($data['password'] != $data['repeatpassword'])
			{
				throw new RuntimeException(Text::_('SOLO_USERS_ERR_NOMATCH'), 500);
			}
		}

		$db    = $this->getDbo();
		$query = $db->getQuery(true)
			->select('COUNT(*)')
			->from($db->qn('#__ak_users'))
			->where($db->qn('username') . ' = ' . $db->q($data['username']))
			->where('NOT(' . $db->qn('id') . ' = ' . $db->q($user->getId()) . ')');
		$db->setQuery($query);

		if ($db->loadResult())
		{
			throw new RuntimeException(Text::_('SOLO_USERS_ERR_USERNAMEEXISTS'), 500);
		}

		$query = $db->getQuery(true)
			->select('COUNT(*)')
			->from($db->qn('#__ak_users'))
			->where($db->qn('email') . ' = ' . $db->q($data['email']))
			->where('NOT(' . $db->qn('id') . ' = ' . $db->q($user->getId()) . ')');
		$db->setQuery($query);

		if ($db->loadResult())
		{
			throw new RuntimeException(Text::_('SOLO_USERS_ERR_EMAILEXISTS'), 500);
		}

		$permissions = [
			'backup'    => in_array($data['permissions']['backup'], ['on', 'yes', 'true', '1']),
			'configure' => in_array($data['permissions']['configure'], ['on', 'yes', 'true', '1']),
			'download'  => in_array($data['permissions']['download'], ['on', 'yes', 'true', '1']),
		];

		if (!$permissions['backup'] && !$permissions['configure'] && !$permissions['download'])
		{
			throw new RuntimeException(Text::_('SOLO_USERS_ERR_NOPERMISSIONS'), 500);
		}

		// Push the new user data
		$user->setEmail($data['email']);
		$user->setName($data['name']);
		$user->setUsername($data['username']);

		if (!empty($data['password']))
		{
			$user->setPassword($data['password']);
		}

		foreach ($permissions as $k => $v)
		{
			$user->setPrivilege('akeeba.' . $k, $v);
		}

		// Handle the TFA stuff
		$tfa = $data['tfa'];

		if (isset($tfa['keep']) && !$tfa['keep'])
		{
			$tfa['method'] = 'none';
		}

		$user->triggerAuthenticationEvent('onTfaSave', $tfa);

		// Do I have to generate new OTEPs?
		$savedTfaMethod = $user->getParameters()->get('tfa.method', '');
		$oteps          = $user->getParameters()->get('tfa.otep', []);

		if ($savedTfaMethod == 'none')
		{
			// Kill OTEPs
			$user->getParameters()->set('tfa.otep', []);
		}
		elseif (empty($oteps))
		{
			$oteps = $this->generateOteps();
			$user->getParameters()->set('tfa.otep', $oteps);
		}

		// Set the preferred base font size
		$baseFontSize = null;

		if (isset($data['base_font_size']) && ($data['base_font_size'] >= 8))
		{
			$baseFontSize = $data['base_font_size'];
		}

		$user->getParameters()->set('accessibility.base_font_size', $baseFontSize);

		// Create/update the user
		$userManager->saveUser($user);

		// Finally, call the onAfterSave event
		if (method_exists($this, 'onAfterSave'))
		{
			$this->onAfterSave();
		}

		$this->behavioursDispatcher->trigger('onAfterSave', [&$this]);

		return $this;
	}

	/**
	 * Generates an arrya of ten random one time emergency passwords
	 */
	protected function generateOteps()
	{
		$oteps = [];

		for ($i = 0; $i < 10; $i++)
		{
			$otep   = '';
			$string = random_bytes(20);

			for ($j = 0; $j < 10; $j++)
			{
				$chunk = substr($string, $j * 2, 2);
				$ints  = unpack('n', $chunk);
				$otep  .= (string) $ints[1];
			}

			$oteps[] = substr($otep, 0, 10);
		}

		return $oteps;
	}
}
