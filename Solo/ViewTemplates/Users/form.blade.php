<?php
/**
 * @package   solo
 * @copyright Copyright (c)2014-2025 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

defined('_AKEEBA') or die();

/** @var \Solo\View\Users\Html $this */

/** @var \Solo\Model\Users $model */
$model = $this->getModel();

$permissions = [
	'backup'    => false,
	'configure' => false,
	'download'  => false,
];

$tfa = [
	'method'  => 'none',
	'yubikey' => '',
	'google'  => '',
	'otep'    => [],
];

if ($model->id)
{
	$user = $this->getContainer()->userManager->getUser($model->id);

	$permissions = [
		'backup'    => $user->getPrivilege('akeeba.backup', false),
		'configure' => $user->getPrivilege('akeeba.configure', false),
		'download'  => $user->getPrivilege('akeeba.download', false),
	];
	$tfa         = [
		'method'  => $user->getParameters()->get('tfa.method', 'none'),
		'yubikey' => $user->getParameters()->get('tfa.yubikey', ''),
		'google'  => $user->getParameters()->get('tfa.google', ''),
		'otep'    => $user->getParameters()->get('tfa.otep', []),
	];

	if (empty($tfa['google']))
	{
		$totp          = new \Awf\Encrypt\Totp(30, 6, 10);
		$tfa['google'] = $totp->generateSecret();
	}
}

?>
<form name="adminForm" id="adminForm" action="@route('index.php?view=users')" method="post"
      role="form" class="akeeba-form--horizontal">

    <div>
        <h3>@lang('SOLO_USERS_HEAD_BASIC')</h3>

        <div class="akeeba-form-group">
            <label for="username">
                @lang('SOLO_USERS_FIELD_USERNAME') *
            </label>
            <input type="text" name="username" maxlength="255" size="50"
                   value="{{{ $model->username }}}"
                   required />
        </div>

        <div class="akeeba-form-group">
            <label for="password">
                @lang('SOLO_USERS_FIELD_PASSWORD')
            </label>
            <input type="password" name="password" maxlength="255" size="50"
                   value="" />
        </div>

        <div class="akeeba-form-group">
            <label for="repeatpassword">
                @lang('SOLO_USERS_FIELD_PASSWORDREPEAT')
            </label>
            <input type="password" name="repeatpassword" maxlength="255" size="50"
                   value="" />
        </div>

        <div class="akeeba-form-group">
            <label for="email">
                @lang('SOLO_USERS_FIELD_EMAIL') *
            </label>
            <input type="email" name="email" maxlength="255" size="50"
                   value="{{{ $model->email }}}" required />
        </div>

        <div class="akeeba-form-group">
            <label for="name">
                @lang('SOLO_USERS_FIELD_NAME')
            </label>
            <input type="text" name="name" maxlength="255" size="50"
                   value="{{{ $model->name }}}" />
        </div>

        <div class="akeeba-form-group">
            <label for="base_font_size">
                @lang('SOLO_USERS_BASE_FONT_SIZE')
            </label>
            <input
                    type="number" min="8" max="144" step="1"
                    list="defaultPointSizes"
                    value="{{{ $this->baseFontSize }}}"
                    name="base_font_size" id="base_font_size"
            />
        </div>
        <datalist id="defaultPointSizes">
            <option value="9">
            <option value="10">
            <option value="11">
            <option value="12">
            <option value="13">
            <option value="16">
            <option value="18">
            <option value="24">
            <option value="26">
            <option value="32">
            <option value="38">
            <option value="42">
            <option value="48">
            <option value="64">
        </datalist>

        <div class="akeeba-form-group">
            <label for="name">
                @lang('SOLO_USERS_FIELDSET_PERMISSIONS')
            </label>
            <div class="akeeba-form-group--checkbox">
                <label>
                    <input type="checkbox" name="permissions[backup]" {{ $permissions['backup'] ? 'checked' : '' }}>
                    @lang('SOLO_USERS_FIELD_PERMISSIONS_BACKUP')
                </label>
            </div>
        </div>

        <div class="akeeba-form-group--checkbox--pull-right">
            <label>
                <input type="checkbox" name="permissions[configure]" {{ $permissions['configure'] ? 'checked' : '' }}>
                @lang('SOLO_USERS_FIELD_PERMISSIONS_CONFIGURE')
            </label>
        </div>

        <div class="akeeba-form-group--checkbox--pull-right">
            <label>
                <input type="checkbox" name="permissions[download]" {{ $permissions['download'] ? 'checked' : '' }}>
                @lang('SOLO_USERS_FIELD_PERMISSIONS_DOWNLOAD')
            </label>
        </div>
    </div>

    <div>
        <h3>@lang('SOLO_USERS_HEAD_TFA')</h3>

        <p>
            @lang('SOLO_USERS_LBL_ABOUTTFA')
        </p>
    </div>

    @if (empty($tfa['method']) || ($tfa['method'] == 'none'))
        <div class="akeeba-form-group">
            <label for="tfa[method]">
                @lang('SOLO_USERS_LBL_TFAMETHOD')
            </label>
            {{ $this->getContainer()->html->setup->tfaMethods('tfa[method]', $tfa['method']) }}
        </div>

        <div id="tfa_containers">
            @include('Users/tfa_none', ['tfa' => $tfa])
            @include('Users/tfa_yubikey', ['tfa' => $tfa])
            @include('Users/tfa_google', ['tfa' => $tfa])
        </div>
    @else
        <div class="akeeba-form-group">
            <label for="tfa[keep]">
                @lang('SOLO_USERS_LBL_TFAENABLE')
            </label>
            <select name="tfa[keep]" id="tfa[keep]">
                <option value="1" checked="checked">@lang('SOLO_YES')</option>
                <option value="0">@lang('SOLO_NO')</option>
            </select>

            <div id="otep_containers">
                @include('Users/tfa_oteps', ['tfa' => $tfa])
            </div>
        </div>
    @endif

    <div class="akeeba-hidden-fields-container">
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="id" value="{{ $model->id }}" />
        <input type="hidden" name="@token()" value="1">
    </div>
</form>
