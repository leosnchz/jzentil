<?php /* Template Name: Photo Gallery */ ?>

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

get_sidebar('galleries'); ?>
<!-- temporary stylesheet for visual -->
<div class="container">
    <div class="p-gallery">
    <?php foreach($photos as $photo) :
      $count ++;
      $img_src = wp_get_attachment_image_src((int)get_post_meta($photo->ID) ['photo'][0], 'medium')[0];
      ?>
        <div class="p-gal-item">
            <a href="<?php echo $photo->guid; ?>">
            <img src="<?php echo $img_src; ?>" >
            </a>
        </div>
    <?php endforeach; ?>

    </div>
</div>

<?php get_footer(); ?>
