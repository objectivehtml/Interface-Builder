<?php namespace InterfaceBuilder\Fieldtypes;

use InterfaceBuilder\InterfaceBuilderField;

class Date extends InterfaceBuilderField {

	protected $hasSettings = TRUE;

	protected $settings = array(
		array(
			'type'  => 'input',
			'name'  => 'format',
			'label' => 'Date Format',
			'description' => 'If this field is storing a valid date, enter the date format. For more information refer to the <a href="http://www.php.net/manual/en/function.date.php">date formatting table</a>.',
			'settings' => array(
				'placeholder' => 'Y-m-d'
			)
		)
	);

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
		
		return '<input type="text" name="'.$this->getName().'" value="'.$this->sanitize($this->getData()).'" id="'.$this->getId().'" class="datepicker" />';
	}
}