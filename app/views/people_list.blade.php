@extends('template')

@section('title')
    Patient list
@endsection


@section('content')
<div class="row">
    <div class="span6"><h1>Patient list</h1></div>
    <div class="span6">
        <br/>
        <?php echo Form::open(array('url' => 'people/list', 'method' => 'GET', 'class' => 'form-search')); ?>
        <div class="input-append">
            <?php echo Form::text('search', null, array(
                'class' => 'span12 search-query',
                'style' => 'margin: 0 auto;',
                'data-provide' => 'typeahead',
                'data-items' => '4',
                'autocomplete' => 'off',
                'data-source' => '["' . implode($typeahead, '","')  . '"]')); ?>
            <?php echo Form::submit('Search', array('class' => 'btn')); ?>
        </div>
        <?php echo Form::close(); ?>
    </div>
</div>
<div class="row">
    <?php if (isset($search)) { ?>
        <div class="span12 alert alert-info">
            Showing all results with first name, surname or Hospital number containing "
            <strong>{{ $search; }}</strong>"</div>
    <?php } ?>
</div>

<div class="row">
    <div class="span12">


    <table class="table table-condensed table-striped table-hover">
        <thead>
            <tr>
                <th>First name</th>
                <th>Surname</th>
                <th>Hospital number</th>
                <th>Grade</th>
                <th>Date booked</th>
            </tr>
        </thead>
        @foreach ($people as $person)
<!--            --><?php //$date = new DateTime($person->date_booked); ?>
            <tr id="{{ $person->id }}" class="person">
                <td>{{ $person->first_name }}</td>
                <td>{{ $person->surname }}</td>
                <td>{{ $person->hospital_number }}</td>
                <td>{{ $person->grade }}</td>
                <td>{{ $person->date_booked }}</td>
            </tr>
        @endforeach
    </table>

        <?php echo $people->links(); ?>

<button class="btn btn-primary" type="button" onclick="location.href='{{ URL::to('people/add') }}'">Add patient</button>
    </div>
</div>

<!--<script src="http://code.jquery.com/jquery.js"></script>-->
<script src="/vendor/jquery/jquery.js"></script>
<script>
    $(document).ready(function () {
        $('.table tr').click(function (event) {
            // alert($(this).attr('id')); //trying to alert id of the clicked row
            window.location = '{{ URL::to('people/'); }}' + '/' +  $(this).attr("id");
        });
    });
</script>

@endsection