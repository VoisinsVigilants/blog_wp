<?php
/**
 * @package Elucidate
 */
// function remove_images($content)
// {
//   if (is_single() === false)
//     return preg_replace('/<img[^>]+./', '', $content);
//   return $content;
// }

// function remove_videos($content)
// {
//   if (is_single() === false)
//     return preg_replace('#(.*?)iframe(.*)#', '', $content);

//   return $content;
// }


$template_url = get_template_directory_uri();
$content = get_the_content(null, false);
$searchimages = '~<img [^>]* />~';
preg_match_all( $searchimages, $content, $pics );

$searchvideos = '#(.*?)iframe(.*)#';

$content = apply_filters( 'the_content', $content );
$content = str_replace( ']]>', ']]&gt;', $content );
preg_match( $searchvideos, $content, $video);
if (isset($video[0])) {
  $searchvideos = '#src=\"(.*)\" ?#';
  
  preg_match( $searchvideos, $content, $video);


}
?>

    <article id="article-ambassadeur-<?php the_ID(); ?>" class="article-ambassadeur">
        <?php
        $float = '';
        if (!isset($video[0]) && isset($pics[0][0])) {
          $img = preg_replace('#\s(class)="[^"]+"#', '', $pics[0][0]);
            echo "<div class='post-img'>".$img."</div>";
            $float = 'float:left;';
        }
        else if (isset($video[0]))
        {
          $video = explode(' ', $video[1]);
          $float = 'float:left';
          $video = str_replace('"', '', $video[0]);
          echo "<div class='post-img'><iframe src='".$video."' width='350' height='350' allowfullscreen> </iframe></div>";
        }
        ?>
        <div id="article-<?php the_ID(); ?>" class="<?php echo ($float != '' ? "entry-header-img" : ''); ?> ">
            <?php //if (isset($pics[0][0]) || isset($video[0])) {echo "entry-header-img";}?>
            <header  class="entry-header">
                <div style="clear: both;margin-right: 30px; font-size: 14px"><?php elucidate_time(); ?></div>
    
                <h1 id="hearder-<?php the_ID(); ?>" class='entry-title'>
                <?php
                if ( is_single() ) { ?>
                    <?php the_title(); ?></h1>
                <?php } else { ?>
                    <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
                <?php } ?>
                <?php  if ( is_sticky() ) { ?>
                    <div class="sticky_post">
                        <?php _e( 'Sticky Post', 'elucidate' ); ?>
                    </div>
                <?php } ?>
    
            </header>
            <?php
            if (isset($video[0]) || isset($pics[0][0])) {
              echo "<div class='entry'>";
            }
            else {
                echo "<div class='entry' style='width: 100%'>";
            }
            ?>
    
            <!-- .entry-header -->
            <?php if (isset($pics[0][0]) || isset($video[0])) {?>
                <div id='entry-content-<?php the_ID(); ?>' class='entry-content'>
            
            <?php }
            else {
                echo "<div class='entry-content''>";
            }
            ?>
    
                <?php if ( has_post_thumbnail() && ! post_password_required() ) { ?>
                    <p class="post-thumbnail">
                        <?php the_post_thumbnail(); ?>
                    </p>
                <?php } ?>
    
                <?php
                if (is_single() === false)
                {
                  $content = get_the_content(null, false);
                  $content = apply_filters( 'the_content', $content );
                  $content = str_replace( ']]>', ']]&gt;', $content );
                  $content = preg_replace('/<img[^>]+./', '', $content);
                  $content = preg_replace('#(.*?)iframe(.*)#', '', $content);
                  echo $content;
                  
                }
                else 
                {
                  the_content();
                }
                ?>
                <?php
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . __( 'Pages:', 'elucidate' ),
                    'after'  => '</div>',
                ) );
                ?>
    
    
                <?php
                if ( is_single() ) { ?>
                    <div class="back-index"><a class="button" href="<?php echo /*(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : */esc_url( home_url( '/' ) )/*)*/.'#post-';the_ID(); ?>"><?php echo __('Back', 'elucidate') ?></a></div>
                <?php }
                ?>
            </div><!-- .entry-content -->
        </div>
        <div id="read_more-<?php the_ID(); ?>" class="comment-read-more <?php if ($pics[0][0]) {echo "comment-read-more-img";} ?>">
            <div class="comment-ambassadeur">
                <img src="<?php echo $template_url?>/img/comment.png">
                <?php
                comments_popup_link( false, __( '1 Comment', 'elucidate' ), __( '% Comments', 'elucidate' ), 'nb-comments' );?>
            </div>
            <div class="read-more-ambassadeur">
                <a class='button read-more' href='<?php the_permalink();?>' >Lire la suite</a>
            </div>
        </div>
        <div style="clear: both"></div>
        </div>

        <?php
        if (get_the_tag_list( '', __( ', ', '_s' ) ) !== false ) {?>
            <footer class="entry-meta">
                <?php elucidate_meta(); ?>

            </footer><!-- .entry-meta -->
        <?php } ?>
        <div style="clear: both"></div>
    </article><!-- #post-## -->

<div style="clear: both"></div>
<style>
    p {
    	margin-bottom :0
    }
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
        
        var post_id = <?php the_ID(); ?>;
        
        div = 'hearder-'+post_id;
        var height_hearder = $("#"+div).css('height');
        div = 'entry-content-'+post_id;
        var new_height = 200-22-parseInt(height_hearder)-35;
        new_height2 = parseInt(new_height / 21, 10);
        $("#"+div).height(new_height2*21);
        if (new_height < 105) {
          div = 'read_more-'+post_id;
          $("#"+div).css("margin-top" ,parseInt(new_height - (new_height2*21), 10));
        }
</script>
