@layout('template')

@section('title')
    Patient list
@endsection


@section('content')

    <h1>Patient list</h1>
    <?php echo Form::open('people/list', 'GET', array('class' => 'form-search')); ?>
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

    <table class="table table-condensed table-striped table-hover">
        <thead>
            <tr>
                <th>First name</th>
                <th>Surname</th>
                <th>ID number</th>
                <th>Priority</th>
                <th>Waiting since</th>
            </tr>
        </thead>
        @foreach ($people as $person)
            <?php $date = new DateTime($person->waiting_since); ?>
            <tr id="{{ $person->id }}">
                <td>{{ $person->first_name }}</td>
                <td>{{ $person->surname }}</td>
                <td>{{ $person->id_number }}</td>
                <td>{{ $person->priority }}</td>
                <td>{{ $date->format('j M Y') }}</td>
            </tr>
        @endforeach
    </table>

<script src="http://code.jquery.com/jquery.js"></script>
<script>
    $(document).ready(function () {
        $('.table tr').click(function (event) {
            // alert($(this).attr('id')); //trying to alert id of the clicked row
            window.location = '{{ URL::to('people/'); }}' + $(this).attr("id");
        });
    });
</script>



@endsection