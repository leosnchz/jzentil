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


	function my_post_queries( $query ) {
	  // not an admin page and it is the main query
	  if (!is_admin() && $query->is_main_query()){
	    if(is_category()){
	      $query->set('posts_per_page', 1);
				$query->set('post_type', 'photo');
	    }
	  }
	}
	add_action( 'pre_get_posts', 'my_post_queries' );


function create_development(){
	register_post_type( 'Development', array(
	  'labels' => array(
	    'name' => __( 'Development' ),
	    'singular_name' => __( 'Development' ),
	    'all_items' => __( 'All Developments' ),
	    'view_item' => __( 'DevelopmentDevelopment' ),
	    'add_new_item' => __( 'Add New Development' ),
	    'add_new' => __( 'Add New' ),
	    'edit_item' => __( 'Edit Development' ),
	    'update_item' => __( 'Update Development' ),
	    'search_items' => __( 'Search Development' ),
	    'not_found' => __( 'Development Not Found' ),
	    'not_found_in_trash' => __( 'Development not found in trash' )
	  ),
	  'description' => 'Development by Joseph Zentil',
	  'hierarchical' => false,
	  'show_in_menu' => true,
	  'show_in_nav_menus' => true,
	  'show_in_admin_bar' => true,
	  'public' => true,
	  'has_archive' => false,
	  'menu_position' => 6,
	  'menu_icon' => 'dashicons-format-video',
	  'rewrite' => array('slug' => 'development')
	));
}
add_action( 'init', 'create_development' );


 function remove_menus () {
  global $menu;
  	$restricted = array(__('Comments'));
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
		'before_widget' => '<div id="%1$s" class="container %2$s">',
		'after_widget' => '</div>'
  ));
}

add_action( 'widgets_init', 'galleries_sidebar' );

// Get And Cache Vimeo Thumbnails
function get_vimeo_thumb($vURL, $size = 'thumbnail_small') {
$pieces = explode("/", $vURL);
$id = end($pieces);

if(get_transient('vimeo_' . $size . '_' . $id)) {
$thumb_image = get_transient('vimeo_' . $size . '_' . $id);
} else {
$json = json_decode(file_get_contents( "http://vimeo.com/api/v2/video/" . $id . ".json" ));
$thumb_image = $json[0]->$size;
set_transient('vimeo_' . $size . '_' . $id, $thumb_image, 2629743);
}
return $thumb_image;
}
