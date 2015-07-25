<?php
get_header();
// vars
$image = get_field('photo');

?>

<img src="<?php echo $image['url']; ?>" />

<?php get_footer(); ?>
