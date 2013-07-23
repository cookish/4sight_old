@extends('template')

@section('title')
Patient list
@endsection


@section('content')

<?php

$personInfo = Person::$formInfo;
$wantedKeys = array (
    'first_name'=>'',
    'surname'=>'',
    'hospital_number'=>'',
    'gender'=>'',
    'grade'=>'',
    'date_booked'=>'',
    'date_of_birth'=>'',
    'phone_1'=>'',
    'short_notice'=>''
);

$personInfo = array_intersect_key($personInfo, $wantedKeys);
$surgery_keys = array(
    'eyes',
    'surgerytype_id',
    'biometry',
    'pre_op_va',
);
?>


<h1>New patient</h1>
<p>&nbsp;</p>
<div class="well">
    <h3>Personal details</h3>
{{ Form::horizontal_open(null)}}
{{ View::make('form_display')
    ->with('formData', array('date_booked' => date("Y-m-d")))
    ->with('formInfo', $personInfo) }}
<h3>Surgery details</h3>
{{ View::make('surgery_form')
    ->with('surgery', new Surgery())
    ->with('show_outcome',false)
    ->with('showFields',$surgery_keys) }}


    <?php echo Form::actions(array(Button::primary_submit('Save changes'), Button::link('people/list', 'Cancel'))); ?>
{{ Form::close(); }}
</div>

@endsection