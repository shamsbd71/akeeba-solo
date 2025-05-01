<?php
/**
 * @package   solo
 * @copyright Copyright (c)2014-2025 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

defined('_AKEEBA') or die();

/** @var   \Solo\View\Setup\Html $this */

$sessionPath = $this->getContainer()->session->getSavePath();
$error       = $this->getContainer()->input->get('error', null, 'base64');

if (!empty($error))
{
	$error = base64_decode($error);
}
else
{
	$error = null;
}

?>
<div class="akeeba-block--warning">
    <h3>
        @lang('SOLO_SETUP_SESSION_LBL_WARNING_HEADER')
    </h3>
    <p>
        @sprintf('SOLO_SETUP_SESSION_LBL_WARNING_BODY', $sessionPath)
    </p>
</div>

@if (!is_null($error))
    <div class="akeeba-block--failure">
        <h3>
            @lang('SOLO_SETUP_SESSION_LBL_ERROR_HEADER')
        </h3>
        <p>
            {{ $error }}
        </p>
    </div>
@endif

<form action="@route('index.php?view=setup&task=savesession')" method="post" role="form"
      class="akeeba-form--horizontal">
    <div class="akeeba-form-group">
        <label for="fs_driver">
            @lang('SOLO_SETUP_LBL_FS_DRIVER')
        </label>
        {{ $this->getContainer()->html->setup->fsDriverSelect( $this->params['fs.driver'], false) }}
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
            <input type="password" name="fs_password" id="fs_password" value="{{ $this->params['fs.password'] }}">
            <p class="akeeba-help-text">
                @lang('SOLO_SETUP_LBL_FS_FTP_PASSWORD_HELP')
            </p>
        </div>

        <div class="akeeba-form-group">
            <label for="fs_directory">
                @lang('SOLO_SETUP_LBL_FS_FTP_DIRECTORY')
            </label>
            <input type="text" name="fs_directory" id="fs_directory" value="{{ $this->params['fs.directory'] }}">
            <p class="akeeba-help-text">
                @lang('SOLO_SETUP_LBL_FS_FTP_DIRECTORY_HELP')
            </p>
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
