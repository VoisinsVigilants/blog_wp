<?php

if ( ! function_exists( 'tj_print_select_option' ) ) :
function tj_print_select_option($options){
	$r='';

	foreach ( $options['select_array'] as $select ) {
		$label = $select['label'];

		if ( $options['value'] == $select['value'] ) // Make default first in list
			$r .= "<option selected='selected' value='" . esc_attr( $select['value'] ) . "'>$label</option>";
		else
			$r .= "<option value='" . esc_attr( $select['value'] ) . "'>$label</option>";
	}
	
	$options['id'] = isset($options['id']) ? $options['id'] : '';
	$options['description'] = isset($options['description']) ? $options['description'] : '';

	$print_select= "<tr valign='top' id='{$options['id']}'>
						<th scope='row'>{$options['label']}</th>
						<td>
							<select name='{$options['name']}'>
							{$r}
							</select>							
						</td>
						<td>
							{$options['description']}
						</td>
					</tr>
					";

	if($options['id'] == 'tonjoo-ecae-button_skin')
	{
		$print_select= "<tr valign='top' id='{$options['id']}'>
							<th scope='row'>{$options['label']}</th>
							<td colspan=2>
								<select name='{$options['name']}'>
								{$r}
								</select>							
							</td>
						</tr>
						";
	}

	echo $print_select;
}

endif;

if ( ! function_exists( 'tj_print_text_option' ) ) :
function tj_print_text_option($options){


	$options['id'] = isset($options['id']) ? $options['id'] : '';
	$options['description'] = isset($options['description']) ? $options['description'] : '';

	$print_select= "<tr valign='top' id='{$options['id']}'>
						<th scope='row'>{$options['label']}</th>
						<td>
							<input type='text' name='{$options['name']}' value='{$options['value']}'>	
						</td>
						<td>
							{$options['description']}
						</td>
					</tr>
					";

	echo $print_select;
}

endif;

if ( ! function_exists( 'tj_print_text_area_option' ) ) :
function tj_print_text_area_option($options){


	if(!$options['row'])
		$options['row']=4;
	if(!$options['column'])
		$options['column']=50;


	

	$print_select= "<tr valign='top' id='{$options['id']}' >
						<th scope='row'>{$options['label']}</th>
						<td>
							<textarea  name='{$options['name']}' rows='{$options['row']}' cols='{$options['column']}'>{$options['value']}</textarea>		
						</td>
					</tr>
					";

	echo $print_select;
}

endif;