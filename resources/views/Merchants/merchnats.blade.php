@extends('Layout.layout')
@section('main')
    
<div class="container">
    <div class="top-heading px-1 py-2 d-flex">
        <div class="part1">
            <h1>Merchants</h1>
            <p>On this screen, you can create, add, or delete Merchants.</p>
        </div>
        <div class="part2">
            <a href="{{route('merchantaddpage')}}">Add New</a>
        </div>
    </div>



</div>


@endsection

