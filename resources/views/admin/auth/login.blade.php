<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

</head>

<body class="authentication-bg position-relative">
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-lg-5">
                    <div class="position-relative rounded-3 overflow-hidden"
                        style="background-image: url(assets/images/flowers/img-3.png); background-position: top right; background-repeat: no-repeat;">
                        <div class="card bg-transparent mb-0">
                            <!-- Logo-->
                            <div class="auth-brand">
                                {{-- <a href="index.html" class="logo-light">
                                <img src="assets/images/logo.png" alt="logo" height="22">
                            </a>
                            <a href="index.html" class="logo-dark">
                                <img src="assets/images/logo-dark.png" alt="dark logo" height="22">
                            </a> --}}
                            </div>

                            <div class="card-body p-4">
                                <div class="w-50">
                                    <h4 class="pb-0 fw-bold">Sign In</h4>
                                    <p class="fw-semibold mb-4">Enter your email address and password to access admin
                                        panel.</p>
                                </div>

                                <form action="{{ route('login') }}" method="POST">
                                    @csrf
                                    @method('POST')

                                    <div class="mb-3">
                                        <label for="emailaddress" class="form-label">Email address</label>
                                        <input class="form-control @error('email') invalid-feedbac @enderror"
                                            type="email" name="email" id="emailaddress" required=""
                                            placeholder="Enter your email">
                                        @error('email')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="password" name="password" class="form-control"
                                                placeholder="Enter your password">
                                        </div>
                                    </div>

                                    <div class="mb-3 mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="checkbox-signin"
                                                checked>
                                            <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                        </div>
                                    </div>

                                    <div class="mb-3 mb-0 text-center">
                                        <button class="btn btn-primary w-100" type="submit"> Log In </button>
                                    </div>

                                </form>
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->
                    </div>

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <footer class="footer footer-alt fw-medium">
        <span class="bg-body">
            <script>
                document.write(new Date().getFullYear())
            </script> © Powerx - Isckon Nepal
        </span>
    </footer>
    {{-- @@include('./partials/footer-scripts.html') --}}

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>

{{-- <body>

    <div id="single-wrapper">
        <form action="{{ route('login') }}" class="frm-single" method="POST">
            @csrf
            @method('POST')
            <div class="inside">
                <div class="title">{{ env('APP_NAME') }}</div>
                <div class="frm-title">Login</div>
                <div class="frm-input">
                  <input type="email" placeholder="Email" value="{{ old('email') }}" name="email" class="frm-inp ">
                  <i class="fa fa-user frm-ico"></i>
                  @error('email')
                  <span class="text-danger" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
                </div>
                <div class="frm-input"><input type="password" placeholder="Password" name="password" class="frm-inp"><i
                        class="fa fa-lock frm-ico"></i></div>
                <div class="clearfix margin-bottom-20">
                    <div class="pull-left">
                        <div class="checkbox primary"><input type="checkbox" id="rememberme"><label
                                for="rememberme">Remember me</label></div>
                    </div>

                </div>
                <button type="submit" class="frm-submit">Login<i class="fa fa-arrow-circle-right"></i></button>


            </div>
        </form>
    </div>



    <script src="assets/scripts/jquery.min.js"></script>
    <script src="assets/scripts/modernizr.min.js"></script>
    <script src="assets/plugin/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugin/nprogress/nprogress.js"></script>
    <script src="assets/plugin/waves/waves.min.js"></script>
    <script src="assets/scripts/main.min.js"></script>
</body> --}}

</html>
