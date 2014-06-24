@extends('template')

@section('title')
Patient list
@endsection


@section('content')

<?php
require_once(app_path().'/views/form.inc.php');
$surgery_keys = array(
	'eyes',
	'surgerytype_id',
	'biometry',
	'pre_op_va',
);
?>


<h1>New patient</h1>
<p>&nbsp;</p>
<div class="well col-sm-7">
	<h3>Personal details</h3>
	{{ Form::model(NULL, array('class'=>'form-horizontal', 'role'=>'form')) }}
		<?php
		form_display::make('text','first_name')->required()->errors($errors)->draw();
		form_display::make('text','surname')->required()->errors($errors)->draw();
		form_display::make('text','hospital_number')->required(true)->errors($errors)->draw();
		form_display::make('select','gender')->required()->errors($errors)
			->options(array('male'=>'Male', 'female'=>'Female'))->draw();
		form_display::make('select','grade')->errors($errors)
			->options(array(1=>'1', 2=>'2', 3=>'3', 4=>'4'))->divCss('col-sm-2')->draw();
		form_display::make('date','date_booked')->required()->errors($errors)->defaultVal(date("Y-m-d"))->draw();
		form_display::make('date','date_of_birth')->required()->errors($errors)->draw();
		form_display::make('text','phone_1')->label('Contact phone')->required()->errors($errors)->draw();
		form_display::make('select','short_notice')->required()->errors($errors)
			->options(array('yes'=>'Yes', 'no'=>'No'))->draw();

		echo '<h3>Surgery details</h3>';
		echo View::make('surgery_form')
			->with('surgery', new Surgery())
			->with('show_outcome',false)
			->with('showFields',$surgery_keys)
			->with('new', true);


		?>

<!--	--><?php //display_text('hospital_number', 'Hospital number', true, $errors); ?>
<!--	--><?php //display_select('gender', 'Gender', true, array('male'=>'Male', 'female'=>'Female'), $errors); ?>
<!--	--><?php //display_select('grade', 'Grade', true, array(1=>'1', 2=>'2', 3=>'3', 4=>'4'), $errors); ?>
<!--	--><?php //display_text('date_booked', 'Date booked', true, $errors); ?>
	<div class="row"></div>

	{{ Form::submit('Add patient', array('class'=>'btn btn-primary')) }}
	{{ link_to('people/list', 'Cancel', array('class' => 'btn btn-default')) }}



	{{ Form::close(); }}
</div>

@endsection