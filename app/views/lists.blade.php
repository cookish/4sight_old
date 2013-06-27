@extends('template')

@section('title')
    Patient list
@endsection


@section('content')

<!--navigation bar-->
<ul class="nav nav-pills">
    @foreach ($surgeryTypeArray as $id => $surgeryType)
        <li{{ (URL::current() == URL::to('lists/'.$id)) ? ' class="active"' : '' }}>
            <a href="{{URL::to('lists/' . $id)}}">&nbsp;&nbsp;&nbsp;&nbsp;{{$surgeryType}}&nbsp;&nbsp;&nbsp;&nbsp;</a>
        </li>
    @endforeach
</ul>

<?php $headers = array(
    'First name',
    'Surname',
    'Hospital',
    'Grade',
    'Date booked',
    'Pre-op date',
    'Post-op date',
    'Contact history',
    'Age',
    'SNR'
); ?>

{{ Table::striped_hover_condensed_open() }}
{{ Table::headers($headers) }}

<?php
$body = array();
foreach ($people as $person) {

    $row = array();
    $row[] = $person->first_name;
    $row[] = $person->surname;
    $row[] = $person->hospital_number;
    $row[] = $person->grade;
    $row[] = $person->date_booked;
    $row[] = '';
    $row[] = '';
    $row[] = $person->contact_history;
    $row[] = '';
    $row[] = '';
    $body[] = $row;
}

//    foreach ($headers as $header) {
//        $temp[] = $person->{$header};
//    }
//    $body[] = $temp;

?>

{{ Table::body($body) }}

{{ Table::close() }}



@endsection