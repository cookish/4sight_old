@extends('template')

@section('title')
    Patient list
@endsection


@section('content')

<!--navigation bar-->
<?php $options = array(
        'today' => 'Today',
        'scheduled' => 'Scheduled',
        'notscheduled' => 'Not yet scheduled',
    );?>
<ul class="nav nav-pills">
    @foreach ($options as $option => $string)
        <li{{ ($current_list == $option) ? ' class="active"' : '' }}>
            <a href="{{ URL::to('lists/' . $current_surgerytype . '/' . $option)}}">
                &nbsp;&nbsp;&nbsp;&nbsp;{{ $string }}&nbsp;&nbsp;&nbsp;&nbsp;</a>
        </li>
    @endforeach
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
                <a href="{{URL::to('lists/' . $id . '/' . $current_list)}}">&nbsp;&nbsp;&nbsp;&nbsp;{{$surgeryType}}&nbsp;&nbsp;&nbsp;&nbsp;</a>
            </li>
            @endforeach
        </ul>
    </li>
</ul>

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
if ($current_list == 'scheduled') {
    $headers = array_merge(array('Surgery date'),  $headers);
}
if ($current_list == 0) {
    $headers = array_merge(array('Type'),  $headers);
}
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
    @if ($current_list == 'scheduled')
        <td>{{ $person->date }}</td>
    @endif
    @if ($current_list == 0)
        <td>{{ $person->surgerytype_id }}</td>
    @endif
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

<?php
$explanations = array(
        'today' => 'The above table shows all patients scheduled for today, sorted by priority',
        'scheduled' => 'The above table shows all patients who have a scheduled surgery, sorted by surgery date then priority',
        'notscheduled' => 'The above table shows all patients who do not yet have a surgery date, sorted by priority',
    );
if ($current_surgerytype == 0) {
    $explanation = $explanations[$current_list].'.';
} else {
    $explanation = $explanations[$current_list]
        .', who need to undergo surgery of type "' . $surgeryTypeArray[$current_surgerytype]. '".';
}
?>

<p>{{ $explanation }}</p>

<p>&nbsp;</p>
<script src="/vendor/jquery/jquery.js"></script>
<script>
    $(document).ready(function () {
        $('.table tr:not(:first)').click(function (event) {
            // alert($(this).attr('id')); //trying to alert id of the clicked row
            window.location = '{{ URL::to('people/'); }}' + '/' +  $(this).attr("id");
        });
    });
</script>
@endsection