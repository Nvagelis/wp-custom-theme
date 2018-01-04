<?php

/**
 * customtheme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package customtheme
 */

if ( ! function_exists( 'customtheme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function customtheme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on underscoress, use a find and replace
		 * to change 'underscoress' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'customtheme', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
                
                /* 
                 * Set the default Featured Image (formerly Post Thumbnail) dimensions. 
                 */
                //set_post_thumbnail_size(825, 510, true);
                
                /* 
                 * To register additional image sizes for Featured Images use: add_image_size(). set_post_thumbnail_size( $width, $height, $crop ) 
                 */
                //add_image_size('customtheme_team', 420, 275, true);

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
                    'menu-1' => esc_html__( 'Primary', 'customtheme' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
                
                /* 
                 * Post Formats 
                 *  'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'          
                 */
                add_theme_support('post-formats', array(
                    'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'
                ));

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'underscoress_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'customtheme_setup' );


/* ----------------------------------------------------------------------- */


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function customtheme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'customtheme_content_width', 640 );
}
add_action( 'after_setup_theme', 'customtheme_content_width', 0 );


/* ----------------------------------------------------------------------- */


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function customtheme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'customtheme' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'customtheme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'customtheme_widgets_init' );



/* ----------------------------------------------------------------------- */



/**
 * Register Google Fonts
 */
if (!function_exists('tempo_fonts_url')) :

    function customtheme_fonts_url() {
        $fonts_url = '';
        $fonts = array();
        $subsets = 'latin,latin-ext';

        if ('off' !== _x('on', 'Noto Sans font: on or off', 'tempo')) {
            $fonts[] = 'Noto Sans:400italic,700italic,400,700';
        }

        if ('off' !== _x('on', 'Noto Serif font: on or off', 'tempo')) {
            $fonts[] = 'Noto Serif:400italic,700italic,400,700';
        }

        if ('off' !== _x('on', 'Inconsolata font: on or off', 'tempo')) {
            $fonts[] = 'Inconsolata:400,700';
        }

        $subset = _x('no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'tempo');

        if ('cyrillic' == $subset) {
            $subsets .= ',cyrillic,cyrillic-ext';
        } elseif ('greek' == $subset) {
            $subsets .= ',greek,greek-ext';
        } elseif ('devanagari' == $subset) {
            $subsets .= ',devanagari';
        } elseif ('vietnamese' == $subset) {
            $subsets .= ',vietnamese';
        }

        if ($fonts) {
            $fonts_url = add_query_arg(array(
                'family' => urlencode(implode('|', $fonts)),
                'subset' => urlencode($subsets),
                    ), 'https://fonts.googleapis.com/css');
        }

        return $fonts_url;
    }

endif;




/**
 * Enqueue scripts and styles.
 */
function customtheme_scripts() {
	wp_enqueue_style( 'customtheme-style', get_stylesheet_uri() );
        
        wp_enqueue_style( 'customtheme-custom-style', get_stylesheet_uri() . 'css/custom.css', array('customtheme-style'), '20151215' );

        wp_enqueue_style('customtheme-googleFonts', 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,700italic,400,700,300');

        // Add custom fonts, used in the main stylesheet.
        // with function customtheme_fonts_url() above
        wp_enqueue_style('customtheme-fonts', customtheme_fonts_url(), array(), null);
        
        
	wp_enqueue_script( 'customtheme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'customtheme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
        
        wp_enqueue_script( 'customtheme-main', get_template_directory_uri() . '/js/main.js', array('jquery'), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'customtheme_scripts' );



/* ----------------------------------------------------------------------- */




/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function customtheme_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'customtheme_body_classes' );



/* ----------------------------------------------------------------------- */



/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function customtheme_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'customtheme_pingback_header' );



/* ----------------------------------------------------------------------- */



/**
 * Load Template Part function
 */
function customtheme_load_template_part($template_name, $part_name = null) {
    ob_start();
    get_template_part($template_name, $part_name);
    $var = ob_get_contents();
    ob_end_clean();
    return $var;
}

/* ----------------------------------------------------------------------- */


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom meta boxes.
 */
//require get_template_directory() . '/inc/meta-boxes.php';


/**
 * Custom widgets.
 */
require get_template_directory() . '/inc/widgets.php';
//require get_stylesheet_directory() . '/inc/widgets.php';


/**
 * Castomizer Api.
 */
require get_template_directory() . '/inc/customizer/customizer.php';
require get_template_directory() . '/inc/customizer/costomizer-advanced.php';


/**
 * Custom mods.
 * custom terms and custom columns
 * 
 */
require get_template_directory() . '/inc/mods.php';


include_once(get_template_directory() . '/inc/custom-post-types.php');
include_once(get_template_directory() . '/inc/custom-taxonomies.php');
include_once(get_template_directory() . '/inc/custom-metabox.php');

include_once(get_template_directory() . '/inc/admin-pages.php');
