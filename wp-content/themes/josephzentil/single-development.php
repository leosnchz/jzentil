<?php
get_header();
$image = get_field('poster');
?>
<div class="container">

    <div class="development">

        <div class="col-4 poster">
            <img src="<?php echo $image['url']; ?> "/>
        </div>

        <div class="col-8">
            <div class="content">
                <h1><?php echo get_the_title(); ?></h1>
                <p><?php the_field("devcontent"); ?></p>
            </div>
            <div class="trailer">
                <?php the_field('trailer');?>
            </div>
        </div>

    </div>

</div>

<?php get_footer(); ?>
