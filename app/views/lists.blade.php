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





<div class="row">&nbsp;</div>
{{ Form::model(NULL, array('class'=>'form-inline', 'role'=>'form')) }}
	<div class="form-group">
		<label for="listDate">Date: </label>
		<input type="text" class="form-control" id="listDate" style="width: 120px;" name="listDate" value="{{ $listDate }}">
	</div>
	&nbsp;&nbsp;&nbsp;
	<div class="form-group">
		<label for="theatre">Theatre: </label>
		<select class="form-control" style="width: 100px;" id="theatre" name="theatre">
			@foreach ($theatres as $theatreOption)
				<option value="{{ $theatreOption }}"
					<?php if ($theatreOption == $theatre) echo 'selected="selected"'; ?> >
					{{ $theatreOption }}
				</option>
			@endforeach
		</select>
	</div>
	&nbsp;&nbsp;&nbsp;

	<button class="btn btn-primary">Go</button>

{{ Form::close() }}
<div class="row">&nbsp;</div>

<?php $theatreName = ($theatre == 'All' ? 'all theatres' : $theatre); ?>
<p class="bg-info col-sm-4">
	<strong>{{ $currentListName }}</strong> list
	@if ($currentList == 'surgery')
		for <strong>{{ $theatreName }}</strong>
	@endif
	on <strong>{{ $listDate }}</strong>
</p>

<table class="table table-condensed table-striped table-hover">
<thead>
	<tr class="">
		<?php if ($theatre == 'All' && $currentList == 'surgery') echo '<th>Theatre</th>'; ?>
		<th>Name</th>
		<th>Hospital</th>
		<th>Age</th>
		<th>Gender</th>
		<th>Surgery type</th>
		<th>Eye</th>
		<th>Biometry</th>
		<th>Ward</th>
		<th>Contact</th>
	</tr>
</thead>


@foreach ($people as $person)
    <tr id="{{ $person->id }}" class="">
	    <?php if ($theatre == 'All') echo '<td>' . $person->surgeries()->first()->theatre. '</td>'; ?>
        <td>{{ $person->first_name }} {{ $person->surname }} </td>
        <td>{{ $person->hospital_number }}</td>
        <td>{{ $person->getAge() }}</td>
        <td>{{ $person->gender }}</td>
        <td>{{ $person->surgeries
	        ->first()
	        ->surgerytype
	        ->name }}</td>
        <td>{{ $person->surgeries()->first()->eyes }}</td>
        <td></td>
	    <td>{{ $person->surgeries->first()->ward }}</td>
	    <td>{{ $person->phone1 }}</td>

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
	    $('#listDate').datepicker({
		    format: "yyyy-mm-dd",
		    todayBtn: "linked",
		    todayHighlight: true
	    });
    });
</script>
@endsection