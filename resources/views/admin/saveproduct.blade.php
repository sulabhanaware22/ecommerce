<x-admin-master>
    @section('css')
    <!-- Custom styles for this page -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @endsection
    @section('content')

    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Save Product</h6>

        </div>
        <div class="row">
            <div class="col-md-10">

            </div>
        </div>
        <div class="card-body">
            <form id="save_product_form" action="{{route('save-product')}}" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-group">
                            <label>PRODUCT TITLE</label>
                            <input type="text" class="form-control" name="productTitle" id="productTitle" @if(isset($product['name']) && $product['name'] !='' ) value="{{$product->name}}" @else value="" @endif />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>PRODUCT DESCRIPTION</label>
                            <textarea rows="15" columns="80" class="form-control" name="productDescription" id="productDescription">@if(isset($product['product_description']) && $product['product_description']!=''){!! nl2br($product->product_description) !!}  @else  @endif  </textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-group">
                            <label>PRODUCT CATEGORY</label>
                            <select name="productCategory" id="productCategory" >
                            <option>Select Category</option>
                            @if(isset($category) && $category != '')
                             @foreach($category as $value)
                             <option value="{{$value->id}}" 
                             @if(isset($product->id) && $product->id != '')
                             @if($value->id == $product->category_id)
                             selected="selected"
                             @endif
                             @endif
                                   >{{$value->name}}</option>
                             @endforeach
                            @endif
                    
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-group">
                            <label>PRODUCT PRICE</label>
                            <input type="number" class="form-control" name="productPrice" id="productPrice" @if(isset($product['price']) && $product['price'] !='' ) value="{{$product->price}}" @else value="" @endif />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-group">
                            <label>PRODUCT QUANTITY</label>
                            <input type="number" class="form-control" name="productQuantity" id="productQuantity" @if(isset($product['total_quantity']) && $product['total_quantity'] !='' ) value="{{$product->total_quantity}}" @else value="" @endif />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-group">
                            <label>PRODUCT IMAGE</label>
                            <input type="file" class="form-control" name="productImage" id="productImage" />
                            <img id="previewImage" @if(isset($product['product_image']) && $product['product_image'] !='' ) src="{{$product->product_image}}" @else src="{{asset('images/noimage.png')}}" @endif alt="your image" width="200px" height="200px" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-group">
                            <input type="hidden" @if(isset($product['id']) && $product['id'] !='' ) value="{{$product->id}}" @else value="" @endif name="id" id="id" />
                           
                           <button class="btn btn-primary btn-sm" type="submit" name="save_product" id="save_product" > Submit</button></a>
                         <img src="{{asset(config('constants.BASE_PATH').'images/loader.gif')}}" id="loader" style="display:none;"/>                 
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endsection
    @section('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('productDescription');
    </script>
    <script>
        $(document).ready(function() {
            $("#productImage").change(function() {
                readURL(this);
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#previewImage').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }(
                $('#save_product_form').on('submit', function(event) {
                    event.preventDefault();
                    $("#productDescription").val(CKEDITOR.instances.productDescription.getData());
                    data = $("#save_product_form")[0];
                    formdata = new FormData(data);
                   $('#loader').css("display","block");
                   $('#save_product').css("display","none");
                   // alert("the value is" + CKEDITOR.instances.productDescription.getData());
                    $.ajax({
                        url: "{{ config('constants.BASE_PATH') }}admin/saveproduct/",
                        type: 'post',
                        data: formdata,
                        enctype: 'multipart/form-data',
                        processData: false,
                        cache: false,
                        contentType: false,
                        beforeSend: function(request) {
                            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                        },
                        'success': function(data) {
                            if(data != ''){
                                response = JSON.parse(data);
                                $('#loader').css("display","none");
                                $('#save_product').css("display","block");
                            }
                           
                            //alert("the data is"+response.message)
                            if (response.message != '') {
                                //alert("saved!");
                                toastr.success(response.message)
                                window.location.href = "{{ config('constants.BASE_PATH') }}admin/products/";
                            }
                        },
                        'error': function(xhr) {
                            if (xhr.status == 422) {
                                response = JSON.parse(xhr.responseText);
                                toastr.success(response.message);
                                window.location.reload();
                            }
                        }
                    })
                }));
        })
    </script>
    @endsection
</x-admin-master>