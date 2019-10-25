<?php
/**
 * The template for displaying article headers
 *
 * @since 1.0.0
 */
$bavotasan_theme_options = bavotasan_theme_options();

// @See https://developer.wordpress.org/reference/functions/wp_list_categories/#comment-1169
$taxonomy = 'category';
 
// Get the term IDs assigned to post.
$post_terms = wp_get_object_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) );
 
// Separator between links.
$separator = ', ';
 
if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) ) {
 
    $term_ids = implode( ',' , $post_terms );
 
    $terms = wp_list_categories( array(
        'title_li' => '',
        'style'    => 'none',
        'echo'     => false,
        'taxonomy' => $taxonomy,
        'include'  => $term_ids
    ) );
 
    $terms = rtrim( trim( str_replace( '<br />',  $separator, $terms ) ), $separator );
 
    // Display post categories.
    //echo  $terms;
}
?>
	<hgroup>
		<?php
		$display_categories = $bavotasan_theme_options['display_categories'];
		if ( ! empty( $display_categories ) && 'page' != get_post_type() ) { ?>
		<h3 class="post-category"><?php echo  $terms; //the_category( ', ' ); ?></h3>
		<?php } ?>
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( sprintf( '<h2 class="entry-title taggedlink"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		endif;
		?>

		<h2 class="entry-meta">
			<?php
			$display_author = $bavotasan_theme_options['display_author'];
			if ( $display_author )
				printf( __( 'by %s', 'carton' ),
					'<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" title="' . esc_attr( sprintf( __( 'Posts by %s', 'carton' ), get_the_author() ) ) . '" rel="author">' . get_the_author() . '</a>'
				);

			the_tags( '<div class="tags"><span>' . __( 'Tags:', 'carton' ) . '</span>', ' ', '</div>' );
			echo ' | ';
			$display_date = $bavotasan_theme_options['display_date'];
			if( $display_date ) {
				if( $display_author )
					echo '&nbsp;&bull;&nbsp;';
			    echo '<a href="' . get_permalink() . '"><time class="published updated" datetime="' . get_the_date( 'Y-m-d' ) . '">' . get_the_date() . '</time></a>';
	        }

			$display_comments = $bavotasan_theme_options['display_comment_count'];
			if( $display_comments && comments_open() ) {
				if ( $display_author || $display_date )
					echo ' | ';

				comments_popup_link( __( '0 Comments', 'carton' ), __( '1 Comment', 'carton' ), __( '% Comments', 'carton' ) );
			}
			echo ' | ';
			$url = urlencode(get_permalink());
			$title = urlencode(html_entity_decode(get_the_title(),ENT_QUOTES,'UTF-8'));
			echo '<ul id="social-share">
				<li><a title="Share on Twitter" href="https://twitter.com/intent/tweet?text='.$title.'%20'.$url.'%20%23GSuiteDevs"><noscript>Twitter</noscript></a></li> | 
				<li><a title="Share on Facebook" href="https://www.facebook.com/sharer.php?u='.$url.'" class="share-facebook"><noscript>Facebook</noscript></a></li> | 
				<li><a title="Share on LinedIn" href="https://www.linkedin.com/shareArticle?mini=true&url='.$url.'&source=MASHe&summary='.$title.'" class="share-linkedin"><noscript>LinkedIn</noscript></a></li> | 
				<li><a title="Share on Reddit" href="https://www.reddit.com/submit?url='.$url.'&title='.$title.'" class="share-reddit" target="_blank"><noscript>Reddit</noscript></a></li>
			  </ul>';
			?>
		</h2>
	</hgroup>
