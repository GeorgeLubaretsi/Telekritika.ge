<?php
/**
 * All groups listing page navigation
 *
 */
/*
$tabs = array(
	'newest' => array(
		'text' => elgg_echo('channels:newest'),
		'href' => 'channels/all?filter=newest',
		'priority' => 200,
	),
	'popular' => array(
		'text' => elgg_echo('channels:popular'),
		'href' => 'channels/all?filter=popular',
		'priority' => 300,
	),
	'discussion' => array(
		'text' => elgg_echo('channels:latestdiscussion'),
		'href' => 'channels/all?filter=discussion',
		'priority' => 400,
	),
);
// sets default selected item
if (strpos(full_url(), 'filter') === false) {
	$tabs['newest']['selected'] = true;
}

foreach ($tabs as $name => $tab) {
	$tab['name'] = $name;

	elgg_register_menu_item('filter', $tab);
}

*/
echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));
