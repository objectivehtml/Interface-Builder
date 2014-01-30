<?php namespace InterfaceBuilder\Fieldtypes;

use InterfaceBuilder\InterfaceBuilderField;

class Textarea extends InterfaceBuilderField {

	public function displayField($data = FALSE)
	{
		if($data)
		{
			$this->data = $data;	
		}
		
		return '<textarea name="'.$this->name.'" id="'.$this->id.'">'.$this->getData().'</textarea>';
	}
}