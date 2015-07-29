<?php /* Template Name: Video Gallery */ ?>

<?php get_header(); ?>


<?php
$args = array('post_type' => 'video');
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();
?>

<div class="container">
    <ul class="video-gallery">
        <li class="columns four">
            <a href='<?php echo get_permalink(); ?>'>
            <span>
            <?php the_title(); ?></span>
            </a>
        </li>
    </ul>
</div>

</div>
<?php endwhile;?>

<?php get_footer(); ?>
