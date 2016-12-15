<?php
Breadcrumbs::register('field', function ($breadcrumbs)
{
	$breadcrumbs->push('Quản lý lĩnh vực', route('field.index'));
});

Breadcrumbs::register('field.create', function ($breadcrumbs)
{
	$breadcrumbs->parent('field');
	$breadcrumbs->push(' Tạo lĩnh vực mới', route('field.create'));
});

Breadcrumbs::register('field.show', function ($breadcrumbs, $field)
{
	$breadcrumbs->parent('field');
	$breadcrumbs->push($field->name, route('field.show', $field->slug));
});

Breadcrumbs::register('field.edit', function ($breadcrumbs, $field)
{
	$breadcrumbs->parent('field');
	$breadcrumbs->push($field->name, route('field.edit', $field->slug));
});
