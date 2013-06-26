@extends('template')

@section('title')
Patient details
@endsection

@section('content')

    <div class="span12 text-center"><h1>{{ $person->first_name }} {{ $person->surname}}</h1><hr/></div>


<div class="tabbable">
  <ul class="nav nav-tabs">
    <?php
    $section = 'details';
    if (Input::old('surgerySave')) $section = 'surgery';
    elseif (Input::old('appointmentSave')) $section = 'appointments';
    ?>
    <li {{ ($section == 'details') ? 'class="active"' : ''}}><a href="#tab1" data-toggle="tab">Patient details</a></li>
    <li {{ ($section == 'surgery') ? 'class="active"' : ''}}><a href="#tab2" data-toggle="tab">Surgical details</a></li>
    <li {{ ($section == 'appointments') ? 'class="active"' : ''}}><a href="#tab3" data-toggle="tab">Appointments</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane {{ ($section == 'details') ? 'active' : '' }}" id="tab1">
            <div class="well">
                <?php if (Session::get('alert_details')) { ?>
                    <div class="span12 alert alert-success">{{ Session::get('alert_details'); }}</div>
                <?php } ?>
                {{ Form::horizontal_open(null)}}
                <h3>Patient details</h3>
                {{ $person_form; }}
                <?php echo Form::actions(array(Button::primary_submit('Save changes', array('name'=>'save')), Form::button('Cancel'))); ?>
                {{ Form::close() }}
            </div>
    </div>
    <div class="tab-pane {{ ($section == 'surgery') ? 'active' : ''}}" id="tab2">
        <div class="well">
            <?php if (Session::get('alert_surgery')) { ?>
                <div class="alert alert-success">{{ Session::get('alert_surgery'); }}</div>
            <?php } ?>
            <h3>Surgical details</h3>

            <?php
            echo Form::open(array('class' => 'form-horizontal'));

            // date
            echo Form::control_group(Form::label('date', 'Date:'),
                Form::text('date', $surgery->date), '',
                '<span class="text-error"> ' . $errors->first('date') . '</span>');

            // surgerytype_id
            echo Form::control_group(Form::label('surgerytype_id', 'Type:'),
                Form::select('surgerytype_id', array(''=>'') + DB::table('surgerytypes')->lists('name','id'), $surgery->surgerytype_id, array('class'=>"myselect")), '',
                '<span class="text-error"> '.$errors->first('surgerytype_id').'</span>');

            // eyes
            $eyes = array('L'=>'L', 'R'=>'R', 'L&R'=>'L&R');
            echo Form::control_group(Form::label('eyes', 'Eye:', array('class' => 'control-label')),
                Form::select('eyes', array('' => '') + $eyes, $surgery->eyes, array('class'=>"myselect")),'',
                '<span class="text-error"> '.$errors->first('eyes').'</span>');

            //ward
            echo Form::control_group(Form::label('ward', 'Ward:'),
                Form::textbox('ward', $surgery->ward), '',
                '<span class="text-error">' . $errors->first('ward') . '</span>');

            // Pre-operative VA left
            echo Form::control_group(Form::label('pre_op_va_left', 'Pre-operative VA left:'),
                Form::textarea('pre_op_va_left', $surgery->pre_op_va_left, array('rows'=>2, 'class' => 'span12')), 'eye_left group1',
            '<span class="text-error"> '.$errors->first('pre_op_va_left').'</span>');

            // Pre-operative VA right
            echo Form::control_group(Form::label('pre_op_va_right', 'Pre-operative VA right:'),
                Form::textarea('pre_op_va_right', $surgery->pre_op_va_right, array('rows'=>2, 'class' => 'span12')), 'eye_right group1',
                '<span class="text-error"> '.$errors->first('pre_op_va_right').'</span>');

            // Post-operative VA left
            echo Form::control_group(Form::label('post_op_va_left', 'Post-operative VA left:'),
                Form::textarea('post_op_va_left', $surgery->post_op_va_left, array('rows'=>2, 'class' => 'span12')), 'eye_left group1',
                '<span class="text-error"> '.$errors->first('post_op_va_left').'</span>');

            // Post-operative VA right
            echo Form::control_group(Form::label('post_op_va_right', 'Post-operative VA right:'),
                Form::textarea('post_op_va_right', $surgery->post_op_va_right, array('rows'=>2, 'class' => 'span12')), 'eye_right group1',
                '<span class="text-error"> '.$errors->first('post_op_va_right').'</span>');

            // biometry left
            echo Form::control_group(Form::label('biometry_left', 'Biometry left:'),
                Form::text('biometry_left', $surgery->biometry_left),
                'eye_left group1',
                '<span class="text-error"> '.$errors->first('biometry_left').'</span>');

            // biometry right
            echo Form::control_group(Form::label('biometry_right', 'Biometry right:'),
                Form::text('biometry_right', $surgery->biometry_right),
                'eye_right group1',
                '<span class="text-error"> '.$errors->first('biometry_right').'</span>');

            // hist. outcome left
            echo Form::control_group(Form::label('histological_outcome_left', 'Histological outcome left:'),
                Form::textarea('histological_outcome_left', $surgery->histological_outcome_left, array('rows'=>4, 'class' => 'span12')),
                'eye_left group2',
                '<span class="text-error"> '.$errors->first('histological_outcome_left').'</span>');

            // hist. outcome right
            echo Form::control_group(Form::label('histological_outcome_right', 'Histological outcome right:'),
                Form::textarea('histological_outcome_right', $surgery->histological_outcome_right, array('rows'=>4, 'class' => 'span12')),
                'eye_right group2',
                '<span class="text-error"> '.$errors->first('histological_outcome_right').'</span>');

            // surgery notes
            echo Form::control_group(Form::label('surgery_notes', 'Surgery notes:'),
                Form::textarea('surgery_notes', $surgery->surgery_notes, array('rows'=>4, 'class'=>'span12')), '',
                '<span class="text-error">' . $errors->first('ward') . '</span>');?>


            <div class="controls"><?php echo Form::submit("Mark surgery as completed", array('name' => 'surgeryComplete', 'class' => 'btn btn-success')); ?></div>

            <?php echo Form::actions(array(
                Button::primary_submit('Save changes', array('name'=>'surgerySave', 'value'=>'save'))

            )); ?>

            {{ Form::close() }}
        </div> <!-- end well -->
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

  </div> <!-- end tab content>

<!--    <script src="http://code.jquery.com/jquery.js"></script>-->
    <script src="/vendor/jquery/jquery.js"></script>
    <script>
        showAllDivs = function () {
            $(".eye_left").show();
            $(".eye_right").show();
        };

        handleNewSelection = function () {

            showAllDivs();
            var typeSelect = $("#surgerytype_id").val();
            var groupOne = new Array('1','2','3');
            var groupTwo = new Array('7','8');
            if (jQuery.inArray(typeSelect, groupOne) > -1) {
                $(".group2").hide();
            } else if (jQuery.inArray(typeSelect, groupTwo) > -1) {
                $(".group1").hide();
            } else {
                $(".group1").hide();
                $(".group2").hide();
            }

            var eyeSelect = $("#eyes").val();
            switch (eyeSelect) {
                case 'L':
                    $(".eye_right").hide();
                    break;
                case 'R':
                    $(".eye_left").hide();
                    break;
                case 'L&R':
                    break;
                default:
                    $(".eye_left").hide();
                    $(".eye_right").hide();
            }
        };

        $(document).ready(function() {

    $("#surgerytype_id").change(handleNewSelection);
    $("#eyes").change(handleNewSelection);

            // Run the event handler once now to ensure everything is as it should be
            handleNewSelection();

        });
    </script>

    @endsection
