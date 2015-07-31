<?php
get_header();

$cat_id = get_query_var('cat');
$cat_name = get_query_var('category_name');
$args = array(
  'posts_per_page' => 12,
  'cat' => $cat_id,
  'category_name' => $cat_name,
  'post_type' => 'photo',
  'post_status' => 'published',
  'paged' => get_query_var('paged') ? get_query_var('paged') : 1
);
$photos = new WP_QUERY($args);
$count = 0;

get_sidebar('galleries'); ?>
<!-- temporary stylesheet for visual -->
<div class="container">
    <div class="col-12">
      <?php
        wp_pagenavi( array( 'query' => $photos ) );
      ?>
    </div>
 </div>

 <div class="container">
    <div class="p-gallery">
    <?php while($photos->have_posts()) : $photos->the_post();
      $count ++;
      $img_meta= get_post_meta(get_the_ID())['photo'];
      $img_id = $img_meta[0];
      $img = wp_get_attachment_image_src((int)$img_id, 'full');
      $img_src = $img[0];

      ?>
      <div class="p-gal-item">
        <a href="<?php the_permalink(); ?>">
          <img src="<?php echo $img_src; ?>" >
        </a>
    </div>
      <?php if ( $count % 4 == 0 ) echo '<div class="clearfix"></div>'; ?>
    <?php endwhile; ?>

</div>
<div class="clearfix"></div>

<?php
wp_reset_postdata();
get_footer();
?>
