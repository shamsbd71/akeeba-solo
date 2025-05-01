<?php
/**
 * @package   solo
 * @copyright Copyright (c)2014-2025 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

use Awf\Text\Text;

defined('_AKEEBA') or die();

// Used for type hinting
/** @var  \Solo\View\Users\Html  $this */

$router = $this->getContainer()->router;

/** @var \Solo\Model\Users $model */
$model = $this->getModel();
?>

<form action="@route('index.php?view=users')" method="post" name="adminForm" id="adminForm"
      role="form" class="akeeba-form">

	<table class="akeeba-table--striped" id="adminList">
		<thead>
			<tr>
				<th width="20px">&nbsp;</th>
				<th width="50px">
					@html('grid.sort', 'SOLO_USERS_FIELD_ID', 'id', $this->lists->order_Dir, $this->lists->order, 'browse')
				</th>
				<th>
					@html('grid.sort', 'SOLO_USERS_FIELD_USERNAME', 'username', $this->lists->order_Dir, $this->lists->order, 'browse')
				</th>
				<th>
					@html('grid.sort', 'SOLO_USERS_FIELD_NAME', 'name', $this->lists->order_Dir, $this->lists->order, 'browse')
				</th>
				<th>
					@html('grid.sort', 'SOLO_USERS_FIELD_EMAIL', 'email', $this->lists->order_Dir, $this->lists->order, 'browse')
				</th>
				<th width="80">
					<abbr title="@lang('SOLO_USERS_HEAD_TFA')">@lang('SOLO_USERS_FIELD_TFA')</abbr>
				</th>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>
					<input type="text" name="username" value="{{ $model->getState('username', '') }}"
						   class="akeebaGridViewAutoSubmitOnChange"
							placeholder="@lang('SOLO_USERS_FIELD_USERNAME')">
				</td>
				<td>
					<input type="text" name="name" value="{{ $model->getState('name', '') }}"
						   class="akeebaGridViewAutoSubmitOnChange"
							placeholder="@lang('SOLO_USERS_FIELD_NAME')">
				</td>
				<td>
					<input type="text" name="email" value="{{ $model->getState('email', '') }}"
						   class="akeebaGridViewAutoSubmitOnChange"
							placeholder="@lang('SOLO_USERS_FIELD_EMAIL')">
				</td>
				<td></td>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="20" class="center">
					{{ $this->pagination->getListFooter() }}
				</td>
			</tr>
		</tfoot>
		<tbody>
		@if (empty($this->items))
			<tr>
				<td colspan="20" class="center">
					@lang('AWF_PAGINATION_LBL_NO_RESULTS')
				</td>
			</tr>
		@else
		<?php $i = 0; ?>
		@foreach($this->items as $user)
		<?php
			/** @var \Solo\Model\Users $user */
			$params = new \Awf\Registry\Registry($user->parameters);
			$tfaMethod = $params->get('tfa.method', 'none');
			$tfaMethod = empty($tfaMethod) ? 'none' : $tfaMethod;
		?>
			<tr>
				<td>
					@html('grid.id', $i++, $user->id)
				</td>
				<td>
					<a href="@route('index.php?view=users&task=edit&id=' . $user->id)">
						{{ (int)$user->id }}
					</a>
				</td>
				<td>
					<a href="@route('index.php?view=users&task=edit&id=' . $user->id)">
						{{{ $this->escape($user->username) }}}
					</a>
				</td>
				<td>
					<a href="@route('index.php?view=users&task=edit&id=' . $user->id)">
						{{{ $user->getFieldValue('name') }}}
					</a>
				</td>
				<td>
					<a href="@route('index.php?view=users&task=edit&id=' . $user->id)">
						{{{ $user->email }}}
					</a>
				</td>
				<td>
					<img src="media/image/tfa-<?php echo $tfaMethod ?>.png" width="16" height="16" title="@lang('SOLO_USERS_TFA_' . $tfaMethod)" />
				</td>
			</tr>
		@endforeach
		@endif
		</tbody>
	</table>

    <div class="akeeba-hidden-fields-container">
        <input type="hidden" name="boxchecked" id="boxchecked" value="0">
        <input type="hidden" name="task" id="task" value="browse">
        <input type="hidden" name="filter_order" id="filter_order" value="{{ $this->lists->order }}">
        <input type="hidden" name="filter_order_Dir" id="filter_order_Dir" value="{{ $this->lists->order_Dir }}">
        <input type="hidden" name="token" value="@token()">
    </div>
</form>

<script type="application/javascript">
	akeeba.System.orderTable = function ()
	{
		var table = document.getElementById("sortTable");
		var direction = document.getElementById("directionTable");
		var order = table.options[table.selectedIndex].value;

		if (order != '{{{ $this->lists->order }}}')
		{
			var dirn = 'asc';
		}
		else
		{
			var dirn = direction.options[direction.selectedIndex].value;
		}

		akeeba.System.tableOrdering(order, dirn, '');
	}
</script>
