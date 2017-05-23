<?php

class acf_field_switcher extends acf_field
{

	/*
	*  __construct
	*
	*  Set name / label needed for actions / filters
	*
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function __construct()
	{
		// vars
		$this->name = 'switcher';
		$this->label = __("Switcher (UI Toggle Switch)",'acf');
		$this->category = __("Choice",'acf');
		$this->defaults = array(
			'layout'		=>	'vertical',
			'choices'		=>	array(),
			'default_value'	=>	'',
		);
		
		
		// do not delete!
    	parent::__construct();
	}
		
	
	/*
	*  create_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function create_field( $field )
	{
		// value must be array
		if( !is_array($field['value']) )
		{
			// perhaps this is a default value with new lines in it?
			if( strpos($field['value'], "\n") !== false )
			{
				// found multiple lines, explode it
				$field['value'] = explode("\n", $field['value']);
			}
			else
			{
				$field['value'] = array( $field['value'] );
			}
		}
		

			//Change Toggle Colors Off/On
			$colorOff = "#32373c";
			$colorOn = "#4fb845";

			?>

			
			<style type="text/css">
					.acf-switcher-list label {
					  display: block;
					  float: left;
					  cursor: pointer;
					  position: relative;
					  width: 62px;
					  height: 26px;
					  padding: 0;
					  margin: 0;
					  overflow: hidden;
					  -moz-border-radius: 20px;
					  -webkit-border-radius: 20px;
					  border-radius: 20px;
					}
					.acf-switcher-list label span {
					  position: absolute;
					  top: 4px;
					  left: 4px;
					  width: 18px;
					  height: 18px;
					  background-color: #fff;
					  -moz-border-radius: 16px;
					  -webkit-border-radius: 16px;
					  border-radius: 16px;
					  -moz-transition: left 0.15s ease-out;
					  -o-transition: left 0.15s ease-out;
					  -webkit-transition: left 0.15s ease-out;
					  transition: left 0.15s ease-out;
					}
					.acf-switcher-list label input {
					  position: absolute;
					  top: 0;
					  left: 0;
					  opacity: 0;
					}
					.acf-switcher-list label input:checked ~ em {
					  background: <?php echo $colorOn;?>;
					}
					.acf-switcher-list label input:checked ~ em:before {
					  opacity: 0;
					}
					.acf-switcher-list label input:checked ~ em:after {
					  opacity: 1;
					}
					.acf-switcher-list label input:checked ~ span {
					  left: 40px;
					}
					.acf-switcher-list label em {
					  /* position: relative; */
					  display: block;
					  height: inherit;
					  font-size: 11px;
					  line-height: 26px;
					  font-weight: 500;
					  font-style: normal;
					  text-transform: uppercase;
					  color: #fff;
					  background-color: <?php echo $colorOff;?>;
					  -moz-transition: background 0.15s ease-out;
					  -o-transition: background 0.15s ease-out;
					  -webkit-transition: background 0.15s ease-out;
					  transition: background 0.15s ease-out;
					}
					.acf-switcher-list label em:before, .acf-switcher-list label em:after {
					  position: absolute;
					  -moz-transition: opacity 0.15s ease-out;
					  -o-transition: opacity 0.15s ease-out;
					  -webkit-transition: opacity 0.15s ease-out;
					  transition: opacity 0.15s ease-out;
					}
					.acf-switcher-list label em:before {
					  content: attr(data-off);
					  right: 14px;
					}
					.acf-switcher-list label em:after {
					  content: attr(data-on);
					  left: 14px;
					  opacity: 0;
					}
					.acf-switcher-list .message-text{
					  float: left;
					  margin-left: 5px;
					  margin-top: 0;
					  padding-top: 4px;
					  font-weight: bold;
					  margin-right: 20px;
					}
					.field_type-switcher {
					    /*padding-bottom: 40px !important;*/
					}

					ul.acf-switcher-list {
					    background: transparent !important;
					}

					ul.acf-switcher-list {
					    background: transparent !important;
					    position: relative;
					    display: block;
					    padding: 1px;
					    margin: 0;
					}	
					ul.acf-switcher-list.switcher.vertical{
						overflow:hidden;
						display:grid;
					}
					ul.acf-switcher-list.switcher.horizontal{
						overflow:hidden;
						display:flex;
					}

			</style>

		<?php
			// trim value
		$field['value'] = array_map('trim', $field['value']);
		
		
		// vars
		$i = 0;
		$e = '<input type="hidden" name="' .  esc_attr($field['name']) . '" value="" />';
		$e .= '<ul class="acf-switcher-list ' . esc_attr($field['class']) . ' ' . esc_attr($field['layout']) . '">';
		
		
		// checkbox saves an array
		$field['name'] .= '[]';
		// $choices = $field['choices'];

$string    = $field['choices'];

$choices = array();
$lines = explode("\n", $string);


foreach ($lines as $line) {

$line = $line.":".$line;

    list($key, $value) = explode(":", $line);
    $choices[$key] = $value;
}


		//echo "<pre>";
		//print_r($choices);
		//echo "</pre>";


if (is_array($choices))
{

   foreach ($choices as $key => $value)
    {		
		// foreach choices
		// foreach( $field['choices'] as $key => $value )
		// {
			// vars
			$i++;
			$atts = '';

			//print_r($key);
			
			
			if( in_array($key, $field['value']) )
			{
				$atts = 'checked="yes"';
			}
			if( isset($field['disabled']) && in_array($key, $field['disabled']) )
			{
				$atts .= ' disabled="true"';
			}
			
			
			// each checkbox ID is generated with the $key, however, the first checkbox must not use $key so that it matches the field's label for attribute
			$id = $field['id'];
			
			if( $i > 1 )
			{
				$id .= '-' . $key;
			}
			
			$e .= '<li><label><input id="' . esc_attr($id) . '" type="checkbox" class="' . esc_attr($field['class']) . '" name="' . esc_attr($field['name']) . '" value="' . esc_attr($key) . '" ' . $atts . ' /><em data-on="'. __( 'on', 'acf' ) .'" data-off="'. __( 'off', 'acf' ) .'"></em><span></span></label> <span class="message-text">' . $value . '</span></li>';
		}
		
		$e .= '</ul>';
		
		
		// return
		echo $e;
	}
	}
	
	/*
	*  create_options()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field	- an array holding all the field's data
	*/
	
	function create_options( $field )
	{
		// vars
		$key = $field['name'];
		
		
		// implode checkboxes so they work in a textarea
		if( is_array($field['choices']) )
		{		
			foreach( $field['choices'] as $k => $v )
			{
				$field['choices'][ $k ] = $k . ' : ' . $v;
			}
			$field['choices'] = implode("\n", $field['choices']);
		}
		
		?>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label for=""><?php _e("Choices",'acf'); ?></label>
		<p><?php _e("Enter each choice on a new line.",'acf'); ?></p>
		<p><?php _e("For more control, you may specify both a value and label like this:",'acf'); ?></p>
		<p><?php _e("red : Red",'acf'); ?><br /><?php _e("blue : Blue",'acf'); ?></p>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'	=>	'textarea',
			'class' => 	'textarea field_option-choices',
			'name'	=>	'fields['.$key.'][choices]',
			'value'	=>	$field['choices'],
		));
		
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Default Value",'acf'); ?></label>
		<p class="description"><?php _e("Enter each default value on a new line",'acf'); ?></p>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'	=>	'textarea',
			'name'	=>	'fields['.$key.'][default_value]',
			'value'	=>	$field['default_value'],
		));
		
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label for=""><?php _e("Layout",'acf'); ?></label>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'	=>	'radio',
			'name'	=>	'fields['.$key.'][layout]',
			'value'	=>	$field['layout'],
			'layout' => 'horizontal', 
			'choices' => array(
				'vertical' => __("Vertical",'acf'), 
				'horizontal' => __("Horizontal",'acf')
			)
		));
		
		?>
	</td>
</tr>
		<?php
		
	}
	
}

new acf_field_switcher();

?>
