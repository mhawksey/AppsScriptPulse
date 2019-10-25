<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TBNN5WT');</script>
<!-- End Google Tag Manager -->
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TBNN5WT"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
	<div id="page" class="grid wfull">

		<div id="mobile-menu" class="clearfix">
			<a class="left-menu" href="#"><i class="icon-reorder"></i></a>
			<a class="mobile-title" href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			<a class="mobile-search" href="#"><i class="icon-search"></i></a>
		</div>
		<div id="drop-down-search"><?php get_search_form(); ?></div>

		<div id="main" class="row">

			<div id="secondary" role="complementary">

				<header id="header" role="banner">

					<div class="header-wrap">
						<?php $tag = ( is_front_page() && is_home() ) ? 'h1' : 'div'; ?>
						<<?php echo $tag; ?> id="site-title"><a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></<?php echo $tag; ?>>
						<div id="site-description"><?php bloginfo( 'description' ); ?></div>
					</div>

					<?php
					if ( $header_image = get_header_image() ) :
						?>
						<a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img id="header-img" src="<?php echo esc_url( $header_image ); ?>" width="<?php echo esc_attr( HEADER_IMAGE_WIDTH ); ?>" height="<?php echo esc_attr( HEADER_IMAGE_HEIGHT ); ?>" alt="" /></a>
						<?php
					endif;
					?>

					<nav id="site-navigation" role="navigation">
						<h3 class="screen-reader-text"><?php _e( 'Main menu', 'carton' ); ?></h3>
						<a class="screen-reader-text" href="#primary" title="<?php esc_attr_e( 'Skip to content', 'carton' ); ?>"><?php _e( 'Skip to content', 'carton' ); ?></a>
						<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
					</nav><!-- #site-navigation -->

				</header><!-- #header -->

				<?php get_sidebar(); ?>

			</div><!-- #secondary.widget-area -->
