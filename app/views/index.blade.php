@extends('template')

@section('title')
Menu
@endsection


@section('content')

<div class="row"><div class="span12"><h1>Menu</h1></div></div>

<div class="row">&nbsp;</div>
<div class="row">&nbsp;</div>

<div class="row">
    <div class="span3"><button class="btn btn-large btn-primary" type="button" onclick="location.href='{{ URL::to('people/add') }}'">New patient</button></div>
    <div class="span9">Create a new patient</div>
</div>
<div class="row">&nbsp;</div>

<div class="row">
    <div class="span3"><button class="btn btn-large btn-primary" type="button" onclick="location.href='{{ URL::to('people/list') }}'">Patients</button></div>
    <div class="span9">Search for patients by name, surname or hospital number</div>
</div>
<div class="row">&nbsp;</div>

<div class="row">
    <div class="span3"><button class="btn btn-large btn-primary" type="button" onclick="location.href='{{ URL::to('appointments/create') }}'">Appointments</button></div>
    <div class="span9">Schedule operations, pre-op and post-op appointments</div>
</div>
<div class="row">&nbsp;</div>

<div class="row">
    <div class="span3"><button class="btn btn-large btn-primary" type="button" onclick="location.href='{{ URL::to('lists/pre-op') }}'">Lists</button></div>
    <div class="span9">View lists of patients categorised by operation type, and sorted according to urgency</div>
</div>
<div class="row">&nbsp;</div>

@endsection