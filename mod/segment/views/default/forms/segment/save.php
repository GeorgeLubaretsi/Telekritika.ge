<?php
/**
 * Edit segment form
 *
 * @package Segment
 */
global $actionbuttons;

/*
TV Channel $container_guid
Date $segment_date
Start time $segment_start_hour  $segment_start_minute
End time $segment_end_hour  $segment_end_minute
Link to video $videolink
Title $title
Summary $excerpt
Sequence in news broadcast (1st, 2nd, 3rd segment, etc.) $sequence
Duration (=end time-start time) <-autogenerated
*/ 
 
$segment = get_entity($vars['guid']);
$vars['entity'] = $segment;

$draft_warning = $vars['draft_warning'];
if ($draft_warning) {
	$draft_warning = '<span class="message warning">' . $draft_warning . '</span>';
}

$action_buttons = '';
$delete_link = '';
$preview_button = '';

if ($vars['guid']) {
	// add a delete button if editing
	$delete_url = "action/segment/delete?guid={$vars['guid']}";
	$delete_link = elgg_view('output/confirmlink', array(
		'href' => $delete_url,
		'text' => elgg_echo('delete'),
		'class' => 'elgg-button elgg-button-delete elgg-state-disabled float-alt'
	));
}

// published segments do not get the preview button
/*if (!$vars['guid'] || ($segment && $segment->status != 'published')) {
	$preview_button = elgg_view('input/submit', array(
		'value' => elgg_echo('preview'),
		'name' => 'preview',
		'class' => 'mls',
	));
}*/

$save_button = elgg_view('input/submit', array(
	'value' => elgg_echo('save'),
	'name' => 'save',
));
$actionbuttons = $save_button . $preview_button . $delete_link;

$channels_keyval = return_channels_keyval();

$vars['container_guid'] = empty($vars['container_guid']) ? $vars['entity']->container_guid : $vars['container_guid']; //!sticky = existing
$vars['container_guid'] = empty($vars['container_guid']) ? $_SESSION['segment_next_container_guid'] : $vars['container_guid']; //!existing = next
$vars['container_guid'] = empty($vars['container_guid']) ? elgg_get_page_owner_guid() : $vars['container_guid']; //!next = default
$channel_label = elgg_echo('channel');
$channel_input = elgg_view('input/dropdown', array(
    'name' => 'container_guid',
    'id' => 'channel_dropdown',
    'value' => $vars['container_guid'],
    'options_values' => $channels_keyval,
));

$broadcast_type_keyval = return_broadcast_type_keyval();

$vars['broadcast_type'] = empty($vars['broadcast_type']) ? $vars['entity']->broadcast_type : $vars['broadcast_type'];
$vars['broadcast_type'] = empty($vars['broadcast_type']) ? $_SESSION['segment_next_broadcast_type'] : $vars['broadcast_type'];
$vars['broadcast_type'] = empty($vars['broadcast_type']) ? 0 : $vars['broadcast_type'];
$broadcast_type_label = elgg_echo('segment:broadcast_type');
$broadcast_type_input = elgg_view('input/dropdown', array(
    'name' => 'broadcast_type',
    'id' => 'broadcast_type_dropdown',
    'value' => $vars['broadcast_type'],
    'options_values' => $broadcast_type_keyval,
));

$vars['segment_date'] = empty($vars['segment_date']) ? $vars['entity']->segment_date : $vars['segment_date'];
$vars['segment_date'] = empty($vars['segment_date']) ? $_SESSION['segment_next_date'] : $vars['segment_date'];
$vars['segment_date'] = empty($vars['segment_date']) ? date("Y-m-d") : $vars['segment_date'];
$segment_date_label = elgg_echo('segment:date');
$segment_date_input = elgg_view('input/date', array(
    'name' => 'segment_date',
    'id' => 'segment_datepicker',
    'value' => $vars['segment_date'],
));

$hours = return_24hours_keyval();
$seconds = $minutes = return_60minutes_keyval();

$vars['segment_start_hour'] = empty($vars['segment_start_hour']) ? $vars['entity']->segment_start_hour : $vars['segment_start_hour'];
$vars['segment_start_hour'] = empty($vars['segment_start_hour']) ? $_SESSION['segment_next_start_hour'] : $vars['segment_start_hour'];
$vars['segment_start_hour'] = empty($vars['segment_start_hour']) ? '00' : $vars['segment_start_hour'];
$segment_starttime_label = elgg_echo('segment:starttime');
$segment_start_hour_input = elgg_view('input/dropdown', array(
    'name' => 'segment_start_hour',
    'id' => 'segment_start_hour',
    'value' => $vars['segment_start_hour'],
    'options_values' => $hours,
));


$vars['segment_start_minute'] = empty($vars['segment_start_minute']) ? $vars['entity']->segment_start_minute : $vars['segment_start_minute'];
$vars['segment_start_minute'] = empty($vars['segment_start_minute']) ? $_SESSION['segment_next_start_minute'] : $vars['segment_start_minute'];
$vars['segment_start_minute'] = empty($vars['segment_start_minute']) ? '00' : $vars['segment_start_minute'];
$segment_start_minute_input = elgg_view('input/dropdown', array(
    'name' => 'segment_start_minute',
    'id' => 'segment_start_minute',
    'value' => $vars['segment_start_minute'],
    'options_values' => $minutes,
));

$vars['segment_start_second'] = empty($vars['segment_start_second']) ? $vars['entity']->segment_start_second : $vars['segment_start_second'];
$vars['segment_start_second'] = empty($vars['segment_start_second']) ? $_SESSION['segment_next_start_second'] : $vars['segment_start_second'];
$vars['segment_start_second'] = empty($vars['segment_start_second']) ? '00' : $vars['segment_start_second'];
$segment_start_second_input = elgg_view('input/dropdown', array(
    'name' => 'segment_start_second',
    'id' => 'segment_start_second',
    'value' => $vars['segment_start_second'],
    'options_values' => $seconds,
));

$segment_endtime_label = elgg_echo('segment:endtime');
$vars['segment_end_hour'] = empty($vars['segment_end_hour']) ? $vars['entity']->segment_end_hour : $vars['segment_end_hour'];
$vars['segment_end_hour'] = empty($vars['segment_end_hour']) ? $_SESSION['segment_next_end_hour'] : $vars['segment_end_hour'];
$vars['segment_end_hour'] = empty($vars['segment_end_hour']) ? '00' : $vars['segment_end_hour'];
$segment_end_hour_input = elgg_view('input/dropdown', array(
    'name' => 'segment_end_hour',
    'id' => 'segment_end_hour',
    'value' => $vars['segment_end_hour'],
    'options_values' => $hours,
));

$vars['segment_end_minute'] = empty($vars['segment_end_minute']) ? $vars['entity']->segment_end_minute : $vars['segment_end_minute'];
$vars['segment_end_minute'] = empty($vars['segment_end_minute']) ? $_SESSION['segment_next_end_minute'] : $vars['segment_end_minute'];
$vars['segment_end_minute'] = empty($vars['segment_end_minute']) ? '00' : $vars['segment_end_minute'];
$segment_end_minute_input = elgg_view('input/dropdown', array(
    'name' => 'segment_end_minute',
    'id' => 'segment_end_minute',
    'value' => $vars['segment_end_minute'],
    'options_values' => $minutes,
));

$vars['segment_end_second'] = empty($vars['segment_end_second']) ? $vars['entity']->segment_end_second : $vars['segment_end_second'];
$vars['segment_end_second'] = empty($vars['segment_end_second']) ? $_SESSION['segment_next_end_second'] : $vars['segment_end_second'];
$vars['segment_end_second'] = empty($vars['segment_end_second']) ? '00' : $vars['segment_end_second'];
$segment_end_second_input = elgg_view('input/dropdown', array(
    'name' => 'segment_end_second',
    'id' => 'segment_end_second',
    'value' => $vars['segment_end_second'],
    'options_values' => $seconds,
));

$duration_label = elgg_echo('segment:manualduration');
$duration_minute_input = elgg_view('input/dropdown', array(
    'name' => 'duration_minute',
    'id' => 'duration_minute',
    'value' => $minute = return_duration_minute($vars['entity']->duration) ? return_duration_minute($vars['entity']->duration) : '00',
    'options_values' => $minutes,
));


$duration_second_input = elgg_view('input/dropdown', array(
    'name' => 'duration_second',
    'id' => 'duration_second',
    'value' => $second = return_duration_second($vars['entity']->duration) ? return_duration_second($vars['entity']->duration) : '00',
    'options_values' => $seconds,
));

$sequence_positions = return_sequence_positions_keyval(40);

$vars['sequence'] = $vars['entity']->sequence;
$vars['sequence'] = empty($vars['sequence']) ? $_SESSION['segment_next_sequence'] : $vars['sequence'];
$vars['sequence'] = empty($vars['sequence']) ? date("Y-m-d") : $vars['sequence'];
$segment_sequence_position_label = elgg_echo('segment:sequenceposition');
$segment_sequence_position_input = elgg_view('input/dropdown', array(
    'name' => 'sequence',
    'id' => 'sequence_dropdown',
    'value' => $vars['sequence'],
    'options_values' => $sequence_positions,
));



$channels_autourl_keyval = return_channels_autourl_keyval();
$auto_videolink = ($channel_entity = get_entity($vars['container_guid']))?$channel_entity->autourl_root:"";

$videolink_label = elgg_echo('segment:videolink');
$videolink_input = elgg_view('input/videolink', array(
        'name' => 'videolink',
        'value' => $vars['entity']->videolink ? $vars['entity']->videolink : $auto_videolink,
));

$title_label = elgg_echo('title');
$title_input = elgg_view('input/text', array(
	'name' => 'title',
	'maxlength' => '40',
	'placeholder' => 'Max 40 Characters',
	'id' => 'segment_title',
	'value' => $vars['title']
));
        /*
$excerpt_label = elgg_echo('segment:excerpt');
$excerpt_input = elgg_view('input/text', array(
	'name' => 'excerpt',
	'id' => 'segment_excerpt',
	'value' => html_entity_decode($vars['excerpt'], ENT_COMPAT, 'UTF-8')
));       */

$body_label = elgg_echo('segment:body');
$body_input = elgg_view('input/longtextnomce', array(
	'name' => 'description',
	'id' => 'segment_description',
	'value' => $vars['description']
));

$save_status = elgg_echo('segment:save_status');
if ($vars['guid']) {
	$entity = get_entity($vars['guid']);
	$saved = date('F j, Y @ H:i', $entity->time_created);
} else {
	$saved = elgg_echo('segment:never');
}

if(elgg_is_admin_logged_in()){
    $status_label = elgg_echo('segment:status');
    $status_input = elgg_view('input/dropdown', array(
	    'name' => 'status',
	    'id' => 'segment_status',
	    'value' => $vars['status'],
	    'options_values' => array(
		    'draft' => elgg_echo('segment:status:draft'),
		    'published' => elgg_echo('segment:status:published')
	    )
    ));
}elseif(isMonitor()){
    $status_input = elgg_view('input/hidden', array('name' => 'status','value' => 'draft'));
}


/*
$comments_label = elgg_echo('comments');
$comments_input = elgg_view('input/dropdown', array(
	'name' => 'comments_on',
	'id' => 'segment_comments_on',
	'value' => $vars['comments_on'],
	'options_values' => array('On' => elgg_echo('on'), 'Off' => elgg_echo('off'))
));
*/

$tags_label = elgg_echo('tags');
$tags_input = elgg_view('input/tags', array(
    'name' => 'tags',
    'id' => 'segment_tags',
    'value' => $vars['tags'],
    'size' => 100
));

$events_label = elgg_echo('events');
$events_input = elgg_view('input/tags', array(
	'name' => 'events',
	'id' => 'segment_events',
	'value' => $vars['events'],
    'size' => 100
));

/*
$access_label = elgg_echo('access');
$access_input = elgg_view('input/access', array(
	'name' => 'access_id',
	'id' => 'segment_access_id',
	'value' => $vars['access_id']
));
*/

$categories_input = elgg_view('categories', $vars);
//$events_input = elgg_view('events', $vars);

// hidden inputs
//$container_guid_input = elgg_view('input/hidden', array('name' => 'container_guid', 'value' => elgg_get_page_owner_guid()));
$guid_input = elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));
$comments_input = elgg_view('input/hidden', array('name' => 'comments_on', 'value' => 'On'));
$access_input = elgg_view('input/hidden', array('name' => 'access_id','value' => get_default_access()));
$context = ($vars['guid']) ? elgg_view('input/hidden', array('name' => 'context', 'value' => "edit")) : elgg_view('input/hidden', array('name' => 'context', 'value' => "new"));

echo <<<___HTML

$draft_warning

<div>
    <label for="segment_status">$status_label</label>
    $status_input
</div>

<div>
    <label for="channel">$channel_label</label>
    $channel_input
</div>

<div>
    <label for="broadcast_type">$broadcast_type_label</label>
    $broadcast_type_input
</div>

<div>
    <label for="segment_date">$segment_date_label</label>
    $segment_date_input
</div>

<div>
    <label for="segment_sequence_position">$segment_sequence_position_label</label>
    $segment_sequence_position_input
</div>

<div>
    <label for="segment_starttime">$segment_starttime_label</label>
    $segment_start_hour_input : $segment_start_minute_input : $segment_start_second_input
</div>

<div>
    <label for="segment_endtime">$segment_endtime_label</label>
    $segment_end_hour_input : $segment_end_minute_input : $segment_end_second_input 
</div>

<div>
	<label for="duration_manual">$duration_label</label>
	$duration_minute_input : $duration_second_input 
</div>

<div>
    <label for="segment_title">$title_label</label>
    $title_input
</div>

<!-- <div>
	<label for="segment_excerpt">$excerpt_label</label>
	$excerpt_input
</div> -->

<label for="segment_description">$body_label</label>
$body_input
<br />

<div>
    <label for="segment_tags">$tags_label</label>
    $tags_input
</div>

<div>
	<label for="segment_tags">$events_label</label>
	$events_input
</div>

$categories_input

<div>
    <label for="videolink">$videolink_label</label>
    $videolink_input
</div>


<div class="elgg-foot">
	<div class="elgg-subtext mbm">
	$save_status <span class="segment-save-status-time">$saved</span>
	</div>

    $access_input
    $comments_input
	$guid_input
	$container_guid_input
    $context
    
</div>

___HTML;

?>

<script>
    var options_values = {};
    <? foreach($channels_autourl_keyval as $key => $val){ echo "options_values['$key'] = '".str_replace("&amp;","&",$val)."';";} ?>

    function updateVideoLink(){
        var container_guid = jQuery("select[name=container_guid] option:selected").val();
        var root = options_values[container_guid];
        if(~root.indexOf("myvideo.ge")){
            var thedate = jQuery("input[name=segment_date]").val().split("-");
            var year = thedate[0];
            var month = thedate[1];
            var day = thedate[2];
            var newdate = [day,month,year].join("-");
            var hour = jQuery("select[name=segment_start_hour] option:selected").val();
            var minute = jQuery("select[name=segment_start_minute] option:selected").val();
            var suffix = "&seekTime="+newdate+"%20"+hour+":"+minute;
            var newurl = root+suffix;
            jQuery("input[name=videolink]").val(newurl);            
        }else if(~root.indexOf("tv25.ge")){
            var thedate = root+jQuery("input[name=segment_date]").val();
            jQuery("input[name=videolink]").val(thedate);                        
        }else{
            jQuery("input[name=videolink]").val("");                        
        }
    }
    
    jQuery(document).ready(function() {
        jQuery("select[name=container_guid], input[name=segment_date], select[name=segment_start_hour], select[name=segment_start_minute]").change(updateVideoLink);
        //jQuery("input[name=segment_date]").datepicker("option", {onSelect: function(){jQuery(this).change();}});
        //jQuery(".elgg-input-date").not('.cv_datepicker').datepicker("option", {onSelect: function(){jQuery(this).change();}});
        updateVideoLink();        
    });
    
</script>

<?