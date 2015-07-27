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
/* Enqueue Styles and Scripts
/*-----------------------------------------------------------------------------------*/

function naked_scripts()  {

	// get the theme directory style.css and link to it in the header
	wp_enqueue_style( 'naked-style', get_template_directory_uri() . '/assets/stylesheets/jz_style.css', '10000', 'all' );

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


  function remove_menus () {
  global $menu;
  	$restricted = array(__('Posts'),  __('Comments'));
  	end ($menu);
  	while (prev($menu)){
  		$value = explode(' ',$menu[key($menu)][0]);
  		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
  	}
  }
  add_action('admin_menu', 'remove_menus');

function galleries_sidebar(){
	register_sidebar(array(
    'name' => __( 'Galleries Sidebar' ),
    'id' => 'galleries',
		'before_widget' => '<aside id="%1$s" class="col-md-2 %2$s">',
		'after_widget' => '</aside>'
  ));
}
add_action( 'widgets_init', 'galleries_sidebar' );

//widgets
	include_once('widgets/galleries.php');
