@extends('layouts.app')
@section('content') 
    <section class="page-content dashboard" id="books_app"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 card-contener">
                    <div class="card cleaneroverview" style="padding: 20px;"> 
                        <div class="row">
                            <div class="col-md-10">
                                <h4 class="text-left">Books Overview</h4> 
                            </div>
                            <div class="col-md-2">
                                <a class="btn btn-success btn-sm" href="{{URL::to('/author/add-book')}}">Add New Book + </a>
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
                                <table class="table table-striped table-bordered table-hover" id="books_list">
                                    <thead>
                                        <th>Id</th> 
                                        <th>Book Name</th>
                                        <th>Published Date</th> 
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach($books as $book)
                                            <tr>
                                                <td>{{ $book['id'] }}</td>
                                                <td>{{ $book['book_name'] }}</td> 
                                                <td>{{ $book['published_date'] }}</td> 
                                                <td> 
                                                    <a class="btn btn-primary btn-sm" onclick="getBookDetails('{{ $book['id'] }}')"><i class="fa fa-window-maximize" aria-hidden="true"></i>Edit</a>
                                                    <button class="btn btn-danger btn-sm" type="button" onclick="deactiveAuthor('{{ $book['id'] }}')"><i class="fa fa-trash" aria-hidden="true"></i> Remove</button>
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
                        {!! Form::model($book, [
                            'method' => 'PUT',
                            'route' => ['author.book.update', $book->id]
                        ]) !!}  
                        <div class="form-group">
                            {!! Form::label('book_name', 'Book Name:', ['class' => 'control-label']) !!}
                            {!! Form::text('book_name', null, ['class' => 'form-control', 'id' => 'book_name']) !!}
                        </div> <br />
                        <div class="form-group">
                            {!! Form::label('published_date', 'Published Date:', ['class' => 'control-label']) !!}
                            {!! Form::text('published_date', null, ['class' => 'form-control', 'id' => 'published_date']) !!}
                        </div> <br /> 
                        {!! Form::submit('Update Book Details', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    </div> 
                </div>
            </div>
        </div>
        <!-- End Popup modal -->
    </section> 
    <script src="{{URL::asset('assets/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script> 
    <style>
        #sales_person_list th:nth-child(5) {
            width: 21% !important;
        }
    </style>
    <script>  

        $(document).ready(function(){ 
            $("#published_date").datepicker({dateFormat: 'yy-mm-dd'});
            $("#alert-box").fadeTo(2000, 500).slideUp(500, function(){
                $("#alert-box").slideUp(500);
            });
        }); 

        /**
         * Get book details for update. 
         */
        function getBookDetails(book_id) { 
            axios.post('{{ route("author.book.get") }}', { 
                book_id: book_id,
                _token: '{{csrf_token()}}'
            }).then(function (response) {   
                $('#book_name').val('');
                $('#published_date').val(''); 
 
                $('#book_name').val(response.data.book.book_name);
                $('#published_date').val(response.data.book.published_date); 
                $('#personModal').modal('toggle');
            }).catch(function (error) {
                console.log(error);
            });
        }

        /**
         * Delete the book. 
         */
        function removeBook(book_id) {
            var confirm = window.confirm('Are you sure you want to remove the book?');
            if (confirm) { 
                axios.post('{{ route("author.book.delete") }}', {
                    book_id: book_id, 
                    _token: '{{csrf_token()}}'
                }).then(function (response) { 
                    window.location.reload();
                }).catch(function (error) {
                    console.log(error);
                });
            }
        }  

    </script> 
@endsection