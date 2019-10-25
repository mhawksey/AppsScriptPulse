<?php
/**
 * The template for displaying article footers
 *
 * @since 1.0.0
 */
 if ( is_singular() ) {
	?>
	<footer class="entry">
	    <?php
	    wp_link_pages( array( 'before' => '<p id="pages">' . __( 'Pages:', 'carton' ) ) );
	    edit_post_link( __( '(edit)', 'carton' ), '<p class="edit-link">', '</p>' );
	    ?>
	</footer><!-- .entry -->
	<?php
}