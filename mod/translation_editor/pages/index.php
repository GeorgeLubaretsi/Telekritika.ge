<?php 

	global $CONFIG;

	gatekeeper();

	// Build elements
	$title_text = elgg_echo("translation_editor:menu:title");
	$title = elgg_view_title($title_text);
	
	elgg_push_breadcrumb($title_text, "translation_editor");
	
	// Get inputs
	$current_language = get_input("current_language", get_current_language());
	
	$translations = get_installed_translations();
	
	if(!(array_key_exists($current_language,$translations ))){
		forward("translation_editor");
	}
	
	$plugin = get_input("plugin");
	
	$languages = array_keys($CONFIG->translations);
	
	$disabled_languages = elgg_get_plugin_setting(TRANSLATION_EDITOR_DISABLED_LANGUAGE, "translation_editor");
	if(!empty($disabled_languages)){
		$disabled_languages = explode(",", $disabled_languages);
	} else {
		$disabled_languages = array();
	}
	
	if(!empty($CONFIG->language)){
		$site_language = $CONFIG->language;
	} else {
		$site_language = "en";
	}
	
	$body .= elgg_view("translation_editor/language_selector", array("current_language" => $current_language, "plugin" => $plugin, "languages" => $languages, "disabled_languages" => $disabled_languages, "site_language" => $site_language));
	
	if(empty($plugin)){
		// show plugin list
		elgg_push_breadcrumb(elgg_echo($current_language));
		
		$plugins = translation_editor_get_plugins($current_language);
		
		$body .= elgg_view("translation_editor/search", array("current_language" => $current_language, "query" => get_input("q")));
		$body .= elgg_view("translation_editor/plugin_list", array("plugins" => $plugins, "current_language" => $current_language));
	} else {
		// show plugin keys
		elgg_push_breadcrumb(elgg_echo($current_language), "translation_editor/" . $current_language);
		elgg_push_breadcrumb($plugin);
		
		$translation = translation_editor_get_plugin($current_language, $plugin);
		if($plugin == "custom_keys" && elgg_is_admin_logged_in()){
			//$body .= elgg_view("translation_editor/add_custom_key");
		}
		$body .= elgg_view("translation_editor/plugin_edit", array("plugin" => $plugin, "current_language" => $current_language, "translation" => $translation));
	}
	
	// Build page
	$page_data = elgg_view_layout('one_column', array(
		'content' => "<div class='elgg-head'>" . $title . "</div>" . $body
	));

	echo elgg_view_page($title_text, $page_data);
	