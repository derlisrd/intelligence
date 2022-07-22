<!doctype html>
<html lang="en">
<head>
    <title>{{ config('app.name', 'Laravel') }}</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="{{ asset('assets/dist/css/style.min-bootswatch.css')}}" rel="stylesheet">
</head>
<body>
<section class="">
    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-7 col-lg-5">
                <div class="wrap border rounded bg-light">
                    <div class="login-wrap p-4 p-md-5">
                        <div class="d-flex">
                            <div class="w-100 text-center">
                            <h3 class="mb-4">Sign In</h3>
                            </div>
                        </div>
                        <form action="{{ route("auth.login") }}" method="POST">
                            @csrf

                            @if (count($errors) > 0)
                                <div class="alert alert-danger" role="alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif


                            <div class="form-group mt-3">
                                <input type="email" class="form-control my-3" name="email" autocomplete="off" autofocus required>
                                <label class="form-control-placeholder" for="email">Email</label>
                            </div>
                            <div class="form-group">
                                <input id="password-field" type="password" name="password" class="form-control my-3" required>
                                <label class="form-control-placeholder" for="password">Password</label>
                            </div>
                            <div class="form-group my-4">
                                <button type="submit" class="form-control btn btn-info rounded submit px-3 text-bold">Sign In</button>
                            </div>
                            <div class="form-group d-md-flex my-3">
                                <div class="w-50 text-left">
                                    <label class="checkbox-wrap checkbox-primary mb-0">Remember Me</label>
                                    <input type="checkbox" >
                                    <span class="checkmark"></span>
                                </div>
                                <div class="w-50 text-md-right">
                                    <a href="#">Forgot Password</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include("layouts.scripts")
</body>
</html>
