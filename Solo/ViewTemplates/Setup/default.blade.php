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

{{-- AdBlock warning --}}
@include('Main/warning_adblock')

<div class="akeeba-panel--info">
    <header class="akeeba-block-header">
        <h1>
			@lang('SOLO_SETUP_LBL_WELCOME_HEAD')
        </h1>
    </header>
    <p>
		@lang('SOLO_SETUP_LBL_WELCOME')
    </p>
</div>

<!--[if IE]>
<div style="margin: 20px; padding: 20px; background-color: yellow; border: 5px solid red; font-size: 14pt;">
    @sprintf('SOLO_SETUP_LBL_ANCIENTIENOTICE', 'http://windows.microsoft.com/en-us/internet-explorer/download-ie', 'http://www.google.com/chrome') ?>
</div>
<![endif]-->

@if (!$this->reqMet): ?>
    <div class="akeeba-block--failure">
		@lang('SOLO_SETUP_LBL_REQUIREDREDTEXT')
    </div>
@endif

<div class="akeeba-panel--{{ $this->reqMet ? 'green' : 'red' }}" id="settingsRequired">
    <header class="akeeba-block-header">
        <h3>
            <span class="akion-{{ $this->reqMet ? 'checkmark' : 'alert' }}-circled"></span>
			@lang('SOLO_SETUP_HEADER_REQUIRED')
        </h3>
    </header>
    <div>
        <p>@lang('SOLO_SETUP_LBL_REQUIRED')</p>
        <table class="akeeba-table--striped">
            <thead>
            <tr>
                <th>@lang('SOLO_SETUP_LBL_SETTING')</th>
                <th>@lang('SOLO_SETUP_LBL_CURRENT_SETTING')</th>
            </tr>
            </thead>
            <tbody>
			@foreach ($this->reqSettings as $option)
                <tr>
                    <td>
						{{ $option['label'] }}
						@if (array_key_exists('notice', $option))
                            <div class="help-block">
								{{ $option['notice'] }}
                            </div>
						@endif
                    </td>
                    <td>
                        <span class="akeeba-label--{{ $option['current'] ? 'green' : ($option['warning'] ? 'orange' : 'red') }}">
                            {{ $option['current'] ? Text::_('SOLO_YES') : Text::_('SOLO_NO') }}
                        </span>
                    </td>
                </tr>
			@endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="akeeba-panel--{{ $this->recMet ? 'green' : 'orange' }}" id="settingsRecommended">
    <header class="akeeba-block-header">
        <h3>
            <span class="akion-{{ $this->recMet ? 'checkmark' : 'alert' }}-circled"></span>
			@lang('SOLO_SETUP_HEADER_RECOMMENDED')
        </h3>
    </header>
    <div>
        <p>@lang('SOLO_SETUP_LBL_RECOMMENDED')</p>
        <table class="akeeba-table--striped" width="100%">
            <thead>
            <tr>
                <th>@lang('SOLO_SETUP_LBL_SETTING')</th>
                <th>@lang('SOLO_SETUP_LBL_RECOMMENDED_VALUE')</th>
                <th>@lang('SOLO_SETUP_LBL_CURRENT_SETTING')</th>
            </tr>
            </thead>
            <tbody>
			<?php foreach ($this->recommendedSettings as $option): ?>
                <tr>
                    <td>
						{{ $option['label'] }}
                    </td>
                    <td>
                        <span class="akeeba-label--grey">
                            {{ $option['recommended'] ? Text::_('SOLO_ON') : Text::_('SOLO_OFF') }}
                        </span>
                    </td>
                    <td>
                        <span class="akeeba-label--{{ ($option['current'] == $option['recommended']) ? 'green' : 'orange' }}">
                            {{ $option['current'] ? Text::_('SOLO_ON') : Text::_('SOLO_OFF') }}
                        </span>
                    </td>
                </tr>
			<?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

