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
<?php
echo Navbar::inverse(null, Navbar::FIX_TOP)
    ->with_brand("St. John's Eye Clinic", '#')
    ->with_menus(
        Navigation::links(
            array(
                array('Home', URL::to('/'), (URL::current() == URL::to('/'))),
                array('New', URL::to('people/add'), (strpos(URL::current(),'people/add'))),
                array('Patients', URL::to('people/list'), (strpos(URL::current(),'people/list'))),
                array('Appointments', URL::to('lists/pre-op'), (strpos(URL::current(),'appointments/create'))),
            )
        )
    );
?>

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


