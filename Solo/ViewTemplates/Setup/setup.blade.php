<?php
/**
 * @package   solo
 * @copyright Copyright (c)2014-2025 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

use Solo\Helper\Escape;

defined('_AKEEBA') or die();

$router = $this->getContainer()->router;

/** @var \Solo\View\Setup\Html $this */
?>
@include('CommonTemplates/FTPBrowser')
@include('CommonTemplates/SFTPBrowser')
@include('CommonTemplates/FTPConnectionTest')

<form
        action="{{ \Awf\Uri\Uri::rebase('?view=setup&task=finish', $this->getContainer()) }}" method="post"
        name="setupForm" id="setupForm"
        class="akeeba-form--horizontal" role="form">

    <div class="akeeba-panel--info">
        <header class="akeeba-block-header">
            <h3>
                <span class="akion-ios-gear"></span>
                @lang('SOLO_SETUP_LBL_APPSETUP')
            </h3>
        </header>
        <div>
            <div class="akeeba-form-group">
                <label for="timezone">
                    @lang('SOLO_SETUP_LBL_TIMEZONE')
                </label>
                {{ $this->getContainer()->html->setup->timezoneSelect($this->params['timezone']) }}
                <p class="akeeba-help-text">
                    @lang('SOLO_SETUP_LBL_TIMEZONE_HELP')
                </p>
            </div>

            <div class="akeeba-form-group">
                <label for="live_site">
                    @lang('SOLO_SETUP_LBL_LIVESITE')
                </label>
                <input type="text" name="live_site" id="live_site" value="{{ $this->params['live_site'] }}">
                <p class="akeeba-help-text">
                    @lang('SOLO_SETUP_LBL_LIVESITE_HELP')
                </p>
            </div>

            <div class="akeeba-form-group">
                <label for="session_timeout">
                    @lang('SOLO_SETUP_LBL_SESSIONTIMEOUT')
                </label>
                <input type="text" name="session_timeout" id="session_timeout"
                       value="{{ $this->params['session_timeout'] }}">
                <p class="akeeba-help-text">
                    @lang('SOLO_SETUP_LBL_SESSIONTIMEOUT_HELP')
                </p>
            </div>

            <div class="akeeba-form-group">
                <label for="proxy_host">
                    @lang('COM_AKEEBA_CONFIG_PROXY_HOST_LABEL')
                </label>
                <input type="text" name="proxy_host" id="proxy_host"
                       value="{{ $this->params['proxy_host'] ?? '' }}">
                <p class="akeeba-help-text">
                    @lang('COM_AKEEBA_CONFIG_PROXY_HOST_DESC')
                </p>
            </div>

            <div class="akeeba-form-group">
                <label for="proxy_port">
                    @lang('COM_AKEEBA_CONFIG_PROXY_PORT_LABEL')
                </label>
                <input type="number" min="1" max="65535" name="proxy_port" id="proxy_port"
                       value="{{ ($this->params['proxy_port'] ?? 8080) ?: 8080 }}">
                <p class="akeeba-help-text">
                    @lang('COM_AKEEBA_CONFIG_PROXY_PORT_DESC')
                </p>
            </div>

            <div class="akeeba-form-group">
                <label for="proxy_user">
                    @lang('COM_AKEEBA_CONFIG_PROXY_USER_LABEL')
                </label>
                <input type="text" name="proxy_user" id="proxy_user"
                       value="{{ $this->params['proxy_user'] ?? '' }}">
                <p class="akeeba-help-text">
                    @lang('COM_AKEEBA_CONFIG_PROXY_USER_DESC')
                </p>
            </div>

            <div class="akeeba-form-group">
                <label for="proxy_pass">
                    @lang('COM_AKEEBA_CONFIG_PROXY_PASS_LABEL')
                </label>
                <input type="password" name="proxy_pass" id="proxy_pass"
                       value="{{ $this->params['proxy_pass'] ?? '' }}">
                <p class="akeeba-help-text">
                    @lang('COM_AKEEBA_CONFIG_PROXY_PASS_DESC')
                </p>
            </div>

            <div class="akeeba-form-group">
                <label for="fs_driver">
                    @lang('SOLO_SETUP_LBL_FS_DRIVER')
                </label>
                {{ $this->getContainer()->html->setup->fsDriverSelect($this->params['fs.driver']) }}
                <p class="akeeba-help-text">
                    @lang('SOLO_SETUP_LBL_FS_DRIVER_HELP')
                </p>
            </div>

            <div id="ftp_options">
                <div class="akeeba-form-group">
                    <label for="fs_host">
                        @lang('SOLO_SETUP_LBL_FS_FTP_HOST')
                    </label>
                    <input type="text" name="fs_host" id="fs_host" value="{{ $this->params['fs.host'] }}">
                    <p class="akeeba-help-text">
                        @lang('SOLO_SETUP_LBL_FS_FTP_HOST_HELP')
                    </p>
                </div>

                <div class="akeeba-form-group">
                    <label for="fs_port">
                        @lang('SOLO_SETUP_LBL_FS_FTP_PORT')
                    </label>
                    <input type="text" name="fs_port" id="fs_port" value="{{ $this->params['fs.port'] }}">
                    <p class="akeeba-help-text">
                        @lang('SOLO_SETUP_LBL_FS_FTP_PORT_HELP')
                    </p>
                </div>

                <div class="akeeba-form-group">
                    <label for="fs_username">
                        @lang('SOLO_SETUP_LBL_FS_FTP_USERNAME')
                    </label>
                    <input type="text" name="fs_username" id="fs_username" value="{{ $this->params['fs.username'] }}">
                    <p class="akeeba-help-text">
                        @lang('SOLO_SETUP_LBL_FS_FTP_USERNAME_HELP')
                    </p>
                </div>

                <div class="akeeba-form-group">
                    <label for="fs_password">
                        @lang('SOLO_SETUP_LBL_FS_FTP_PASSWORD')
                    </label>
                    <input type="password" name="fs_password" id="fs_password"
                           value="{{ $this->params['fs.password'] }}">
                    <p class="akeeba-help-text">
                        @lang('SOLO_SETUP_LBL_FS_FTP_PASSWORD_HELP')
                    </p>
                </div>

                <div class="akeeba-form-group">
                    <label for="fs_directory">
                        @lang('SOLO_SETUP_LBL_FS_FTP_DIRECTORY')
                    </label>

                    <input type="text" name="fs_directory" id="fs_directory"
                           value="{{ $this->params['fs.directory'] }}" />

                    <p class="akeeba-help-text">
                        @lang('SOLO_SETUP_LBL_FS_FTP_DIRECTORY_HELP')
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="akeeba-panel--info">
        <header class="akeeba-block-header">
            <h3>
                <span class="akion-person-stalker"></span>
                @lang('SOLO_SETUP_LBL_USERSETUP')
            </h3>
        </header>
        <div>
            <p>@lang('SOLO_SETUP_LBL_USERSETUP_TEXT')</p>

            <div class="akeeba-form-group">
                <label for="user_username">
                    @lang('SOLO_SETUP_LBL_USER_USERNAME')
                </label>
                <div class="col-sm-10">
                    <input type="text" name="user_username" id="user_username"
                           value="{{ $this->params['user.username'] }}">
                    <div class="help-block">
                        @lang('SOLO_SETUP_LBL_USER_USERNAME_HELP')
                    </div>
                </div>
            </div>

            <div class="akeeba-form-group">
                <label for="user_password">
                    @lang('SOLO_SETUP_LBL_USER_PASSWORD')
                </label>
                <input type="password" name="user_password" id="user_password"
                       value="{{ $this->params['user.password'] }}">
                <p class="akeeba-help-text">
                    @lang('SOLO_SETUP_LBL_USER_PASSWORD_HELP')
                </p>
            </div>

            <div class="akeeba-form-group">
                <label for="user_password2">
                    @lang('SOLO_SETUP_LBL_USER_PASSWORD2')
                </label>
                <input type="password" name="user_password2" id="user_password2"
                       value="{{ $this->params['user.password2'] }}">
                <p class="akeeba-help-text">
                    @lang('SOLO_SETUP_LBL_USER_PASSWORD2_HELP')
                </p>
            </div>

            <div class="akeeba-form-group">
                <label for="user_email">
                    @lang('SOLO_SETUP_LBL_USER_EMAIL')
                </label>
                <input type="text" name="user_email" id="user_email" value="{{ $this->params['user.email'] }}">
                <p class="akeeba-help-text">
                    @lang('SOLO_SETUP_LBL_USER_EMAIL_HELP')
                </p>
            </div>

            <div class="akeeba-form-group">
                <label for="user_name">
                    @lang('SOLO_SETUP_LBL_USER_NAME')
                </label>
                <input type="text" name="user_name" id="user_name" value="{{ $this->params['user.name'] }}">
                <p class="akeeba-help-text">
                    @lang('SOLO_SETUP_LBL_USER_NAME_HELP')
                </p>
            </div>

        </div>
    </div>

    <div class="akeeba-form-group--pull-right">
        <div class="akeeba-form-group--actions">
            <button type="submit" id="setupFormSubmit" class="akeeba-btn--primary">
                @lang('SOLO_BTN_SUBMIT')
            </button>
        </div>
    </div>

</form>

<script type="text/javascript" language="javascript">
    // Callback routine to close the browser dialog
    var akeeba_browser_callback = null;

    akeeba.System.documentReady(function ()
    {
        // Push some custom URLs
        akeeba.Setup.URLs['ftpBrowser']  = '{{ Escape::escapeJS($router->route('index.php?view=ftpbrowser')) }}';
        akeeba.Setup.URLs['sftpBrowser'] = '{{ Escape::escapeJS($router->route('index.php?view=sftpbrowser')) }}';
        akeeba.Setup.URLs['testFtp']     =
            '{{ Escape::escapeJS($router->route('index.php?view=configuration&task=testftp')) }}';
        akeeba.Setup.URLs['testSftp']    =
            '{{ Escape::escapeJS($router->route('index.php?view=configuration&task=testsftp')) }}';
    });

</script>
