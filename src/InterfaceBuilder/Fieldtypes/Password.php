<?php namespace InterfaceBuilder\Fieldtypes;

use InterfaceBuilder\InterfaceBuilderField;

class Password extends InterfaceBuilderField {

	public function displayField($data = FALSE)
	{
		if($data)
		{
			$this->data = $data;	
		}
		
		if(empty($this->data))
		{
			$this->data = $this->default;
		}

		return '<input type="password" name="'.$this->name.'" value="'.$this->sanitize($this->data).'" id="'.$this->id.'" />';
	}
}