<?php
if (!isset($formData)) {
    $formData = array();
}



// formInfo has details of what fields belong in the form
// formData has data for each of the fields from the database, if set

foreach ($formInfo as $field => $fieldData) {
    $value = (isset($formData->{$field}) ? $formData->{$field} : null);
    $required = (isset($fieldData['required']) && $fieldData['required']) ? array('class'=>'required') : null;
    switch ($fieldData['type']) {
        case 'text':
            echo Form::control_group(Form::label($field, $fieldData['label'] . ':', $required),
                Form::text($field, Input::old($field, $value)),'',
                '<span class="text-error"> '. $errors->first($field) . '</span>');
            break;
        case 'dropdown':
            // add a blank line at the top of the dropdown
            $fieldData['options'] = array('' => '') + $fieldData['options'];
            echo Form::control_group(Form::label($field, $fieldData['label'] . ':', $required),
                Form::select($field, $fieldData['options'], $value), '',
            '<span class="text-error"> '. $errors->first($field) . '</span>');
            break;
        case 'timestamp':
            if ($value) {
                $date = new DateTime($value);
                $value = $date->format('j F Y');
            }
            echo Form::control_group(Form::label($field, $fieldData['label'] . ':', $required),
                Form::text($field, Input::old($field, $value)),'',
                '<span class="text-error"> '. $errors->first($field) . '</span>');
            break;
        case 'textarea':
            echo Form::control_group(Form::label($field, $fieldData['label'] . ':', $required),
                Form::xxlarge_textarea($field, Input::old($field, $value), array('rows' => '4')),'',
                '<span class="text-error"> '. $errors->first($field) . '</span>');
            break;
    }
}
?>
