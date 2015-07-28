<?php
get_header();
// vars
$image = get_field('photo');

?>
<section class="container">
    <div class="photo">
        <img src="<?php echo $image['url']; ?>" />
    </div>
</section>
<?php get_footer(); ?>
