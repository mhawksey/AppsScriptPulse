<?php $format = get_post_format(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	    <?php get_template_part( 'content', 'header' ); ?>

	    <div class="entry-content">
		    <?php
			if ( empty( $format ) && ( ! is_single() || is_search() || is_archive() ) ) {
				/* if( has_post_thumbnail() ) {
					global $wp_query;
					$size = ( 0 == $wp_query->current_post ) ? 'large' : 'medium';
					$class = ( 0 == $wp_query->current_post ) ? 'alignnone' : 'alignleft';
					echo '<a href="' . get_permalink() . '" class="image-anchor">';
					the_post_thumbnail( $size, array( 'class' => $class . ' img-thumbnail' ) );
					echo '</a>';
				}*/
				//the_excerpt();
				the_content( __( 'Read more &rarr;', 'carton' ) );
				// if ( function_exists( 'wpsabox_author_box' ) ) echo wpsabox_author_box(); 
			} else {
				the_content( __( 'Read more &rarr;', 'carton' ) );
			}
			?>
	    </div><!-- .entry-content -->

	    <?php get_template_part( 'content', 'footer' ); ?>
	</article><!-- #post-<?php the_ID(); ?> -->