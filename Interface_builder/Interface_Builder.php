<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Interface_Builder {

	private $fields   = array();
	
	public $data = array();

	public function __construct($data = array())
	{
		if(isset($data['data']))
		{
			$this->data = $data['data'];
		}

		if(isset($data['fields']))
		{
			$this->add_fields($fields);
		}
	}

	public function table($data = FALSE, $attributes = array())
	{
		$fields = array();
		$html   = array();

		if($data)
		{
			$this->data = $data;
		}

		$fields = $this->build();

		$attribute_array = array();

		foreach($attributes as $name => $value)
		{
			$attribute_array[] = $name.'="'.$value.'"';
		}

		$html[] = '<table '.implode(NULL, $attribute_array).'>';
		$html[] = '<tr><th style="width:40%">Preference</th><th>Setting</th></tr>';

		foreach($fields as $field_name => $field)
		{
			$html[] = '<tr><td>'.$field->label.$field->description.'</td><td>'.$field->field.'</td></tr>';
		}

		$html[] = '</table>';

		return implode(NULL, $html);
	}

	public function build($data = FALSE)
	{
		$fields = array();

		if($data)
		{
			$this->data = $data;
		}

		foreach($this->fields as $field_name => $field)
		{

			$data     = isset($this->data[$field_name]) ? $this->data[$field_name] : NULL;
			$obj      = $this->load($field_name, $field);

			$fields[$field_name] = (object) array(
				'label'       => $obj->display_label($data),
				'description' => $obj->display_description($data),
				'field'       => $obj->display_field($data)
			);
		}

		return $fields;
	}

	public function load($name, $field)
	{
		$class_name = ucfirst($field['type']).'_IBField';

		require_once 'fieldtypes/'.ucfirst($field['type']) . '.php';

		return new $class_name($name, $field);
	}

	public function add_fields($fields = array())
	{
		foreach($fields as $field_name => $field)
		{
			$this->add_field($field_name, $field);
		}
	}

	public function add_field($name, $field = array())
	{
		$count = count($this->fields) + 1;

		$default = array(
			'label'       => 'Field '.$count,
			'id'          => 'field_'.$count,
			'type'        => 'input',
			'description' => NULL,
			'default'     => NULL,
			'settings'    => NULL
		);

		foreach($default as $index => $value)
		{
			if(!isset($field[$index]))
			{
				$field[$index] = $value;
			}
		}

		$this->fields[$name] = $field;
	}

	public function get_fields()
	{
		return $this->fields;
	}

	public function get_field($name)
	{
		return $this->fields[$name];
	}

	public function remove_field($name)
	{
		unset($this->fields[$name]);
	}

	public function remove_fields()
	{
		$this->fields = array();
	}

}

abstract class IBFieldtype {

	public $name, $label, $id, $type, $default = '', $settings;

	public function __construct($name, $field)
	{
		$this->name = $name;

		foreach($field as $attr => $value)
		{
			$this->$attr = $value;
		}
	}

	public function display_label($data = '')
	{
		return '<label for="'.$this->id.'">'.$this->label.'</label>';
	}

	public function display_description($data = '', $prepend = '<p>', $append = '</p>')
	{
		return !empty($this->description) ? $prepend.$this->description.$append : NULL;
	}

	abstract public function display_field($data = '');
	
	public function validate($data = '')
	{
		return TRUE;
	}

	public function save($data = '')
	{
		return $data;
	}
}