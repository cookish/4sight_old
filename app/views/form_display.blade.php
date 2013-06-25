<?php
if (!isset($formData)) {
    $formData = array();
}

$formInfo = array(
    'first_name' => array('type'=>'text', 'label' => 'First name', 'required'=> true),
    'surname' => array('type'=>'text', 'label' => 'Surname', 'required'=> true),
    'gender' => array('type'=>'dropdown', 'label' => 'Gender',
        'options' => array('male' => 'Male','female' => 'Female')),
    'hospital_number' => array('type'=>'text', 'label' => 'Hospital number', 'required'=> true),
    'grade' => array('type'=>'dropdown', 'label' => 'Grade',
        'options' => array(1 => '1', 2 => '2', 3 => '3', 4 => '4')),
    'date_booked' => array('type'=>'timestamp', 'label' => 'Date Booked', 'required'=> true),
    'date_of_birth' => array('type'=>'timestamp', 'label' => 'Date of birth'),
    'phone_1' => array('type'=>'text', 'label' => 'Phone 1'),
    'phone_2' => array('type'=>'text', 'label' => 'Phone 2'),
    'short_notice' => array('type'=>'dropdown', 'label' => 'Short notice',
        'options' => array(true => 'Yes', false => 'No')),
    'contact_history' => array('type'=>'textarea', 'label' => 'Contact history'),
    'cancellation_notes' => array('type'=>'textarea', 'label' => 'Cancellation notes')
);


// formInfo has details of what fields belong in the form
// formData has data for each of the fields from the database, if set

foreach ($formInfo as $field => $fieldData) {
    $value = (isset($formData->{$field}) ? $formData->{$field} : null);
    $required = (isset($fieldData['required']) && $fieldData['required']) ? array('class'=>'required') : null;
    switch ($fieldData['type']) {
        case 'text':
            echo Form::control_group(Form::label($field, $fieldData['label'], $required),
                Form::text($field, Input::old($field, $value)),'',
                '<span class="text-error"> '. $errors->first($field) . '</span>');
            break;
        case 'dropdown':
            // add a blank line at the top of the dropdown
            $fieldData['options'] = array('') + $fieldData['options'];
            echo Form::control_group(Form::label($field, $fieldData['label'], $required),
                Form::select($field, $fieldData['options']), '',
            '<span class="text-error"> '. $errors->first($field) . '</span>');
            break;
        case 'timestamp':
            if ($value) {
                $date = new DateTime($value);
                $value = $date->format('j F Y');
            }
            echo Form::control_group(Form::label($field, $fieldData['label'], $required),
                Form::text($field, Input::old($field, $value)),'',
                '<span class="text-error"> '. $errors->first($field) . '</span>');
            break;
        case 'textarea':
            echo Form::control_group(Form::label($field, $fieldData['label'], $required),
                Form::xxlarge_textarea($field, Input::old($field, $value), array('rows' => '4')),'',
                '<span class="text-error"> '. $errors->first($field) . '</span>');
            break;
    }
}
?>
