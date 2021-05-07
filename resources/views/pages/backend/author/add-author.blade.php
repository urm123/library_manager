@extends('layouts.app')
@include('includes.menu')
@section('content') 
    <section class="page-content dashboard" id="sales_person_app"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 col-md-offset-3">
                    <div class="card cleaneroverview" style="padding: 20px;"> 
                        <div class="title">
                            <h4 class="text-left">Create Author</h4>  
                            <div class="text-right" style="float:right;">
                                <a class="btn btn-success btn-sm" href="{{URL::to('/admin/dashboard')}}">Author Overview </a>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
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
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::open([
                                    'route' => 'admin.author.store'
                                ]) !!} 
                                {!! Form::hidden('role', 2, ['class' => 'form-control']) !!}
                                <div class="form-group">
                                    {!! Form::label('first_name', 'First Name:', ['class' => 'control-label']) !!}
                                    {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
                                </div> <br />
                                <div class="form-group">
                                    {!! Form::label('last_name', 'Last Name:', ['class' => 'control-label']) !!}
                                    {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
                                </div> <br />
                                <div class="form-group">
                                    {!! Form::label('email', 'Email:', ['class' => 'control-label']) !!}
                                    {!! Form::email('email', null, ['class' => 'form-control']) !!}
                                </div> <br />
                                <div class="form-group">
                                    {!! Form::label('password', 'Password:', ['class' => 'control-label']) !!}
                                    {!! Form::text('password', null, ['class' => 'form-control']); !!}
                                </div> <br />
                                <div class="form-group">
                                    {!! Form::label('password', 'Confirm Password:', ['class' => 'control-label']) !!}
                                    {!! Form::text('password_confirmation', null, ['class' => 'form-control']); !!}
                                </div> <br />
                                <div class="form-group">
                                    {!! Form::label('telephone', 'Telephone:', ['class' => 'control-label']) !!}
                                    {!! Form::text('telephone', null, ['class' => 'form-control']) !!}
                                </div> <br />  
                                {!! Form::submit('Add New Author', ['class' => 'btn btn-primary']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>  
                <!--/end card-contener -->
            </div>
        </div>
    </section>  
    <script>

        $(document).ready(function(){  

            $("#alert-box").fadeTo(2000, 500).slideUp(500, function(){
                $("#alert-box").slideUp(500);
            });
        }); 

    </script> 
    <script type="text/x-template" id="typeahead">
        <input type="text" class="form-control typeahead" placeholder="Search" data-provide="typeahead"/>
    </script>
@endsection