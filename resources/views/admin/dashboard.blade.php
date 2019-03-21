<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
</head>
<body>

<div class="jumbotron">
    <h1 class="text-center">Members</h1>
    <p class="text-center">Here we can modify our members</p>
</div>

<div id="app">
    <div id="wrapper">

        <vue-app></vue-app>

    </div>
</div>
<!-- /#wrapper -->

</body>

<script src="{{asset('js/app.js')}}"></script>
</html>
