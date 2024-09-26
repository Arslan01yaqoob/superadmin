@extends('Layout.layout')
@section('main')
    <div class="container">

        <div class="top-heading px-1 py-2 d-flex">
            <div class="part1">
                <h1>Users</h1>
                <p>On this screen, you can create, add, or delete users.</p>
            </div>
            <div class="part2">
                <a href="{{ route('adduserpage') }}">Add New User</a>
            </div>
        </div>




        <table class="table" id="datatabel">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">User Image</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Country</th>
                    <th scope="col">contact info</th>
                    <th>Account Status</th>
                    <th scope="col">status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($user as $data)
                    <tr>
                        <td>{{ $data->id }}</td>
                        <td scope="row"><img class="tableimg" src="{{ $data->image_url }}" alt=""></td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->country->country_name }}</td>
                        <td>{{ $data->phone_num ?: $data->email }}</td>

                        <td>{{ $data->account_status}}</td>
 
                        <td>
                            <label class="switch">
                                <input onchange="updateStatus({{ $data->id }})"
                                    {{ $data->status == 1 ? 'checked' : '' }} type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>



                        <td>
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i
                                        class="material-icons md-more_horiz"></i> </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('userdetails', ['id' => $data->id]) }}">View
                                        detail</a>
                                    <a class="dropdown-item" href="{{route('userupdatepage',['id'=>$data->id])}}">Edit detail</a>
                                    
                                    <a class="dropdown-item text-danger" href="{{route('updateaccountstatus',['status'=>1,'user'=>$data->id])}}">Temporarily Blocked</a>
                                    <a class="dropdown-item text-danger" href="{{route('updateaccountstatus',['status'=>2,'user'=>$data->id])}}">Suspend User</a>
                                    <a class="dropdown-item text-danger" href="{{route('updateaccountstatus',['status'=>3,'user'=>$data->id])}}">Block Account</a>
                                    <a class="dropdown-item text-success" href="{{route('updateaccountstatus',['status'=>4,'user'=>$data->id])}}">Active Account</a>

                                



                                </div>
                            </div>

                        </td>

                    </tr>
                @endforeach


            </tbody>

        </table>


    </div>
@endsection
@push('script')
    <script>
        // sessions messages all are here
        $(document).ready(function() {
            $('#datatabel').DataTable();
        });
        $(document).ready(function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 1500
                });
            @endif
            @if (session('error'))

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 1500
                });
            @endif
        });
        // sessiona messages are end here

        // updating category status
        function updateStatus(id) {
            $.ajax({
                url: "{{ route('updateuserstatus') }}",
                type: "Get",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                success: function(response) {
                    if (response.success) {
                        console.log("Status updated successfully!");
                    } else {
                        console.log("Failed to update status.");
                    }
                },
            });
        }

    </script>
@endpush
