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
				<a class="navbar-brand" href="{{ URL::to('/') }}">{{ HTML::image('images/4sight_logo.png','4sight', array('style'=>"max-width:80px; margin-top: -7px;")) }}</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li {{ (strpos(URL::current(),'people/add') ? 'class="active"' : '') }}><a href="{{ URL::to('people/add') }}">New</a></li>
					<li {{ (strpos(URL::current(),'people/list') ? 'class="active"' : '') }}><a href="{{ URL::to('people/list') }}">Patients</a></li>
					<li {{ (strpos(URL::current(),'schedule/') ? 'class="active"' : '') }}><a href="{{ URL::to('schedule/') }}">Schedule</a></li>
					<li {{ (strpos(URL::current(),'lists') ? 'class="active"' : '') }}><a href="{{ URL::to('lists/0/today') }}">Lists</a></li>

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
</body>
</html>


