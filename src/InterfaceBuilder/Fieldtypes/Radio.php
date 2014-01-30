<?php namespace InterfaceBuilder\Fieldtypes;

use InterfaceBuilder\InterfaceBuilderField;

class Radio extends InterfaceBuilderField {

	protected $hasOptions = TRUE;

	public function displayField($data = FALSE)
	{
		if($data)
		{
			$this->data = $data;	
		}
		
		$html = array('<div id="'.$this->id.'">');

		if(isset($this->settings['options']))
		{
			foreach($this->settings['options'] as $value => $name)
			{
				$checked = $this->sanitize($this->getData()) == $value ? 'checked="checked"' : NULL;

				$html[] = '<label><input type="radio" name="'.$this->name.'" value="'.$value.'" '.$checked.'> '.$name.'</label>';
			}
		}

		$html[] = '</div>';

		return implode(NULL, $html);
	}

}