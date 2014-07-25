@extends('template')

@section('title')
Menu
@endsection

@section('content')

<div class="row"><div class=".col-sm-12"><h1>Menu</h1></div></div>



<div class="row">
	<h4>Patients</h4>
	<dl class="dl-horizontal">
		<dt><a href="{{ URL::to('people/add') }}">New patient</a></dt><dd>Create a new patient</dd>
		<dt><a href="{{ URL::to('people/list') }}">Patient list</a></dt><dd>Find and list patients</dd>
	</dl>
</div>
<div class="row">
	<h4>Tasks</h4>
	<dl class="dl-horizontal">
		<dt><a href="#">Contact patients</a></dt><dd>List patients who need contacting for appointments or surgery</dd>
		<dt><a href="#">Surgery outcomes</a></dt><dd>Indicate the outcome of surgeries that have been performed</dd>
		<dt><a href="#">Appointment resolution</a></dt> <dd>Update the status of pre-op and post-op appointments</dd>
	</dl>
</div>
<div class="row">
	<h4>Info</h4>
	<dl class="dl-horizontal">
		<dt><a href="{{ URL::to('lists') }}">Surgery lists</a></dt><dd>Generate lists for surgery, pre-op and post-op</dd>
		<dt><a href="#">Reports</a></dt><dd>Generate reports</dd>
	</dl>
</div>
<div class="row">
	<h4>Other</h4>
	<dl class="dl-horizontal">
		<dt><a href="#">Schedule</a></dt><dd>Schedule surgeries for a day</dd>
	</dl>
	<dl class="dl-horizontal">
		<dt><a href="#">Lens management</a></dt><dd>Manage lens stocks</dd>
	</dl>
	<dl class="dl-horizontal">
		<dt><a href="#">Utilities</a></dt><dd>Various utilities</dd>
	</dl>
</div>
,
@endsection