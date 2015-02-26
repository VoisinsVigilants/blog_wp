<?php
/*
Plugin Name: Easy Custom Auto Excerpt
Plugin URI: http://www.tonjoo.com/easy-custom-auto-excerpt/
Description: Auto Excerpt for your post on home, front_page, search and archive.
Version: 2.1.0
Author: tonjoo
Author URI: http://www.tonjoo.com/
Contributor: Todi Adiyatmo Wijoyo, Haris Ainur Rozak
*/

define("TONJOO_ECAE", 'easy-custom-auto-excerpt');
define("ECAE_VERSION", '2.1.0');
define('ECAE_DIR_NAME', str_replace("/easy-custom-auto-excerpt.php", "", plugin_basename(__FILE__)));

require_once( plugin_dir_path( __FILE__ ) . 'ajax.php');

function tonjoo_ecae_plugin_init()
{
    // modify post object here
    global $is_main_query_ecae;

    $is_main_query_ecae=true;

    // Localization
    load_plugin_textdomain(TONJOO_ECAE, false, dirname(plugin_basename(__FILE__)) . '/languages');
}

add_action('plugins_loaded', 'tonjoo_ecae_plugin_init');

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'tonjoo_ecae_donate');

function tonjoo_ecae_donate($links)
{
    $donate_link = '<a href="http://tonjoo.com/donate/" target="_blank" >Donate</a>';    
    array_push($links, $donate_link);

    if(! function_exists('is_ecae_premium_exist'))
    {
        $premium_link = '<a href="http://tonjoo.com/addons/easy-custom-auto-excerpt-premium/" target="_blank" >Upgrade to premium</a>';
        array_push($links, $premium_link);
    }

    return $links;
}


/**
 * admin_enqueue_scripts
 */
add_action('admin_enqueue_scripts', 'ecae_admin_enqueue_scripts', 100);

function ecae_admin_enqueue_scripts()
{
    if(isset($_GET['page']) && $_GET['page'] == "tonjoo_excerpt")
    {
        //print script
        echo "<script type='text/javascript'>";
        echo "var ecae_dir_name = '".plugins_url( ECAE_DIR_NAME , dirname(__FILE__) )."';";
        echo "var ecae_button_dir_name = '".plugins_url( ECAE_DIR_NAME.'/buttons/' , dirname(__FILE__) )."';";

        if(function_exists('is_ecae_premium_exist')) {
            echo "var ecae_premium_dir_name = '".plugins_url( ECAE_PREMIUM_DIR_NAME , dirname(__FILE__) )."';";
            echo "var ecae_button_premium_dir_name = '".plugins_url( ECAE_PREMIUM_DIR_NAME.'/buttons/' , dirname(__FILE__) )."';";
            echo "var ecae_premium_enable = true;";
        }
        else
        {
            echo "var ecae_button_premium_dir_name = '".plugins_url( ECAE_DIR_NAME.'/assets/premium-promo/' , dirname(__FILE__) )."';";
            echo "var ecae_premium_enable = false;";
        }
        
        echo "</script>";

        // javascript
        wp_enqueue_script('ace-js',plugin_dir_url( __FILE__ )."assets/ace-min-noconflict-css-monokai/ace.js",array(),ECAE_VERSION);
        wp_enqueue_script('select2-js',plugin_dir_url( __FILE__ )."assets/select2/select2.js",array(),ECAE_VERSION);  

        // css
        wp_enqueue_style('select2-css',plugin_dir_url( __FILE__ )."assets/select2/select2.css",array(),ECAE_VERSION);

        // admin script and stylel
        wp_enqueue_script('ecae-admin-js',plugin_dir_url( __FILE__ )."assets/script.js",array(),ECAE_VERSION);
        wp_enqueue_style('ecae-admin-css',plugin_dir_url( __FILE__ )."assets/style.css",array(),ECAE_VERSION);
    }
}


/**
 * wp_enqueue_scripts
 */
add_action('wp_enqueue_scripts', 'ecae_wp_enqueue_scripts', 100);

function ecae_wp_enqueue_scripts()
{
    //ambil options dari db
    global $options;

    $options = get_option('tonjoo_ecae_options');    
    $options = tonjoo_ecae_load_default($options);

    /**
     * Font
     */
    echo "<style type='text/css'>";

    switch ($options['button_font']) 
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

    echo "p.ecae-button { font-family: '".$options['button_font']."', Helvetica, Arial, sans-serif; }";    
    echo "</style>";


    /**
     * Button skin
     */
    $array_buttonskins = ecae_get_array_buttonskins();

    if(! isset($options['button_skin']) || ! in_array($options['button_skin'], $array_buttonskins))
    {
        $options['button_skin'] = 'ecae-buttonskin-none';
    }   

    /* filter if premium */
    $exp = explode('-PREMIUM', $options['button_skin']);
    if(count($exp) > 1 AND $exp[1] == 'true')
    {
        wp_enqueue_style($exp[0],plugins_url(ECAE_PREMIUM_DIR_NAME."/buttons/{$exp[0]}.css"),array(),ECAE_VERSION);
    }
    else
    {
        wp_enqueue_style($exp[0],plugins_url(ECAE_DIR_NAME."/buttons/{$exp[0]}.css"),array(),ECAE_VERSION);
    }

    // frontend style
    wp_enqueue_style('ecae-frontend-css',plugin_dir_url( __FILE__ )."assets/style-frontend.css",array(),ECAE_VERSION);
}

function ecae_get_array_buttonskins()
{
    $skins = scandir(dirname(__FILE__)."/buttons");

    $button_skin =  array();

    foreach ($skins as $key => $value) {

        $extension = pathinfo($value, PATHINFO_EXTENSION); 
        $filename = pathinfo($value, PATHINFO_FILENAME); 
        $extension = strtolower($extension);
        $the_value = strtolower($filename);

        if($extension=='css')
        {
            array_push($button_skin,$the_value);
        }
    }

    if(function_exists('is_ecae_premium_exist')) 
    {
        $skins = scandir(ABSPATH . 'wp-content/plugins/'.ECAE_PREMIUM_DIR_NAME.'/buttons');

        foreach ($skins as $key => $value) {

            $extension = pathinfo($value, PATHINFO_EXTENSION); 
            $filename = pathinfo($value, PATHINFO_FILENAME); 
            $extension = strtolower($extension);
            $the_value = strtolower($filename);

            if($extension=='css')
            {
                array_push($button_skin,$the_value.'-PREMIUMtrue');
            }
        }
    }

    return $button_skin;
}

/** 
 * Display a notice that can be dismissed 
 */
add_action('admin_notices', 'ecae_premium_notice');
function ecae_premium_notice() 
{
    global $current_user ;

    $user_id = $current_user->ID;
    $ignore_notice = get_user_meta($user_id, 'ecae_premium_ignore_notice', true);
    $ignore_count_notice = get_user_meta($user_id, 'ecae_premium_ignore_count_notice', true);
    $max_count_notice = 15;

    // if usermeta(ignore_count_notice) is not exist
    if($ignore_count_notice == "")
    {
        add_user_meta($user_id, 'ecae_premium_ignore_count_notice', $max_count_notice, true);

        $ignore_count_notice = 0;
    }

    // display the notice or not
    if($ignore_notice == 'forever')
    {
        $is_ignore_notice = true;
    }
    else if($ignore_notice == 'later' && $ignore_count_notice < $max_count_notice)
    {
        $is_ignore_notice = true;

        update_user_meta($user_id, 'ecae_premium_ignore_count_notice', intval($ignore_count_notice) + 1);
    }
    else
    {
        $is_ignore_notice = false;
    }

    /* Check that the user hasn't already clicked to ignore the message & if premium not installed */
    if (! $is_ignore_notice  && ! function_exists("is_ecae_premium_exist")) 
    {
        echo '<div class="updated"><p>';
        printf(__('Get 40+ read more button style, <a href="%1$s" target="_blank">Get Easy Custom Auto Excerpt Premium !</a> <span style="float:right;"><a href="%2$s" style="color:#a00;">Don\'t bug me again</a> <a href="%3$s" class="button button-primary" style="margin:-5px -5px 0 5px;vertical-align:baseline;">Not Now</a></span>'), 'https://tonjoo.com/addons/easy-custom-auto-excerpt-premium/', '?ecae_premium_nag_ignore=forever', '?ecae_premium_nag_ignore=later');
        echo "</p></div>";
    }
}

add_action('admin_init', 'ecae_premium_nag_ignore');
function ecae_premium_nag_ignore() 
{
    global $current_user;
    $user_id = $current_user->ID;

    // If user clicks to ignore the notice, add that to their user meta
    if (isset($_GET['ecae_premium_nag_ignore']) && $_GET['ecae_premium_nag_ignore'] == 'forever') 
    {
        update_user_meta($user_id, 'ecae_premium_ignore_notice', 'forever');
    }
    else if (isset($_GET['ecae_premium_nag_ignore']) && $_GET['ecae_premium_nag_ignore'] == 'later') 
    {
        update_user_meta($user_id, 'ecae_premium_ignore_notice', 'later');
        update_user_meta($user_id, 'ecae_premium_ignore_count_notice', 0);

        $total_ignore_notice = get_user_meta($user_id, 'ecae_premium_ignore_count_notice_total', true); 

        if($total_ignore_notice == '') $total_ignore_notice = 0;

        update_user_meta($user_id, 'ecae_premium_ignore_count_notice_total', intval($total_ignore_notice) + 1);

        if(intval($total_ignore_notice) >= 5)
        {
            update_user_meta($user_id, 'ecae_premium_ignore_notice', 'forever');
        }
    }
}

/**
 * activate hook
 */
// register_activation_hook( __FILE__, 'ecae_activate' );
// function ecae_activate() 
// {
//     global $current_user;
//     $user_id = $current_user->ID;
//     update_user_meta($user_id, 'ecae_premium_ignore_notice', 'always show');
// }

/**
 * Main Query Check
 */
add_action( 'loop_end', 'tonjoo_ecae_loop_end' );
function tonjoo_ecae_loop_end( $query ) 
{
    // modify post object here
    global $is_main_query_ecae;

    $is_main_query_ecae=false;

    if($query->is_main_query()){
        $is_main_query_ecae=true;
    }
}

/**
 * Do Filter after this 
 * add_filter('the_content', 'do_shortcode', 11); // AFTER wpautop()
 * So we can preserve shortcode
 */
add_filter('the_content', 'tonjoo_ecae_execute', 10);

function tonjoo_ecae_execute($content, $width = 400)
{
    global $options;
    global $content_pure;

    if($options['special_method'] == 'yes')
    {
        global $is_main_query_ecae;
    
        if(!$is_main_query_ecae) 
            return $content;
    }

    $content_pure = $content;

    //if not post type FRS
    if('pjc_slideshow' == get_post_type())
    {
        return $content;

        exit;
    }
    
    $width   = $options['width'];
    $justify = $options['justify'];    

    /**
     * no limit number if 1st-paragraph mode
     */
    if(strpos($options['excerpt_method'],'-paragraph'))
    {
        if(function_exists("is_ecae_premium_exist"))
        {
            $width = strlen(wp_kses($content,array())); //max integer in 32-bit system
        }
        else
        {
            $options['excerpt_method'] = 'paragraph';
        }
    }
    
    if ($options['home'] == "yes" && is_home()) {
        return tonjoo_ecae_excerpt($content, $width, $justify);
    }

    if ($options['front_page'] == "yes" && is_front_page()) {
        return tonjoo_ecae_excerpt($content, $width, $justify);
    }
    
    if ($options['archive'] == "yes" && is_archive()) {
        return tonjoo_ecae_excerpt($content, $width, $justify);
    }

    /** 
     * excerpt in pages 
     */
    $excerpt_in_page = $options['excerpt_in_page'];
    $excerpt_in_page = trim($excerpt_in_page);

    //prevent white space explode
    if($excerpt_in_page!='')
    {
        $excerpt_in_page = explode('|',$excerpt_in_page);
    }
    else
    {
        $excerpt_in_page = array();
    }

    foreach ($excerpt_in_page as $key => $value)
    {
        if(is_page($value)) return tonjoo_ecae_excerpt($content, $width, $justify);
    }
    

    /**
     * last location check
     */
    if ($options['search'] == "yes" && is_search()) {
        return tonjoo_ecae_excerpt($content, $width, $justify);
    }    
    else {
        return $content;
    }
}


function tonjoo_ecae_excerpt($content, $width, $justify)
{
    global $post;
    global $options;

    $postmeta = get_post_meta($post->ID, 'ecae_meta', true);

    if(function_exists('is_ecae_premium_exist') && isset($postmeta['disable_excerpt']) && $postmeta['disable_excerpt'] == 'yes') 
    {
        return $content;

        exit;
    }

    $total_width = 0;
    $pos = strpos($content, '<!--more-->');
    $array_replace_list = array();
    
    //if read more
    if ($pos) 
    {
        //check shortcode optons
        if ($options['strip_shortcode'] == 'yes') {
            $content = strip_shortcodes($content);
        }

        $content = substr($content, 0, $pos);
    } 
    elseif ($post->post_excerpt != '') 
    {
        //check shortcode optons
        if ($options['strip_shortcode'] == 'yes') {
            $content = strip_shortcodes($content);
        }

        $content = $post->post_excerpt;        
    } 
    elseif ($width == 0) 
    {
        $content = '';
    } 
    // elseif (!(strlen($content) <= (int) $width)) 
    else
    {        
        // Do caption shortcode
        $content = ecae_convert_caption($content);
        
        $figure_replace          = new eace_content_regex("|:", "/<figure.*?\>([^`]*?)<\/figure>/",$options,true);
        $hyperlink_image_replace = new eace_content_regex("|#", "/<a[^>]*>(\n|\s)*(<img[^>]+>)(\n|\s)*<\/a>/",$options,true);
        $image_replace           = new eace_content_regex("|(", "/<img[^>]+\>/",$options,true );
        
        //biggest -> lowest the change code

        $html_replace = array();

        $extra_markup = $options['extra_html_markup'];

        $extra_markup = trim($extra_markup);

        //prevent white space explode
        if($extra_markup!='')
            $extra_markup = explode('|',$extra_markup);
        else
            $extra_markup = array();

        $extra_markup_tag=array('*=','(=',')=','_=','<=','>=','/=','\=',']=','[=','{=','}=','|=');

        //default order
        $array_replace_list['pre']='=@'; // syntax highlighter like crayon
        $array_replace_list['video']='=}';
        $array_replace_list['table']='={';    
        $array_replace_list['p']='=!';
        $array_replace_list['b']='=&';
        $array_replace_list['a']='=*';
        $array_replace_list['i']='=)';
        $array_replace_list['h1']='=-';
        $array_replace_list['h2']='`=';
        $array_replace_list['h3']='!=';
        $array_replace_list['h4']='#=';
        $array_replace_list['h5']='$=';
        $array_replace_list['h6']='%=';
        $array_replace_list['ul']='=#';
        $array_replace_list['ol']='=$';
        $array_replace_list['strong']='=(';
        $array_replace_list['blockquote']='=^';
   
        foreach ($extra_markup as $markup) 
        {
            $counter = 0;

            if(!isset($array_replace_list[$markup]))
                $array_replace_list[$markup]=$extra_markup_tag[$counter];

            $counter++;
        }

        //push every markup into processor
        foreach ($array_replace_list as $key=>$value) 
        {
            //use image processing algorithm for table and video
            if($key=='video'||$key=='table')
                $push   = new eace_content_regex("{$value}", "/<{$key}.*?\>([^`]*?)<\/{$key}>/",$options,true);
            else
                $push   = new eace_content_regex("{$value}", "/<{$key}.*?\>([^`]*?)<\/{$key}>/",$options);

            array_push($html_replace, $push);
        }

        $pattern = get_shortcode_regex();

        if(!strpos('hana-flv-player', $pattern))
            $pattern = str_replace('embed','caption|hana-flv-player',$pattern);

        $shortcode_replace = new eace_content_regex("+*", '/'.$pattern.'/s',$options);
        
        //trim image
        $option_image = $options['show_image'];        
        
        if ($option_image == 'yes' || $option_image == 'first-image')
        {
            $number = false;
            //limit the image excerpt
            if ($option_image == 'first-image')
                $number = 1;
            
            $figure_replace->replace($content, $width, $number);            
            $hyperlink_image_replace->replace($content, $width, $number);            
            $image_replace->replace($content, $width, $number);
        }
        else
        {
            //remove image , this is also done for featured-image option
            $figure_replace->remove($content);
            $hyperlink_image_replace->remove($content);
            $image_replace->remove($content);
        }

        // check shortcode optons
        if ($options['strip_shortcode'] == 'yes') {
            $content = strip_shortcodes($content);
        }    

        // Replace remaining tag
        foreach ($html_replace as $replace) {
             $replace->replace($content, $width,false,$total_width);
        }  
       
        $shortcode_replace->replace($content, $width,false,$total_width);
        
        //use wp kses to fix broken element problem
        $content = wp_kses($content, array());

        if(strpos($content,'<!--STOP THE EXCERPT HERE-->')===false)
        {
            //give the stop mark so the plugin can stop
            $content=$content.'<!--STOP THE EXCERPT HERE-->';
        }

        //strip the text
        $content = substr($content, 0, strpos($content,'<!--STOP THE EXCERPT HERE-->'));

        //do the restore 3 times, avoid nesting
        $shortcode_replace->restore($content);

        foreach ($html_replace as $restore) $restore->restore($content, $width);
        foreach ($html_replace as $restore) $restore->restore($content, $width);
        foreach ($html_replace as $restore) $restore->restore($content, $width);

        $shortcode_replace->restore($content);

        /**
         * image position
         */
        switch ($options['image_position']) {
            case 'right':
                $img_position = "";
                break;

            case 'left':
                $img_position = "";
                break;

            case 'center':
                $img_position = "margin-left:auto !important; margin-right:auto !important;";
                break;

            case 'float-left':
                $img_position = "float:left;";
                break;

            case 'float-right':
                $img_position = "float:right;";
                break;
            
            default:
                $img_position = "text-align:right;";
                break;
        }

        $img_added_css = $img_position;

        /*if($options['image_width_type'] == 'manual')
        {
            $img_added_css.= "width:{$options['image_width']}%;";
        }*/
        
        $img_added_css.= "padding:{$options['image_padding_top']}px {$options['image_padding_right']}px {$options['image_padding_bottom']}px {$options['image_padding_left']}px;";
                
        if ($option_image == 'yes')
        {
            $figure_replace->restore($content,false,true);
            $hyperlink_image_replace->restore($content,false,true);
            $image_replace->restore($content,false,true);            
        } 
        elseif ($option_image == 'first-image') 
        {
            //catch all of hyperlink and image on the content => '|#'  and '|('' 
            preg_match_all('/\|\([0-9]*\|\(|\|\#[0-9]*\|\#|\|\:[0-9]*\|\:/', $content, $result, PREG_PATTERN_ORDER);

            if (isset($result[0])) 
            {
                $remaining = array_slice($result[0], 0, 1);
                
                if(isset($remaining[0]))
                {
                    //delete remaining image
                    $content = preg_replace('/\|\:[0-9]*\|\:/', '', $content);
                    $content = preg_replace('/\|\([0-9]*\|\C/', '', $content);
                    $content = preg_replace('/\|\#[0-9]*\|\#/', '', $content);

                    
                    if($options['image_position'] == 'left')
                    {
                        $content = "<div class='ecae-image ecae-table-left'><div class='ecae-table-cell' style='$img_added_css'>" . $remaining[0] . "</div>" . "<div class='ecae-table-cell'>" . $content . '</div>' ;
                    }
                    else if($options['image_position'] == 'right')
                    {
                        $content = "<div class='ecae-image ecae-table-right'><div class='ecae-table-cell' style='$img_added_css'>" . $remaining[0] . "</div>" . "<div class='ecae-table-cell'>" . $content . '</div>' ;
                    }
                    else
                    {
                        $content = "<div class='ecae-image' style='$img_added_css'>" . $remaining[0] . "</div>" . $content;
                    }

                    $figure_replace->restore($content, 1,true);
                    $hyperlink_image_replace->restore($content, 1,true);
                    $image_replace->restore($content, 1,true);
                }
            }
        } 
        elseif ($option_image == 'featured-image') 
        {
            //check featured image;
            $featured_image = has_post_thumbnail(get_the_ID());
            $image = false;

            if($featured_image) $image = get_the_post_thumbnail(get_the_ID());
            
            // only put image if there is image :p
            if($image)
            {
                if($options['image_position'] == 'left')
                {
                    $content = "<div class='ecae-image ecae-table-left'><div class='ecae-table-cell' style='$img_added_css'>" . $image . "</div>" . "<div class='ecae-table-cell'>" . $content . '</div>' ;
                }
                else if($options['image_position'] == 'right')
                {
                    $content = "<div class='ecae-image ecae-table-right'><div class='ecae-table-cell' style='$img_added_css'>" . $image . "</div>" . "<div class='ecae-table-cell'>" . $content . '</div>' ;
                }
                else
                {
                    $content = "<div class='ecae-image' style='$img_added_css'>" . $image . "</div>" . $content;
                }
            }
        }
 
        //delete remaining image
        $content = preg_replace('/\|\([0-9]*\|\C/', '', $content);
        $content = preg_replace('/\|\#[0-9]*\|\#/', '', $content);
            
        //delete remaining
        $extra_markup_tag=array('*='.'(=',')=','_=','<=','>=','/=','\=',']=','[=','{=','}=','|=');

        foreach ($extra_markup_tag as $value) 
        {
            $char = str_split($value);

            $content = preg_replace("/"."\\"."{$char[0]}"."\\"."{$char[1]}"."[0-9]*"."\\"."{$char[0]}"."\\"."{$char[1]}"."/", '', $content);
        }        

        foreach($array_replace_list as $key=>$value) 
        {
            $char = str_split($value);

            $content = preg_replace("/"."\\"."{$char[0]}"."\\"."{$char[1]}"."[0-9]*"."\\"."{$char[0]}"."\\"."{$char[1]}"."/", '', $content);
        }        
    }
    

    /**
     * readmore text
     */
    $link = get_permalink();
    $readmore = "";

    //remove last div is image position left / right
    if($options['image_position'] == 'left' || $options['image_position'] == 'right' && strpos($content, 'ecae-table-cell'))
    {
        if(strpos($content, 'ecae-table-cell')) $content = substr($content, 0, -6);
    }
        
    if (trim($options['read_more']) != '-') 
    {
        //failsafe
        $options['read_more_text_before'] = isset($options['read_more_text_before'] )? $options['read_more_text_before']  : '...';

        $button_skin = explode('-PREMIUM', $options['button_skin']);
        $trim_readmore_before = trim($options['read_more_text_before']);

        $read_more_text_before = empty($trim_readmore_before) ? $options['read_more_text_before'] : $options['read_more_text_before']."&nbsp;&nbsp;";
        
        $readmore_link = "<div class='read-more'><a class='button' href='$link'>Lire la Suite</a></div>";
        //$readmore_link = " <a class='ecae-link' href='$link'><span>{$options['read_more']}</span></a>";
        $readmore = "<p class='ecae-button {$button_skin[0]}' style='text-align:{$options['read_more_align']};' >$read_more_text_before $readmore_link</p>";
        $consult_link = "<div class='read-more'><a class='button' href='$link'>Consulter l'article</a></div>";
        $consult = "<p class='ecae-button {$button_skin[0]}' style='text-align:{$options['read_more_align']};' >$read_more_text_before $consult_link</p>";
        
        // always_show_read_more
        if(! strpos($options['excerpt_method'],'-paragraph'))
        {
          
            if($options['always_show_read_more'] == 'yes')
            {
                $content = str_replace('<!-- READ MORE TEXT -->', '', $content);
                $content = $content . $readmore;

            }
            else
            {
                if (!strstr($_SERVER["REQUEST_URI"], "/regions-")) 
                {
                  if (strpos($content, '<!-- READ MORE TEXT -->'))
                  {
                    $content = str_replace('<!-- READ MORE TEXT -->', ' &hellip;<!-- READ MORE TEXT -->', $content);
                    $content = str_replace('<!-- READ MORE TEXT -->', $readmore, $content);
                  }
                  else
                    $content .= $consult;
                }
            }
        }
    }
    
    if ($justify != "no") {
        $content = "<div class='ecae' style='text-align:$justify'>" . $content . "</div>";
    }

    /**
     * filter if 1st-paragraph mode 
     */
    if(strpos($options['excerpt_method'],'-paragraph'))
    {
        $num_paragraph = substr($options['excerpt_method'], 0, 1);
        $content = get_per_paragraph(intval($num_paragraph), $content);

        global $content_pure;

        $len_content = strlen(wp_kses($content,array())) + 1;  // 1 is a difference between them
        $len_content_pure = strlen(wp_kses($content_pure,array()));

        // always_show_read_more
        if($options['always_show_read_more'] == 'yes')
        {
            $content = $content . $readmore;
        }
        else 
        {
            if($len_content < $len_content_pure)
            {
                $content = $content . $readmore;
            }    
        }
    }

    //add last div is image position left / right
    if($options['image_position'] == 'left' || $options['image_position'] == 'right')
    {
        if(strpos($content, 'ecae-table-cell')) $content .= '</div>';
    }
    
    /**
     * custom css
     */    
    $style = "<style type='text/css'>";
    $style.= $options["custom_css"];

    if(function_exists('is_ecae_premium_exist') && isset($options["button_font_size"]))
    {
        $style.= '.ecae-button { font-size: '.$options["button_font_size"].'px !important; }';
    }
    
    $style.= "</style>";

    // remove empty html tags
    if($options["strip_empty_tags"] == 'yes')
    {
        $content = strip_empty_tags($content);
    }    

    return "<!-- Generated by Easy Custom Auto Excerpt -->$style $content<!-- Generated by Easy Custom Auto Excerpt -->";
}

class eace_content_regex
{
    var $key;
    var $holder;
    var $regex;
    var $unique_char;
    var $image;
    var $options;
    
    public function __construct($unique_char, $regex,$options,$image=false)
    {
        $this->regex = $regex;
        $this->unique_char = $unique_char;

        $this->image = $image;
        $this->options = $options;
    }
    
    public function replace(&$content, &$width, $number = false, &$total_width=0)
    {
        //get all image in the content    
        preg_match_all($this->regex, $content, $this->holder, PREG_PATTERN_ORDER);
    
        $this->key = 0;        

        //only cut bellow the $number variabel treshold ( to limit the number of replacing)
        if($number) array_slice($this->holder[0], 0, $number);
        
        foreach ($this->holder[0] as $text) 
        {
            $unique_key = "{$this->unique_char}{$this->key}{$this->unique_char}";
            
            $content   = str_replace($text, $unique_key, $content);

            if(!$this->image&&strpos($content,'<!--STOP THE EXCERPT HERE-->')===false)
            {
                $total_width = $total_width + strlen(wp_kses($text,array()));         

                if($total_width > $width && !strpos($this->options['excerpt_method'],'-paragraph'))
                {
                    //tell plugin to stop at this point
                    $content = str_replace($unique_key, "{$unique_key}<!--STOP THE EXCERPT HERE--><!--- SECRET END TOKEN ECAE --->",$content);
                    //exit loop
                    
                    if($this->options['excerpt_method'] == 'word')
                    {
                        //if use word cut technique
                        $overflow = $total_width - $width;

                        $current_lenght =  strlen(wp_kses($text,array()));

                        $overflow = $current_lenght-$overflow;

                        // $pos = get cut position based on fixed position ($overflow), but without break last word
                        $pos = strpos($text, ' ', $overflow);
                        $holder_str = substr($text,0,$pos);

                        // delete last non alphanumeric character
                        $holder_str = preg_replace("/[^A-Za-z0-9 ]$/", '', $holder_str);
                        
                        $holder_str = wp_kses($holder_str,array()); 

                        $holder_str  = "<p>{$holder_str}<!-- READ MORE TEXT --></p>";  
                    
                        $this->holder[0][$this->key] = $holder_str;
                    }
                    else
                    {
                        //if use preserve paragraph technique
                        $this->holder[0][$this->key]  = "{$this->holder[0][$this->key]}<!-- READ MORE TEXT -->";  
                    }         

                    //strip the text
                    $content = substr($content, 0, strpos($content,'<!--- SECRET END TOKEN ECAE --->'));
                    
                    break;
                }
            }

            $this->key = $this->key + 1;
        } 
    }

    function restore(&$content, $maximal = false)
    {
        //maximal number to restore
        if (!$maximal) $maximal = $this->key;
        
        //serves as counter, how many replace are made
        $i = 0;

        for ($i; $i < $maximal; $i++) {
            if (isset($this->holder[0][$i]))
            {
                $content = str_replace("{$this->unique_char}{$i}{$this->unique_char}", $this->holder[0][$i], $content);
            }
        }
    }
    
    function remove(&$content)
    {        
        $content = preg_replace($this->regex, "", $content);
    }
}

function ecae_convert_caption($content)
{
    $results[0] = array();

    $pattern = '/\[(\[?)(caption)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)/s';

    preg_match_all($pattern, $content, $results);

    foreach ($results[0] as $result) 
    {
        $caption = do_shortcode($result);
        $content = str_replace($result,$caption, $content);
    }   

    return $content;
}

function strip_empty_tags ($str, $repto = NULL)
{
    //** Return if string not given or empty.
    if (!is_string ($str)
        || trim ($str) == '')
            return $str;

    //** Recursive empty HTML tags.
    return preg_replace (

        //** Pattern written by Junaid Atari.
        '/<([^<\/>]*)>([\s]*?|(?R))<\/\1>/imsU',

        //** Replace with nothing if string empty.
        !is_string ($repto) ? '' : $repto,

        //** Source string
        $str
    );
}

require_once(plugin_dir_path(__FILE__) . 'tonjoo-library.php');
require_once(plugin_dir_path(__FILE__) . 'default.php');
require_once(plugin_dir_path(__FILE__) . 'options-page.php');