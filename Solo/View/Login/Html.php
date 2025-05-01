<?php
/**
 * @package   solo
 * @copyright Copyright (c)2014-2025 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

namespace Solo\View\Login;

use Awf\Mvc\View;

class Html extends View
{
	public $username;
	public $password;
	public $secret;
	public $autologin;

	/**
	 * Executes before displaying the "main" task (initial requirements check page)
	 *
	 * @return  boolean
	 */
	public function onBeforeMain()
	{
		// Present the login in a plain page, no headers, menus, etc.
		$this->container->input->set('tmpl', 'component');

		$this->username  = $this->container->segment->getFlash('auth_username');
		$this->password  = $this->container->segment->getFlash('auth_password');
		$this->secret    = $this->container->segment->getFlash('auth_secret');
		$this->autologin = $this->container->segment->getFlash('auto_login');

		return true;
	}
}
