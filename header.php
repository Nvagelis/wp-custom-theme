<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package underscoress
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'underscoress' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
			endif;

			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php
			endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'underscoress' ); ?></button>
			<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				) );
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
            
            
            
            <div>
                <h1>customizer values</h1>
                <?php
                    $custom_logo = get_theme_mod('custom_logo', '');
                    $logo_text = get_theme_mod('logo_text', '');
                    $anchor_color = get_theme_mod('anchor_color', '');
                    $custom_checkbox = get_theme_mod('custom_checkbox', '');
                    $custom_url = get_theme_mod('custom_url', '');
                    $custom_email = get_theme_mod('custom_email', '');
                    $custom_textarea = get_theme_mod('custom_textarea', '');
                    $custom_number = get_theme_mod('custom_number', '');
                    $custom_date = get_theme_mod('custom_date', '');
                    $custom_range = get_theme_mod('custom_range', '');
                    $multi_field = get_theme_mod('multi_field', '');
                    
                ?>
                <div class="custom_logo"><?php echo 'custom_logo : '.$custom_logo; ?></div>
                <div class="logo_text"><?php echo $logo_text; ?></div>
                <div class="anchor_color"><?php echo $anchor_color; ?></div>
                <div class="custom_checkbox"><?php echo $custom_checkbox; ?></div>
                <div class="custom_url"><?php echo $custom_url; ?></div>
                <div class="custom_email"><?php echo $custom_email; ?></div>
                <div class="custom_textarea"><?php echo $custom_textarea; ?></div>
                <div class="custom_number"><?php echo $custom_number; ?></div>
                <div class="custom_date"><?php echo $custom_date; ?></div>
                <div class="custom_range"><?php echo $custom_range; ?></div>
                <div class="multi_field"><?php echo $multi_field; ?></div>
            </div>
