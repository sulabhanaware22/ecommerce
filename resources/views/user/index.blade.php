<x-home-master>
    @section('css')
    <link type="text/css" rel="stylesheet" href="{{asset('css/simplePagination.css')}}" />
    @endsection
    @section('content')
    @if (session()->has('paymentmessage'))
    jhkjxzhckzxhckxzjchxzkjchxzkjchxzkjchxzkjcxhkjxzhcxz
    <div class="alert alert-success text-center">

        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>

        <p>   {{ session('paymentmessage') }}</p>

    </div>
    @endif
    <!--end of nav bar-->
    <!--Image view for display on home screen-->
    <!--            <div class="row">
                            <img src="images/banner_image.jpg" alt="banner_image" width="" height="" />
                        </div>-->
    <!--end of image to display on home screen-->
    <!--Image slider to display on home screen list of 10 images-->
    <div class="">
        <div class="background-image img-responsive">
            <div class="row theme-banner-customization">
                <div class="col-md-3 theme-card box">
                    <img src="{{asset('images/home_block_image1.jpg')}}" class="theme-card-image" />
                </div>
                <div class="col-md-3  theme-card box">
                    <img src="{{asset('images/home_block_image2.png')}}" class="theme-card-image" />
                </div>
                <div class="col-md-3  theme-card box">
                    <img src="{{asset('images/home_block_image6.jpg')}}" class="theme-card-image" />
                </div>
            </div>
        </div>
    </div>
    <!--end of image slider to display images on home screen-->
    <!--Start of image carousel slider-->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100 carousel-theme-img" src="{{asset('images/home_carousel01_4.jpg')}}" alt="First slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>First Slide Title</h5>
                    <p>Lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100 carousel-theme-img" src="{{asset('images/home_carousel02_01.jpg')}}" alt="Second slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second Slide Title</h5>
                    <p>Lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum</p>
                </div>

            </div>
            <div class="carousel-item">
                <img class="d-block w-100 carousel-theme-img" src="{{asset('images/home_carousel03_01.jpg')}}" alt="Third slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Third Slide Title</h5>
                    <p>Lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum</p>
                </div>

            </div>
            <div class="carousel-item">
                <img class="d-block w-100 carousel-theme-img" src="{{asset('images/home_carousel04_01.jpg')}}" alt="Fourth slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Fourth Slide Title</h5>
                    <p>Lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum</p>
                </div>

            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!--End of image carousel slider-->
    <!--add the home screen page to select the products from the grid view-->
    <div class="home_screen">
        <div class="row">
            <div class="col-md-2 offset-2 col-xs-2 offset-3 col-sm-2 offset-3">
                <h2>Products List</h2>
            </div>
        </div>
        <div class="container">
            <div class="row" id="datatable" style="margin-bottom:20px;">
             @include('user.productitem')
            </div>
        </div>
    </div>
    @stop
    @section('scripts')
    <script type="text/javascript" src="{{asset('js/jquery.simplePagination.js')}}"></script>
    <script type="text/javascript">

    $(window).on('hashchange', function() {

        if (window.location.hash) {

            var page = window.location.hash.replace('#', '');

            if (page == Number.NaN || page <= 0) {

                return false;

            }else{

                getData(page);

            }

        }

    });

    

    $(document).ready(function()

    {

        $(document).on('click', '.pagination a',function(event)

        {

            event.preventDefault();

  

            $('li').removeClass('active');

            $(this).parent('li').addClass('active');

  

            var myurl = $(this).attr('href');

            var page=$(this).attr('href').split('page=')[1];

  

            getData(page);

        });

  

    });

  

    function getData(page){

        $.ajax(

        {

            url: '?page=' + page,

            type: "get",

            datatype: "html"

        }).done(function(data){

            $("#datatable").empty().html(data);

            location.hash = page;

        }).fail(function(jqXHR, ajaxOptions, thrownError){

              alert('No response from server');

        });

    }

</script>
    <script>
        // $(document).ready(function() {
        //     onLoad();
        //     $(function() {
        //         $("#datatable").pagination({
        //             items: 100,
        //             itemsOnPage: 10,
        //             cssStyle: 'compact-theme'
        //         });
        //     });
        //     function onLoad(){
        //         page=1;
        //         $.ajax({
        //             url: "{{ config('constants.BASE_PATH') }}user/onloadproducts/"+page,
        //             type: 'get',
        //             data: data,
        //             beforeSend: function(request) {
        //                 return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
        //             },
        //             'success': function(data) {
        //                 response = JSON.parse(data)
        //                 //alert("the data is"+response.message)
        //                 if (response.message != '') {
        //                     //alert("saved!");
        //                     toastr.success(response.message)
        //                     $("#cartlength").text(<?php session('cartlength') ?>);
        //                   //  window.location.reload();
        //                     window.location.href = "{{ config('constants.BASE_PATH') }}user/carts/";
        //                 }
        //             },
        //             'error': function(xhr) {
        //                 //  alert("inside exception"+xhr);
        //                 if (xhr.status == 500) {
        //                     response = JSON.parse(xhr.responseText);
        //                     toastr.warning(response.message);
        //                     //   window.location.reload();
        //                 }
        //             }
        //         });
        //     }
        // });
    </script>
    @endsection
</x-home-master>