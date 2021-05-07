@extends('layouts.app')
@section('content') 
    <div class="container-fluid" id="bookStore">
        <div class="row"> 
            <div class="col-md-3"></div>
            <div class="col-md-6 col-md-offset-3">
                <div class="card cleaneroverview" style="padding: 20px;">  
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
                            <div class="row">
                                <div class="col-md-9"> 
                                    <input type="text" class="form-control" v-model="keyword" placeholder="Search Book Here">
                                </div>
                                <div class="col-md-3">
                                    <button @click.prevent="searchBook()" class="btn btn-primary mb-2">Search Here</button>
                                </div>
                            </div>             
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-md-12">  
                            <div class="row">
                                <div class="col-md-9">  
                                    <ul class="list-group">
                                        <li v-for="book in books" class="list-group-item">@{{ book.suggest_name }}</li> 
                                    </ul>
                                    <span id="pop_up_error" style="color: red;" v-if="pop_up_error">@{{ pop_up_error }}</span>
                                </div>
                            </div>             
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>  
            <!--/end card-contener -->
        </div>
    </div>
    <script type="text/javascript"> 

        var data = {  
            books: '',  
            keyword: '', 
            pop_up_error: ''
        };  

        var restaurantHome = new Vue({
            el: '#bookStore',
            data: data,
            mounted: function () {},
            methods: { 
                searchBook: function () {   
                    var $this = this; 
                    $this.pop_up_error = '';
                    $this.books = '';
                    let restaurant_id = $this.restaurant_id;
                    if($this.keyword){
                        axios.post('{{route('book.search')}}', {
                            _token: '{{csrf_token()}}',
                            keyword: $this.keyword
                        }).then(function (response) {  
                            if(response.data.success == true){
                                $this.books = response.data.suggestions;
                            }else{
                                $this.pop_up_error = 'No suggestions found.';
                            }
                        }).catch(function (error) {
                            console.log(error);
                        }); 
                    }else{
                        $this.pop_up_error = 'Please type the keyword.';
                    }
                }
            }
        });
    </script>
@endsection

















