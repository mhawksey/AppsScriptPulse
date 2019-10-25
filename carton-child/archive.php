<?php get_header(); ?>
<?php $bavotasan_theme_options = bavotasan_theme_options(); ?>

	<section id="primary" class="clearfix">

		<?php if ( have_posts() ) : ?>

			<div id="boxes" class="js-masonry" data-masonry-options='{ "columnWidth": <?php echo $bavotasan_theme_options['column_width']; ?>, "itemSelector": ".masonry" }'>
				<?php
				while ( have_posts() ) : the_post();

					/* Include the post format-specific template for the content. If you want to
					 * this in a child theme then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );

				endwhile;
				?>
			</div>

			<?php
			bavotasan_content_nav();
		else :
			get_template_part( 'content', 'none' );
		endif;
		?>

	</section><!-- #primary.c8 -->

<?php get_footer(); ?>