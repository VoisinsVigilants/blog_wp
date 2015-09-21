<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Elucidate
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta property="og:image" content="http://blog.voisinsvigilants.org/wp-content/themes/elucidate/img/logo_partage.png" />

    <meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel= "icon" href="<?php echo get_template_directory_uri();?>/img/favicon.png" type="image/x-icon" />
<?php wp_head(); ?>
  <script type="text/javascript">
  <!--
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  
    ga('create', 'UA-29923651-2', 'auto');
    ga('send', 'pageview');
  //-->
  </script>

</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header id="masthead" class="site-header" role="banner">
<!--        <head>-->
<!--            <meta property="og:type" content="video" >-->

            <!--            <meta property="og:video" content="https://www.youtube.com/watch?v=-w1zSfJZbeA" />-->
<!--        </head>-->
        <div class="site-branding">
            <div class="link-vv">
                <img style="width: 15px;" src="<?php echo get_template_directory_uri();?>/img/oeil.png">
                <a href="http://www.voisinsvigilants.org">accéder au site voisinsvigilants.org</a>
            </div>
            <a rel="home" href="<?php echo home_url()?>"><img src="<?php echo get_template_directory_uri();?>/img/logoBlog.png" ></a>

        </div>
        <div style="clear: both"></div>

        <div>
            <div class="before-site-title"></div>
            <div class="site-title"><h1><?php bloginfo( 'description' ); ?></h1></div>
            <div class="after-site-title"></div>
            <div class="site-description"><h2 ><?php bloginfo( 'name' ); ?></h2></div>
            <div style="clear: both;border-bottom: 2px solid black;width: 98%;height: 10px;float: left;margin-left: 1%;margin-right: 1%;margin-bottom: 15px"></div>
        </div>
        <div style="clear: both"></div>
        <div class="text-menu-vv"><?php echo __('Discover all the blog links to the device Voisins Vigilant', 'elucidate')?></div>
        <?php  $blog_details = get_blog_details(1);?>
        <div class="menu-vv">
            <a href="http://<?php echo $blog_details->domain ?>"><div class="<?php echo $_SERVER["REQUEST_URI"] == "/" || (!strstr($_SERVER["REQUEST_URI"], "/ambassadeurs/") && !strstr($_SERVER["REQUEST_URI"], "/presse/") && !strstr($_SERVER["REQUEST_URI"], "/securite/") && !strstr($_SERVER["REQUEST_URI"], "/regions-")) ? "link-menu-vv-selected" : "link-menu-vv" ?>"><img src="<?php echo get_template_directory_uri().($_SERVER["REQUEST_URI"] == "/" || (!strstr($_SERVER["REQUEST_URI"], "/ambassadeurs/") && !strstr($_SERVER["REQUEST_URI"], "/presse/") && !strstr($_SERVER["REQUEST_URI"], "/securite/") && !strstr($_SERVER["REQUEST_URI"], "/regions-")) ? "/img/oeil_BLANC.png" : "/img/oeil.png");?>"/>VOISINS VIGILANTS</div></a>
            <a href="http://<?php echo $blog_details->domain ?>/ambassadeurs/"><div class="<?php echo strstr($_SERVER["REQUEST_URI"], "/ambassadeurs/") || strstr($_SERVER["REQUEST_URI"], "/regions-") ? "link-menu-vv-selected" : "link-menu-vv" ?>"><img src="<?php  echo get_template_directory_uri().($_SERVER["REQUEST_URI"] == "/ambassadeurs/" || strstr($_SERVER["REQUEST_URI"], "/regions-") ? "/img/ambassadeurs_BLANC.png" : "/img/ambassadeurs.png");?>">AMBASSADEURS</div></a>
            <a href="http://<?php echo $blog_details->domain ?>/presse/"><div class="<?php echo strstr($_SERVER["REQUEST_URI"], "/presse/") ? "link-menu-vv-selected" : "link-menu-vv" ?>"><img src="<?php echo get_template_directory_uri().(strstr($_SERVER["REQUEST_URI"], "/presse/") ? "/img/presse_BLANC.png" : "/img/presse.png");?>">PRESSE</div></a>
            <a href="http://<?php echo $blog_details->domain ?>/securite/"><div class="<?php echo strstr($_SERVER["REQUEST_URI"], "/securite/") ? "link-menu-vv-selected" : "link-menu-vv" ?>"><img src="<?php  echo get_template_directory_uri().(strstr($_SERVER["REQUEST_URI"], "/securite/") ? "/img/cadenas_BLANC.png" : "/img/cadenas.png");?>">SECURITE</div></a>
            <div style="clear: both"></div>
        </div>

        <!--
        <div>
            <a href="/ambassadeurs/"><img style="padding: 0 1%" width="98%" src="<?php echo get_template_directory_uri();?>/img/ambassadeur.png" ></a>
        </div>
        -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
