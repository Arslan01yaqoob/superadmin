@extends('Layout.layout')
@section('main')
    <div class="container">
        <div class="top-heading px-1 py-2 d-flex">
            <div class="part1">
                <h1>Onboarding Advertisements</h1>
                <p>Welcome to the Onboarding Ads management screen.</p>
            </div>
            <div class="part2">
                <a href="{{ route('addonboardingpage') }}">Add New</a>
            </div>
        </div>


        <form style="display: none" method="post" action="{{ route('deleteonboarding') }}" id="deleteadd">
            @csrf
            <input type="text" name="addid" id="addid">
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Subtitle</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ads as $ad)
                    <tr>
                        <td>{{ $ad->id }}</td>
                        <td>
                                <lottie-player id="animation" src="{{ asset($ad->image_url) }}" background="transparent"
                                    speed="1" style="width: 100px; height: 100px;" loop autoplay>

                        </td>
                        <td>{{ $ad->title }}</td>
                        <td>{{ $ad->subtitle }}</td>
                        <td>
                            <label class="switch">
                                <input onchange="updateStatus({{ $ad->id }})" {{ $ad->status == 1 ? 'checked' : '' }}
                                    type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                        <td>
                            <div class="button-container">
                                <a href="{{ route('onboardingupdatepage', ['id' => $ad->id]) }}" class="btn btn-info">
                                    <img src="{{ asset('assets/imgs/icons/edit.png') }}" alt="">
                                </a>
                                <a onclick="deletead({{ $ad->id }})" class="btn btn-danger">
                                    <img src="{{ asset('assets/imgs/icons/bin.png') }}" alt="">
                                </a>
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
                url: "{{ route('updateonboardingstatus') }}",
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

        function deletead(id) {
            let addid = id

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#addid').val(addid)
                    $('#deleteadd').submit()

                }
            });

        }
    </script>
@endpush
