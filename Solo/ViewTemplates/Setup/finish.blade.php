<?php
/**
 * @package   solo
 * @copyright Copyright (c)2014-2025 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

use Awf\Text\Text;

defined('_AKEEBA') or die();

/** @var \Solo\View\Setup\Html $this */

?>
<div class="akeeba-block--failure">
	<h3>
		<span class="akion-alert-circled"></span>
		@lang('SOLO_SETUP_MSG_CONFIGNOTWRITTEN_HEAD')
	</h3>
	<p>
        @lang('SOLO_SETUP_MSG_CONFIGNOTWRITTEN')
    </p>
</div>

<div>
    <p>
		@lang('SOLO_SETUP_LBL_MANUALCONFIGINSTRUCTIONS')
    </p>

    <pre>{{ '&lt;?php die(); ?&gt;' . "\n" . $this->getContainer()->appConfig->toString('JSON', ['pretty_print' => true]) }}</pre>
</div>
