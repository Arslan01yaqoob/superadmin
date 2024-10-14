@extends('Layout.layout')
@section('main')
    <div class="container">
        <div class="top-heading px-1 py-2 d-flex">
            <div class="part1">
                <h1>Services Names</h1>
                <p>Use this screen to create, modify, or delete service names easily.</p>
            </div>
            <div class="part2">
                <a href="{{ route('addservicenamepage') }}">Add New</a>
            </div>
        </div>

        <table class="table" id="datatabel">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Service Name</th>
                    <th scope="col">Niche</th>
                    <th scope="col">Category</th>
                    <th scope="col">Status</th>
                    <th scope="col">Edit</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($servicesnames as $data)
                    <tr>
                        <td>{{ $data->id }}</td>

                        <td>{{ $data->service_name }}</td>
                        <td>{{ $data->niche->niche_name }}</td>
                        <td>{{ $data->category->category_name }}</td>
                        <td> <label class="switch">
                                <input onchange="updateStatus({{ $data->id }})"
                                    {{ $data->status == 1 ? 'checked' : '' }} type="checkbox">
                                <span class="slider"></span>
                            </label></td>
                        <td>
                            <div class="button-container">
                                <a href="{{ route('servicenameupdatepage', ['id' => $data->id]) }}" class="btn btn-info"><img
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
    <script type="text/javascript">
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
        // updating category status
        function updateStatus(id) {
            $.ajax({
                url: "{{ route('servicenamestatusupdate') }}",
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
