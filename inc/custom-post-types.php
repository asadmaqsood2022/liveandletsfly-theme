<?php

// Register Custom Post Type
function meals_function()
{

    $labels = array(
        'name'                  => _x('Meals', 'Post Type General Name', 'text_domain'),
        'singular_name'         => _x('Meals', 'Post Type Singular Name', 'text_domain'),
        'menu_name'             => __('Meals', 'text_domain'),
        'name_admin_bar'        => __('Meals', 'text_domain'),
        'archives'              => __('Meals Archives', 'text_domain'),
        'attributes'            => __('Meals Attributes', 'text_domain'),
        'parent_item_colon'     => __('Parent Meals:', 'text_domain'),
        'all_items'             => __('All Meals', 'text_domain'),
        'add_new_item'          => __('Add New Meal', 'text_domain'),
        'add_new'               => __('Add Meal', 'text_domain'),
        'new_item'              => __('New Meal', 'text_domain'),
        'edit_item'             => __('Edit Meal', 'text_domain'),
        'update_item'           => __('Update Meal', 'text_domain'),
        'view_item'             => __('View Meal', 'text_domain'),
        'view_items'            => __('View Meals', 'text_domain'),
        'search_items'          => __('Search Meal', 'text_domain'),
        'not_found'             => __('Not found', 'text_domain'),
        'not_found_in_trash'    => __('Not found in Trash', 'text_domain'),
        'featured_image'        => __('Featured Image', 'text_domain'),
        'set_featured_image'    => __('Set featured image', 'text_domain'),
        'remove_featured_image' => __('Remove featured image', 'text_domain'),
        'use_featured_image'    => __('Use as featured image', 'text_domain'),
        'insert_into_item'      => __('Insert into item', 'text_domain'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'text_domain'),
        'items_list'            => __('Meals list', 'text_domain'),
        'items_list_navigation' => __('Meals list navigation', 'text_domain'),
        'filter_items_list'     => __('Filter Meal list', 'text_domain'),
    );
    $args = array(
        'label'                 => __('Meals', 'text_domain'),
        'description'           => __('Meals', 'text_domain'),
        'labels'                => $labels,
        'supports' => array('title', 'editor', 'thumbnail'),
        'taxonomies'            => array('department'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type('meals', $args);
}
add_action('init', 'meals_function', 0);

$labels = array(
    'name' => _x('Airlines', 'taxonomy general name'),
    'singular_name' => _x('Airlines', 'taxonomy singular name'),
    'search_items' =>  __('Search Airlines'),
    'all_items' => __('All Airline'),
    'parent_item' => __('Parent Airlines'),
    'parent_item_colon' => __('Parent Airlines:'),
    'edit_item' => __('Edit Airline'),
    'update_item' => __('Update Airline'),
    'add_new_item' => __('Add New Airline'),
    'new_item_name' => __('New Airline Name'),
    'menu_name' => __('Airlines'),
);

// Now register the taxonomy
register_taxonomy('airlines', array('meals'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'airlines'),
));
