@push('style')
<style>

td{
    font-size: 14px !important;
}

</style>

@endpush
@extends('Layout.layout')
@section('main')
    <div class="container">

        <div class="top-heading px-1 py-2 d-flex">
            <div class="part1">
                <h1>Users Details</h1>
                <p>Here are all the details of the specific user.</p>

            </div>
            <div class="part2">
            </div>
        </div>
<div class="card p-4">


        <div class="row">

            <div class="col-md-6">
                <h3>Personal Details</h3>
                
                <table class="detailstable table table-bordered table-striped">
                    <tr>
                        <th>Fields</th>
                        <th>Details</th>
                    </tr>


                    <tr>
                        <td>Id</td>
                        <td>{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <td>E-mail</td>
                        <td>{{ $user->email ?: '' }}</td>
                    </tr>
                    <tr>
                        <td>Phone-Num</td>
                        <td>{{ $user->phone_num ?: '' }}</td>
                    </tr>
                    <tr>
                        <td>Profile pic</td>
                        <td>
                            <img class="profile-image" src="{{ asset($user->image_url) }}" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td>Cover Image</td>
                        <td>
                            <img class="profile-image" src="{{ asset($user->cover_image_url) }}" alt="">
                        </td>
                    </tr>




                </table>
            </div>
            <div class="col-md-6">
                <h3>Other Details</h3>
                
                <table class="detailstable">
                    <tr>
                        <th>Fields</th>
                        <th>Details</th>
                    </tr>

                    <tr>
                        <td>Account Status</td>
                        <td>{{ $user->account_status }}</td>
                    </tr>

                    <tr>
                        <td>Country</td>
                        <td>{{ $user->country->country_name }}</td>
                    </tr>
                    <tr>
                        <td>State</td>
                        <td>{{ $user->state->state_name }}</td>
                    </tr>
                    <tr>
                        <td>City</td>
                        <td>{{ $user->city->city_name }}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>{{ $user->address }}</td>
                    </tr>
                    <tr>
                        <td>Bio</td>
                        <td>{{ $user->description }}</td>
                    </tr>
                    <tr>
                        <td>Date of Birth</td>
                        <td>{{ $user->date_of_birth }}</td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td>{{ $user->gendar }}</td>
                    </tr>
                </table>




            </div>
            

        </div>

    </div>

    </div>
@endsection
