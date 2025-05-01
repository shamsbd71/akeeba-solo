<?php
/**
 * @package   solo
 * @copyright Copyright (c)2014-2025 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

namespace Solo\View\Users;


use Awf\Mvc\DataView\Html as BaseHtml;
use Awf\Utils\Template;

class Html extends BaseHtml
{
	public $baseFontSize = 0;

	public function onBeforeBrowse()
	{
		$document = $this->container->application->getDocument();

		// Buttons (new, edit, copy, delete)
		$buttons = [
			[
				'title'   => 'SOLO_BTN_ADD',
				'class'   => 'akeeba-btn--green',
				'onClick' => 'akeeba.System.submitForm(\'add\')',
				'icon'    => 'akion-person-add',
			],
			[
				'title'   => 'SOLO_BTN_EDIT',
				'class'   => 'akeeba-btn--grey',
				'onClick' => 'akeeba.System.submitForm(\'edit\')',
				'icon'    => 'akion-edit',
			],
			[
				'title'   => 'SOLO_BTN_DELETE',
				'class'   => 'akeeba-btn--red',
				'onClick' => 'akeeba.System.submitForm(\'remove\')',
				'icon'    => 'akion-trash-b',
			],
		];

		$toolbar = $document->getToolbar();

		foreach ($buttons as $button)
		{
			$toolbar->addButtonFromDefinition($button);
		}

		return parent::onBeforeBrowse();
	}

	protected function onBeforeAdd()
	{
		$this->loadFormJavascript();
		$this->buttonsForAddEdit();

		return parent::onBeforeAdd();
	}

	protected function onBeforeEdit()
	{
		$this->loadFormJavascript();
		$this->buttonsForAddEdit();

		$userManager        = $this->container->userManager;
		$user               = $userManager->getUser($this->getModel()->id);
		$this->baseFontSize = $user->getParameters()->get('accessibility.base_font_size', 11);

		return parent::onBeforeEdit();
	}

	protected function buttonsForAddEdit()
	{
		$buttons = [
			[
				'title'   => 'SOLO_BTN_SAVECLOSE',
				'class'   => 'akeeba-btn--green',
				'onClick' => 'akeeba.System.submitForm(\'save\')',
				'icon'    => 'akion-checkmark',
			],
			[
				'title'   => 'SOLO_BTN_CANCEL',
				'class'   => 'akeeba-btn--orange',
				'onClick' => 'akeeba.System.submitForm(\'cancel\')',
				'icon'    => 'akion-close-circled',
			],
		];

		$toolbar = $this->container->application->getDocument()->getToolbar();

		foreach ($buttons as $button)
		{
			$toolbar->addButtonFromDefinition($button);
		}
	}

	protected function loadFormJavascript()
	{
		Template::addJs('media://js/solo/users.js', $this->container->application);

		$js = <<< JS
akeeba.System.documentReady(function() {
	akeeba.Users.initialize();
});

JS;

		$document = $this->container->application->getDocument();
		$document->addScriptDeclaration($js);
	}
}
