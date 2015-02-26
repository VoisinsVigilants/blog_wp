<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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
            <?php
                if (strstr($_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"], $blog_details->domain."/regions-") !== false || $_SERVER["REQUEST_URI"] == "/ambassadeurs/") {
                    $blog_url = get_template_directory_uri();
                    $blog_id = get_current_blog_id();
                    echo "<link rel='stylesheet' href='$blog_url/style-ambassadeur.css' type='text/css' media='screen' />";
                    echo  "<div class='img-ambassadeur'><img src='$blog_url/regions/$blog_id.png'></div>";
                }
            ?>
		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
                 if (strstr($_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"], $blog_details->domain."/regions-") !== false) {
                    get_template_part( 'content-ambassadeur', false );
                }
                else {
                    get_template_part( 'content', false );
                } ?>

			<?php endwhile; ?>

			<?php //elucidate_content_nav( 'nav-below' );
                wp_paginate();?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'index' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
if (strstr($_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"], $blog_details->domain."/regions-") !== false) {
    get_sidebar("ambassadeur");
}
else
    get_sidebar();
?>
<?php get_footer(); ?>
