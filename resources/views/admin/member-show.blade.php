@extends('layouts.admin')

@section('jumbotron')
<div class="jumbotron">
    <h1 class="text-center">Members</h1>
    <p class="text-center">Here we can modify our members</p>
</div>
@endsection


@section('content')
    <div class="col-lg-10 col-lg-offset-1">

        <vue-member></vue-member>

    </div>

@endsection