=== Big Cartel Plugin by Tonka Park ===
Contributors: tonkapark
Donate link: http://tonkapark.com
Tags: bigcartel, big cartel
Requires at least: 2.8
Tested up to: 3.5.2
Stable tag: 0.2.0

Include your Big Cartel product links and images within wordpress posts, pages and widgets.

== Description ==

The Big Cartel Plugin is originally brought to you by Tonka Park. 

The plugin offers the ability to include product links and images for a single bigcartel shop on your wordpress site. Through the use of short codes within posts and pages and a simple widget it is easy to upsell your products on your blog.

Related Links:

* [Big Cartel Wordpress Plugin Home](http://tonkapark.com/big-cartel-integration-wordpress-plugin/ "Big Cartel Plugin")
* [Big Cartel Help](http://help.bigcartel.com/)
* [Big Cartel Themes and Templates by Tonka Park](http://tonkapark.com "Big Cartel Themes and Templates")

Big Cartel Plugin by Tonka Park is not endorsed or affiliated with Big Cartel LLC.

== Installation ==

1. Upload folder `big-cartel-plugin` to `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Under Big Cartel Settings, Enter the Subdomain of you BigCartel store eg. http://{subdomain}.bigcartel.com
1. Under Big Cartel Settings, Enter the full URL of your Big Cartel store eg. http://store.yourdomain.com or http://subdomain.bigcartel.com

== Screenshots ==

1. Big Cartel Plugin Settings

== Changelog ==

= 0.2.0 =
* Change how the images are displayed to match new CDN urls from Big Cartel.
* Add option for 1000x1000 pixel images to shortcode.

= 0.1.5 =
* Products Shortcode fixed to stop when no more products

= 0.1.4 =
* Somehow code was overwritten with 0.1.3, fixing and re-releasing

= 0.1.2 =
* Added new attribute, show_price, to display product price on bc_product shortcode
* Added new attribute, show_price, to display product price on bc_products shortcode
* Added new attribute, products_count, to limit number of products shown on bc_products shortcode
* New format_currency function
* Better caching and use of store api calls.

= 0.1.1 =
* Added new attribute to display product title on on bc_product shortcode

= 0.1.0 =
* Big Cartel Widget now allows images to be displayed
* New ability to set target and css_class for product image links in shortcode
* New products shortcode will show all product images from a store
* Change to use wp_get_url for api calls, this is introduces caching

= 0.0.5 =
* Removed DEBUG line that was unused and caused error to display
* Added new subdomain shortcode attribute to allow other big cartel stores to be referenced in posts
* Product List widget now allows number of products listed to be changed

= 0.0.4 =
* Initial wordpress.org plugin repository version
