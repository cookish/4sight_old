@extends('template')

@section('title')
Patient list
@endsection


@section('content')
<h1>New patient</h1>
<p>&nbsp;</p>
<div class="well">
{{ Form::horizontal_open(null)}}
{{ View::make('form_display')
    ->with('formData', array())
    ->with('formInfo',
        array('surgerytype_id' => array('type'=>'dropdown', 'label' => 'Surgery type', 'required'=> true,
        'options' => DB::table('surgerytypes')->lists('name','id')))
    + Person::$formInfo) }}
<?php echo Form::actions(array(Button::primary_submit('Save changes'), Button::link('people/list', 'Cancel'))); ?>
{{ Form::close(); }}
</div>

@endsection