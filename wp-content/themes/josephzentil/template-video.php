<?php /* Template Name: Video Gallery */
// Create post object
?>

<?php get_header(); ?>
<div class="container">
    <div class="gallery">
        <?php
        $args = array('post_type' => 'video');
        $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post();
        ?>
        <div class="gal-item">
            <a href='<?php echo get_permalink(); ?>'>
                <img src="<?=get_vimeo_thumb( 'http//vimeo.com/' + get_field('video_id') , 'thumbnail_large');?>" />
            </a>
        </div>
        <?php endwhile;?>
    </div>

</div>

<?php get_footer(); ?>
