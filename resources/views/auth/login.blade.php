<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('css\bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css\homemasterstyles.css')}}">
    <title>Ecommerce - Login</title>
</head>

<body>
    <div class="container">
        <div class="row" style="margin-top: 40px;">
            <div class="col-md-6 offset-3">
                <h2>Login</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-3">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="theme-seaparator">
                        <div class="row">
                            <div class="col-md-10 offset-1">
                                <div class="form-group">
                                    <label>USERNAME</label>
                                
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 offset-1">
                                <div class="form-group">
                                    <label>PASSWORD</label>
                                    <!-- <input type="password" name="user_password" class="form-control" placeholder="Password here" /> -->
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 offset-1">
                                <div class="form-group">
                                    <!-- <button type="button" name="submit" class="btn btn-primary theme-button">SUBMIT</button> -->
                                    <button type="submit" class="btn btn-primary theme-button">
                                    {{ __('Login') }}
                                </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 offset-1">
                                <label>New User?  <a class="theme-anchor" href="{{ route('register') }}">{{ __('Register Here?') }}</a>
                                    <!-- <a href="#" class="theme-anchor">Register Here?</a></label> -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 offset-1">
                                <label>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link theme-anchor" href="{{ route('password.request') }}"
                                  >Forgot Password?</a>
                                  @endif
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{asset('js\jquery-3.2.1.slim.min.js')}}"></script>
    <script src="{{asset('js\popper.min.js')}}"></script>
    <script src="{{asset('js\bootstrap.min.js')}}"></script>
</body>

</html>