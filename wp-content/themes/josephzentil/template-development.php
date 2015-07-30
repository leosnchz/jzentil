<?php /* Template Name: Development */ ?>

<?php get_header(); ?>
<div class="container">

    <?php
    $args = array('post_type' => 'development');
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post();
    $image = get_field('poster');
    ?>

        <div class="development">

            <div class="col-4 poster">
                <img src="<?php echo $image['url']; ?> "/>
            </div>

            <div class="col-8 wrap">
                <div class="bottom">
                    <div class="trailer video">
                        <iframe src="https://player.vimeo.com/video/<?php echo get_field('trailer_id') ?>?color=ffffff&title=0&byline=0&portrait=0" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>
                    <div class="content">
                        <h1><?php echo get_the_title(); ?></h1>
                        <p><?php the_field("devcontent"); ?></p>
                    </div>
                </div>
            </div>
        </div>

    <?php endwhile;?>
</div><!-- #container .content-area -->

<?php get_footer(); ?>
