<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('css\bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css\homemasterstyles.css')}}">
    @yield('css')
    <title>Ecommerce</title>
    <style>
        body {
            overflow-x: hidden;
        }

        #add_to_cart,
        #edit_to_cart {
            width: 100%;
            height: 100%;
            background-color: #EA5252;
            border: none;
            padding: 10px;
            color: black;
            font-weight: 400px;
        }
        #continue_shopping {
            width: 100%;
            height: 100%;
            background-color: #85D0F7;
            border: none;
            padding: 10px;
            color: black;
            font-weight: 400px;
        }
        #proceed_to_checkout,
        #proceed_for_payment {
            width: 100%;
            height: 100%;
            background-color: #EA5252;
            border: none;
            padding: 10px;
            color: black;
            font-weight: 400px;
        }

        .amt-paid {
            border: 1px solid #dee2e6;
            width: 50%;
        }

        .panel-title {

            display: inline;

            font-weight: bold;

        }

        .display-table {

            display: table;

        }

        .display-tr {

            display: table-row;

        }

        .display-td {

            display: table-cell;

            vertical-align: middle;

            width: 61%;

        }
    </style>
</head>

<body>
    <div class="">
        <!--nav bar -->
        <!-- A grey horizontal navbar that becomes vertical on small screens -->
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <!-- Links -->
            <ul class="navbar-nav flex-row">
                <a class="navbar-brand" href="#">
                    <img src="{{asset('images/logo.png')}}" alt="Logo" style="width:40px;">
                </a>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('user-dashboard')}}">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('user-cart')}}">Saved Cart <span class="badge badge-light" id="cartlength">
                            <?php
                            $cart = session('cartlength');
                            if (isset($cart) && $cart != '') {
                                echo $cart;
                            } else {
                                echo "0";
                            }
                            ?>

                        </span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('user-order')}}">Checkout</a>
                </li>
            </ul>
            <ul class="navbar-nav flex-row ml-md-auto  d-md-flex">
                <!-- Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                        <img class="img-profile rounded-circle" width="50px" height="50px" @if(isset(Auth::user()->url) && Auth::user()->url !='' ) src="{{Auth::user()->url}}" @else src="{{asset('images/noimage.png')}}" @endif alt="your image">
                        {{Auth::user()->name}}
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{route('user-profile',Auth::user()->id)}}">User Profile</a>
                        <a class="dropdown-item" href="{{route('order-history',Auth::user()->id)}}">Order History</a>
                        <a class="dropdown-item" href="{{route('change-userpassword',Auth::user()->id)}}">Change Password</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>

        @yield('content')

        <!--end of selection of products from home view-->
        <!--start of pagination-->
        <!-- <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav> -->
        <!--end of pagination-->
    </div>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script src="{{asset('js\jquery-3.2.1.slim.min.js')}}"></script> -->
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('js\popper.min.js')}}"></script>
    <script src="{{asset('js\bootstrap.min.js')}}"></script>
    @yield('scripts')
</body>

</html>