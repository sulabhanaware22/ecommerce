@if($products)
                @foreach($products as $product)
                <div class="col-md-3">
                    <div class="home_grid2">
                        <div class="row">
                            @if(isset($product->product_image) && $product->product_image != '')
                            <a href="{{route('product-detail',$product->pid)}}"><img src="{{$product->product_image}}" class="home_grid2_image"></a>
                            @else
                            <a href="{{route('product-detail',$product->pid)}}"><img src="{{$product->product_image}}" class="home_grid2_image"></a>
                            @endif

                        </div>
                        <div class="theme-product_list_row">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Product Name:</label>
                                </div>
                                <div class="col-md-6">
                                    <label>{{Str::limit($product->pname,10)}}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Product Price:</label>

                                </div>
                                <div class="col-md-6">
                                    <label>$ {{$product->price}}</label>
                                    <!-- <select>
                                            <option>Quantity</option>
                                            <option>2</option>
                                            <option>4</option>
                                            <option>6</option>
                                        </select> -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 offset-4">
                                    <button data-toggle="collapse" data-target="#demo{{$product->pid}}">Read more</button>
                                </div>
                                <div class="col-md-12">
                                    <div id="demo{{$product->pid}}" class="collapse">
                                        @if(isset($product->product_description) && $product->product_description != ''){!! nl2br(Str::limit($product->product_description,70)) !!}@else ----- @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
@endif
{!! $products->render() !!}