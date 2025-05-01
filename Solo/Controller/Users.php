<?php
/**
 * @package   solo
 * @copyright Copyright (c)2014-2025 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

namespace Solo\Controller;


class Users extends DataControllerDefault
{
	public function execute($task)
	{
		$inCMS = $this->container->segment->get('insideCMS', false);

		if ($inCMS)
		{
			throw new \RuntimeException('You are not allowed to access this view when Solo is running inside another CMS', 403);
		}

		return parent::execute($task);
	}
}
