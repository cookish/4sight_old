<?php
//Asset::container('bootstrapper')->styles();
//Asset::container('bootstrapper')->scripts();
?>
<!DOCTYPE HTML>
<html lang="en-GB">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
	<link href="/vendor/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css" />
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/css/override.css" rel="stylesheet" media="screen">
    <style>
        body { padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */}
    </style>

</head>
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="navbar-collapse collapse">

				<ul class="nav navbar-nav">
					<li><a class="navbar-brand" href="{{ URL::to('/') }}">{{ HTML::image('images/4sight_logo.png','4sight', array('style'=>"max-width:80px; margin-top: -7px;")) }}</a></li>
					<li class="dropdown {{ (strpos(URL::current(),'people/') ? 'active' : '') }}">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Patients <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="{{ URL::to('people/add') }}">New patient</a></li>
							<li><a href="{{ URL::to('people/list') }}">Patient list</a></li>
						</ul>
					</li>
					<li class="dropdown {{ (strpos(URL::current(),'tasks/') ? 'active' : '') }}">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="badge">176</span> Tasks <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#">Contact patients <span class="badge pull-right">6</span></a></li>
							<li><a href="#">Surgery outcomes <span class="badge pull-right">42</span></a></li>
							<li><a href="#">Appointment resolution <span class="badge">128</span></a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Info <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="{{ URL::to('lists') }}">Surgery lists</a></li>
							<li><a href="#">Reports</a></li>
						</ul>
					</li>
					<li {{ (strpos(URL::current(),'schedule/') ? 'class="active"' : '') }}><a href="{{ URL::to('schedule/') }}">Schedule</a></li>
					<li {{ (strpos(URL::current(),'lensmanagement/') ? 'class="active"' : '') }}><a href="#">Lens management</a></li>
					<li {{ (strpos(URL::current(),'utilities/') ? 'class="active"' : '') }}><a href="#">Utilities</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">
        <div class="row">
<!--           <div class="col-sm-1">-->
                @yield('sidebar')
<!--            </div>-->
<!--            <div class="col-sm-8">-->
                @yield('content')
<!--            </div>-->
        </div>
    </div>
	<script src="http://code.jquery.com/jquery.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
</body>
</html>


