@extends('template')

@section('title')
Patient list
@endsection


@section('content')
<h1>New patient</h1>
<p>&nbsp;</p>
{{ Form::horizontal_open(null)}}
{{ $person_form; }}
<?php echo Form::actions(array(Button::primary_submit('Save changes'), Form::button('Cancel'))); ?>
{{ Form::close(); }}

@endsection