<?php namespace InterfaceBuilder\Fieldtypes;

use InterfaceBuilder\InterfaceBuilderField;

class Checkbox extends InterfaceBuilderField {

	protected $hasOptions = TRUE;

	public function displayField($data = FALSE)
	{
		if($data)
		{
			$this->data = $data;	
		}
				
		if(!$this->getData())
		{
			$this->data = array();	
		}

		if(!is_array($this->getData()))
		{
			$this->data = explode('|', $this->getData());
		}
		
		$html = array('<div id="'.$this->id.'">');
		
		if(isset($this->settings['options']))
		{
			foreach($this->settings['options'] as $value => $name)
			{
				$checked = in_array($value, $this->getData()) ? 'checked="checked"' : NULL;
	
				$html[] = '<label><input type="checkbox" name="'.$this->name.'[]" id="'.$this->id.'" value="'.$value.'" '.$checked.'> '.$name.'</label>';
			}
		}

		$html[] = '</div>';
		
		return implode(NULL, $html);
	}
}