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
<div id="tfa_google" style="display: none">
    <p class="akeeba-block--info">
		@lang('SOLO_USERS_TFA_GOOGLE_INTRO')
	</p>

	<h4>@lang('SOLO_USERS_TFA_GOOGLE_LBL_STEP1')</h4>
	<p>
		@lang('SOLO_USERS_TFA_GOOGLE_SETUP1')
	</p>
	<ul>
		<li>
			<a href="http://support.google.com/accounts/bin/answer.py?hl=en&answer=1066447">
				Official Google Authenticator app for Android, iOS and BlackBerry
			</a>
		</li>
		<li>
			<a href="http://en.wikipedia.org/wiki/Google_Authenticator#Implementation">
				Compatible clients for other devices and OS (listed in Wikipedia)
			</a>
		</li>
	</ul>

	<div class="akeeba-block--warning">
		@lang('SOLO_USERS_TFA_GOOGLE_SETUP1_WARNING')
	</div>

	<h4>@lang('SOLO_USERS_TFA_GOOGLE_LBL_STEP2')</h4>
	@lang('SOLO_USERS_TFA_GOOGLE_SETUP2A')
    <table class="akeeba-table--striped">
        <tr>
            <td>
				@lang('SOLO_USERS_TFA_GOOGLE_SETUP2A_ACCOUNT')
            </td>
            <td>
                Akeeba Solo
            </td>
        </tr>
        <tr>
            <td>
				@lang('SOLO_USERS_TFA_GOOGLE_SETUP2A_KEY')
            </td>
            <td>
                <code>{{ $tfa['google'] }}</code>
            </td>
        </tr>
    </table>

    <p>
		@lang('SOLO_USERS_TFA_GOOGLE_SETUP2B')
    </p>
    <img src="https://chart.googleapis.com/chart?chs=200x200&chld=Q|2&cht=qr&chl={{ urlencode('otpauth://totp/Akeeba%20Solo?secret=' . $tfa['google']) }}">

	<h4>@lang('SOLO_USERS_TFA_GOOGLE_LBL_STEP3')</h4>
	<div class="akeeba-form-group">
		<label for="tfa[secret]">
			@lang('SOLO_USERS_LBL_TFASECURITYCODE')
		</label>
        <input type="text" name="tfa[secret]" class="form-control" value="">
	</div>

    <input type="hidden" name="tfa[google]" value="{{ $tfa['google'] }}">
</div>
