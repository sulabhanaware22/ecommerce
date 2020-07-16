<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('css\bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css\homemasterstyles.css')}}">
    <title>Ecommerce - Register</title>
</head>

<body>
    <div class="container">
        <div class="row" style="margin-top: 40px;">
            <div class="col-md-6 offset-3">
                <h2>Register</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-3">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="theme-seaparator">
                        <div class="row">
                            <div class="col-md-10 offset-1">
                                <div class="form-group">
                                    <label>FULL NAME</label>


                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
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
                                    <label>EMAIL ADDRESS</label>


                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                    <label>ROLE</label>

                                   
                                   <select id="type"  class="form-control @error('type') is-invalid @enderror" name="type" value="{{ old('type') }}" required>
                                       <option value="">select</option>
                                       <option value="1">Admin</option>
                                       <option value="2">User</option>
                                   </select>
                                    @error('type')
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
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

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
                                    <label>CONFIRM PASSWORD</label>
                                    <!-- <input type="password" name="user_password" class="form-control" placeholder="Password here" /> -->
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 offset-1">
                                <div class="form-group">
                                    <!-- <button type="button" name="submit" class="btn btn-primary theme-button">SUBMIT</button> -->
                                    <button type="submit" class="btn btn-primary theme-button">
                                        {{ __('Register') }}
                                    </button>
                                </div>
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