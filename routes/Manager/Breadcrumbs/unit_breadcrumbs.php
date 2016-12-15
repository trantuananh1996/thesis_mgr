<?php

Breadcrumbs::register('unit', function ($breadcrumbs) {
	$breadcrumbs->push('Quản lý đơn vị', route('unit.index'));
});

Breadcrumbs::register('unit.create', function ($breadcrumbs) {
	$breadcrumbs->parent('unit');
	$breadcrumbs->push(' Tạo đơn vị mới', route('unit.create'));
});

Breadcrumbs::register('unit.show', function ($breadcrumbs, $unit) {
	$breadcrumbs->parent('unit');
	$breadcrumbs->push($unit->name, route('unit.show', $unit->slug));
});

Breadcrumbs::register('unit.edit', function ($breadcrumbs, $unit) {
	$breadcrumbs->parent('field');
	$breadcrumbs->push($unit->name, route('field.edit', $unit->slug));
});