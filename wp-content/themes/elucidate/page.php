<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Elucidate
 */

$blog_details = get_blog_details(1);
if (strstr($_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"], $blog_details->domain."/regions-") !== false || $_SERVER["REQUEST_URI"] == "/ambassadeurs/") {
    get_header("ambassadeur");
}
else
    get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

<!--			--><?php //while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
//					if ( comments_open() || '0' != get_comments_number() )
//						comments_template();
				?>

<!--			--><?php //endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
