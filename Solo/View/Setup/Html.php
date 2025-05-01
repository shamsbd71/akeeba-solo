<?php
/**
 * @package   solo
 * @copyright Copyright (c)2014-2025 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

namespace Solo\View\Setup;

use Awf\Mvc\View;
use Awf\Text\Text;
use Awf\Uri\Uri;
use Awf\Utils\Template;

class Html extends View
{
	public $reqSettings;
	public $reqMet;
	public $recommendedSettings;
	public $recMet;
	public $params;
	public $connectionParameters;

	/**
	 * Executes before displaying the "main" task (initial requirements check page)
	 *
	 * @return  boolean
	 */
	public function onBeforeMain()
	{
		// Set up the page header and toolbar buttons
		$buttons = [
			[
				'title' => 'SOLO_BTN_NEXT',
				'class' => 'akeeba-btn--teal',
				'url'   => Uri::rebase('?view=setup&task=database', $this->container),
				'icon'  => 'akion-chevron-right',
			],
		];
		$this->setupPageHeader($buttons);

		// Get the model
		/** @var \Solo\Model\Setup $model */
		$model = $this->getModel();

		// Push data from the model
		$this->reqSettings         = $model->getRequired();
		$this->reqMet              = $model->isRequiredMet();
		$this->recommendedSettings = $model->getRecommended();
		$this->recMet              = $model->isRecommendedMet();

		return true;
	}

	public function onBeforeSession()
	{
		Template::addJs('media://js/solo/setup.js', $this->getContainer()->application);

		// Set up the page header and toolbar buttons
		$buttons = [
			[
				'title'   => 'SOLO_BTN_NEXT',
				'class'   => 'akeeba-btn--teal',
				'onClick' => "akeeba.System.triggerEvent('setupFormSubmit', 'click')",
				'icon'    => 'akion-chevron-right',
			],
		];
		$this->setupPageHeader($buttons);

		// Get the model
		/** @var \Solo\Model\Setup $model */
		$model = $this->getModel();

		$this->params = $model->getSetupParameters();

		return true;
	}

	public function onBeforeDatabase()
	{
		Template::addJs('media://js/solo/setup.js', $this->getContainer()->application);

		// Set up the page header and toolbar buttons
		$buttons = [
			[
				'title' => 'SOLO_BTN_PREV',
				'class' => 'akeeba-btn--grey',
				'url'   => Uri::rebase('?view=setup', $this->container),
				'icon'  => 'akion-chevron-left',
			],
			[
				'title'   => 'SOLO_BTN_NEXT',
				'class'   => 'akeeba-btn--teal',
				'onClick' => "akeeba.System.triggerEvent('dbFormSubmit', 'click')",
				'icon'    => 'akion-chevron-right',
			],
		];
		$this->setupPageHeader($buttons);

		// Get the model
		/** @var \Solo\Model\Setup $model */
		$model = $this->getModel();

		// Push data from the model
		$this->connectionParameters = $model->getDatabaseParameters();

		return true;
	}

	public function onBeforeSetup()
	{
		Template::addJs('media://js/solo/setup.js', $this->getContainer()->application);

		// Set up the page header and toolbar buttons
		$buttons = [
			[
				'title' => 'SOLO_BTN_PREV',
				'class' => 'akeeba-btn--grey',
				'url'   => Uri::rebase('?view=database', $this->container),
				'icon'  => 'akion-chevron-left',
			],
			[
				'title'   => 'SOLO_BTN_NEXT',
				'class'   => 'akeeba-btn--teal',
				'onClick' => "akeeba.System.triggerEvent('setupFormSubmit', 'click')",
				'icon'    => 'akion-chevron-right',
			],
		];
		$this->setupPageHeader($buttons);

		// Get the model
		/** @var \Solo\Model\Setup $model */
		$model    = $this->getModel();
		$document = $this->getContainer()->application->getDocument();

		$this->params = $model->getSetupParameters();

		// JavaScript language strings
		$doc = $this->container->application->getDocument();
		$doc->lang('SOLO_COMMON_LBL_ROOT');
		$doc->lang('COM_AKEEBA_CONFIG_DIRECTFTP_TEST_OK');
		$doc->lang('COM_AKEEBA_CONFIG_DIRECTFTP_TEST_FAIL');
		$doc->lang('COM_AKEEBA_CONFIG_DIRECTSFTP_TEST_OK');
		$doc->lang('COM_AKEEBA_CONFIG_DIRECTSFTP_TEST_FAIL');

		return true;
	}

	/**
	 * Set up the page header
	 *
	 * @param   array  $buttons  An array of button definitions to add to the toolbar
	 *
	 * @return void
	 */
	private function setupPageHeader($buttons = [])
	{
		$toolbar = $this->container->application->getDocument()->getToolbar();
		$toolbar->setTitle('SOLO_SETUP_TITLE');

		if (!empty($buttons))
		{
			foreach ($buttons as $button)
			{
				$toolbar->addButtonFromDefinition($button);
			}
		}
	}
}
