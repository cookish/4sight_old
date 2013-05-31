@layout('template')

@section('title')
Schedule appointments
@endsection

@section('content')
<div class="row">
    <?php echo Form::open(); ?>
    <div class = "span12">
        <?php echo Form::label('date', 'Select the date for which to schedule appointments:'); ?>
        <?php $nextWeek  = mktime(0, 0, 0, date("m")  , date("d")+7, date("Y")); ?>
        <?php echo Form::text('date', date('d F Y', $nextWeek)); ?>
        &nbsp;<?php echo Form::submit('update', array('class' => "btn btn-primary")); ?>
    </div>
    <?php echo Form::close(); ?>
    <table class="table table-condensed table-striped table-hover">
        <thead>
        <tr>
            <th>First name</th>
            <th>Surname</th>
            <th>Hospital number</th>
            <th>Grade</th>
            <th>Date booked</th>
        </tr>
        </thead>
        @foreach ($people as $person)
        <?php $date = new DateTime($person->date_booked); ?>
        <tr id="{{ $person->id }}">
            <td>{{ $person->first_name }}</td>
            <td>{{ $person->surname }}</td>
            <td>{{ $person->hospital_number }}</td>
            <td>{{ $person->grade }}</td>
            <td>{{ $date->format('j M Y') }}</td>
        </tr>
        @endforeach
    </table>


@endsection