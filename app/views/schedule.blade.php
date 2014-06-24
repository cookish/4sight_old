@extends('template')

@section('title')
Schedule appointments
@endsection

@section('content')
<div class=".col-sm-3">
<?php
if (!$current_date) {
    $date = mktime(0, 0, 0, date("m")  , date("d")+7, date("Y"));
} else {
    $date = mktime(0, 0, 0, substr($current_date,0,2), substr($current_date,2,2), substr($current_date,4,4));
}
?>
Date: {{ Former::date('date','')
->id('datepicker')
->value(date('m/d/Y', $date))
->submit('update')
->class('input-sm');
}}
</div><div class=".col-sm-5">
<ul class="nav nav-pills">
    <li class="dropdown active">
        <a class="dropdown-toggle"
           data-toggle="dropdown"
           href="#">
            Surgery: {{ $surgeryTypeArray[$current_surgerytype] }}
            <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
            @foreach ($surgeryTypeArray as $id => $surgeryType)
            <li{{ ($current_surgerytype == $id) ? ' class="active"' : '' }}>
            <a href="{{URL::to('schedule/' . $id . '/' . $current_date)}}">&nbsp;&nbsp;&nbsp;&nbsp;{{$surgeryType}}&nbsp;&nbsp;&nbsp;&nbsp;</a>
    </li>
    @endforeach
</ul>
</li>
</ul>
</div>

<?php $headers = array(
    'First name',
    'Surname',
    'Hospital',
    'Grade',
    'Date booked',
    'Pre-op date',
    'Post-op date',
    'Age'
);
?>
{{ Table::striped_hover_condensed_open() }}
<thead>
<tr class="">
    @foreach ($headers as $header)
    <th>{{ $header }}</th>
    @endforeach
</tr>
</thead>


@foreach ($people as $person)
<?php

//calculate age
$age = '';
if ($person->date_of_birth) {
    $tz  = new DateTimeZone('Africa/Johannesburg');
    $age = DateTime::createFromFormat('Y-m-d', $person->date_of_birth, $tz)
        ->diff(new DateTime('now', $tz))
        ->y;
    if ($age >= 60) $age .= ' (SNR)';
}
?>

<tr id="{{ $person->id }}" class="">
    <td>{{ $person->first_name }}</td>
    <td>{{ $person->surname }}</td>
    <td>{{ $person->hospital_number }}</td>
    <td>{{ $person->grade }}</td>
    <td>{{ $person->date_booked }}</td>
    <td>{{ $person->preop_date }}</td>
    <td>{{ $person->postop_date }}</td>
    <td>{{ $age }}</td>
</tr>
@endforeach

{{ Table::close() }}
<?php echo $people->links(); ?>




    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <script src="/vendor/jquery/jquery.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script>
        $(document).ready(function () {
            $(function() {
                $("#datepicker").datepicker({
                    onSelect: function(dateText) {
                        $(this).change();
                        str = $(this).val().replace('/', '').replace('/', '')
                        window.location.href =
                            "{{ URL::to('schedule/'. $current_surgerytype. '/')}}"+ "/" + str;

                    }
                });
            }

            );
        });

    </script>
@endsection