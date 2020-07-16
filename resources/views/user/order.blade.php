<x-home-master>
    @section('css')
    <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    @endsection

    @section('content')
    <!--add the home screen page to select the products from the grid view-->
    @if (Session::has('paymentview'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger text-center">

                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>

                <p>{{ Session::get('paymentview') }}</p>
                <a id="continue_shopping" href="{{route('user-dashboard')}}">CONTINUE SHOPPING</a>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-md-10 offset-1">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Orders</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Username</th>
                                    <th>Product Image</th>
                                    <th>Product Title</th>
                                    <th>Product Description</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Username</th>
                                    <th>Product Image</th>
                                    <th>Product Title</th>
                                    <th>Product Description</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if(isset($carts) && !empty($carts))
                                @foreach($carts as $cart)
                                <tr>
                                    <td>{{$cart->ref_id}}</td>
                                    <td>{{$cart->u_name}}</td>
                                    <td><img src="{{config('constants.IMAGE_PATH').$cart->product_image}}" width="100" height="100"></td>
                                    <td>{{$cart->p_name}}</td>
                                    <td>{{$cart->product_description}}</td>
                                    <td>{{$cart->c_name}}</td>
                                    <td>{{$cart->p_qty}}</td>
                                    <td>{{$cart->p_price}}</td>
                                    <td>{{($cart->p_qty) * ($cart->p_price)}}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td>No Records Found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><br><br>
    <?php
    if (isset($carts) && !empty($carts)) {
        $total = 0;
        foreach ($carts as $value) {
            $total = $total + ($value->p_price * $value->p_qty);
        }
    }
    ?>
    <div class="row">
        <div class="col-md-3 offset-4 amt-paid">
            <label>Total Amount to be paid</label>&nbsp;&nbsp;&nbsp;&nbsp;<label>$ {{$total}}</label>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-3 offset-4">
            <a href="{{route('user-payment')}}"><input type="submit" value="PROCEED FOR PAYMENT" id="proceed_for_payment"></input></a>
        </div>
    </div>
    </div>

    <div class="modal fade" id="deleteCartPopupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Do you want to delete the cart item?</div>
                <div class="modal-footer">
                    <input type="hidden" name="delete_cartproduct_id" id="delete_cartproduct_id" value="" />
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" id="delete_cartproduct_btn" type="button" data-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>
    @stop
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    @section('scripts')
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <!-- Page level custom scripts -->
    <script src="{{asset('js/demo/datatables-demo.js')}}"></script>
    <script src="{{asset('js/toastr.min.js')}}"></script>
    <script>
        function getCartProduct(id) {
            //alert("The id is" + id);
            $("#delete_cartproduct_id").attr('value', id);
        }
        $(document).ready(function() {
            $('#delete_cartproduct_btn').click(function() {
                id = $("#delete_cartproduct_id").val();
                //  alert("inside");
                $.ajax({
                    url: "{{ config('constants.BASE_PATH') }}user/deletecartitem/" + id,
                    type: 'delete',
                    beforeSend: function(request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                    },
                    'success': function(data) {
                        if (data != '') {
                            response = JSON.parse(data);
                        }
                        if (response.message != '') {
                            toastr.success(response.message);
                            location.reload();
                            //  window.location.href= "{{ config('constants.BASE_PATH') }}getposts/";       
                        }
                    },
                    'error': function(xhr) {
                        if (xhr.status == 403) {
                            const response = JSON.parse(xhr.responseText);
                            //  alert(response.message);
                            // console.log(xhr);
                            toastr.warning(response.message);
                            location.reload();
                        }
                    }
                })
            });
        });
    </script>
    @stop
</x-home-master>