@extends('template')

@section('title')
    Patient list
@endsection


@section('content')
<ul class="nav nav-pills">
    @foreach ($listArray as $list)
        <?php $nospaces = str_replace(' ', '' ,$list);?>
        <li{{ (strpos(URL::current(),$nospaces)) ? ' class="active"' : '' }}>
            <a href="{{URL::to('lists/' . $nospaces)}}">&nbsp;&nbsp;{{$list}}&nbsp;&nbsp;</a>
        </li>
    @endforeach
</ul>

@endsection