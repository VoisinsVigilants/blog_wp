<?php
/**
 * @package Elucidate
 */
?>
<div style="">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<hearder class="entry-header">

        <?php
        the_category(', ') ?>
        <?php if ( is_single() ) { ?>
            <h1 class="entry-title"><?php the_title(); ?></h1>
        <?php } else { ?>
            <h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
        <?php } ?>

        <?php  if ( is_sticky() ) { ?>
			<div class="sticky_post">
				<?php _e( 'Sticky Post', 'elucidate' ); ?>
			</div>
		<?php } ?>
        <div>
            <div style="font-size: 14px;float: left;margin-top: 5px">
                <?php
                elucidate_time();
                echo "  ";
                if ( get_the_author_meta( 'display_name' )) {
                    echo "<div class='byline'>";
                        echo elucidate_byline();
                    echo "</div>";
                    }
                echo " | ";
                comments_popup_link( false, __( '1 Comment', 'elucidate' ), __( '% Comments', 'elucidate' ), 'nb-comments' );
                ?>
            </div>
            <div style="float: right">
                <?php echo hupso_the_content_shortcodes($content); ?>
            </div>
            <div style="clear: both"></div>
        </hearder>
        <?php if (get_the_tag_list( '', __( ', ', '_s' ) ) !== false ) {?>
        <div class="entry-meta">
            <?php elucidate_meta(); ?>

            <!--		--><?php //edit_post_link( __( 'Edit', 'elucidate' ), '<span class="edit-link">', '</span>' ); ?>
        </div><!-- .entry-meta -->
        <?php } ?>


	</div><!-- .entry-header -->

	<div class="entry-content">
		<?php if ( has_post_thumbnail() && ! post_password_required() ) { ?>
			<p class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</p>
		<?php } ?>
        <?php 
        the_content(); 
        ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'elucidate' ),
				'after'  => '</div>',
			) );
		?>
        <?php if ( !is_single() ) {/* ?>
            <div class="read-more"><a class='button' href='<?php the_permalink();?>' >Lire la suite</a></div>
        <?php */}?>
                <?php
                if ( is_single() ) { ?>
                    <div class="back-index"><a class="button" href="<?php echo /*(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : */esc_url( home_url( '/' ) )/*)*/.'#post-';the_ID(); ?>"><?php echo __('Back', 'elucidate') ?></a></div>
                <?php }
                ?>
	</div><!-- .entry-content -->


</article><!-- #post-## -->
</div>
<div style="clear: both"></div>

