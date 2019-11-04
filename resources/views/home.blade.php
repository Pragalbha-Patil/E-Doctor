@extends('layouts.app')

@section('content')

<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<div class="container">
    <div class="row justify-content-center">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Doctor Admin Panel - Home</div>
                
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    @if(Session::has('msg'))
                        <!-- <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p> -->
                        <!-- Modal -->
                        <script>
                             
                             $( document ).ready(function() {
                                // alert('Record added successfully!');
                                console.log( "ready!" );
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
                                <p> Record Added successfully! </p>
                                <a href="{{route('appointments')}}">View Appointments</a>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                            </div>
                            </div>

                        </div>
                        </div>
                    @endif

                    <form method="POST" action = "{{ route('datetimeinput') }}">
                    @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1"><i class="fa fa-user-md" aria-hidden="true"></i> Doctor Name</label>
                            <input type="text" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="Enter name" name="name" required value="{{auth()->user()->name}}" readonly>
                            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                                else.</small> -->
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><i class="fa fa-calendar" aria-hidden="true"></i> Enter free date</label>
                            <input type="date" class="form-control" id="exampleInputEmail1"
                                aria-describedby="date" name="date" required>
                            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                                else.</small> -->
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1"><i class="fa fa-clock-o" aria-hidden="true"></i> Enter free time</label>
                            <input type="time" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp" name="time" required>
                            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                                else.</small> -->
                        </div>
                        <!--
                             <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1"
                                placeholder="Password">
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div> -->
                        <div style="overflow:hidden;">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div id="datetimepicker12"></div>
                                    </div>
                                </div>
                            </div>
                            <script type="text/javascript">
                                $(function () {
                                    $('#datetimepicker12').datetimepicker({
                                        inline: true,
                                        sideBySide: true
                                    });
                                });
                            </script>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection