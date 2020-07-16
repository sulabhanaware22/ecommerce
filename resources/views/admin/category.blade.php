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
                    <h6 class="m-0 font-weight-bold text-primary">Categories List</h6>
                </div>
                <div class="col-sm-1">
                    <a href="{{route('category-manage','')}}"><button class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add</button></a>
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
                            <th>Category Name</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Category Name</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($categories)
                        @foreach($categories as $c)
                        <tr>
                            <td>{{$c->id}}</td>
                            <td>{{$c->name}}</td>
                            <td>
                                @if($c->status === 0)
                                <button id="approved" onclick="approved('{{$c->id}}')" class="btn btn-success btn-sm">Approve</button>
                                @else
                                <button type="button" id="dissapproved" onclick="dissapproved('{{$c->id}}')" class="btn btn-success btn-sm">Disapprove</button>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('category-manage',$c->id)}}"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Edit</button></a>
                                <button class="btn btn-sm btn-danger" onclick="getCategory('{{$c->id}}')" data-toggle="modal" data-target="#deleteCategoryPopupModal"><i class="fa fa-trash"></i> Delete</button>
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
    <div class="modal fade" id="deleteCategoryPopupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Category</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Do you want to delete the category?</div>
                <div class="modal-footer">
                    <input type="hidden" name="delete_category_id" id="delete_category_id" value="" />
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" id="delete_category_btn" type="button" data-dismiss="modal">Delete</button>
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
        function getCategory(id) {
            // alert("The id is"+id);
            $("#delete_category_id").attr('value', id);
        }

        function dissapproved(id) {
            //  alert("inside");
            //  event.preventDefault();
            $.ajax({
                url: "{{ config('constants.BASE_PATH') }}admin/disapprove/" + id,
                type: "get",
                beforeSend: function(request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                'success': function(data) {
                        response = JSON.parse(data);
                        if (response.message != '') {
                            toastr.success(response.message);
                            location.reload();
                            //  window.location.href= "{{ config('constants.BASE_PATH') }}getposts/";       
                        }
                    }
            });
        }

        function approved(id) {
            //    alert("inside");
            //   event.preventDefault();
            $.ajax({
                url: "{{ config('constants.BASE_PATH') }}admin/approve/" + id,
                type: "get",
                beforeSend: function(request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                'success': function(data) {
                        response = JSON.parse(data);
                        if (response.message != '') {
                            toastr.success(response.message);
                            location.reload();
                            //  window.location.href= "{{ config('constants.BASE_PATH') }}getposts/";       
                        }
                    }
            });
        }
        $(document).ready(function() {
            $('#delete_category_btn').click(function() {
                id = $("#delete_category_id").val();
                //  alert("inside");
                $.ajax({
                    url: "{{ config('constants.BASE_PATH') }}admin/deletecategory/" + id,
                    type: 'delete',
                    beforeSend: function(request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                    },
                    'success': function(data) {
                        response = JSON.parse(data);
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