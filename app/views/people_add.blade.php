@extends('template')

@section('title')
Patient list
@endsection


@section('content')
<h1>New patient</h1>
<p>&nbsp;</p>
<div class="well">
{{ Form::horizontal_open(null)}}
{{ $person_form; }}
<?php echo Form::actions(array(Button::primary_submit('Save changes'), Button::link('people/list', 'Cancel'))); ?>
{{ Form::close(); }}
</div>

@endsection