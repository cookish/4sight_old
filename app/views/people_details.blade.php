@extends('template')

@section('title')
Patient details
@endsection

@section('sidebar')
<?php require_once(app_path().'/views/form.inc.php');
//Session::forget('_old_input');
//Session::push('_old_input.date', '4');
//Session::put('', array('date'=>'3'));
//print_r(Session::all());
?>

<h4>{{ $person->first_name }} {{ $person->surname }} : {{ $person->hospital_number }} </h4>
<br>
<div class="tabbable">
<ul class="nav nav-tabs">
    <?php
    $section = 'details';
    if (Input::old('surgerySave') || Input::old('surgeryComplete')) $section = 'surgery';
    elseif (Input::old('appointmentSave')) $section = 'appointments';
    ?>
    <li {{ ($section == 'details') ? 'class="active"' : ''}}><a href="#tab1" data-toggle="tab">Patient details</a></li>
    <li {{ ($section == 'surgery') ? 'class="active"' : ''}}><a href="#tab2" data-toggle="tab">Surgical details</a></li>
    <li {{ ($section == 'appointments') ? 'class="active"' : ''}}><a href="#tab3" data-toggle="tab">Appointments</a></li>
    <li {{ ($section == 'past_surgeries') ? 'class="active"' : ''}}><a href="#tab4" data-toggle="tab">Past surgeries</a></li>
</ul>
</div>


@if (Session::get('alert_details'))
    <div class="col-sm-12 alert alert-success">{{ Session::get('alert_details'); }}</div>
@endif
@if (Session::get('alert_surgery_'.$surgery->id) )
    <div class="alert alert-success">{{ Session::get('alert_surgery_'.$surgery->id); }}</div>
@endif

<?php //print_r($errors->all()); ?>
@endsection

@section('content')
<div class="tabbable">
  <div class="tab-content">
    <div class="tab-pane {{ ($section == 'details') ? 'active' : '' }}" id="tab1">
        <h3>Patient details</h3>
            <div class="well">
	            {{ Form::model($person, array('class'=>'form-horizontal', 'role'=>'form')) }}

                <?php
                //set the date booked to default to today
//                $formInfo = Person::$formInfo;
                //$formInfo = today;


	            form_display::make('text','first_name')->required()->errors($errors)->draw();
	            form_display::make('text','surname')->required()->errors($errors)->draw();
	            form_display::make('text','hospital_number')->required(true)->errors($errors)->draw();
	            form_display::make('select','gender')->required()->errors($errors)
	                ->options(array('male'=>'Male', 'female'=>'Female'))->divCss("col-sm-2")->draw();
	            form_display::make('select','grade')->errors($errors)
	                ->options(array(1=>'1', 2=>'2', 3=>'3', 4=>'4'))->divCss('col-sm-2')->draw();
	            form_display::make('date','date_booked')->required()->errors($errors)->draw();
	            form_display::make('date','date_of_birth')->required()->errors($errors)->draw();
	            form_display::make('text','phone_1')->label('Contact phone')->required()->errors($errors)->draw();
	            form_display::make('text','phone_2')->label('Alternate phone')->errors($errors)->draw();
	            form_display::make('textarea','contact_history')->rows(5)->errors($errors)->draw();
	            form_display::make('select','short_notice')->required()->errors($errors)
	                ->options(array('yes'=>'Yes', 'no'=>'No'))->divCss("col-sm-2")->draw();
                form_display::make('textarea','cancellation_notes')->rows(5)->errors($errors)->draw();
                ?>

<!--                 View::make('form_display')-->
<!--                    ->with('formData', $person)-->
<!--                    ->with('formInfo', $formInfo)-->

	            {{ Form::submit('Save changes', array('name'=>'save','class'=>'btn btn-primary')) }}
	            {{ link_to('people/list', 'Cancel', array('class' => 'btn btn-default')) }}

                {{ Form::close() }}
            </div>
    </div>


<!-- ------------------------------------------------ SURGERY  ------------------------------------------------ -->

    <div class="tab-pane {{ ($section == 'surgery') ? 'active' : ''}}" id="tab2">

        {{ Form::model($surgery, array('class' => 'form-horizontal')) }}
<!--	    --><?php //print_r($surgery);
//	    echo "\n\n";
//	    print_r($past_surgeries);
	    ?>

        <h3>Surgical details</h3>
        <div class="well">

            <?php
            echo  View::make('surgery_form')
                    ->with('surgery', $surgery)
                    ->with('show_outcome', false);
			?>
	        {{ Form::hidden('surgerySave',$surgery->id) }}
	        {{ Form::submit('Save changes', array('class'=>'btn btn-primary')) }}
        </div> <!-- end well -->

        <div class="alert alert-info">
         <?php
         form_display::make('select', 'outcome')->options(Surgery::$outcomes)->defaultVal($surgery->outcome)->errors($errors)
	         ->draw();
//         echo Form::control_group(Form::label('outcome', 'Outcome:'),
//            Form::select('outcome', array(''=>'') + Surgery::$outcomes, $surgery->outcome, array('class'=>"myselect")), '',
//            '<span class="text-error"> '.$errors->first('outcome').'</span>');
         ?>
	        <div class="controls">
	            {{ Form::hidden('surgeryComplete',$surgery->id) }}

                {{ Form::submit("Save and mark surgery as concluded", array('class' => 'btn btn-info')) }}
	        </div>
        </div> <!-- end success alert box -->
        {{ Form::close() }}
    </div> <!-- end tab 2 -->

<!-- --------------------------------------------- APPOINTMENTS --------------------------------------------- -->

    <div class="tab-pane {{ ($section == 'appointments') ? 'active' : ''}}" id="tab3">

        <h3>Appointments</h3>

        @foreach ($person->appointments as $appointment)

        <?php
        //whether this appointment was just saved
        $savedApp = (Input::old('appointmentSave') == $appointment->id)
        ?>
        <div class="well">
            <?php
            echo Form::open();
            $temp = ($savedApp) ? Input::old('date',$appointment->date) : $appointment->date;
            $date = '';
            if ($temp) {
                $date = new DateTime($temp);
                $date = $date->format('j F Y');
            }
            $appointtypeidToDisplay = ($savedApp) ? Input::old('appointmenttype_id', $appointment->appointmenttype_id) : $appointment->appointmenttype_id;
            ?>

            <select class="myselect" name="appointmenttype_id">
                @foreach (DB::table('appointmenttypes')->lists('name', 'id') as $id => $name)
                    <option value="{{ $id }}" {{ ($id == $appointtypeidToDisplay) ? 'selected = "selected"' : ''}} >{{ $name }}</option>
                @endforeach
            </select>
            <?php

            //echo Form::select('appointmenttype_id', DB::table('appointmenttypes')->lists('name', 'id'), $appointment->appointmenttype_id, array('class'=>'myselect'));

            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            echo '<input class="input-medium" name="date" type="text" value="' . $date .'" id="date">';
//            echo Form::medium_text('date', $date->format('j F Y'),'');
//            print_r($errors);
            if (Input::old('appointmentSave') == $appointment->id) {
                echo '<span class="text-error"> '. $errors->first("date") . '</span>';
            }
            ?>

                <div class="control-group"><textarea class=".col-sm-12" rows="4" name="notes">{{ $appointment->notes; }}</textarea></div>
                <button class="btn btn-primary" name="appointmentSave" value="{{ $appointment->id; }}">Save</button>
                <button class="btn" name="appointmentDelete" value="{{ $appointment->id; }}"><i class="glyphicon-search glyphicon-trash"></i> Delete</button>
                <?php echo Form::close();?>
            </div> <!-- end well -->
        @endforeach


        <!-- Button to trigger modal -->
        <a href="#myModal" role="button" class="btn" data-toggle="modal">Add appointment</a>

        <!-- Modal -->
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
            <?php echo Form::open(array('class' => 'form-horizontal')); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">New appointment</h3>
            </div>
            <div class="modal-body">

                <div class="control-group .col-sm-6">

                    <select class="myselect" name="appointmenttype_id">
                        @foreach (DB::table('appointmenttypes')->get(array('id', 'name')) as $apptype)
                        <option value="{{ $apptype->id; }}">{{ $apptype->name; }}</option>
                        @endforeach

                    </select>
                </div>

                <div class="control-group .col-sm-6 text-right">Date: <input class="myshortinput" name="date" type="text"/></div>
                Notes:<br/>
                <div class="control-group"><textarea class=".col-sm-12" rows="4" name="notes"></textarea></div>

            </div> <!-- end modal body -->
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                <button class="btn btn-primary" name="appointmentAdd">Save changes</button>
            </div>
            </div>
            <?php echo Form::close();?>
            </div>
        </div> <!-- end modal -->

    </div> <!-- end tab 3 -->

<!-- --------------------------------------------- PAST SURGERIES --------------------------------------------- -->


    <div class="tab-pane {{ ($section == 'past_surgeries') ? 'active' : '' }}" id="tab4">

        <h3>Surgical details</h3>
        @foreach ($past_surgeries as $psurgery)
        <?php echo Form::model($psurgery, array('class' => 'form-horizontal'));?>
        <div class="well">

            <?php
            if (Session::get('alert_surgery_'.$psurgery->id)) {
                echo '<div class="alert alert-success">'.Session::get('alert_surgery_'.$psurgery->id).'</div>';
            }
            ?>
            {{ View::make('surgery_form')
                ->with('surgery', $psurgery)
                ->with('show_outcome', true)
            }}

	        {{ Form::hidden('surgerySave',$psurgery->id) }}
	        {{ Form::submit('Save changes', array('class'=>'btn btn-primary')) }}


        </div> <!-- end well -->
        {{ Form::close() }}
        @endforeach
    </div>  <!-- end tab 4 -->
  </div> <!-- end tab content-->
@endsection
