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
<div id="tfa_oteps">
	<h4>@lang('SOLO_USERS_TFA_OTEPS_HEAD')</h4>

	<p class="akeeba-block--info">
		@lang('SOLO_USERS_TFA_OTEPS_INTRO')
	</p>

	<pre>
@foreach($tfa['otep'] as $otep)
	{{ substr($otep, 0, 3) . '-' . substr($otep, 3, 3) . '-' . substr($otep, 6)  . "\n" }}
@endforeach</pre>
</div>
