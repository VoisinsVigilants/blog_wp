<?php
/**
 * The template for displaying Search Results pages.
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
	<section id="primary" class="content-area">
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

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'elucidate' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'ambassadeur' ); ?>

			<?php endwhile; ?>

<!--			--><?php //elucidate_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'search' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>