<?php namespace InterfaceBuilder;

abstract class InterfaceBuilderField extends InterfaceBuilderCore {
	
	/**
	 * Field data
	 *
	 * @access	protected
	 * @type		
	*/
	
	protected $data;
		

	/**
	 * Field default data
	 *
	 * @access	protected
	 * @type	mixed	
	*/
	
	protected $default = '';
	
		
	/**
	 * Field Description
	 *
	 * @access	protected
	 * @type	string
	*/
	
	protected $description;
	

	/**
	 * Does the fieldtype have additional configuration or settings? 
	 *
	 * @access	protected
	 * @type		
	*/
	
	protected $hasSettings = FALSE;
	
	/**
	 * Does the fieldtype have options? 
	 *
	 * @access	protected
	 * @type		
	*/
	
	protected $hasOptions = FALSE;
	
	/**
	 * Field ID
	 *
	 * @access	protected
	 * @type		
	*/
	
	protected $id;
		
		
	/**
	 * Field Label
	 *
	 * @access	protected
	 * @type	null
	*/
	
	protected $label;
		
		
	/**
	 * Field Name
	 *
	 * @access	protected
	 * @type		
	*/
	
	protected $name;
	
			
	/**
	 * Is the field required?
	 *
	 * @access	protected
	 * @type	bool	
	*/
	
	protected $required = FALSE;
	
			
	/**
	 * Settings array to pass anything you need to each fieldtype
	 *
	 * @access	protected
	 * @type	array	
	*/
	
	protected $settings;
		
			
	/**
	 * Constructor
	 *
	 * @access	protected
	 * @type	string	
	*/
	
	public function __construct($properties = array())
	{
		parent::__construct($properties);
	}
	
			
	/**
	 * Get the field ID
	 *
	 * @access	protected
	 * @return	string	
	*/
	
	public function getId()
	{
		return !empty($this->id) ? $this->id : $this->name;
	}
	
			
	/**
	 * Get the field label
	 *
	 * @access	protected
	 * @return	string	
	*/
	
	public function getLabel()
	{
		return !empty($this->label) ? $this->label : $this->name;
	}
		
			
	/**
	 * Display the field label
	 *
	 * @access	protected
	 * @return	string	
	*/
	
	public function displayLabel()
	{
		return '<label for="'.$this->getId().'">'.$this->getLabel().'</label>';
	}
		
			
	/**
	 * Display the field label
	 *
	 * @access	protected
	 * @return	string	
	*/
	
	public function displayDescription()
	{
		return '<p>'.$this->description.'</p>';
	}
	
	
	/**
	 * Display the fieldtype
	 *
	 * @access	protected
	 * @return	string	
	*/
	
	abstract function displayField($data = FALSE);
		
			
	/**
	 * Display the field label
	 *
	 * @access	protected
	 * @return	string	
	*/
	
	public function getSettings($data = FALSE)
	{
		if(!$this->hasSettings)
		{
			return NULL;
		}

		$return = array();

		if(is_array($this->settings))
		{
			foreach($this->settings as $setting)
			{
				$class = '\InterfaceBuilder\Fieldtypes\\'.$setting['type'];
				
				$value = isset($data->{$setting['name']}) ? $data->{$setting['name']} : FALSE;
	
				$setting['id']   = 'setting-'.$this->name.'-'.$setting['name'];
				$setting['name'] = 'settings['.$this->name.']['.$setting['name'].']';

				$obj   = new $class($setting);

				$return[] = array(
					'label' => $obj->displayLabel(),
					'field' => $obj->displayField($value),
					'description' => $obj->displayDescription()
				);
			}
		}

		return $return;
	}
	

	/**
	 * Validate the fieldtype
	 *
	 * @access	protected
	 * @return	mixed	
	*/
	
	public function validate()
	{
		return TRUE;
	}
	
	
	/**
	 * Save the fieldtype
	 *
	 * @access	protected
	 * @return	mixed	
	*/
	
	public function save()
	{
		return $this->data;
	}
	
	
	/**
	 * Helper method to prepare the form data
	 *
	 * @access	public
	 * @return	string	
	*/
	
	public function sanitize($str = '', $fieldName = '')
	{
		$preppedFields = array();

		// if the field name is an array we do this recursively
		if (is_array($str))
		{
			foreach ($str as $key => $val)
			{
				$str[$key] = $this->formPrep($val);
			}

			return $str;
		}

		if (empty($str) || isset($preppedFields[$fieldName]))
		{
			return $str;
		}

		// In case htmlspecialchars misses these.
		$str = htmlspecialchars(str_replace(array("'", '"'), array("&#39;", "&quot;"), $str));

		if ($fieldName != '')
		{
			$preppedFields[$fieldName] = $fieldName;
		}

		return $str;
	}
}