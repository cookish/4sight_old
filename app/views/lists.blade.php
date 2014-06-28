@extends('template')

@section('title')
    Patient list
@endsection


@section('content')

<!--navigation bar-->
<ul class="nav nav-tabs" role="tablist">
		<li {{ ($currentList == 'surgery' ? 'class = "active"' : '') }}><a href="{{ URL::to('/lists/surgery/') }}">Surgery</a></li>
@foreach (Appointmenttype::all() as $appointmentType)
	<li {{ ($currentList == $appointmentType->id ? 'class = "active"' : '') }}><a href="{{ URL::to('/lists/' . $appointmentType->id . '/') }}">{{ $appointmentType->name }}</a></li>
@endforeach
</ul>



<table class="table table-condensed table-striped table-hover">
<thead>
	<tr class="">
		<th>Type</th>
		<th>First name</th>
		<th>Surname</th>
		<th>Hospital</th>
		<th>Grade</th>
		<th>Date booked</th>
		<th>Age</th>
	</tr>
</thead>


@foreach ($people as $person)
<?php
    $age = $person->getAge();
    if ($age >= 60) $age .= ' (SNR)';
?>

    <tr id="{{ $person->id }}" class="">
    <td>{{ $person->surgeries()->first()->surgerytype_id }}</td>
    <td>{{ $person->surgeries()->first()->date }}</td>
    <td>{{ $person->first_name }}</td>
    <td>{{ $person->surname }}</td>
    <td>{{ $person->hospital_number }}</td>
    <td>{{ $person->grade }}</td>
    <td>{{ $person->date_booked }}</td>
    <td>{{ $age }}</td>
    </tr>
@endforeach

</table>
<?php echo $people->links(); ?>

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