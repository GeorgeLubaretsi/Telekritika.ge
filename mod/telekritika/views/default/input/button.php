<?php
/**
 * Create a input button
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['src']   Src of an image
 * @uses $vars['class'] Additional CSS class
 */

if (isset($vars['class'])) {
	$vars['class'] = "elgg-button {$vars['class']}";
} else {
	$vars['class'] = "elgg-button";
}

$defaults = array(
	'type' => 'button',
);

$vars = array_merge($defaults, $vars);

switch ($vars['type']) {
	case 'button':
	case 'reset':
	case 'submit':
	case 'image':
		break;
	default:
		$vars['type'] = 'button';
		break;
}

// blank src if trying to access an offsite image. @todo why?
if (strpos($vars['src'], elgg_get_site_url()) === false) {
	$vars['src'] = "";
}
?>
<? if($CONFIG->translation_todo_recording && (elgg_is_admin_logged_in() || isMonitor())){ ?>
    <button <?php echo elgg_format_attributes($vars); ?> ><?=$vars['value']?></button>
<? }else{ ?>
    <input <?php echo elgg_format_attributes($vars); ?> />
<? }