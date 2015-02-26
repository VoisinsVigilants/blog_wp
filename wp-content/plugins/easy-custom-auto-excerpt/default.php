<?php

function tonjoo_ecae_load_default(&$options){
	if(!is_numeric($options['width'])){
		$options['width']=500;		
	}
	if(!isset($options['excerpt_method'])){
		$options['excerpt_method']='paragraph';		
	}
	if(!isset($options['show_image'])){
		$options['show_image']='yes';		
	}
	if(!isset($options['image_position']) || !function_exists('is_ecae_premium_exist')){
		$options['image_position']='none';
	}
	if(!isset($options['image_width_type']) || !function_exists('is_ecae_premium_exist')){
		$options['image_width_type']='manual';
	}
	if(!isset($options['image_width'])){
		$options['image_width']='100';
	}
	if(!isset($options['image_padding_top']) || !function_exists('is_ecae_premium_exist')){
		$options['image_padding_top']='5';
	}
	if(!isset($options['image_padding_right']) || !function_exists('is_ecae_premium_exist')){
		$options['image_padding_right']='5';
	}
	if(!isset($options['image_padding_bottom']) || !function_exists('is_ecae_premium_exist')){
		$options['image_padding_bottom']='5';
	}
	if(!isset($options['image_padding_left']) || !function_exists('is_ecae_premium_exist')){
		$options['image_padding_left']='5';
	}
	if(!isset($options['home'])){
		$options['home']='yes';		
	}
	if(!isset($options['front_page'])){
		$options['front_page']='yes';
	}
	if(!isset($options['search'])){
		$options['search']='yes';		
	}
	if(!isset($options['archive'])){
		$options['archive']='yes';		
	}
	if(!isset($options['excerpt_in_page'])){
		$options['excerpt_in_page']='';		
	}
	if(!isset($options['justify'])){
		$options['justify']='no';		
	}
	if(!isset($options['read_more'])||$options['read_more']==''){
		$options['read_more']='read more';		
	}

	if(!isset($options['strip_shortcode'])){
		$options['strip_shortcode']='yes';		
	}
	
	if(!isset($options['strip_empty_tags'])){
		$options['strip_empty_tags']='yes';		
	}
	
	if(!isset($options['special_method'])){
		$options['special_method']='no';
	}

	if(!isset($options['always_show_read_more'])){
		$options['always_show_read_more']='no';
	}

	// if(!isset($options['featured_image_excerpt'])){
	// 	$options['featured_image_excerpt']='yes';		
	// }

	if(!isset($options['read_more_text_before'])){
		$options['read_more_text_before']='';		
	}

	if(!isset($options['read_more_align'])){
		$options['read_more_align']='left';		
	}

	if(!isset($options['extra_html_markup'])){
		$options['extra_html_markup']='span';		
	}
	
	if(!isset($options['show_image'])){
		$options['show_image']='yes';		
	}

	if(!isset($options['custom_css'])){
		$options['custom_css']="";
	}

	if(!isset($options['button_skin'])){
		$options['button_skin']="none";
	}

	if(!isset($options['button_font'])){
		$options['button_font']="Open Sans";
	}

	if(!isset($options['button_font_size'])){
		$options['button_font_size']="14";
	}

	return $options;
}