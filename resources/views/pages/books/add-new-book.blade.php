@extends('layouts.app')
@section('content') 
    <section class="page-content dashboard" id="sales_person_app"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 col-md-offset-3">
                    <div class="card cleaneroverview" style="padding: 20px;"> 
                        <div class="title">
                            <h4 class="text-left">Add New Book</h4>  
                            <div class="text-right" style="float:right;">
                                <a class="btn btn-success btn-sm" href="{{URL::to('/admin/dashboard')}}">Books Overview </a>
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
                                    <br />
                                    <div class="alert alert-success" id="alert-box">
                                        {{ Session::get('flash_message') }}
                                    </div>
                                @endif
                                @if(Session::has('flash_error_message'))
                                    <br />
                                    <div class="alert alert-danger" id="alert-box">
                                        {{ Session::get('flash_error_message') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::open([
                                    'route' => 'author.book.store'
                                ]) !!}  
                                <div class="form-group">
                                    {!! Form::label('book_name', 'Book Name:', ['class' => 'control-label']) !!}
                                    {!! Form::text('book_name', null, ['class' => 'form-control']) !!}
                                </div> <br />
                                <div class="form-group">
                                    {!! Form::label('published_date', 'Published Date:', ['class' => 'control-label']) !!}
                                    {!! Form::text('published_date', null, ['class' => 'form-control']) !!}
                                </div> <br />   
                                {!! Form::submit('Add New Book', ['class' => 'btn btn-primary']) !!}
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
    <style>
        #sales_person_list th:nth-child(5) {
            width: 21% !important;
        }
    </style>
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