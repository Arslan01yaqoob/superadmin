@extends('Layout.layout')
@section('main')
    <div class="container">
        <div class="top-heading px-1 py-2 d-flex">
            <div class="part1">
                <h1>States</h1>
                <p>On this screen, you can create, add, or delete States.</p>
            </div>
            <div class="part2">
                <a href="{{ route('addnestatepage') }}">Add New</a>
            </div>
        </div>




        <table class="table" id="datatabel">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">State Name</th>
                    <th scope="col">Country Name</th>
                    <th scope="col">Cities</th>
                    <th scope="col">Status</th>
                    <th scope="col">Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($states as $data)
                    <tr>
                        <td>{{ $data->id }}</td>

                        <td>{{ $data->state_name }}</td>
                        <td>{{ $data->country->country_name }}</td>
                        <td>{{ $data->active_cities_count }} Active Cities</td>
                        <td> <label class="switch">
                                <input onchange="updateStatus({{ $data->id }})"
                                    {{ $data->status == 1 ? 'checked' : '' }} type="checkbox">
                                <span class="slider"></span>
                            </label></td>
                        <td>
                            <div class="button-container">
                                <a href="{{ route('stateupdatepage', ['id' => $data->id]) }}" class="btn btn-info"><img
                                        src="{{ asset('assets/imgs/icons/edit.png') }}" alt=""></a>


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
                url: "{{ route('updatestatestatus') }}",
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
