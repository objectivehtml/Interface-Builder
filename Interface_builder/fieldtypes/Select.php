<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Select_IBField extends IBFieldtype {

	public function display_field($data = '')
	{
		$html = array();

		$html[] = '
		<select name="'.$this->name.'" id="'.$this->id.'">';

		foreach($this->settings['options'] as $option_value => $option_name)
		{
			$selected = $data == $option_value ? 'selected="selected"' : NULL;
			$html[]   = '<option value="'.$option_value.'" '.$selected.'>'.$option_name.'</option>';
		}

		$html[] = '</select>';

		return implode(NULL, $html);
	}

}