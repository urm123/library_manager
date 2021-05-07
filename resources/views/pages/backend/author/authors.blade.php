@extends('layouts.app')
@include('includes.menu')
@section('content') 
    <section class="page-content dashboard" id="sales_person_app"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 card-contener">
                    <div class="card cleaneroverview" style="padding: 20px;"> 
                        <div class="row">
                            <div class="col-md-11">
                                <h4 class="text-left">Authors Overview</h4> 
                            </div>
                            <div class="col-md-1">
                                <a class="btn btn-success btn-sm" href="{{URL::to('/admin/add-author')}}">Add New+ </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                @if($errors->any())
                                    <br />
                                    <div class="alert alert-danger" id="alert-box">
                                        @foreach($errors->all() as $error)
                                            <p>{{ $error }}</p> 
                                        @endforeach
                                    </div> 
                                @endif
                                @if(Session::has('flash_message'))
                                    <div class="alert alert-success" id="alert-box">
                                        {{ Session::get('flash_message') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                        <div class="" style="min-height:200px;">
                            <div class="col-sm-12">
                                <br />
                                <table class="table table-striped table-bordered table-hover" id="sales_person_list">
                                    <thead>
                                        <th>Id</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Telephone</th> 
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach($authors as $author)
                                            <tr>
                                                <td>{{ $author['id'] }}</td>
                                                <td>{{ $author['first_name'] }}</td>
                                                <td>{{ $author['last_name'] }}</td>
                                                <td>{{ $author['email'] }}</td>
                                                <td>{{ $author['telephone'] }}</td> 
                                                <td> 
                                                    <a class="btn btn-primary btn-sm" onclick="getAuthor('{{ $author['id'] }}')"><i class="fa fa-window-maximize" aria-hidden="true"></i>View</a>
                                                    @if($author['is_active'] == 1)
                                                        <button class="btn btn-danger btn-sm" type="button" onclick="deactiveAuthor('{{ $author['id'] }}')"><i class="fa fa-trash" aria-hidden="true"></i> Deactive</button>
                                                    @else
                                                        <button class="btn btn-success btn-sm" type="button" onclick="activeAuthor('{{ $author['id'] }}')"><i class="fa fa-trash" aria-hidden="true"></i> Activate</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>  
                <!--/end card-contener -->
            </div>
        </div>
        <!-- Popup modal -->
        <div class="modal" id="personModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header"> 
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            {!! Form::label('first_name', 'First Name:', ['class' => 'control-label']) !!}
                            {!! Form::text('first_name', null, ['class' => 'form-control', 'id' => 'first_name', 'disabled' => 'true']) !!}
                        </div> <br />
                        <div class="form-group">
                            {!! Form::label('last_name', 'Last Name:', ['class' => 'control-label']) !!}
                            {!! Form::text('last_name', null, ['class' => 'form-control', 'id' => 'last_name', 'disabled' => 'true']) !!}
                        </div> <br />
                        <div class="form-group">
                            {!! Form::label('email', 'Email:', ['class' => 'control-label']) !!}
                            {!! Form::email('email', null, ['class' => 'form-control', 'id' => 'email', 'disabled' => 'true']) !!}
                        </div> <br />
                        <div class="form-group">
                            {!! Form::label('telephone', 'Telephone:', ['class' => 'control-label']) !!}
                            {!! Form::text('telephone', null, ['class' => 'form-control', 'id' => 'telephone', 'disabled' => 'true']) !!}
                        </div> 
                    </div> 
                </div>
            </div>
        </div>
        <!-- End Popup modal -->
    </section>  
    <script>  

        $(document).ready(function(){ 
            $("#alert-box").fadeTo(2000, 500).slideUp(500, function(){
                $("#alert-box").slideUp(500);
            });
        }); 

        /**
         * Get the author details for show. 
         */
        function getAuthor(author_id) { 
            axios.post('{{ route("admin.author.get") }}', { 
                author_id: author_id,
                _token: '{{csrf_token()}}'
            }).then(function (response) {   
                $('#first_name').val('');
                $('#last_name').val('');
                $('#email').val('');
                $('#telephone').val(''); 
 
                $('#first_name').val(response.data.author.first_name);
                $('#last_name').val(response.data.author.last_name);
                $('#email').val(response.data.author.email);
                $('#telephone').val(response.data.author.telephone); 
                $('#personModal').modal('toggle');
            }).catch(function (error) {
                console.log(error);
            });
        }

        /**
         * Deactive author. 
         */
        function deactiveAuthor(author_id) {
            var confirm = window.confirm('Are you sure you want to deactivate the author?');
            if (confirm) { 
                axios.post('{{ route("admin.author.delete") }}', {
                    user_id: author_id, 
                    _token: '{{csrf_token()}}'
                }).then(function (response) { 
                    window.location.reload();
                }).catch(function (error) {
                    console.log(error);
                });
            }
        } 

        /**
         * Activate the author. 
         */
        function activeAuthor(author_id) { 
            axios.post('{{ route("admin.author.active") }}', {
                user_id: author_id, 
                _token: '{{csrf_token()}}'
            }).then(function (response) { 
                window.location.reload();
            }).catch(function (error) {
                console.log(error);
            }); 
        }

    </script> 
@endsection