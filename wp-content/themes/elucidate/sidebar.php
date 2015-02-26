<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Elucidate
 */
?>

<?php if (strstr($_SERVER["REQUEST_URI"], "/regions-")) { ?>
<div id="secondary" class="widget-area" role="complementary" style="border: 1px solid #C9C8D1;padding: 10px 10px;margin-bottom: 15px">
<?php

$args = array(
    'blog_id'      => $GLOBALS['blog_id'],
    'role'         => 'contributor',
    'meta_key'     => '',
    'meta_value'   => '',
    'meta_compare' => '',
    'meta_query'   => array(),
    'include'      => array(),
    'exclude'      => array(),
    'orderby'      => 'login',
    'order'        => 'ASC',
    'offset'       => '',
    'search'       => '',
    'number'       => '',
    'count_total'  => false,
    'fields'       => 'all',
    'who'          => ''
);

$data = get_users( $args );

$lien = get_template_directory_uri()."/ambassadeurs/".$data[0]->ID.".png";
echo "<div class='img-profil-ambassadeur'>
<img src='$lien'>
</div>";

$prenom = get_the_author_meta('first_name', $data[0]->ID);
    $nom = get_the_author_meta('last_name', $data[0]->ID);
        $description = get_the_author_meta('description', $data[0]->ID);
        echo "<div class='nom-prenom'>$nom $prenom</div>";
        echo "<div class='description-ambassadeur'>$description</div>";
        ?>
</div>
<?php }?>
	<div id="secondary" class="widget-area" role="complementary" style="border: 1px solid #C9C8D1;padding: 10px 10px;">
		<?php do_action( 'before_sidebar' );?>
        <aside id="search" class="widget widget_search">
            <?php get_search_form(); ?>
        </aside>
		<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

            <aside id="search" class="widget widget_search">
                <?php get_search_form(); ?>
            </aside>

			<aside id="search" class="widget widget_search">
				<?php get_search_form(); ?>
			</aside>

			<aside id="archives" class="widget">
				<h1 class="widget-title"><?php _e( 'Archives', 'elucidate' ); ?></h1>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</aside>

			<aside id="meta" class="widget">
				<h1 class="widget-title"><?php _e( 'Meta', 'elucidate' ); ?></h1>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</aside>

		<?php endif; // end sidebar widget area ?>
</div><!-- #secondary -->
