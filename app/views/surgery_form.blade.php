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
}

// surgerytype_id
if ($all || in_array('surgerytype_id', $showFields)) {
	form_display::make('select','surgerytype_id')->label('Type')
		->options(DB::table('surgerytypes')->lists('name','id'))
		->errors($errors)
		->addInputCss("surgerytype_id $id")
		->draw();
}

// eyes
if ($all || in_array('eyes', $showFields)) {
	$eyes = array('L'=>'L', 'R'=>'R', 'L&R'=>'L&R');
	form_display::make('select','eyes')->label('Eye')
		->options($eyes)
		->errors($errors)
		->addInputCss("eyes $id")
		->draw();
}

//ward
if ($all || in_array('ward', $showFields)) {
	form_display::make('text','ward')->errors($errors)->draw();
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
        }
    }
}


// surgery notes
if ($all || in_array('surgery_notes', $showFields)) {
	form_display::make('textarea','surgery_notes')->errors($errors)
		->rows(4)->draw();
}

//outcome
if ($show_outcome) {
	form_display::make('select','outcome')->errors($errors)
		->options(Surgery::$outcomes)
		->draw();
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