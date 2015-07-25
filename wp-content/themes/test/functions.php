<?php


// custom post types
function create_custom(){
    register_post_type( 'Video', array(
      'labels' => array(
        'name' => __( 'Videos' ),
        'singular_name' => __( 'Video' ),
        'all_items' => __( 'All Videos' ),
        'view_item' => __( 'View Video' ),
        'add_new_item' => __( 'Add New Video' ),
        'add_new' => __( 'Add New' ),
        'edit_item' => __( 'Edit Video' ),
        'update_item' => __( 'Update Video' ),
        'search_items' => __( 'Search Videos' ),
        'not_found' => __( 'Video Not Found' ),
        'not_found_in_trash' => __( 'Video not found in trash' )
        ),
      'description' => 'Company Career Pages',
      'hierarchical' => false,
      'show_in_menu' => true,
      'show_in_nav_menus' => true,
      'show_in_admin_bar' => true,
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'Video')
      )
    );

    register_post_type( 'Photo', array(
      'labels' => array(
        'name' => __( 'Photos' ),
        'singular_name' => __( 'Photo' ),
        'all_items' => __( 'All Photos' ),
        'view_item' => __( 'View Photo' ),
        'add_new_item' => __( 'Add New Photo' ),
        'add_new' => __( 'Add New' ),
        'edit_item' => __( 'Edit Photo' ),
        'update_item' => __( 'Update Photo' ),
        'search_items' => __( 'Search Photos' ),
        'not_found' => __( 'Photo Not Found' ),
        'not_found_in_trash' => __( 'Photo not found in trash' )
      ),
      'description' => 'Branded Design Postings',
      'hierarchical' => false,
      'show_in_menu' => true,
      'show_in_nav_menus' => true,
      'show_in_admin_bar' => true,
      'public' => true,
      'has_archive' => false,
      'rewrite' => array('slug' => 'Photo'),
    ));
  }
  add_action( 'init', 'create_custom' );

include_once('portfolio-photo.php');
include_once('portfolio-video.php');
