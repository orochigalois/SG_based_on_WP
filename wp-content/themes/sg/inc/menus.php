<?php

// Add a social links to header menu
/*function add_socials_to_header_menu($items, $args) {
	ob_start();
		if($args->theme_location == 'header-secondary-menu') {
			while(have_rows('social_profiles', 'options')) {
				the_row();

				$network = get_sub_field('network');
				$url     = get_sub_field('url');

				if(!empty($network['value']) && $url) {
					print '<li class="menu-item-social"><a href="'.esc_attr($url).'" target="_blank" title="'.esc_attr($network['value']).'">'.lp_file_contents('/images/icons/social/'.$network['value'].'.svg').'</a></li>';
				}
			}
		}
	$html = ob_get_clean();

	return $items.$html;
}
add_filter('wp_nav_menu_items', 'add_socials_to_header_menu', 10, 2);*/

// Show icons in the main menu submenus
/*function add_icons_to_main_submenu($title, $item, $args, $depth) {
	if($args->theme_location == 'header-primary-menu') {
		if($depth == 1) {
			$icon = wp_get_attachment_image(get_field('icon', $item->ID), 'medium');
			$title = $icon.'<span><span>'.$title.'</span></span>';
		}
	}

	return $title;
}
add_filter('nav_menu_item_title', 'add_icons_to_main_submenu', 10, 4);*/

// Add dropdown arrows to main menu items
/*function add_dropdown_icons_to_mainmenu($title, $item, $args, $depth) {
	if($args->theme_location == 'header-primary-menu') {
		if($depth == 0 && in_array('menu-item-has-children', $item->classes)) {
			$icon = lp_file_contents('/images/icons/dropdown-arrow.svg');
			$title = $title.$icon;
		}
	}

	return $title;
}
add_filter('nav_menu_item_title', 'add_dropdown_icons_to_mainmenu', 10, 4);*/

// Add a submenu with links from a WP_Query to a menu item
/*function add_posts_to_menu($sorted_menu_items, $args) {
    foreach($sorted_menu_items as $item) {
        if($item->url == '/specials') {
            $specials = get_posts(array(
                'post_type'=>'specials',
                'posts_per_page' => -1,
                'meta_key' => 'page_or_submenu',
                'meta_value' => 'submenu',
            ));
            
            $specials = array_map('wp_setup_nav_menu_item', $specials);
            array_walk($specials, function(&$s, $key, $item) {
                // Link to the menu item parent
                $s->menu_item_parent = $item->ID;
            }, $item);

            $sorted_menu_items = array_merge($sorted_menu_items, $specials);
        }
    }

    return $sorted_menu_items;
}
add_filter('wp_nav_menu_objects', 'add_posts_to_menu', 10, 2);*/