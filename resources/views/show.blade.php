@extends('layouts.app')
@section('content')

@if(Session::has('msg'))
    <!-- <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p> -->
    <!-- Modal -->
    <script>
        $(document).ready(function () {
            // alert('Record added successfully!');
            console.log("ready!");
            $('#myModal').modal('show');
        });
    </script>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                    <h4 class="modal-title">Record Status</h4>
                </div>
                <div class="modal-body">
                    <p> Record Deleted successfully! </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
@endif

<table class="table">
    <thead>
        <tr>
            <th scope="col">Patient #</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Mobile</th>
            <th scope="col">Gender</th>
            <th scope="col">Date</th>
            <th scope="col">Time</th>
            <th scope="col">Token (To verify)</th>
            <th scope="col">Delete Record</th>
        </tr>
    </thead>
    <tbody>
        @if($data->isEmpty())
            <h3 style="text-align:center;"> No records exist! </h3>
            <script>
                function remove() {
                    var empty = document.getElementsByClassName("table");
                    empty.style.display = none;
                }
            </script>
        @else
            @foreach ($data as $data)
            <?php 
            $time = strtotime($data->atime);
            ?>
            <tr>
                <th scope="row">{{$data->uid}}</th>
                <td>{{$data->uname}}</td>
                <td>{{$data->uemail}}</td>
                <td>{{$data->umobile}}</td>
                <td>{{$data->ugender}}</td>
                <td>{{$data->adate}}</td>
                <td>{{date("h:i a", $time)}}</td>
                <td>{{$data->atoken}}</td>
                <td><i class="fa fa-trash" aria-hidden="true"></i><a
                        href="/appointments/{{urlencode(base64_encode($data->uid))}}" style="text-decoration:none;"
                        onclick="return confirm('Are you sure you want to delete this record?');"> Delete</a></td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>
@endsection