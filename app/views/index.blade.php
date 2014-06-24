@extends('template')

@section('title')
Menu
@endsection

@section('content')

<div class="row"><div class=".col-sm-12"><h1>Menu</h1></div></div>

<div class="row">&nbsp;</div>
<div class="row">&nbsp;</div>

<div class="row">
    <div class="col-sm-2"><button class="btn btn-lg btn-primary" type="button" onclick="location.href='{{ URL::to('people/add') }}'">New patient</button></div>
    <div class="col-sm-10">Create a new patient</div>
</div>
<div class="row">&nbsp;</div>

<div class="row">
    <div class="col-sm-2"><button class="btn btn-lg btn-primary" type="button" onclick="location.href='{{ URL::to('people/list') }}'">Patients</button></div>
    <div class="col-sm-10">Search for patients by name, surname or hospital number</div>
</div>
<div class="row">&nbsp;</div>

<div class="row">
    <div class="col-sm-2"><button class="btn btn-lg btn-primary" type="button" onclick="location.href='{{ URL::to('schedule/0') }}'">Schedule </button></div>
    <div class="col-sm-10">Schedule operations, pre-op and post-op appointments</div>
</div>
<div class="row">&nbsp;</div>

<div class="row">
    <div class="col-sm-2"><button class="btn btn-lg btn-primary" type="button" onclick="location.href='{{ URL::to('lists/0/today') }}'">Lists</button></div>
    <div class="col-sm-10">View lists of patients categorised by operation type, and sorted according to urgency</div>
</div>
<div class="row">&nbsp;</div>

@endsection