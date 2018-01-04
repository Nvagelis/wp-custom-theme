<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package underscoress
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) : the_post();
                        ?>
                    
                    <!-- custom meta box -->
                    <?php
                        $post = get_post();
                    ?>
                    <div style="background-color: #006799">
                        <h3>custom meta box area</h3>
                        <div><span>my_meta_box_text: </span><span><?php echo get_post_meta($post->ID, 'my_meta_box_text', true); ?></span></div>
                        <div><span>my_meta_box_select: </span><span>...</span></div>
                    </div>
                        <?php
                        /*
                         *default if i have content-single
                         *                          */
			//get_template_part( 'template-parts/content', 'single' );
                        
                        /*
                         *if i want content-single for single posts and content for index page
                         *                          */
                        //$format = get_post_format() ? : 'single';
			//get_template_part( 'template-parts/content', $format );
                
                
                        /*
                         * if i want to choose from content files (default calls content.php)
                         *                          */
                         get_template_part( 'template-parts/content', get_post_type() );
                
                
			the_post_navigation(array(
                            'next_text' => '<span>επόμενο</span>',
                            'prev_text' => '<span>προιγούμενο</span>',
                        ));

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
