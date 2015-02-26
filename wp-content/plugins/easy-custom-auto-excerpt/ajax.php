<?php

/**
 * Ajax preview button
 */
add_action('wp_ajax_ecae_preview_button', 'ecae_preview_button' ); /* for logged in user */

function ecae_preview_button() {
    global $wpdb; // this is how you get access to the database
    /**
     * Font
     */
    echo "<style type='text/css'>";

    switch ($_POST['button_font']) 
    {
        case "Open Sans":
            echo "@import url(http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext);"; //Open Sans
            break;
        case "Lobster":
            echo "@import url(http://fonts.googleapis.com/css?family=Lobster);"; //Lobster
            break;
        case "Lobster Two":
            echo "@import url(http://fonts.googleapis.com/css?family=Lobster+Two:400,400italic,700,700italic);"; //Lobster Two
            break;
        case "Ubuntu":
            echo "@import url(http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic);"; //Ubuntu
            break;
        case "Ubuntu Mono":
            echo "@import url(http://fonts.googleapis.com/css?family=Ubuntu+Mono:400,700,400italic,700italic);"; //Ubuntu Mono
            break;
        case "Titillium Web":
            echo "@import url(http://fonts.googleapis.com/css?family=Titillium+Web:400,300,700,300italic,400italic,700italic);"; //Titillium Web
            break;
        case "Grand Hotel":
            echo "@import url(http://fonts.googleapis.com/css?family=Grand+Hotel);"; //Grand Hotel
            break;
        case "Pacifico":
            echo "@import url(http://fonts.googleapis.com/css?family=Pacifico);"; //Pacifico
            break;
        case "Crafty Girls":
            echo "@import url(http://fonts.googleapis.com/css?family=Crafty+Girls);"; //Crafty Girls
            break;
        case "Bevan":
            echo "@import url(http://fonts.googleapis.com/css?family=Bevan);"; //Bevan
            break;
        default:
            echo "@import url(http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext);"; //Open Sans
    }

    echo "p.ecae-button { font-family: '".$_POST['button_font']."', Helvetica, Arial, sans-serif; }";    
    echo "</style>";

    /**
     * button style
     */
    $exp = explode('-PREMIUM', $_POST['button_skin']);
    if(count($exp) > 1 AND $exp[1] == 'true')
    {
        echo '<link rel="stylesheet" href="'.plugins_url(ECAE_PREMIUM_DIR_NAME."/buttons/{$exp[0]}.css").'" type="text/css" media="all">';
    }
    else
    {
        echo '<link rel="stylesheet" href="'.plugins_url(ECAE_DIR_NAME."/buttons/{$exp[0]}.css").'" type="text/css" media="all">';
    }

    /**
     * custom css
     */
    $style = "<style type='text/css'>";
    $style.= $_POST["custom_css"];

    if(function_exists('is_ecae_premium_exist') && isset($_POST["button_font_size"]))
    {
        $style.= '.ecae-button { font-size: '.$_POST["button_font_size"].'px !important; }';
    }
    
    $style.= "</style>";

    echo $style;

    /**
     * print button
     */
    $button_skin = explode('-PREMIUM', $_POST['button_skin']);
    $trim_readmore_before = trim($_POST['read_more_text_before']);
    $_POST['read_more_text_before'] = empty($trim_readmore_before) ? $_POST['read_more_text_before'] : $_POST['read_more_text_before']."&nbsp;&nbsp;";                          
    $readmore_link = " <a class='ecae-link' href='javascript:;'><span>{$_POST['read_more']}</span></a>";
    $readmore = "<p class='ecae-button {$button_skin[0]}' style='text-align:{$_POST['read_more_align']};' >{$_POST['read_more_text_before']} $readmore_link</p>";
    
    echo $readmore;

    die();
}