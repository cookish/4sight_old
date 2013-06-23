@extends('template')

@section('title')
Patient list
@endsection


@section('content')
<h1>New patient</h1>
<p>&nbsp;</p>
{{ $person_form; }}
<button class="btn" onclick="location.href='{{ URL::to('people/list') }}'">Cancel</button>
@endsection