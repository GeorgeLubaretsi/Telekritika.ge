<?php
/**
 * Action called by AJAX periodic auto saving when editing.
 *
 * @package Commentary
 */

$guid = get_input('guid');
$user = elgg_get_logged_in_user_entity();
$title = get_input('title');
$description = get_input('description');
$excerpt = get_input('excerpt');

// because get_input() doesn't use the default if the input is ''
if (empty($excerpt)) {
	$excerpt = $description;
}

// store errors to pass along
$error = FALSE;

if ($title && $description) {

	if ($guid) {
		$entity = get_entity($guid);
		if (elgg_instanceof($entity, 'object', 'commentary') && $entity->canEdit()) {
			$commentary = $entity;
		} else {
			$error = elgg_echo('commentary:error:post_not_found');
		}
	} else {
		$commentary = new ElggCommentary();
		$commentary->subtype = 'commentary';

		// force draft and private for autosaves.
		$commentary->status = 'unsaved_draft';
		$commentary->access_id = ACCESS_PRIVATE;
		$commentary->title = $title;
		$commentary->description = $description;
		$commentary->excerpt = elgg_get_excerpt($excerpt);

		// mark this as a brand new post so we can work out the
		// river / revision logic in the real save action.
		$commentary->new_post = TRUE;

		if (!$commentary->save()) {
			$error = elgg_echo('commentary:error:cannot_save');
		}
	}

	// creat draft annotation
	if (!$error) {
		// annotations don't have a "time_updated" so
		// we have to delete everything or the times are wrong.

		// don't save if nothing changed
		if ($auto_save_annotations = $commentary->getAnnotations('commentary_auto_save', 1)) {
			$auto_save = $auto_save_annotations[0];
		} else {
			$auto_save == FALSE;
		}

		if (!$auto_save) {
			$annotation_id = $commentary->annotate('commentary_auto_save', $description);
		} elseif ($auto_save instanceof ElggAnnotation && $auto_save->value != $description) {
			$commentary->clearAnnotations('commentary_auto_save');
			$annotation_id = $commentary->annotate('commentary_auto_save', $description);
		} elseif ($auto_save instanceof ElggAnnotation && $auto_save->value == $description) {
			// this isn't an error because we have an up to date annotation.
			$annotation_id = $auto_save->id;
		}

		if (!$annotation_id) {
			$error = elgg_echo('commentary:error:cannot_auto_save');
		}
	}
} else {
	$error = elgg_echo('commentary:error:missing:description');
}

if ($error) {
	$json = array('success' => FALSE, 'message' => $error);
	echo json_encode($json);
} else {
	$msg = elgg_echo('commentary:message:saved');
	$json = array('success' => TRUE, 'message' => $msg, 'guid' => $commentary->getGUID());
	echo json_encode($json);
}
exit;
