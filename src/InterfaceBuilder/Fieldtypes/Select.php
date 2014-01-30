<?php namespace InterfaceBuilder\Fieldtypes;

use InterfaceBuilder\InterfaceBuilderField;

class Select extends InterfaceBuilderField {

	protected $hasOptions = TRUE;

	public function displayField($data = FALSE)
	{
		if($data)
		{
			$this->data = $data;	
		}
		
		$html = array('<select name="'.$this->name.'" id="'.$this->id.'">');

		if(isset($this->settings['options']))
		{
			foreach($this->settings['options'] as $value => $name)
			{
				$html[]   = '<option value="'.$value.'" '.((string) $this->getData() == (string) $value ? 'selected="selected"' : NULL).'>'.$name.'</option>';
			}
		}

		$html[] = '</select>';

		return implode(NULL, $html);
	}
}