@layout('template')

@section('title')
Menu
@endsection


@section('content')

<h1>Menu</h1>
<p>&nbsp;</p>
<p><button class="btn btn-large btn-primary" type="button" onclick="location.href='{{ URL::to('people/list') }}'">Patient list</button></p>

@endsection