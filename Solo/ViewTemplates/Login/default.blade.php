<?php
/**
 * @package   solo
 * @copyright Copyright (c)2014-2025 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

use Awf\Text\Text;

defined('_AKEEBA') or die();

// Used for type hinting
/** @var  \Solo\View\Login\Html  $this */

?>
<div style="height: 100%">
    <form class="akeeba-form--stretch" role="form" action="@route('index.php?view=login&task=login')"
          method="POST" id="loginForm">

        <div class="akeeba-panel--info">
            <header class="akeeba-block-header">
                <h2>
                    @lang('SOLO_LOGIN_PLEASELOGIN')
                </h2>
            </header>

            <div class="akeeba-form-group">
                <input type="text" id="username" name="username" class="form-control" placeholder="@lang('SOLO_LOGIN_LBL_USERNAME')" required autofocus value="{{{ $this->username }}}">
            </div>
            <div class="akeeba-form-group">
                <input type="password" id="password" name="password" class="form-control" placeholder="@lang('SOLO_LOGIN_LBL_PASSWORD')" required value="{{{ $this->password }}}">
            </div>

            @if (!defined('AKEEBADEBUG'))
                <div class="akeeba-form-group">
                    <input type="text" name="secret" class="form-control" placeholder="@lang('SOLO_LOGIN_LBL_SECRETCODE')" value="{{{ $this->secret }}}">
                </div>
            @endif

            <div class="akeeba-form-group--actions">
                <button class="akeeba-btn--primary--block" style="width: 100%" type="submit" id="btnLoginSubmit">
                    <span class="akion-log-in"></span>
                    @lang('SOLO_LOGIN_LBL_LOGIN')
                </button>
            </div>

            <div class="akeeba-hidden-fields-container">
                <input type="hidden" name="token" value="@token()">
            </div>
        </div>

    </form>
</div>

@if ($this->autologin)
<script type="text/javascript">
    akeeba.System.documentReady({
        document.getElementById('loginForm').submit();
    })
</script>
@endif
