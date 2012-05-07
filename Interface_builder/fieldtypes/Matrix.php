<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Matrix_IBField extends IBFieldtype {

	public $input_type;

	public function display_field($data = '')
	{
		$html = array();

		$attribute_array = array();

		foreach($this->settings['attributes'] as $name => $value)
		{
			$attribute_array[] = $name.'="'.$value.'"';
		}

		$html[] = '<div id="ib-matrix-'.$this->name.'">';
		$html[] = '<table '.implode(NULL, $attribute_array).' class="ib-field-matrix">';
		$html[] = '<thead><tr><th style="width:1px"></th>';

		foreach($this->settings['columns'] as $column)
		{
			if(is_array($column))
			{
				if(isset($column['title']))
				{
					$column = $column['title'];
				}
				else
				{
					$column = $column['name'];
				}
			}

			$html[] = '<th>'.$column.'</th>';
		}

		$html[] = '</tr>';
		$html[] = '</thead>';
		$html[] = '<tbody>';

		if(is_array($data))
		{
			foreach($data as $index => $row)
			{
				$html[] = '<tr><td><div class="ib-drag-handle"></div></td>';

				foreach($this->settings['columns'] as $column)
				{
					$html[] = '<td><input type="text" name="'.$this->name.'['.($index-1).']['.$column['name'].']" value="'.(isset($data[$index][$column['name']]) ? $data[$index][$column['name']] : NULL).'" /></td>';
				}
				
				$html[] = '</tr>';
			}
		}
		
		$html[] = '</tbody>';
		$html[] = '</table>

		<a href="#" class="add-row">Add Row</a>

		</div>

		<script type="text/javascript">
		$(document).ready(function() {
			var id = "#ib-matrix-'.$this->name.'";
			var $wrapper = $(id);
			var $body = $wrapper.find("tbody");
			var $head = $wrapper.find("thead tr");
			var columns = '.json_encode($this->settings['columns']).'

			$wrapper.find(".add-row").click(function() {
				
				var row = $("<tr />");
				var index = $body.find("tr").length;

				row.append("<td><div class=\"ib-drag-handle\"></div></td>");

				for(var x = 1; x < $head.find("th").length; x++) {
					row.append("<td><input type=\"text\" name=\"'.$this->name.'["+index+"]["+columns[x-1].name+"]\" value=\"\" /></td>");
				}

				$body.append(row);

				return false;
			});
		});
		</script>

		';

		return implode(NULL, $html);
	}
}