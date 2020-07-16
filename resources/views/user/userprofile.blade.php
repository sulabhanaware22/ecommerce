<x-home-master>
@section('css')
    <link href="{{asset('css/toastr.min.css')}}" rel="stylesheet">
 @stop

<!--end of nav bar-->
<!--add the home screen page to select the products from the grid view-->
@section('content')
<div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">User Profile</h6>

</div>


<div class="card-body">
    <form id="save_user_profile_form" action="{{route('edit-userprofile')}}" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="form-group">
                    <label>Profile Name</label>
                    <input type="text" class="form-control" name="name" id="name" @if(isset($user['name']) && $user['name'] !='' ) value="{{$user->name}}" @else value="" @endif />
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="form-group">
                    <label>User Image</label>
                    <input type="file" class="form-control" name="userImage" id="userImage" />
                    <img id="previewImage" @if(isset($user['url']) && $user['url'] !='' ) src="{{$user->url}}" @else src="{{asset('images/noimage.png')}}" @endif alt="your image" width="200px" height="200px" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="form-group">
                    <input type="hidden" @if(isset($user['id']) && $user['id'] !='' ) value="{{$user->id}}" @else value="" @endif name="id" id="id" />
                    <input type="submit" value="submit" name="user_save_profile" id="user_save_profile" />
                </div>
            </div>
        </div>
    </form>
</div>
@stop
@section('scripts')
<!-- Optional JavaScript -->
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Core plugin JavaScript-->
<script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>
<script src="{{asset('js/toastr.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $("#userImage").change(function() {
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
            $('#save_user_profile_form').on('submit', function(event) {
                event.preventDefault();
                data = $("#save_user_profile_form")[0];
                formdata = new FormData(data);
                $.ajax({
                    url: "{{ config('constants.BASE_PATH') }}user/edituserprofile/",
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
                        response = JSON.parse(data)
                        //alert("the data is"+response.message)
                        if (response.message != '') {
                            //alert("saved!");
                            toastr.success(response.message)
                            window.location.reload();
                        }
                    },
                    'error': function() {

                    }
                })
            }));
    })
</script>
@stop
</x-home-master>