<?php /* Template Name: Video Gallery */ ?>

<?php get_header(); ?>


<?php

//Define your custom post type name in the arguments

$args = array('post_type' => 'video');

//Define the loop based on arguments

$loop = new WP_Query( $args );

//Display the contents

while ( $loop->have_posts() ) : $loop->the_post();
?>

<div class="container">
    <ul class="gallery-wrap">
        <li>
            <a href='<?php echo get_permalink(); ?>'>
            <?php the_content(); ?>
            <span><?php the_title(); ?></span>
            </a>
        </li>
    </ul>
</div>

<h1 class="entry-title"><?php the_title(); ?></h1>
<div class="entry-content">
<?php the_content(); ?>
</div>
<?php endwhile;?>

<?php get_footer(); ?>
