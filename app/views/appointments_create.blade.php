@extends('template')

@section('title')
Schedule appointments
@endsection

@section('content')
<div class="row">
    <?php echo Form::open(); ?>
    <div class = "span12">
        <?php echo Form::label('date', 'Select the date for which to schedule appointments:'); ?>
        <?php $nextWeek  = mktime(0, 0, 0, date("m")  , date("d")+7, date("Y")); ?>
        <?php echo Form::text('date', date('d F Y', $nextWeek)); ?>
        &nbsp;<?php echo Form::submit('update', array('class' => "btn btn-primary")); ?>
    </div>
    <?php echo Form::close(); ?>



    <p>(Not yet implemented)</p>

@endsection