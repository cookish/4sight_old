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
<div class="navbar navbar-inverse navbar-fixed-top"><div class="navbar-inner"><div class="container"><button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="brand" href="#">St. John's Eye Clinic</a>
            <div class="nav-collapse collapse">
                <ul class="nav">

                    <li class="{{ (URL::current() == URL::home()) ? 'active' : ''; }}"><a href="{{ URL::to('/') }}">Home</a></li>
                    <li class="{{ (strpos(URL::current(),'people/add')) ? 'active' : ''; }}"><a href="{{ URL::to('people/add') }}">New</a></li>
                    <li class="{{ (strpos(URL::current(),'people/list')) ? 'active' : ''; }}"><a href="{{ URL::to('people/list') }}">Patients</a></li>
                    <li class="{{ (strpos(URL::current(),'appointments/create')) ? 'active' : ''; }}"><a href="{{ URL::to('appointments/create') }}">Appointments</a></li>
                    <li class="{{ (strpos(URL::current(),'lists/')) ? 'active' : ''; }}"><a href="{{ URL::to('lists/pre-op') }}">Lists</a></li>

                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
        </div></div></div>
    <div class="container">
        <div class="row-fluid">
            <div class="span10">
                @yield('content')
            </div>
        </div>
    </div>
<!--    <script src="http://code.jquery.com/jquery.js"></script>-->
    <script src="/vendor/jquery/jquery.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>


