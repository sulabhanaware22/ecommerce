<x-home-master>
    @section('css')
    <link href="{{asset('css/toastr.min.css')}}" rel="stylesheet">
    @stop
    @section('content')
    <div class="row">
        <div class="col-md-10 offset-1">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Product Detail</h6>
                </div>
                <div class="card-body">
                    <div class="home_screen">

                        <div class="container">
                            <br><br>
                            <form id="save_cartdetails_form" action="{{route('add-cart')}}" method="post">
                                <div class="row">
                                    <div class="col-md-8 offset-4 col-xs-12 col-sm-8 offset-4">
                                        <h3>
                                            @if(isset($product->name) && $product->name != '')
                                            {{$product->name}}
                                            @else
                                            ----
                                            @endif
                                        </h3>
                                    </div>
                                </div><br><br>

                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="{{$product->product_image}}" width="300px" height="300px">
                                    </div>
                                    <div class="col-md-8">
                                        <h3>
                                            @if(isset($product['product_description']) && $product['product_description']!=''){!! nl2br($product->product_description) !!} @else @endif
                                        </h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-4">
                                        <select id="product_quantity" class="form-control" name="product_quantity">
                                            <option value="">Select Quantity</option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <h3>
                                            Rs. {{$product->price}}
                                        </h3>
                                    </div>
                                </div><br><br>
                                <div class="row">
                                    <div class="col-md-3 offset-4">
                                        <input type="hidden" name="product_id" value="{{$product->id}}" />
                                        <input type="submit" value="ADD TO CART" id="add_to_cart"></input>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop
    @section('scripts')
  
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{asset('js/toastr.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#save_cartdetails_form').on('submit', function(event) {
                event.preventDefault();
                data = $("#save_cartdetails_form").serialize();


                // alert("the value is" + CKEDITOR.instances.productDescription.getData());
                $.ajax({
                    url: "{{ config('constants.BASE_PATH') }}user/addcartitem/",
                    type: 'post',
                    data: data,
                    beforeSend: function(request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                    },
                    'success': function(data) {
                        response = JSON.parse(data)
                        //alert("the data is"+response.message)
                        if (response.message != '') {
                            //alert("saved!");
                            toastr.success(response.message)
                            $("#cartlength").text(<?php session('cartlength') ?>);
                          //  window.location.reload();
                           window.location.href = "{{ config('constants.BASE_PATH') }}user/carts/";
                        }
                    },
                    'error': function(xhr) {
                        //  alert("inside exception"+xhr);
                        if (xhr.status == 500) {
                            response = JSON.parse(xhr.responseText);
                            toastr.warning(response.message);
                            //   window.location.reload();
                        }
                    }
                })
            });
        });
    </script>
    @stop
</x-home-master>