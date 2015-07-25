<?php
define( 'JOSEPH_ZENTIL', 1.0 );

add_theme_support( 'automatic-feed-links' );

register_nav_menus(
	array(
		'primary'	=>	__( 'Primary Menu', 'naked' ), // Register the Primary menu
		// Copy and paste the line above right here if you want to make another menu,
		// just change the 'primary' to another name
	)
);

/*-----------------------------------------------------------------------------------*/
/* Activate sidebar for Wordpress use
/*-----------------------------------------------------------------------------------*/
function naked_register_sidebars() {
	register_sidebar(array(				// Start a series of sidebars to register
		'id' => 'sidebar', 					// Make an ID
		'name' => 'Sidebar',				// Name it
		'description' => 'Take it on the side...', // Dumb description for the admin side
		'before_widget' => '<div>',	// What to display before each widget
		'after_widget' => '</div>',	// What to display following each widget
		'before_title' => '<h3 class="side-title">',	// What to display before each widget's title
		'after_title' => '</h3>',		// What to display following each widget's title
		'empty_title'=> '',					// What to display in the case of no title defined for a widget
		// Copy and paste the lines above right here if you want to make another sidebar,
		// just change the values of id and name to another word/name
	));
}
// adding sidebars to Wordpress (these are created in functions.php)
add_action( 'widgets_init', 'naked_register_sidebars' );

/*-----------------------------------------------------------------------------------*/
/* Enqueue Styles and Scripts
/*-----------------------------------------------------------------------------------*/

function naked_scripts()  {

	// get the theme directory style.css and link to it in the header
	wp_enqueue_style( 'naked-style', get_template_directory_uri() . 'style.css', '10000', 'all' );

	// add fitvid
	wp_enqueue_script( 'naked-fitvid', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), NAKED_VERSION, true );

	// add theme scripts
	wp_enqueue_script( 'naked', get_template_directory_uri() . '/js/theme.min.js', array(), NAKED_VERSION, true );

}
add_action( 'wp_enqueue_scripts', 'naked_scripts' ); // Register this fxn and allow Wordpress to call it automatcally in the header

// custom post types
  function create_gallery_post(){
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
      'description' => 'Photos by Joseph Zentil',
      'hierarchical' => false,
			'taxonomies' => array(
				'category'
			),
      'show_in_menu' => true,
      'show_in_nav_menus' => true,
      'show_in_admin_bar' => true,
      'public' => true,
      'has_archive' => true,
	  'menu_position' => 5,
	  'menu_icon' => 'dashicons-format-gallery',
      'rewrite' => array('slug' => 'Photo')
      )
    );

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
      'description' => 'Videos by Joseph Zentil',
      'hierarchical' => false,
      'show_in_menu' => true,
      'show_in_nav_menus' => true,
      'show_in_admin_bar' => true,
      'public' => true,
      'has_archive' => false,
	  'menu_position' => 6,
	  'menu_icon' => 'dashicons-format-video',
      'rewrite' => array('slug' => 'Video')
    ));
  }
  add_action( 'init', 'create_gallery_post' );
