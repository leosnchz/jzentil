<?php /* Template Name: PHOTO GALLERY */ ?>

<?php get_header();

$cat_id = get_query_var('cat');
$args = array(
  'posts_per_page' => 12,
  'offset' => 0,
  'category' => $cat_id,
  'post_type' => 'photo',
  'post_status' => 'publish',
  'suppress_filters' => true
);
$photos = get_posts($args);
$count = 0;

// var_dump($photos);
// var_dump(get_post_meta(9));

get_sidebar('galleries'); ?>
<!-- temporary stylesheet for visual -->
<div class="container">
    <ul class="photo-gallery">
    <?php foreach($photos as $photo) :
      $count ++;
      $img_src = wp_get_attachment_image_src((int)get_post_meta($photo->ID)['photo'][0], 'medium')[0];
      ?>
        <li class="columns three">
            <a href="<?php echo $photo->guid; ?>">
            <img src="<?php echo $img_src; ?>" >
            </a>
        </li>
    <?php endforeach; ?>

    </ul>
</div>
<?php get_footer(); ?>
