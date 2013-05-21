@layout('template')

@section('title')
Patient details
@endsection

@section('content')

<div class="row">
    <div class="span12"><h1>{{ $person->first_name }} {{ $person->surname}}</h1></div>
</div>
<div class="row">
    <div class="span6">

        <h3>Patient details</h3>
        <?php echo Form::open(null, 'POST', array('class' => 'form-horizontal')); ?>
        <?php $person_arr = $person->to_array(); ?>
        <?php unset($person_arr['id']); ?>
        <?php unset($person_arr['created_at']); ?>
        <?php unset($person_arr['updated_at']); ?>

        @foreach ($person_arr as $key => $value)
        <?php $fieldname = ucfirst(str_replace('_', ' ', $key)); ?>
        <?php if ($key == 'waiting_since') {
            $date = new DateTime($person->waiting_since);
            $value = $date->format('j F Y');
        }?>
        <div class="control-group">
            <label class="control-label" for="{{ $key }}">{{ $fieldname }}</label>
            <div class="controls">
                <input name="{{ $key }}" type="text" value="{{ $value }}">
            </div>
        </div>
        @endforeach

        <p>&nbsp;</p>
        <?php echo Form::submit('Save changes', array('name' => 'save', 'class' => 'btn btn-primary'));?>
        <?php echo Form::close();?>
        <button class="btn" onclick="location.href='{{ URL::to('people/list') }}'">Close</button>
    </div>
    <div class="span5 offset1">
        <h3>Conditions</h3>
        @foreach ($person->conditions as $condition)
        <?php echo Form::open(null, 'POST', array('class' => 'form-horizontal')); ?>
        <div class="well">

            <div class="control-group span6">
                <select class="myselect" name="type_{{ $condition->id; }}">
                    @foreach (DB::table('conditions')->get(array('id', 'name')) as $cond)
                    <option value="{{ $cond->id; }}">{{ $cond->name; }}</option>
                    @endforeach

                </select>
            </div>

            <div class="control-group"><textarea class="span12" rows="4" name="notes_{{ $condition->id; }}">{{ $condition->pivot->notes; }}</textarea></div>
            <button class="btn">Save changes</button>
            <button class="btn"><i class="icon-search icon-trash"></i> Delete</button>

        </div>

        <?php echo Form::close();?>
        @endforeach


        <h3>Appointments</h3>
        <div class="accordion" id="accordion_appointments">
            @foreach ($person->appointments as $appointment)
            <div class="accordion-group">

                <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_appointments" href="#collapse{{ $appointment->pivot->id}}">

                        <?php $date = new DateTime($appointment->pivot->date); ?>
                        {{ $appointment->name }} - {{ $date->format('j F Y'); }}
                    </a>
                </div>
                <div id="collapse{{ $appointment->pivot->id; }}" class="accordion-body collapse">
                    <div class="accordion-inner">
                        <?php echo Form::open(null, 'POST', array('class' => 'form-horizontal')); ?>

                        <div class="control-group span6">
                            <select class="myselect" name="type_{{ $appointment->id; }}">
                                @foreach (DB::table('appointmenttypes')->get(array('id', 'name')) as $app)
                                <option value="{{ $app->id; }}">{{ $app->name; }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="control-group span6"><input class="myshortinput" name="date_{{ $appointment->id }}" type="text" value="{{ $date->format('j F Y'); }}"/></div>


                        <div class="control-group"><textarea class="span12" rows="4" name="notes_{{ $appointment->id; }}">{{ $appointment->pivot->notes; }}</textarea></div>
                        <button class="btn">Save</button>
                        <button class="btn"><i class="icon-search icon-trash"></i> Delete</button>
                        <?php echo Form::close();?>
                    </div>
                </div>

            </div>


            @endforeach





        </div>
        <div class="span3">moo adf asdf</div>
    </div>
    @endsection
