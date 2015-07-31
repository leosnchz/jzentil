<?php
get_header();
$image = get_field('poster');
?>
<div class="container">

    <div class="development">

        <div class="col-4 poster">
            <img src="<?php echo $image['url']; ?> "/>
        </div>

        <div class="col-8 wrap">
            <?php if( get_post_meta($post->ID, 'trailer_id', true) ) { ?>

                <div class="trailer video">
                    <?php the_field("trailer_id"); ?>
                </div>

            <?php } ?>
                <div class="content">
                    <h1><?php echo get_the_title(); ?></h1>
                    <p><?php the_field("devcontent"); ?></p>
                    <p><?php the_field("genre"); ?></p>
                    <p><span>Producers:</span> <?php the_field("producers"); ?></p>
                    <p><span>Status:</span> <?php the_field("status"); ?></p>
                </div>
            </div>
        </div>
    </div>

</div>

<?php get_footer(); ?>
