<x-admin-master>
    @section('css')
    <!-- Custom styles for this page -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @endsection
    @section('content')

    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Save Category</h6>

        </div>
        <div class="row">
            <div class="col-md-10">

            </div>
        </div>
        <div class="card-body">
            <form id="save_category_form" action="{{route('save-category')}}" method="post">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-group">
                            <label>CATEGORY NAME</label>
                            <input type="text" class="form-control" name="categoryName" id="categoryName" @if(isset($category['name']) && $category['name'] !='' ) value="{{$category->name}}" @else value="" @endif />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-group">
                            <input type="hidden" @if(isset($category['id']) && $category['id'] !='' ) value="{{$category->id}}" @else value="" @endif name="id" id="id" />
                           
                           <button class="btn btn-primary btn-sm" type="submit" name="save_category" id="save_category" > Submit</button></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endsection
    @section('scripts')
    <!-- Page level plugins -->
    <script>
        $(document).ready(function() { 
                $('#save_category_form').on('submit', function(event) {
                    event.preventDefault();
                    data = $("#save_category_form").serialize();
                   // alert("the value is" + CKEDITOR.instances.productDescription.getData());
                    $.ajax({
                        url: "{{ config('constants.BASE_PATH') }}admin/savecategory/",
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
                                window.location.href = "{{ config('constants.BASE_PATH') }}admin/categories/";
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
                });
        });
    </script>
    @endsection
</x-admin-master>