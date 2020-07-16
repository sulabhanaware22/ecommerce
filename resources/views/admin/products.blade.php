<x-admin-master>
  @section('css')
  <!-- Custom styles for this page -->
  <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  @endsection
  @section('content')
  <!-- Page Heading -->
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="row">
        <div class="col-sm-11">
        <h6 class="m-0 font-weight-bold text-primary">Products List</h6>
        </div>
        <div class="col-sm-1">
        <a href="{{route('product-manage','')}}"><button class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add</button></a>
        </div>
      </div> 
    </div>
    <div class="row">
      <div class="col-md-10">
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Id</th>
              <th>Product Title</th>
              <th>Product Description</th>
              <th>Category</th>
              <th>Image</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Id</th>
              <th>Product Title</th>
              <th>Product Description</th>
              <th>Category</th>
              <th>Image</th>
              <th>Actions</th>
            </tr>
          </tfoot>
          <tbody>
            @if($products)
            @foreach($products as $product)
            <tr>
              <td>{{$product->pid}}</td>
              <td>{{$product->pname}}</td>
              <td>@if(isset($product->product_description) && $product->product_description != ''){!! nl2br(Str::limit($product->product_description,70)) !!}@else ----- @endif</td>
              <td>{{$product->cname}}</td>
              <td>
                @if(isset($product->product_image) && $product->product_image != '')
                <img src="{{$product->product_image}}" width="100" height="100">
                @else
                <img src="{{asset('images/noimage.png')}}" width="100" height="100">
                @endif
              </td>
              <td>
                <a href="{{route('product-manage',$product->pid)}}"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Edit</button></a>
                <button class="btn btn-sm btn-danger" onclick="getProduct('{{$product->pid}}')" data-toggle="modal" data-target="#deleteProductPopupModal"><i class="fa fa-trash"></i> Delete</button>
                <img src="{{asset(config('constants.BASE_PATH').'images/loader.gif')}}" id="loader" style="display:none;"/>                 
              </td>
            </tr>
            @endforeach
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!--modal poup for delete version-->
  <div class="modal fade" id="deleteProductPopupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Do you want to delete the product?</div>
        <div class="modal-footer">
          <input type="hidden" name="delete_product_id" id="delete_product_id" value="" />
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <button class="btn btn-danger" id="delete_product_btn" type="button" data-dismiss="modal">Delete</button>
        </div>
      </div>
    </div>
  </div>
  <!--end of modal popup-->
  @endsection
  @section('scripts')
  <!-- Page level plugins -->
  <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <!-- Page level custom scripts -->
  <script src="{{asset('js/demo/datatables-demo.js')}}"></script>
  <script>
    function getProduct(id) {
      // alert("The id is"+id);
      $("#delete_product_id").attr('value', id);
    }
    $(document).ready(function() {
      $('#delete_product_btn').click(function() {
        id = $("#delete_product_id").val();
        $('#loader').css('display','block');
        //  alert("inside");
        $.ajax({
          url: "{{ config('constants.BASE_PATH') }}admin/deleteproduct/" + id,
          type: 'delete',
          beforeSend: function(request) {
            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
          },
          'success': function(data) {
            if(data != ''){
              response = JSON.parse(data);
            }   
            $('#loader').css('display','none');
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
    })
  </script>
  @endsection
</x-admin-master>