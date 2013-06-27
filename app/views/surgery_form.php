<?php

//need to identify different surgeries by id for javascript to work
$id = 'id' . $surgery->id;
//print_r($surgery);

// whether this is the surgery that has been saved - i.e. whether to display error messages
$dispErr = ((Input::old('surgerySave') == $surgery->id) ||
    (Input::old('surgeryComplete') == $surgery->id));

// date
echo Form::control_group(Form::label('date', 'Date:'),
    Form::text('date', $surgery->date), '',
    ($dispErr) ? '<span class="text-error"> ' . $errors->first('date') . '</span>' : '');

// surgerytype_id
echo Form::control_group(Form::label('surgerytype_id', 'Type:'),
    Form::select('surgerytype_id', array(''=>'') + DB::table('surgerytypes')->lists('name','id'), $surgery->surgerytype_id, array('class'=>"myselect surgerytype_id $id")), '',
    ($dispErr) ? '<span class="text-error"> '.$errors->first('surgerytype_id').'</span>' : '');

// eyes
$eyes = array('L'=>'L', 'R'=>'R', 'L&R'=>'L&R');
echo Form::control_group(Form::label('eyes', 'Eye:', array('class' => 'control-label')),
    Form::select('eyes', array('' => '') + $eyes, $surgery->eyes, array('class'=>"myselect eyes $id")),'',
    ($dispErr) ? '<span class="text-error"> '.$errors->first('eyes').'</span>' : '');

//ward
echo Form::control_group(Form::label('ward', 'Ward:'),
    Form::textbox('ward', $surgery->ward), '',
    ($dispErr) ? '<span class="text-error">' . $errors->first('ward') . '</span>' : '');

// Pre-operative VA left
echo Form::control_group(Form::label('pre_op_va_left', 'Pre-operative VA left:'),
    Form::textarea('pre_op_va_left', $surgery->pre_op_va_left, array('rows'=>2, 'class' => 'span12')), "eye_left group1 $id",
    ($dispErr) ? '<span class="text-error"> '.$errors->first('pre_op_va_left').'</span>' : '');

// Pre-operative VA right
echo Form::control_group(Form::label('pre_op_va_right', 'Pre-operative VA right:'),
    Form::textarea('pre_op_va_right', $surgery->pre_op_va_right, array('rows'=>2, 'class' => 'span12')), "eye_right group1 $id",
    ($dispErr) ? '<span class="text-error"> '.$errors->first('pre_op_va_right').'</span>' : '');

// Post-operative VA left
echo Form::control_group(Form::label('post_op_va_left', 'Post-operative VA left:'),
    Form::textarea('post_op_va_left', $surgery->post_op_va_left, array('rows'=>2, 'class' => 'span12')), "eye_left group1 $id",
    ($dispErr) ? '<span class="text-error"> '.$errors->first('post_op_va_left').'</span>' : '');

// Post-operative VA right
echo Form::control_group(Form::label('post_op_va_right', 'Post-operative VA right:'),
    Form::textarea('post_op_va_right', $surgery->post_op_va_right, array('rows'=>2, 'class' => 'span12')), "eye_right group1 $id",
    ($dispErr) ? '<span class="text-error"> '.$errors->first('post_op_va_right').'</span>' : '');

// biometry left
echo Form::control_group(Form::label('biometry_left', 'Biometry left:'),
    Form::text('biometry_left', $surgery->biometry_left),
    "eye_left group1 $id",
    ($dispErr) ? '<span class="text-error"> '.$errors->first('biometry_left').'</span>' : '');

// biometry right
echo Form::control_group(Form::label('biometry_right', 'Biometry right:'),
    Form::text('biometry_right', $surgery->biometry_right),
    "eye_right group1 $id",
    ($dispErr) ? '<span class="text-error"> '.$errors->first('biometry_right').'</span>' : '');

// hist. outcome left
echo Form::control_group(Form::label('histological_outcome_left', 'Histological outcome left:'),
    Form::textarea('histological_outcome_left', $surgery->histological_outcome_left, array('rows'=>4, 'class' => 'span12')),
    "eye_left group2 $id",
    ($dispErr) ? '<span class="text-error"> '.$errors->first('histological_outcome_left').'</span>' : '');

// hist. outcome right
echo Form::control_group(Form::label('histological_outcome_right', 'Histological outcome right:'),
    Form::textarea('histological_outcome_right', $surgery->histological_outcome_right, array('rows'=>4, 'class' => 'span12')),
    "eye_right group2 $id",
    ($dispErr) ? '<span class="text-error"> '.$errors->first('histological_outcome_right').'</span>' : '');

// surgery notes
echo Form::control_group(Form::label('surgery_notes', 'Surgery notes:'),
    Form::textarea('surgery_notes', $surgery->surgery_notes, array('rows'=>4, 'class'=>'span12')), '',
    ($dispErr) ? '<span class="text-error">' . $errors->first('ward') . '</span>' : '');

//outcome
if ($show_outcome) {
    echo Form::control_group(Form::label('outcome', 'Outcome:'),
        Form::select('outcome', array(''=>'') + Surgery::$outcomes, $surgery->outcome, array('class'=>"myselect")), '',
        ($dispErr) ? '<span class="text-error"> '.$errors->first('outcome').'</span>' : '');
}

?>

<!--    <script src="http://code.jquery.com/jquery.js"></script>-->
<script src="/vendor/jquery/jquery.js"></script>
<script>
    showAllDivs<?php echo $id;?> = function () {
        $(".eye_left.<?php echo $id;?>").show();
        $(".eye_right.<?php echo $id;?>").show();
    };

    handleNewSelection<?php echo $id;?> = function () {

        showAllDivs<?php echo $id;?>();
        var typeSelect = $(".surgerytype_id.<?php echo $id;?>").val();
        var groupOne = new Array('1','2','3');
        var groupTwo = new Array('7','8');
        if (jQuery.inArray(typeSelect, groupOne) > -1) {
            $(".group2.<?php echo $id;?>").hide();
        } else if (jQuery.inArray(typeSelect, groupTwo) > -1) {
            $(".group1.<?php echo $id;?>").hide();
        } else {
            $(".group1.<?php echo $id;?>").hide();
            $(".group2.<?php echo $id;?>").hide();
        }

        var eyeSelect = $(".eyes.<?php echo $id;?>").val();
        switch (eyeSelect) {
            case 'L':
                $(".eye_right.<?php echo $id;?>").hide();
                break;
            case 'R':
                $(".eye_left.<?php echo $id;?>").hide();
                break;
            case 'L&R':
                break;
            default:
                $(".eye_left.<?php echo $id;?>").hide();
                $(".eye_right.<?php echo $id;?>").hide();
        }
    };

    $(document).ready(function() {

        $(".surgerytype_id.<?php echo $id;?>").change(handleNewSelection<?php echo $id;?>);
        $(".eyes.<?php echo $id;?>").change(handleNewSelection<?php echo $id;?>);

        // Run the event handler once now to ensure everything is as it should be
        handleNewSelection<?php echo $id;?>();

    });
</script>