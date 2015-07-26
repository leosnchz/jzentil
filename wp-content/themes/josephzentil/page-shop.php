<?php
get_header();?>
	<div class="container">
		<div id="content" role="main" class="span8">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post();?>

					<article class="post">

						<div class="the-content">
							<?php do_shortcode("[bc_products target='_blank' css_class='my-product' products_count='10' show_title='yes' show_price='yes']"); ?>
						</div><!-- the-content -->

					</article>

				<?php endwhile; // OK, let's stop the page loop once we've displayed it ?>

			<?php else : // Well, if there are no posts to display and loop through, let's apologize to the reader (also your 404 error) ?>

				<article class="post error">
					<h1 class="404">Nothing has been posted like that yet</h1>
				</article>

			<?php endif; // OK, I think that takes care of both scenarios (having a page or not having a page to show) ?>
		</div><!-- #content .site-content -->
	</div><!-- #container .content-area -->
<?php get_footer(); // This fxn gets the footer.php file and renders it ?>
