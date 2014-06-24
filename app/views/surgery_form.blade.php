<?php
require_once(app_path().'/views/form.inc.php');
// show all fields if showFields array is not set
if (!isset($showFields)) {
    $all = true;
} else {
    $all = false;
}
//$all = true;

//need to identify different surgeries by id for javascript to work
$id = 'id0';
if (isset($surgery->id)) {
    $id = 'id' . $surgery->id;
}


if (!isset($new)
	// whether this is the surgery that has been saved - i.e. whether to display error messages
	&& ((Input::old('surgerySave') != $surgery->id) && (Input::old('surgeryComplete') != $surgery->id)))
{
	// setting $errors to NULL prevents any validation messages from being displayed
	$errors = NULL;
}


// date
if ($all || in_array('date', $showFields)) {
	form_display::make('date','date')->errors($errors)->draw();
//    echo Form::control_group(Form::label('date', 'Date:'),
//        Form::text('date', $surgery->date), '',
//        ($dispErr) ? '<span class="text-error"> ' . $errors->first('date') . '</span>' : '');
}

// surgerytype_id
if ($all || in_array('surgerytype_id', $showFields)) {
	form_display::make('select','surgerytype_id')->label('Type')
		->options(DB::table('surgerytypes')->lists('name','id'))
		->errors($errors)
//		->addOuterCss
		->addInputCss("surgerytype_id $id")
		->draw();

//    echo Form::control_group(Form::label('surgerytype_id', 'Type:'),
//        Form::select('surgerytype_id', array(''=>'') + DB::table('surgerytypes')->lists('name','id'), $surgery->surgerytype_id, array('class'=>"myselect surgerytype_id $id")), '',
//        ($dispErr) ? '<span class="text-error"> '.$errors->first('surgerytype_id').'</span>' : '');
}

// eyes
if ($all || in_array('eyes', $showFields)) {
	$eyes = array('L'=>'L', 'R'=>'R', 'L&R'=>'L&R');
	form_display::make('select','eyes')->label('Eye')
		->options($eyes)
		->errors($errors)
		->addInputCss("eyes $id")
		->draw();
//    $eyes = array('L'=>'L', 'R'=>'R', 'L&R'=>'L&R');
//    echo Form::control_group(Form::label('eyes', 'Eye:', array('class' => 'control-label')),
//        Form::select('eyes', array('' => '') + $eyes, $surgery->eyes, array('class'=>"myselect eyes $id")),'',
//        ($dispErr) ? '<span class="text-error"> '.$errors->first('eyes').'</span>' : '');
}

//ward
if ($all || in_array('ward', $showFields)) {
	form_display::make('text','ward')->errors($errors)->draw();
//    echo Form::control_group(Form::label('ward', 'Ward:'),
//        Form::textbox('ward', $surgery->ward), '',
//        ($dispErr) ? '<span class="text-error">' . $errors->first('ward') . '</span>' : '');
}

foreach (Surgerydatatype::all() as $surgeryDataType) {
    if ($all || in_array($surgeryDataType->name, $showFields)) {
        foreach (array("L", "R") as $whichEye) {
            $data = $surgery->surgerydata()
                ->where('surgery_data_type_id', '=', $surgeryDataType->id)
                ->where('eye', '=', $whichEye)
                ->first();
            if ($data) {
                $value = $data->value;
            } else {
                $value = '';
            }
            $dataName = $surgeryDataType->name;
            $dataName .= ($whichEye == 'L' ? '_left' : '_right');

            $label = $surgeryDataType->label . ($whichEye == 'L' ? ' Left' : ' Right');
	        form_display::make('textarea',$dataName)->defaultVal($value)
		        ->rows(2)
	            ->addOuterCss($surgeryDataType->name . " eye_$whichEye $id")
		        ->errors($errors)->draw();
//            echo Form::control_group(Form::label($dataName, $label),
//                Form::textarea(
//                    $dataName, $value,
//                    array('rows'=>2, 'class' => '.col-sm-12')),
//                $surgeryDataType->name . " eye_$whichEye " . $id,
//                ($dispErr) ? '<span class="text-error"> '.$errors->first($dataName).'</span>' : ''
//            );
        }
    }
}

//
//
//// Pre-operative VA left
//if ($all || in_array('pre_op_va_left', $showFields)) {
//echo Form::control_group(Form::label('pre_op_va_left', 'Pre-operative VA left:'),
//    Form::textarea('pre_op_va_left', $surgery->pre_op_va_left, array('rows'=>2, 'class' => 'span12')), "eye_left group1 $id",
//    ($dispErr) ? '<span class="text-error"> '.$errors->first('pre_op_va_left').'</span>' : '');
//}
//
//// Pre-operative VA right
//if ($all || in_array('pre_op_va_right', $showFields)) {
//echo Form::control_group(Form::label('pre_op_va_right', 'Pre-operative VA right:'),
//    Form::textarea('pre_op_va_right', $surgery->pre_op_va_right, array('rows'=>2, 'class' => 'span12')), "eye_right group1 $id",
//    ($dispErr) ? '<span class="text-error"> '.$errors->first('pre_op_va_right').'</span>' : '');
//}
//
//// Post-operative VA left
//if ($all || in_array('post_op_va_left', $showFields)) {
//echo Form::control_group(Form::label('post_op_va_left', 'Post-operative VA left:'),
//    Form::textarea('post_op_va_left', $surgery->post_op_va_left, array('rows'=>2, 'class' => 'span12')), "eye_left group1 $id",
//    ($dispErr) ? '<span class="text-error"> '.$errors->first('post_op_va_left').'</span>' : '');
//}
//
//// Post-operative VA right
//if ($all || in_array('post_op_va_right', $showFields)) {
//echo Form::control_group(Form::label('post_op_va_right', 'Post-operative VA right:'),
//    Form::textarea('post_op_va_right', $surgery->post_op_va_right, array('rows'=>2, 'class' => 'span12')), "eye_right group1 $id",
//    ($dispErr) ? '<span class="text-error"> '.$errors->first('post_op_va_right').'</span>' : '');
//}
//
//// biometry left
//if ($all || in_array('biometry_left', $showFields)) {
//echo Form::control_group(Form::label('biometry_left', 'Biometry left:'),
//    Form::text('biometry_left', $surgery->biometry_left),
//    "eye_left group1 $id",
//    ($dispErr) ? '<span class="text-error"> '.$errors->first('biometry_left').'</span>' : '');
//}
//
//// biometry right
//if ($all || in_array('biometry_right', $showFields)) {
//echo Form::control_group(Form::label('biometry_right', 'Biometry right:'),
//    Form::text('biometry_right', $surgery->biometry_right),
//    "eye_right group1 $id",
//    ($dispErr) ? '<span class="text-error"> '.$errors->first('biometry_right').'</span>' : '');
//}
//
//// hist. outcome left
//if ($all || in_array('histological_outcome_left', $showFields)) {
//echo Form::control_group(Form::label('histological_outcome_left', 'Histological outcome left:'),
//    Form::textarea('histological_outcome_left', $surgery->histological_outcome_left, array('rows'=>4, 'class' => 'span12')),
//    "eye_left group2 $id",
//    ($dispErr) ? '<span class="text-error"> '.$errors->first('histological_outcome_left').'</span>' : '');
//}
//
//// hist. outcome right
//if ($all || in_array('histological_outcome_right', $showFields)) {
//echo Form::control_group(Form::label('histological_outcome_right', 'Histological outcome right:'),
//    Form::textarea('histological_outcome_right', $surgery->histological_outcome_right, array('rows'=>4, 'class' => 'span12')),
//    "eye_right group2 $id",
//    ($dispErr) ? '<span class="text-error"> '.$errors->first('histological_outcome_right').'</span>' : '');
//}


// surgery notes
if ($all || in_array('surgery_notes', $showFields)) {
	form_display::make('textarea','surgery_notes')->errors($errors)
		->rows(4)->draw();
//    echo Form::control_group(Form::label('surgery_notes', 'Surgery notes:'),
//        Form::textarea('surgery_notes', $surgery->surgery_notes, array('rows'=>4, 'class'=>'.col-sm-12')), '',
//        ($dispErr) ? '<span class="text-error">' . $errors->first('ward') . '</span>' : '');
}

//outcome
if ($show_outcome) {
	form_display::make('select','outcome')->errors($errors)
		->options(Surgery::$outcomes)
		->draw();
//    echo Form::control_group(Form::label('outcome', 'Outcome:'),
//        Form::select('outcome', array(''=>'') + Surgery::$outcomes, $surgery->outcome, array('class'=>"myselect")), '',
//        ($dispErr) ? '<span class="text-error"> '.$errors->first('outcome').'</span>' : '');
}

?>

<?php
// array of which surgery data types to display, indexed by surgerytype_id
$displayArray = array();
$surgerytypes = SurgeryType::with('surgerydatatypes')->get();
foreach ($surgerytypes as $surgerytype) {
    $displayArray[$surgerytype->id] = "";
    foreach ($surgerytype->surgerydatatypes as $surgerydatatype) {
        $displayArray[$surgerytype->id][] = '.' . $surgerydatatype->name;
    }
}
?>

<!--    <script src="http://code.jquery.com/jquery.js"></script>-->
<script src="/vendor/jquery/jquery.js"></script>
<script>
    hideAllDivs{{ $id }} = function () {
        @foreach (Surgerydatatype::all() as $surgerydatatype)
        $(".{{ $surgerydatatype->name }}.{{ $id }}").hide();
        @endforeach
    };

    handleNewSelection{{ $id }} = function () {


        var typeSelect = $(".surgerytype_id.{{ $id }}").val();
        // get data from php into javascript
        var displayArray = {{ json_encode($displayArray) }};

        hideAllDivs{{ $id }}();

        var display = null;
        if ((typeSelect in displayArray) && displayArray[typeSelect].length > 0) {
            //e.g. "biometry pre_op_va"
            display = displayArray[typeSelect].join(',');
            $(display).show();
        }

        var eyeSelect = $(".eyes.{{ $id }}").val();
        switch (eyeSelect) {
            case 'L':
                $(".eye_R.{{ $id }}").hide();
                break;
            case 'R':
                $(".eye_L.{{ $id }}").hide();
                break;
            case 'L&R':
                break;
            default:
                $(".eye_L.{{ $id }}").hide();
                $(".eye_R.{{ $id }}").hide();
        }
    };

    $(document).ready(function() {

        $(".surgerytype_id.{{ $id }}").change(handleNewSelection{{ $id }});
        $(".eyes.{{ $id }}").change(handleNewSelection{{ $id }});

        // Run the event handler once now to ensure everything is as it should be
        handleNewSelection{{ $id }}();

    });
</script>