<script type="text/javascript">
$(function() {
	var $fieldsToRemove = $('#section-fields input[name="remove_field[]"]'),
		$selectedFieldsToRemove = $fieldsToRemove.filter(':checked'),
		$removeBtn = $('#remove-fields');

	$fieldsToRemove.change(function () {
		$selectedFieldsToRemove = $fieldsToRemove.filter(':checked');
		if ($selectedFieldsToRemove.size() == 0) {
			$removeBtn.prop('disabled', 'disabled');
		} else {
			$removeBtn.removeProp('disabled');
		}
	}).change();

	$removeBtn.on('click', function(e) {
		e.prevenDefault();

		if($selectedFieldsToRemove.size() < 1) return false;

		Api.delete('/api.datasource.field', $selectedFieldsToRemove.serialize(), function(response) {
			for(i in response.content) {
				$('[data-id="' +response.content[i]+ '"]').remove();
			}
		});
	});

	$(document).on('change', 'input[name="visible"]', function () {
		var $input = $(this);
		var id = $input.val();

		if ($(this).checked()) {
			Api.post('/api.datasource.field.visible', {field_id: id});
		} else {
			Api.delete('/api.datasource.field.visible', {field_id: id});
		}
	});
});
</script>

<div class="panel">
	<div class="panel-heading" data-icon="th-list fa-lg">
		<span class="panel-title">@lang('datasource::core.field.list')</span>
		<div class="panel-heading-controls">
			{!! Form::button(trans('datasource::core.button.remove_fields'), [
				'data-icon' => 'trash-o',
				'class' => 'btn btn-sm btn-danger btn-labeled',
				'id' => 'remove-fields'
			]) !!}
		</div>
	</div>
	<table id="section-fields" class="table table-primary table-striped table-hover">
		<colgroup>
			<col width="40px" />
			<col width="50px" />
			<col width="100px" />
			<col width="200px" />
			<col width="200px" />
			<col />
		</colgroup>
		<thead>
		<tr>
			<td></td>
			<td>@lang('datasource::core.field.position')</td>
			<td>@lang('datasource::core.field.key')</td>
			<td>@lang('datasource::core.field.name')</td>
			<td class="text-center">@lang('datasource::core.field.visible')</td>
			<td class="text-right">@lang('datasource::core.field.type')</td>
		</tr>
		</thead>
		<tbody>
		@foreach ($fields as $field)
		<tr data-id="{{ $field->getId() }}">
			<td>
				@if(!$field->isSystem())
				{!! Form::checkbox('remove_field[]', $field->getId(), false, ['id' => $field->getKey()]) !!}
				@endif
			</td>
			<td class="text-center">
				<span class="editable-position">{{ $field->getPosition() }}</span>
			</td>
			<td>
				<label for="{{ $field->getKey() }}">{{ $field->getKey() }}</label>
			</td>
			<td>
				{!! link_to_route('backend.datasource.field.edit', $field->getName(), [$field->getId()]) !!}
			</td>
			<td class="text-center">
				{!! Form::checkbox("visible", $field->getId(), $field->isVisible()) !!}
			</td>
			<td class="text-right">
				{!! UI::label($field->getType()->getCategory(), 'success') !!} {!! UI::label($field->getTypeTitle()) !!}
			</td>
		</tr>
		@endforeach
		</tbody>
	</table>

	<div class="panel-footer">
		<div class="btn-group">
			{!! link_to_route('backend.datasource.field.create', trans('datasource::core.button.create_field'), $section->getId(), [
				'data-icon' => 'plus', 'class' => 'btn btn-primary btn-labeled'
			]) !!}
		</div>
	</div>
</div>