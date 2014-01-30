<?php namespace InterfaceBuilder\Fieldtypes;

use InterfaceBuilder\InterfaceBuilderField;

class Input extends InterfaceBuilderField {

	public function displayField($data = FALSE)
	{
		if($data)
		{
			$this->data = $data;	
		}
		
		$inputType = 'text';
			
		if(isset($this->settings['type']))
		{
			$inputType = $this->settings['type'];
		}
		
		$placeholder = NULL;
	
		if(isset($this->settings['placeholder']))
		{
			$placeholder = $this->settings['placeholder'];
		}
		
		return '<input type="'.$inputType.'" name="'.$this->getName().'" value="'.$this->sanitize($this->getData()).'" id="'.$this->getId().'" placeholder="'.$placeholder.'" />';
	}
}