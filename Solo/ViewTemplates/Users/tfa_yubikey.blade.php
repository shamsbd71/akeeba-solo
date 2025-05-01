<?php
/**
 * @package   solo
 * @copyright Copyright (c)2014-2025 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

use Awf\Text\Text;

defined('_AKEEBA') or die();

/** @var \Solo\View\Users\Html $this */

?>
<div id="tfa_yubikey" style="display: none">
	<p class="akeeba-block--info">
		@lang('SOLO_USERS_TFA_YUBIKEY_INTRO')
	</p>

    <p>
		@lang('SOLO_USERS_TFA_YUBIKEY_SETUP')
	</p>

	<div class="akeeba-form-group">
		<label class="control-label col-sm-2" for="tfa[yubikey]">
			@lang('SOLO_USERS_LBL_TFASECURITYCODE')
		</label>
        <input type="text" name="tfa[yubikey]" class="form-control" value="{{ $tfa['yubikey'] }}">
	</div>
</div>
