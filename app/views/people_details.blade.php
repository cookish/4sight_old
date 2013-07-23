@extends('template')

@section('title')
Patient details
@endsection

@section('content')

    <div class="span12 text-center"><h1>{{ $person->first_name }} {{ $person->surname}}</h1><hr/></div>


<div class="tabbable">
  <ul class="nav nav-pills">
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
  <div class="tab-content">
    <div class="tab-pane {{ ($section == 'details') ? 'active' : '' }}" id="tab1">

        <?php if (Session::get('alert_details')) { ?>
            <div class="span12 alert alert-success">{{ Session::get('alert_details'); }}</div>
        <?php } ?>
        <h3>Patient details</h3>

            <div class="well">

                {{ Form::horizontal_open(null)}}

                <?php
                //set the date booked to default to today
                $formInfo = Person::$formInfo;
                //$formInfo = today;
                ?>

                {{ View::make('form_display')
                    ->with('formData', $person)
                    ->with('formInfo', $formInfo)}}
                <?php echo Form::actions(array(Button::primary_submit('Save changes', array('name'=>'save')), Button::link('people/list', 'Cancel'))); ?>
                {{ Form::close() }}
            </div>
    </div>

    <div class="tab-pane {{ ($section == 'surgery') ? 'active' : ''}}" id="tab2">
        <?php
        echo Form::open(array('class' => 'form-horizontal'));

        if (Session::get('alert_surgery_'.$surgery->id) ) { ?>
        <div class="alert alert-success">{{ Session::get('alert_surgery_'.$surgery->id); }}</div>
        <?php } ?>
        <h3>Surgical details</h3>
        <div class="well">

             <?php

            echo  View::make('surgery_form')
                    ->with('surgery', $surgery)
                    ->with('show_outcome', false);

            echo Form::actions(array(
                Button::primary_submit('Save changes', array('name'=>'surgerySave', 'value'=>$surgery->id))

            )); ?>
        </div> <!-- end well -->

        <div class="alert alert-info">
         <?php
         echo Form::control_group(Form::label('outcome', 'Outcome:'),
            Form::select('outcome', array(''=>'') + Surgery::$outcomes, $surgery->outcome, array('class'=>"myselect")), '',
            '<span class="text-error"> '.$errors->first('outcome').'</span>');
         ?>

            <div class="controls"><?php echo Form::submit("Save and mark surgery as concluded",
                    array('name' => 'surgeryComplete', 'value'=>$surgery->id, 'class' => 'btn btn-info')); ?></div>
        </div> <!-- end success alert box -->
        {{ Form::close() }}
    </div> <!-- end tab 2 -->


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

                <div class="control-group"><textarea class="span12" rows="4" name="notes">{{ $appointment->notes; }}</textarea></div>
                <button class="btn btn-primary" name="appointmentSave" value="{{ $appointment->id; }}">Save</button>
                <button class="btn" name="appointmentDelete" value="{{ $appointment->id; }}"><i class="icon-search icon-trash"></i> Delete</button>
                <?php echo Form::close();?>
            </div> <!-- end well -->
        @endforeach


        <!-- Button to trigger modal -->
        <a href="#myModal" role="button" class="btn" data-toggle="modal">Add appointment</a>

        <!-- Modal -->
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <?php echo Form::open(array('class' => 'form-horizontal')); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">New appointment</h3>
            </div>
            <div class="modal-body">


                <div class="control-group span6">

                    <select class="myselect" name="appointmenttype_id">
                        @foreach (DB::table('appointmenttypes')->get(array('id', 'name')) as $apptype)
                        <option value="{{ $apptype->id; }}">{{ $apptype->name; }}</option>
                        @endforeach

                    </select>
                </div>

                <div class="control-group span6 text-right">Date: <input class="myshortinput" name="date" type="text"/></div>
                Notes:<br/>
                <div class="control-group"><textarea class="span12" rows="4" name="notes"></textarea></div>



            </div> <!-- end modal body -->
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                <button class="btn btn-primary" name="appointmentAdd">Save changes</button>
            </div>
            <?php echo Form::close();?>
        </div> <!-- end modal -->

    </div> <!-- end tab 3 -->

    <div class="tab-pane {{ ($section == 'past_surgeries') ? 'active' : '' }}" id="tab4">

        <h3>Surgical details</h3>
        @foreach ($past_surgeries as $psurgery)
        <?php echo Form::open(array('class' => 'form-horizontal'));?>
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

            <?php echo Form::actions(array(
                Button::primary_submit('Save changes', array('name'=>'surgerySave', 'value'=>$psurgery->id))

            )); ?>
        </div> <!-- end well -->
        {{ Form::close() }}
        @endforeach


    </div>  <!-- end tab 4 -->

  </div> <!-- end tab content>



    @endsection
