<?php 
/*
Plugin Name: Big Cartel Plugin by Tonka Park
Plugin URI: http://tonkapark.com
Description: Include your Big Cartel product links and images within wordpress posts, pages and widgets.
Author: Matt Anderson
Version: 0.2.0
Author URI: http://tonkapark.com
*/
/*
Copyright (C) 2012-2013 by  Matt Anderson, Tonka Park

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
*/

add_action( 'widgets_init', 'BCi_Init' );
function BCi_Init() {
  register_widget( 'BCi' );
}

class BCi extends WP_Widget{ 
	var $name;
	var $dir;
	var $path;
	var $siteurl;
	var $wpadminurl;
	var $version;

	var $apiurl;
	var $productsurl;

	var $sizes;
	
	function BCi()  {
    	parent::WP_Widget( false, $name = 'Big Cartel Widget' );
    
		// set class variables
		$this->name = 'Big Cartel Plugin by Tonka Park';
    	$this->short_name = 'Big Cartel';
		$this->path = dirname(__FILE__).'/';
		$this->dir = plugins_url('/',__FILE__);
		$this->siteurl = get_bloginfo('url');
		$this->wpadminurl = admin_url();
		$this->version = '0.2.0';
    
		$this->apibase = 'http://api.bigcartel.com/';
		$this->subdomain = get_option('bc_subdomain');
		$this->storeurl = 'http://' . $this->subdomain . '.bigcartel.com';
		
		$this->sizes['small'] = 75;
		$this->sizes['thumb'] = 75;
		$this->sizes['thumbnail'] = 75;
		$this->sizes['75'] = 75;
		$this->sizes['175'] = 175;
		$this->sizes['medium'] = 175;
		$this->sizes['300'] = 300;    
		$this->sizes['large'] = 300;
		$this->sizes['1000'] = 1000;
		$this->sizes['full'] = 1000;     
				
		add_action('admin_menu', array($this,'create_menu')); 
    
	    add_shortcode('bc_product', array($this,'bc_product_shortcode'));
	    add_shortcode('bc_products', array($this,'bc_products_shortcode'));
    
	    add_filter('widget_text', 'do_shortcode');
    	
	    return true;
	  }
	



	function apiurl($subdomain){
		return $this->apibase . $subdomain;
	}

	function productsapiurl($subdomain, $limit = 300){
		return $this->apiurl($subdomain) . '/products.js?limit='. $limit;
	}

	function storeapiurl($subdomain){
		return $this->apiurl($subdomain) . '/store.js'; 
	}
	
	function format_currency($price, $subdomain){
		$store = $this->load_store($subdomain);
		$currency = $store->currency->sign;
		$price = $currency . '' . number_format($price, 2);
		return $price;
	}
	  
	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$product_limit = $instance['product_limit'];
		$show_images = $instance['show_images'];

		echo $before_widget;

		if ($title) {
		  echo $before_title . $title . $after_title;
		}
		//build list of products
		echo $this->list_products($product_limit, $show_images);

		echo $after_widget;    
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance = $new_instance;
		
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['product_limit'] = absint($new_instance['product_limit']);
		$instance['show_images'] = isset($new_instance['show_images']);
		
		return $instance;
	}
	function form( $instance ) {
		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Big Cartel Products', 'product_limit' => 10, 'show_images' => false);
		$instance = wp_parse_args( (array) $instance, $defaults );  
	  	?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" />                  
		</p>            
		<p>
		<label for="<?php echo $this->get_field_id( 'product_limit' ); ?>"><?php _e( 'Number of products to list:' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'product_limit' ); ?>" name="<?php echo $this->get_field_name( 'product_limit' ); ?>" type="text" value="<?php echo $instance['product_limit']; ?>" size="3"/>                  
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'show_images' ); ?>"><?php _e( 'Thumbnails:' ); ?></label>
		<input class="checkbox" type="checkbox" <?php checked( $instance['show_images'], true ); ?> id="<?php echo $this->get_field_id( 'show_images' ); ?>" name="<?php echo $this->get_field_name( 'show_images' ); ?>" /> <?php _e( 'Include product images?', $this->textdomain); ?></label>
		</p>		
		<?php
	} 

	/**
	* Creates Admin Menu
	*
	**/
	function create_menu(){
    	add_menu_page($this->short_name, $this->short_name, 'administrator', __FILE__, array($this,'admin_page'));  
    	add_action( 'admin_init', array($this,'register_bc_settings' ));
	}

	/**
	 * Displays Admin Settings Panel
	 *
	**/
	function admin_page(){
		if (!current_user_can('manage_options'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}  
		include('bigcartel_settings.php');
	}
  
	/**
	 * Register options
	 *
	**/  
	function register_bc_settings() {
		register_setting( 'bc-settings-group', 'bc_subdomain' );	
		register_setting( 'bc-settings-group', 'bc_shop_url' );	
	}    
  
	/**
	* Individual Product Image Shortcode
	* 
	* The shortcode parser that replaces the shortcode in the post, page or widget
	* [bc_product permalink="product-name-permalink" size="small|medium|large" subdomain="tonkapark" css_class="css" target="_blank" show_title="yes" show_price="yes"]
	* @param array		$atts
	* @return string
	*/  
	function bc_product_shortcode($atts) {
		extract( shortcode_atts( array(
				'permalink' => '',
				'size' => 'large',
				'subdomain' => $this->subdomain,
				'target' => '_self',
				'css_class' => '',
				'show_title' => 'no',
				'show_price' => 'no'
				) , $atts ) );
					  
		$store_url = $this->get_store_url($subdomain);

		if (isset($permalink)) {
			$products = $this->load_products($subdomain);

			foreach ($products as $item) {          
				if ($item->permalink == $permalink){                                
					$image = $item->images[0]->url;
					$link = '<div class="bc-plugin-product '. $css_class .'"><a href="' . $store_url . '/product/' . $item->permalink . '" title="' . $item->name . '" target="'. $target .'"><img src="' . $this->image_url($item->images[0]->url, $size) . '" />';
					if ($show_title == 'yes'){
						$link .= '<div class="bc-plugin-title">' . $item->name . '</div>';
					}
					$link .= '</a>';
					if ($show_price == 'yes'){
						$link .= '<div class="bc-plugin-price">' . $this->format_currency($item->price, $subdomain) . '</div>';
					}					
					$link .= '</div>'; 
					break;   
			 	}
			}  
			return $link;
		} else {
			return '[Big Cartel Shortcode Error]';
		}
    
	}
	
	
	/**
	* Products Image Grid Shortcode
	* 
	* The shortcode parser that replaces the shortcode in the post, page or widget
	* [bc_products size="small|medium|large" css_class="css" target="_blank" products_count="10" show_title="yes" show_price="yes"]
	* @param array		$atts
	* @return string
	*/	
	function bc_products_shortcode($atts){
		extract( shortcode_atts( array(
				'size' => 'large',
				'target' => '_self',
				'css_class' => '',
				'products_count' => '10',
				'show_title' => 'no',
				'show_price' => 'no'
				) , $atts ) );		

		$store_url = $this->get_store_url($this->subdomain);
		$products = $this->load_products($this->subdomain);
		$i=0;
		$links = '<div class="bc-plugin-products">';
		do{ 
			$image = $item->images[0]->url;
			$links .= '<div class="bc-plugin-product '. $css_class .'"><a href="' . $store_url . '/product/' . $products[$i]->permalink . '" title="' . $products[$i]->name . '" target="'. $target .'"><img src="' . $this->image_url($products[$i]->images[0]->url, $size) . '" />';
			if ($show_title == 'yes'){
				$links .= '<div class="bc-plugin-title">' . $products[$i]->name .'</div>';
			}							
			$links .= '</a>';
			if ($show_price == 'yes'){
				$links .= '<div class="bc-plugin-price">'. $this->format_currency($products[$i]->price, $this->subdomain) .'</div>';
			}
			$links .= '</div>';				
			$i++;
		} while ( $i < $products_count && count($products) > $i );		  
		$links .= '</div>';
		return $links;
		return '[BigCartel Products Error]';
	}	
	
	function list_products($limit = 10, $show_images = false){
		$products = $this->load_products($this->subdomain);
		$store_url = $this->get_store_url($this->subdomain);
		$list = '<ul>';
		$i=0;
		do {
			$list .= '<li><a href="' . $store_url . '/product/' . $products[$i]->permalink . '" title="' . $products[$i]->name . '">';
			if ($show_images){
				$list .= '<img src="'.$this->image_url($products[$i]->images[0]->url, "small") .'"/> ';
			}
			$list .= '<span class="bc-list-product-title">' . $products[$i]->name . '</span></a></li>';              
			$i++;
		} while ( $i < $limit);        
		$list .= '</ul>';
		return $list;    
	}

	function load_products($subdomain){
		$cache_key = 'bcpro_'.$subdomain.'_products_cache';
		if ( false === ( $result = get_transient( $cache_key ) ) ) {
		    // this code runs when there is no valid transient set
		    $result = $this->fetch($this->productsapiurl($subdomain));
			set_transient( $cache_key, $result, 60 );
		}
		return json_decode($result);
	}

	function get_store_url($subdomain){
		$store = $this->load_store($subdomain);
 		return $store->url;
	}
		
	function load_store($subdomain){
		$cache_key = 'bcpro_'.$subdomain.'_store_cache';
		if ( false === ( $result = get_transient( $cache_key ) ) ) {
		    // this code runs when there is no valid transient set
		    $result = $this->fetch($this->storeapiurl($subdomain));
			set_transient( $cache_key, $result, 30 );
		}		
		return json_decode($result);
	}

	function image_url($url, $size_string = 'large'){
    $filename = basename($url);
    
    preg_match("/\/(\d+)\//", $url, $matches);
    $picture_id = $matches[0];
    
		$size = $this->sizes[$size_string] ? $this->sizes[$size_string] : 300;

    $newurl = "http://images.cdn.bigcartel.com/bigcartel/product_images/". $picture_id ."/max_h-".$size."+max_w-".$size."/".$filename;

		return $newurl;
	}

	function fetch($url){
		$page = wp_remote_get( $url );
		$data = $page['body'];

		if (empty($data)) { return false; } // if nothing found in rss feed, do nothing

		return $data;
	}
  
}

?>