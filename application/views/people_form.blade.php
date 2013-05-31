<?php
echo Form::open($formTarget, 'POST', array('class' => 'form-horizontal'));
if (!isset($personData)) {
    $personData = array();
}
$fields = array(
    'first_name' => 'First Name',
    'surname' => 'Surname',
    'hospital_number' => 'Hospital number',
    'grade' => 'Grade',
    'date_booked' => 'Date booked',
    'date_of_birth' => 'Date of birth',
    'phone_1' => 'Phone 1',
    'phone_2' => 'Phone 2',
    'contact_history' => 'Contact history',
    'short_notice' => 'Short notice',
    );

$required = array(
    'first_name',
    'surname',
    'grade',
    'hospital_number',
    'date_booked');

$dates = array(
    'date_booked',
    'date_of_birth'
);

?>

@foreach ($fields as $field_name => $field_label)

<div class="control-group">
    <?php
    $requiredStyle = in_array($field_name, $required) ? 'required' : '';
    $value = (isset($personData->{$field_name}) ? $personData->{$field_name} : null);
    if (isset($value) && in_array($field_name, $dates)) {
        $date = new DateTime($value);
        $value = $date->format('j F Y');
    }
?>
    <?php echo Form::label($field_name, $field_label, array('class' => 'control-label ' . $requiredStyle)); ?>
    <div class="controls">
        <?php echo Form::text($field_name, Input::old($field_name, $value)); ?>
        <span class="text-error">{{ $errors->first($field_name) }}</span>
    </div>

</div>

@endforeach
<p>&nbsp;</p>
<?php echo Form::submit($saveText, array('name' => 'save', 'class' => 'btn btn-primary'));?>
<?php echo Form::close();?>