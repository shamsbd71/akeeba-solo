<?php
/**
 * @package   solo
 * @copyright Copyright (c)2014-2025 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

defined('_AKEEBA') or die();

/** @var \Solo\View\Setup\Html $this */

$router = $this->getContainer()->router;
?>

<div class="akeeba-panel--info">
    <header class="akeeba-block-header">
        <h1>
            @lang('SOLO_SETUP_SUBTITLE_DATABASE')
        </h1>
    </header>
    <p>
        @lang('SOLO_SETUP_LBL_DATABASE_INFO')
    </p>
</div>

<form action="@route('index.php?view=setup&task=installdb')" method="post" role="form"
      name="dbForm"
      class="akeeba-form--horizontal">

    <div class="akeeba-form-group">
        <label for="driver">
            @lang('SOLO_SETUP_LBL_DATABASE_DRIVER')
        </label>
        {{ $this->getContainer()->html->setup->databaseTypesSelect( $this->connectionParameters['driver']) }}
        <p class="akeeba-help-text">
            @lang('SOLO_SETUP_LBL_DATABASE_DRIVER_HELP')
        </p>
    </div>

    <div class="akeeba-form-group" id="host-wrapper">
        <label for="host">
            @lang('SOLO_SETUP_LBL_DATABASE_HOST')
        </label>
        <input type="text" id="host" name="host" placeholder="@lang('SOLO_SETUP_LBL_DATABASE_HOST')"
               value="{{ $this->connectionParameters['host'] }}">
        <p class="akeeba-help-text">
            @lang('SOLO_SETUP_LBL_DATABASE_HOST_HELP')
        </p>
    </div>

    <div class="akeeba-form-group" id="user-wrapper">
        <label for="user">
            @lang('SOLO_SETUP_LBL_DATABASE_USER')
        </label>
        <input type="text" id="user" name="user" placeholder="@lang('SOLO_SETUP_LBL_DATABASE_USER')"
               value="{{ $this->connectionParameters['user'] }}">
        <p class="akeeba-help-text">
            @lang('SOLO_SETUP_LBL_DATABASE_USER_HELP')
        </p>
    </div>

    <div class="akeeba-form-group" id="pass-wrapper">
        <label for="pass">
            @lang('SOLO_SETUP_LBL_DATABASE_PASS')
        </label>
        <input type="password" id="pass" name="pass" placeholder="@lang('SOLO_SETUP_LBL_DATABASE_PASS')"
               value="{{ $this->connectionParameters['pass'] }}">
        <p class="akeeba-help-text">
            @lang('SOLO_SETUP_LBL_DATABASE_PASS_HELP')
        </p>
    </div>

    <div class="akeeba-form-group" id="name-wrapper">
        <label for="name">
            @lang('SOLO_SETUP_LBL_DATABASE_NAME')
        </label>
        <input type="text" id="name" name="name" placeholder="@lang('SOLO_SETUP_LBL_DATABASE_NAME')"
               value="{{ $this->connectionParameters['name'] }}">
        <p class="akeeba-help-text">
            @lang('SOLO_SETUP_LBL_DATABASE_NAME_HELP')
        </p>
    </div>

    <div class="akeeba-form-group" id="prefix-wrapper">
        <label for="prefix">
            @lang('SOLO_SETUP_LBL_DATABASE_PREFIX')
        </label>
        <input type="text" id="prefix" name="prefix" placeholder="@lang('SOLO_SETUP_LBL_DATABASE_PREFIX')"
               value="{{ $this->connectionParameters['prefix'] }}">
        <p class="akeeba-help-text">
            @lang('SOLO_SETUP_LBL_DATABASE_PREFIX_HELP')
        </p>
    </div>

    <div class="akeeba-form-group" id="prefix-dbencryption">
        <label for="dbencryption">
            @lang('SOLO_SETUP_LBL_DATABASE_DBENCRYPTION')
        </label>
        <div class="akeeba-toggle">
            @html('fefselect.booleanlist', 'dbencryption', ['forToggle' => 1, 'colorBoolean' => 1], $this->connectionParameters['ssl']['enable'])
        </div>
        <p class="akeeba-help-text">
            @lang('SOLO_SETUP_LBL_DATABASE_DBENCRYPTION_HELP')
        </p>
    </div>

    <div class="akeeba-form-group" id="prefix-dbsslcipher">
        <label for="dbsslcipher">
            @lang('SOLO_SETUP_LBL_DATABASE_DBSSLCIPHER')
        </label>
        <input type="text" id="dbsslcipher" name="dbsslcipher"
               placeholder="@lang('SOLO_SETUP_LBL_DATABASE_DBSSLCIPHER')"
               value="{{ $this->connectionParameters['ssl']['cipher'] }}">
        <p class="akeeba-help-text">
            @lang('SOLO_SETUP_LBL_DATABASE_DBSSLCIPHER_HELP')
        </p>
    </div>

    <div class="akeeba-form-group" id="prefix-dbsslca">
        <label for="dbsslca">
            @lang('SOLO_SETUP_LBL_DATABASE_DBSSLCA')
        </label>
        <input type="text" id="dbsslca" name="dbsslca" placeholder="@lang('SOLO_SETUP_LBL_DATABASE_DBSSLCA')"
               value="{{ $this->connectionParameters['ssl']['ca'] }}">
        <p class="akeeba-help-text">
            @lang('SOLO_SETUP_LBL_DATABASE_DBSSLCA_HELP')
        </p>
    </div>

    <div class="akeeba-form-group" id="prefix-dbsslkey">
        <label for="dbsslkey">
            @lang('SOLO_SETUP_LBL_DATABASE_DBSSLKEY')
        </label>
        <input type="text" id="dbsslkey" name="dbsslkey" placeholder="@lang('SOLO_SETUP_LBL_DATABASE_DBSSLKEY')"
               value="{{ $this->connectionParameters['ssl']['key'] }}">
        <p class="akeeba-help-text">
            @lang('SOLO_SETUP_LBL_DATABASE_DBSSLKEY_HELP')
        </p>
    </div>

    <div class="akeeba-form-group" id="prefix-dbsslcert">
        <label for="dbsslcert">
            @lang('SOLO_SETUP_LBL_DATABASE_DBSSLCERT')
        </label>
        <input type="text" id="dbsslcert" name="dbsslcert" placeholder="@lang('SOLO_SETUP_LBL_DATABASE_DBSSLCERT')"
               value="{{ $this->connectionParameters['ssl']['cert'] }}">
        <p class="akeeba-help-text">
            @lang('SOLO_SETUP_LBL_DATABASE_DBSSLCERT_HELP')
        </p>
    </div>

    <div class="akeeba-form-group" id="prefix-dbsslverifyservercert">
        <label for="dbsslverifyservercert">
            @lang('SOLO_SETUP_LBL_DATABASE_DBSSLVERIFYSERVERCERT')
        </label>
        <div class="akeeba-toggle">
            @html('fefselect.booleanlist', 'dbsslverifyservercert', ['forToggle' => 1, 'colorBoolean' => 1],
				$this->connectionParameters['ssl']['verify_server_cert'])
        </div>
        <p class="akeeba-help-text">
            @lang('SOLO_SETUP_LBL_DATABASE_DBSSLVERIFYSERVERCERT_HELP')
        </p>
    </div>

    <div class="akeeba-form-group--pull-right">
        <div class="akeeba-form-group--actions">
            <button type="submit" id="dbFormSubmit" class="akeeba-btn--primary">
                @lang('SOLO_BTN_SUBMIT')
            </button>
        </div>
    </div>
</form>
