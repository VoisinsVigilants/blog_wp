<?php

add_action( 'admin_init', 'tonjoo_ecae_options_init' );
add_action( 'admin_menu', 'tonjoo_ecae_options_page' );

/**
 * Init plugin options to white list our options
 */
function tonjoo_ecae_options_init(){

	register_setting( 'tonjoo_options', 'tonjoo_ecae_options' );
}

/**
 * Load up the menu page
 */
function tonjoo_ecae_options_page() 
{	
	// add_plugin_page( $page_title, $menu_title, $capability, $menu_slug, $function);
	
	add_options_page( 
		__("Easy Custom Auto Excerpt Options Page",TONJOO_ECAE), 
		'Excerpt', 
		'moderate_comments', 
		'tonjoo_excerpt', 
		'tonjoo_ecae_options_do_page' );
}

/**
 * Create the options page
 */
function tonjoo_ecae_options_do_page() 
{
	global $select_options, $radio_options;

	if(!isset( $_REQUEST['settings-updated'])) {		
		$_REQUEST['settings-updated'] = false;
	}

	/**
	 * save options
	 */
	if($_POST)
	{
		update_option('tonjoo_ecae_options', $_POST['tonjoo_ecae_options']);
		
		$location = admin_url("options-general.php?page=tonjoo_excerpt") . '&settings-updated=true';
		echo "<meta http-equiv='refresh' content='0;url=$location' />";
		echo "<h2>Loading...</h2>";
		exit();
	}

	if (!current_user_can('moderate_comments')) {  
		wp_die('You do not have sufficient permissions to access this page.');
	} 

	?>

	<div class="wrap">
	<?php echo "<h2>".__("Easy Custom Auto Excerpt Options")."</h2>"; ?>

	<br>
	<?php _e("Easy Custom Auto Excerpt by",TONJOO_ECAE) ?> 
	<a href='http://tonjoo.com' target="_blank">tonjoo</a> ~ 
	<a href='http://tonjoo.com/addons/easy-custom-auto-excerpt/' target="_blank"><?php _e("Plugin Page",TONJOO_ECAE) ?></a> | 
	<a href='http://wordpress.org/support/view/plugin-reviews/easy-custom-auto-excerpt?filter=5' target="_blank"><?php _e("Please Rate :)",TONJOO_ECAE) ?></a> |
	<a href='http://wordpress.org/extend/plugins/easy-custom-auto-excerpt/' target="_blank"><?php _e("Comment",TONJOO_ECAE) ?></a> | 
	<a href='http://forum.tonjoo.com' target="_blank"><?php _e("Bug Report",TONJOO_ECAE) ?></a> |
	<a href='http://tonjoo.com/addons/easy-custom-auto-excerpt/#faq' target="_blank"><?php _e("FAQ",TONJOO_ECAE) ?></a> |
	<a href='http://tonjoo.com/donate' target="_blank"><?php _e("Donate Us",TONJOO_ECAE) ?></a> 
	<br>
	<br>

	<?php if(isset($_REQUEST['settings-updated']) && $_REQUEST['settings-updated']==true) { ?>
	    <div id="message" class="updated">
	        <p><strong><?php _e('Settings saved.') ?></strong></p>
	    </div>
	<?php } ?>

	<form method="post" action="">
		<?php settings_fields('tonjoo_options'); ?>
		<?php 

		$options = get_option('tonjoo_ecae_options'); 

		tonjoo_ecae_load_default($options);

		?>

		<div class="metabox-holder columns-2" style="margin-right: 300px;">
		<div class="postbox-container" style="width: 100%;min-width: 463px;float: left; ">
		<div class="meta-box-sortables ui-sortable">
		<div id="adminform" class="postbox">
		<h3 class="hndle"><span>Page Excerpt</span></h3>
		<div class="inside" style="z-index:1;">
		<!-- Extra style for options -->
		<style>
			.form-table td {
				vertical-align: middle;
			}

			.form-table th {
				width: 175px;
			}

			.form-table input[type=text], .form-table input[type=number], .form-table select {
				width: 200px;
				margin-right: 10px;
			}

			label.error{
			    margin-left: 5px;
			    color: red;
			}

			.form-table tr th {
			    text-align: left;
			    font-weight: normal;
			}

			.meta-subtitle {
			    margin: 0px -22px !important;
			    border-top:1px solid rgb(238, 238, 238);
			    background-color:#f6f6f6;
			}

			@media (max-width: 767px) {
			    .meta-subtitle {
			      margin-left: -12px !important;
			    }
			}

			label{
				vertical-align: top
			}
		</style>

		<table class="form-table">

		<?php
			if(! function_exists('is_ecae_premium_exist') && strpos($options['excerpt_method'],'-paragraph')) {
	        	$options['excerpt_method'] = 'paragraph';
	        }

			$excerpt_method_ar = array(
				'0' => array(
					'value' =>	'paragraph',
					'label' =>  __('Paragraph',TONJOO_ECAE)
					),
				'1' => array(
					'value' =>	'word',
					'label' =>  __('Word',TONJOO_ECAE) 
					),
				'2' => array(
					'value' =>	'1st-paragraph',
					'label' =>  __('Show First Paragraph',TONJOO_ECAE) 
					),
				'3' => array(
					'value' =>	'2nd-paragraph',
					'label' =>  __('Show 1st - 2nd Paragraph',TONJOO_ECAE) 
					),
				'4' => array(
					'value' =>	'3rd-paragraph',
					'label' =>  __('Show 1st - 3rd Paragraph',TONJOO_ECAE)
					)
				);

			$excerpt_method = array(
				"name"=>"tonjoo_ecae_options[excerpt_method]",
				"description" => "Paragraph preserved styling, word does excerpt with excact word count",
				"label" => __("Excerpt method",TONJOO_ECAE),
				"value" => $options['excerpt_method'],
				"select_array" => $excerpt_method_ar,
				);


			echo tj_print_select_option($excerpt_method);

			?>

			<tr valign="top">
				<th>Excerpt size</th>
				<td><input type="number" name="tonjoo_ecae_options[width]" value="<?php echo $options['width'] ?>"></td>
				<td>Number of Character preserved, word will be preserved</td>
			</tr>

			<?php

			$yes_no_options = array(
				'0' => array(
					'value' =>	'no',
					'label' =>  __('No',TONJOO_ECAE)
					),
				'1' => array(
					'value' =>	'yes',
					'label' =>  __('Yes',TONJOO_ECAE) 
					)
				);

			$image_select = array(
				"name"=>"tonjoo_ecae_options[strip_shortcode]",
				"description" => __("If you select 'yes' any shortcode will be ommited from the excerpt",TONJOO_ECAE),
				"label" => __("Strip shortcode",TONJOO_ECAE),
				"value" => $options['strip_shortcode'],
				"select_array" => $yes_no_options,
				);

			echo tj_print_select_option($image_select);


			$yes_no_options = array(
				'0' => array(
					'value' =>	'no',
					'label' =>  __('No',TONJOO_ECAE)
					),
				'1' => array(
					'value' =>	'yes',
					'label' =>  __('Yes',TONJOO_ECAE) 
					)
				);

			$image_select = array(
				"name"=>"tonjoo_ecae_options[strip_empty_tags]",
				"description" => __("If you select 'yes' any empty HTML tags will be ommited from the excerpt",TONJOO_ECAE),
				"label" => __("Strip empty HTML tags",TONJOO_ECAE),
				"value" => $options['strip_empty_tags'],
				"select_array" => $yes_no_options,
				);

			echo tj_print_select_option($image_select);


			$yes_no_options = array(
				'0' => array(
					'value' =>	'no',
					'label' =>  __('No',TONJOO_ECAE)
					),
				'1' => array(
					'value' =>	'yes',
					'label' =>  __('Yes',TONJOO_ECAE) 
					)
				);

			$image_select = array(
				"name"=>"tonjoo_ecae_options[special_method]",
				"description" => __("Use this method only if there are any problem with the excerpt",TONJOO_ECAE),
				"label" => __("Special method",TONJOO_ECAE),
				"value" => $options['special_method'],
				"select_array" => $yes_no_options,
				);

			echo tj_print_select_option($image_select);


			$yes_no_options = array(
				'0' => array(
					'value' =>	'no',
					'label' =>  __('No',TONJOO_ECAE)
					),
				'1' => array(
					'value' =>	'yes',
					'label' =>  __('Yes',TONJOO_ECAE) 
					)
				);

			$image_select = array(
				"name"=>"tonjoo_ecae_options[always_show_read_more]",
				"description" => __("If you select 'yes', readmore link will always show",TONJOO_ECAE),
				"label" => __("Always show read more",TONJOO_ECAE),
				"value" => $options['always_show_read_more'],
				"select_array" => $yes_no_options,
				);

			echo tj_print_select_option($image_select);
			

			$excerpt_yes_options = array(
				'0' => array(
					'value' =>	'no',
					'label' =>  __('No',TONJOO_ECAE)
					),
				'1' => array(
					'value' =>	'yes',
					'label' =>  __('Yes',TONJOO_ECAE) 
					)
				);

			$justify_options = array(
				'0' => array(
					'value' =>	'no',
					'label' =>  __('No',TONJOO_ECAE)
					),
				'1' => array(
					'value' =>	'left',
					'label' =>  __('Left',TONJOO_ECAE) 
					),
				'2' => array(
					'value' =>	'right',
					'label' =>  __('Right',TONJOO_ECAE) 
					),
				'3' => array(
					'value' =>	'justify',
					'label' =>  __('Justify',TONJOO_ECAE)
					),
				'4' => array(
					'value' =>	'center',
					'label' =>  __('Center',TONJOO_ECAE)
					)
				);

			$readmore_align_options = array(
				'0' => array(
					'value' =>	'left',
					'label' =>  __('Left (default)',TONJOO_ECAE)
					),
				'1' => array(
					'value' =>	'center',
					'label' =>  __('Center',TONJOO_ECAE) 
					),
				'2' => array(
					'value' =>	'right',
					'label' =>  __('Right',TONJOO_ECAE) 
					)
				);			


			$home_select = array(
				"name"=>"tonjoo_ecae_options[home]",
				"description" => "",
				"label" => __("Home excerpt",TONJOO_ECAE),
				"value" => $options['home'],
				"select_array" => $excerpt_yes_options,
				);

			$front_page_select = array(
				"name"=>"tonjoo_ecae_options[front_page]",
				"description" => "",
				"label" => __("Front Page excerpt",TONJOO_ECAE),
				"value" => $options['front_page'],
				"select_array" => $excerpt_yes_options,
				);

			$archive_select = array(
				"name"=>"tonjoo_ecae_options[archive]",
				"description" => "",
				"label" => __("Archive excerpt",TONJOO_ECAE),
				"value" => $options['archive'],
				"select_array" => $excerpt_yes_options,
				);

			$excerpt_in_page = array(
				'label'=>__('Excerpt in page',TONJOO_ECAE),
				'name'=>'tonjoo_ecae_options[excerpt_in_page]',
				'value'=>$options['excerpt_in_page'],
				'description'=>__('The value is page ID or page slug. For multiple pages, use "|" (without quote) between them',TONJOO_ECAE),
				);

			$search_select = array(
				"name"=>"tonjoo_ecae_options[search]",
				"description" => "",
				"label" => __("Search excerpt",TONJOO_ECAE),
				"value" => $options['search'],
				"select_array" => $excerpt_yes_options,
				);

			$justify_select = array(
				"name"=>"tonjoo_ecae_options[justify]",
				"description" => __("The plugin will try to align the text on the excerpt page",TONJOO_ECAE),
				"label" => __("Text align",TONJOO_ECAE),
				"value" => $options['justify'],
				"select_array" => $justify_options,
				);
			
			$text_options = array(
				'label'=>__('Read more text',TONJOO_ECAE),
				'name'=>'tonjoo_ecae_options[read_more]',
				'value'=>$options['read_more'],
				'description'=>__('If you do not want to display it, fill with "-" (without quote)',TONJOO_ECAE)
				);

			$extra_html_markup = array(
				'label'=>__('Extra HTML markup',TONJOO_ECAE),
				'name'=>'tonjoo_ecae_options[extra_html_markup]',
				'value'=>$options['extra_html_markup'],
				'description'=>__('Extra HTML markup to save. Use "|" (without quote) between markup',TONJOO_ECAE),
				);	

			$readmore_text_before_options = array(
				'label'=>__('Text before link',TONJOO_ECAE),
				'name'=>'tonjoo_ecae_options[read_more_text_before]',
				'value'=>$options['read_more_text_before'],
				'description'=>__('Text before read more link',TONJOO_ECAE)
				);

			$readmore_align_select = array(
				"name"=>"tonjoo_ecae_options[read_more_align]",
				"description" => __("Read more text's align. Leave it default if read more new line option is turned off.",TONJOO_ECAE),
				"label" => __("Read more align",TONJOO_ECAE),
				"value" => $options['read_more_align'],
				"select_array" => $readmore_align_options
				);		

			echo '<tr><td colspan=3><h3 class="meta-subtitle">Excerpt Location</h3></td></tr>';

			echo tj_print_select_option($home_select);
			echo tj_print_select_option($front_page_select);
			echo tj_print_select_option($search_select);
			echo tj_print_select_option($archive_select);
			echo tj_print_text_option($excerpt_in_page);

			echo '<tr><td colspan=3><h3 class="meta-subtitle">Display Image Options</h3></td></tr>';

			$yes_no_options = array(
				'0' => array(
					'value' =>	'no',
					'label' =>  __("No",TONJOO_ECAE)
					),
				'1' => array(
					'value' =>	'yes',
					'label' =>  __("Show All Images",TONJOO_ECAE)
					),
				'2' => array(
					'value' =>	'first-image',
					'label' =>  __('Show only First Image',TONJOO_ECAE) 
					),
				'3' => array(
					'value' =>	'featured-image',
					'label' =>  __('Use Featured Image',TONJOO_ECAE)
					)
				);

			$image_select = array(
				"name"=>"tonjoo_ecae_options[show_image]",
				"description" => "",
				"label" => __("Content image",TONJOO_ECAE),
				"value" => $options['show_image'],
				"select_array" => $yes_no_options,
				"description" => __("Display Image in excerpt",TONJOO_ECAE) 
				);

			echo tj_print_select_option($image_select);

			// premium anouncement
			if(! function_exists('is_ecae_premium_exist'))
			{			
				echo "<tr><td colspan=3><h3 class='meta-subtitle'>Purchase the <a href='https://tonjoo.com/addons/easy-custom-auto-excerpt-premium/' target='_blank'>Premium Edition</a> to enable all display image options</h3></td></tr>";
			}
			
			echo "<tr><th colspan=3><i>Image options below is only work for Content Image: Show Only First Image and Use Featured Image </i></th></tr>";
			

			$yes_no_options = array(
				'0' => array(
					'value' =>	'none',
					'label' =>  __("None",TONJOO_ECAE)
					),
				'1' => array(
					'value' =>	'left',
					'label' =>  __("Left",TONJOO_ECAE)
					),
				'2' => array(
					'value' =>	'right',
					'label' =>  __("Right",TONJOO_ECAE)
					),
				'3' => array(
					'value' =>	'center',
					'label' =>  __('Center',TONJOO_ECAE) 
					),
				'4' => array(
					'value' =>	'float-left',
					'label' =>  __('Float Left',TONJOO_ECAE)
					),
				'5' => array(
					'value' =>	'float-right',
					'label' =>  __('Float Right',TONJOO_ECAE)
					)
				);

			$image_select = array(
				"name"=>"tonjoo_ecae_options[image_position]",
				"description" => "",
				"label" => __("Image position",TONJOO_ECAE),
				"value" => $options['image_position'],
				"select_array" => $yes_no_options,
				"description" => __("Image position option",TONJOO_ECAE) 
				);

			echo tj_print_select_option($image_select);

			?>

			<tr valign="top">
				<th>Image width</th>
				<td>
					<input type="radio" name="tonjoo_ecae_options[image_width_type]" value="auto" <?php if($options['image_width_type'] == 'auto') echo 'checked' ?> >
					Auto
				</td>
				<td>&nbsp;</td>
			</tr>

			<tr valign="top">
				<th>&nbsp;</th>
				<td>
					<input type="radio" name="tonjoo_ecae_options[image_width_type]" value="manual" <?php if($options['image_width_type'] == 'manual') echo 'checked' ?> >
					<input type="number" name="tonjoo_ecae_options[image_width]" value="<?php echo $options['image_width'] ?>" style="float: right;width: 175px;margin-top: -5px;">
				</td>
				<td>&nbsp;</td>
			</tr>

			<tr valign="top">
				<th>Image margin</th>
				<td>
					<p style="padding-top:0px;float:left;">Top</p>
					<input type="number" name="tonjoo_ecae_options[image_padding_top]" value="<?php echo $options['image_padding_top'] ?>" style="float: right;width: 100px;" >
				</td>
				<td>px</td>
			</tr>

			<tr valign="top">
				<th>&nbsp;</th>
				<td>
					<p style="padding-top:0px;float:left;">Right</p>
					<input type="number" name="tonjoo_ecae_options[image_padding_right]" value="<?php echo $options['image_padding_right'] ?>" style="float: right;width: 100px;" >
				</td>
				<td>px</td>
			</tr>

			<tr valign="top">
				<th>&nbsp;</th>
				<td>
					<p style="padding-top:0px;float:left;">Bottom</p>
					<input type="number" name="tonjoo_ecae_options[image_padding_bottom]" value="<?php echo $options['image_padding_bottom'] ?>" style="float: right;width: 100px;" >
				</td>
				<td>px</td>
			</tr>

			<tr valign="top">
				<th>&nbsp;</th>
				<td>
					<p style="padding-top:0px;float:left;">Left</p>
					<input type="number" name="tonjoo_ecae_options[image_padding_left]" value="<?php echo $options['image_padding_left'] ?>" style="float: right;width: 100px;" >
				</td>
				<td>px</td>
			</tr>

			<?php

			// $featured_image_excerpt = array(
			// 	'0' => array(
			// 		'value' =>	'no',
			// 		'label' =>  __('No',TONJOO_ECAE)
			// 		),
			// 	'1' => array(
			// 		'value' =>	'yes',
			// 		'label' =>  __('Yes',TONJOO_ECAE) 
			// 		)
			// 	);

			// $image_select = array(
			// 	"name"=>"tonjoo_ecae_options[featured_image_excerpt]",
			// 	"description" => "",
			// 	"label" => __("Featured image",TONJOO_ECAE),
			// 	"value" => $options['featured_image_excerpt'],
			// 	"select_array" => $featured_image_excerpt,
			// 	"description" => __("Display featured image if post excerpt is set",TONJOO_ECAE) 
			// 	);

			// echo tj_print_select_option($image_select);

			echo '<tr><td colspan=3><h3 class="meta-subtitle">Content Options</h3></td></tr>';

			echo tj_print_select_option($justify_select);					
			tj_print_text_option($extra_html_markup);

			echo '<tr><td colspan=3><h3 class="meta-subtitle">Read More Options</h3></td></tr>';			

			tj_print_text_option($text_options);
			tj_print_text_option($readmore_text_before_options);
			tj_print_select_option($readmore_align_select);

			// premium anouncement
			if(! function_exists('is_ecae_premium_exist'))
			{			
				echo "<tr><td colspan=3><h3 class='meta-subtitle'>Purchase the <a href='https://tonjoo.com/addons/easy-custom-auto-excerpt-premium/' target='_blank'>Premium Edition</a> to enable all button font and the premium button skins</h3></td></tr>";
			}

			$button_font_array = array(
				'0' => array(
					'value' =>	'Open Sans',
					'label' =>  __('Open Sans',TONJOO_ECAE)
					),
				'1' => array(
					'value' =>	'Lobster',
					'label' =>  __('Lobster',TONJOO_ECAE) 
					),
				'2' => array(
					'value' =>	'Lobster Two',
					'label' =>  __('Lobster Two',TONJOO_ECAE) 
					),
				'3' => array(
					'value' =>	'Ubuntu',
					'label' =>  __('Ubuntu',TONJOO_ECAE) 
					),
				'4' => array(
					'value' =>	'Ubuntu Mono',
					'label' =>  __('Ubuntu Mono',TONJOO_ECAE) 
					),
				'5' => array(
					'value' =>	'Titillium Web',
					'label' =>  __('Titillium Web',TONJOO_ECAE) 
					),
				'6' => array(
					'value' =>	'Grand Hotel',
					'label' =>  __('Grand Hotel',TONJOO_ECAE) 
					),
				'7' => array(
					'value' =>	'Pacifico',
					'label' =>  __('Pacifico',TONJOO_ECAE) 
					),
				'8' => array(
					'value' =>	'Crafty Girls',
					'label' =>  __('Crafty Girls',TONJOO_ECAE) 
					),
				'9' => array(
					'value' =>	'Bevan',
					'label' =>  __('Bevan',TONJOO_ECAE) 
					)
			);

			if(! function_exists('is_ecae_premium_exist')) {
	        	for ($i=0; $i <= 9; $i++) { 
	        		$button_font_array[$i]['value'] = __('Open Sans',TONJOO_ECAE);
	        	}
	        }

			$button_font = array(
				"name"=>"tonjoo_ecae_options[button_font]",
				"description" => "",
				"label" => __("Button Font",TONJOO_ECAE),
				"value" => $options['button_font'],
				"select_array" => $button_font_array
				);

			echo tj_print_select_option($button_font);

			if(! function_exists('is_ecae_premium_exist')) {
	        	$options['button_font_size'] = '14';
	        }

			?>

			<tr valign="top">
				<th>Button Font Size</th>
				<td><input type="number" name="tonjoo_ecae_options[button_font_size]" value="<?php echo $options['button_font_size'] ?>"></td>
				<td>&nbsp;</td>
			</tr>

			<?php	

            $dir =  dirname(__FILE__)."/buttons";
            $skins = scandir($dir);
            $button_skin =  array();
            $button_skin_val = $options['button_skin'];

            array_push($button_skin, array("label"=>"None","value"=>"ecae-buttonskin-none"));
            array_push($button_skin, array("label"=>"Black","value"=>"ecae-buttonskin-black"));
            array_push($button_skin, array("label"=>"White","value"=>"ecae-buttonskin-white"));

            if(function_exists('is_ecae_premium_exist')) 
            {                
                $dir =  ABSPATH . 'wp-content/plugins/'.ECAE_PREMIUM_DIR_NAME.'/buttons';

                $skins = scandir($dir);

                foreach ($skins as $key => $value) {

                    $extension = pathinfo($value, PATHINFO_EXTENSION); 
                    $filename = pathinfo($value, PATHINFO_FILENAME); 
                    $extension = strtolower($extension);
                    $the_value = strtolower($filename);
                    $filename_ucwords = str_replace('-', ' ', $filename);
                    $filename_ucwords = ucwords($filename_ucwords);
                    $filename_ucwords = str_replace('Ecae Buttonskin ', '', ucwords($filename_ucwords));

                    if($extension=='css'){
                        $data = array(
	                                "label"=>"$filename_ucwords (Premium)",
	                                "value"=>"$the_value-PREMIUMtrue"
	                            );

                        array_push($button_skin,$data);
                    }
                }
            }
            else
		    {
		        $skins = scandir(ABSPATH . 'wp-content/plugins/'.ECAE_DIR_NAME.'/assets/premium-promo');

                foreach ($skins as $key => $value) {

                    $extension = pathinfo($value, PATHINFO_EXTENSION); 
                    $filename = pathinfo($value, PATHINFO_FILENAME); 
                    $extension = strtolower($extension);
                    $the_value = strtolower($filename);
                    $filename_ucwords = str_replace('-', ' ', $filename);
                    $filename_ucwords = ucwords($filename_ucwords);
                    $filename_ucwords = str_replace('Ecae Buttonskin ', '', ucwords($filename_ucwords));

                    if($extension=='png'){
                        $data = array(
	                                "label"=>"$filename_ucwords (Premium)",
	                                "value"=>"$the_value-PREMIUMtrue"
	                            );

                        array_push($button_skin,$data);
                    }
                }

                if(substr($button_skin_val, -12) == "-PREMIUMtrue")
                {
                	$button_skin_val = "ecae-buttonskin-none";
                }
		    }

            $option_select = array(
                            "name"=>"tonjoo_ecae_options[button_skin]",
                            "description" => "",
                            "label" => "Button Skin",
                            "value" => $button_skin_val,
                            "select_array" => $button_skin,
                            "id"=>"tonjoo-ecae-button_skin"
                        );
            
            tj_print_select_option($option_select);
        ?>

	        <tr><td colspan=3><h3 class="meta-subtitle">Read More Live Preview</h3></td></tr>
	        <tr>
	        	<td colspan=3>
	        		<div id="ecae_ajax_preview_button"></div>
	        	</td>
	        </tr>

			<tr><td colspan=3><h3 class="meta-subtitle">Custom CSS</h3></td></tr>
			<tr valign="top">
				<th colspan=3>
					<p style="margin-top:-25px;font-size:14px;">
						Some css attribute need to use <code>!important</code> value to affect
					</p>
					<div id="ace-editor"><?php echo $options["custom_css"]; ?></div>
					<textarea id="ace_editor_value" name="tonjoo_ecae_options[custom_css]" ><?php echo $options["custom_css"]; ?></textarea>
				</th>
			</tr>
		</table>

		<br>
		<input type="submit" class="button-primary" value="<?php _e('Save Options', 'pjc_slideshow_options'); ?>" />	

		</div>			
		</div>			
		</div>			
		</div>			


		<div class="postbox-container" style="float: right;margin-right: -300px;width: 280px;">
		<div class="metabox-holder" style="padding-top:0px;">	
		<div class="meta-box-sortables ui-sortable">
			<div id="email-signup" class="postbox">
				<h3 class="hndle"><span>Save Options</span></h3>
				<div class="inside" style="padding-top:10px;">
					Save your changes to apply the options
					<br>
					<br>
					<input type="submit" class="button-primary" value="Save Options" />
					
				</div>
			</div>

			
			<!-- ADS -->
			<div class="postbox">			
				<script type="text/javascript">
					jQuery(function(){
						var url = 'http://tonjoo.com/about/?promo=get';
						var pluginName = "ecae";
						var promoFirst = new Array();
						var promoSecond = new Array();

						// strpos function
						function strpos(haystack, needle, offset) {
							var i = (haystack + '')
								.indexOf(needle, (offset || 0));
							return i === -1 ? false : i;
						}

						jQuery.ajax({url: url, dataType:'jsonp'}).done(function(data){
							
							if(typeof data =='object')
							{
								var fristImg, fristUrl;

							    // looping jsonp object
								jQuery.each(data, function(index, value){

									<?php if(! function_exists('is_ecae_premium_exist')): ?>

									fristImg = pluginName + '-premium-img';
									fristUrl = pluginName + '-premium-url';

									// promoFirst
									if(index == fristImg)
								    {
								    	promoFirst['img'] = value;
								    }

								    if(index == fristUrl)
								    {
								    	promoFirst['url'] = value;
								    }

								    <?php else: ?>

								    if(! fristImg)
								    {
								    	// promoFirst
										if(strpos(index, "-img"))
									    {
									    	promoFirst['img'] = value;

									    	fristImg = index;
									    }

									    if(strpos(index, "-url"))
									    {
									    	promoFirst['url'] = value;

									    	fristUrl = index;
									    }
								    }

								    <?php endif; ?>

									// promoSecond
									if(strpos(index, "-img") && index != fristImg)
								    {
								    	promoSecond['img'] = value;
								    }

								    if(strpos(index, "-url") && index != fristUrl)
								    {
								    	promoSecond['url'] = value;
								    }
								});

								//promo_1
								jQuery("#promo_1 img").attr("src",promoFirst['img']);
								jQuery("#promo_1 a").attr("href",promoFirst['url']);

								//promo_2
								jQuery("#promo_2 img").attr("src",promoSecond['img']);
								jQuery("#promo_2 a").attr("href",promoSecond['url']);
							}
						});
					});
				</script>

				

				<!-- <h3 class="hndle"><span>This may interest you</span></h3> -->
				<div class="inside" style="margin: 23px 10px 6px 10px;">
					<div id="promo_1" style="text-align: center;padding-bottom:17px;">
						<a href="http://tonjoo.com" target="_blank">
							<img src="<?php echo plugins_url(ECAE_DIR_NAME."/assets/loading-big.gif") ?>" width="100%" alt="WordPress Security - A Pocket Guide">
						</a>
					</div>
					<div id="promo_2" style="text-align: center;">
						<a href="http://tonjoo.com" target="_blank">
							<img src="<?php echo plugins_url(ECAE_DIR_NAME."/assets/loading-big.gif") ?>" width="100%" alt="WordPress Security - A Pocket Guide">
						</a>
					</div>
				</div>
			</div>
		</div>
		</div>
		</div>	

		</div>
	</form>
</div>
<?php


}

