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
                    <h6 class="m-0 font-weight-bold text-primary">Payments List</h6>
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
                            <th>Payment Date</th>
                            <th>User Name</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Payment Date</th>
                            <th>User Name</th>
                            <th>Price</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($payments)
                        @foreach($payments as $value)
                        <tr>
                            <td>{{$value->id}}</td>
                            <td>{{date("d M Y",strtotime($value->payment_date))}}</td>
                            <td>{{$value->user->name}}</td>
                            <td>{{$value->price}}</td>
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
    <!--end of modal popup-->
    @endsection
    @section('scripts')
    <!-- Page level plugins -->
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <!-- Page level custom scripts -->
    <script src="{{asset('js/demo/datatables-demo.js')}}"></script>
    <script>
        $(document).ready(function() {

        })
    </script>
    @endsection
</x-admin-master>