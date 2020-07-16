<x-home-master>

 @section('css')
    <link href="{{asset('css/toastr.min.css')}}" rel="stylesheet">
 @stop

@section('content')
        <!--add the home screen page to select the products from the grid view-->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">User Profile</h6>

            </div>
            <div class="row">
                <div class="col-md-10">

                </div>
            </div>

            <div class="card-body">
                <form id="save_user_password_form" action="{{route('save-userpassword')}}" method="post">

                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="text" class="form-control" name="password" id="password" />

                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <div class="form-group">
                                <input type="hidden" @if(isset($user['id']) && $user['id'] !='' ) value="{{$user->id}}" @else value="" @endif name="id" id="id" />
                                <input type="submit" value="submit" name="save_admin_password" id="save_admin_password" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
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
            $('#save_user_password_form').on('submit', function(event) {
                event.preventDefault();
                data = $("#save_user_password_form")[0];
                formdata = new FormData(data);
                $.ajax({
                    url: "{{ config('constants.BASE_PATH') }}user/saveuserpassword/",
                    type: 'post',
                    data: formdata,

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
                });
            });
        });
    </script>
    @stop
</x-home-master>