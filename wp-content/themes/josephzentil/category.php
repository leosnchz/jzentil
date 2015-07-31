<?php
get_header();

$cat_id = get_query_var('cat');
$cat_name = get_query_var('category_name');
$args = array(
  'posts_per_page' => 2,
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
<link rel="stylesheet" href="http://josephzentil.leonardo-sanchez.com/html/assets/stylesheets/screen.css" />
<div class="col-md-10">
  <div class="row">
    <div class="col-md-6">
      <h2><?php single_cat_title(); ?></h2>
    </div>
    <div class="col-md-6">
      <?php
        wp_pagenavi( array( 'query' => $photos ) );

      ?>
    </div>
  </div>
  <div class="row">
    <ul class="photo-gallery">
    <?php while($photos->have_posts()) : $photos->the_post();
      $count ++;
      $img_meta = get_post_meta(get_the_ID())['photo'][0];
      $img_src = wp_get_attachment_image_src((int)$img_meta, 'full')[0];

      ?>
      <li class="col-md-3">
        <a href="<?php the_permalink(); ?>">
          <img src="<?php echo $img_src; ?>" >
        </a>
      </li>
      <?php if ( $count % 4 == 0 ) echo '<div class="clearfix"></div>'; ?>
    <?php endwhile;

    ?>

    </ul>
  </div>
</div>
<div class="clearfix"></div>

<?php
wp_reset_postdata();
get_footer();
