<?php
class form_display {

	static public function make($type, $name)
	{
		return new self($type, $name);
	}

	private $type;
	private $errors;
	private $label;
	private $name;
	private $defaultVal;
	private $divCss;
	private $outerCss = 'form-group';
	private $inputCss = 'form-control';
	private $required = false;
	private $rows;
//	private $showErrors = true;
	private $options = array();

	function form_display($type, $name) {
		$this->type = $type;
		$this->name = $name;
	}

	function errors($errors) { $this->errors = $errors; return $this; }
	function label($label) { $this->label = $label; return $this; }
	function defaultVal($defaultVal) { $this->defaultVal = $defaultVal; return $this; }
	function required() { $this->required = true; return $this; }
//	function suppressErrors() { $this->showErrors = false; return $this; }
	function divCss($divCss) { $this->divCss = $divCss; return $this; }
	function addOuterCss($outerCss) { $this->outerCss .= ' ' . $outerCss; return $this; }
	function addInputCss($inputCss) { $this->inputCss .= ' ' . $inputCss; return $this; }
	function options($options) { $this->options = $options; return $this; }
	function rows($rows) { $this->rows = $rows; return $this; }


	function draw() {
		if (isset($this->options)) {   // add blank entry as first option
			$this->options = array(''=>'') + $this->options;
		}
		$showErrors = isset($this->errors) && $this->errors->has($this->name);
		$this->addOuterCss($showErrors ? 'has-error' : '');
		if (!$this->label) {
			$this->label = ucfirst(str_replace('_', ' ', $this->name));
		}
		if (!$this->divCss && $this->type == 'select') $this->divCss = 'col-sm-3'; // by default selects have width of 3
		elseif (!$this->divCss && $this->type == 'textarea') $this->divCss = 'col-sm-9'; // by default textareas have width of 9
		elseif (!$this->divCss) $this->divCss = 'col-sm-5'; // default width of 5


?>

		<div class="<?php echo $this->outerCss; ?>">
			<?php echo Form::label($this->name, ($this->required ? '* ' : '') . $this->label, array('class'=>'col-sm-3 control-label')); ?>
			<div class="<?php echo $this->divCss; ?>">
				<?php
				switch ($this->type) {
					case 'text':
						echo Form::text($this->name, $this->defaultVal, array('class'=>$this->inputCss));
						break;
					case 'select':
						echo Form::select($this->name, $this->options, $this->defaultVal, array('class'=>$this->inputCss));
						break;
					case 'date':
		                $value = Input::old($this->name);
						if (!$value) {
							$value = $this->defaultVal;
						}
						if ($value) {
			                $date = new DateTime($value);
							$value = $date->format('j F Y');
						}
						echo Form::text($this->name, $value, array('class'=>$this->inputCss));
						break;
					case 'textarea':
						$attr = array('class'=>$this->inputCss);
						if (isset($this->rows)) {
							$attr['rows'] = $this->rows;
						}
						echo Form::textarea($this->name, $this->defaultVal, $attr);
						break;
//            }
					default:
						throw new ErrorException('Unknown type of form given:' . $this->type);
				}
				if ($showErrors) {
					echo '<span class="text-danger">' . $this->errors->first($this->name). '</span>';
				}
				?>
			</div>
		</div>
	<?php
	}
}