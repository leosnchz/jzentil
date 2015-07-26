<?php /* Template Name: VIDEO GALLERY */ ?>

<?php get_header();?>


<?php
query_posts('video');
while (have_posts()) : the_post();
the_content();
endwhile;
?>


<?php get_footer();?>
