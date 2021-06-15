<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <title>Aplikasi UTD PMI</title>

    <!-- Favicons -->
    <link href="<?= base_url('/assets/img/logo.png') ?>" rel="icon">

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url('/assets/lib/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!--external css-->
    <link href="<?= base_url('/assets/lib/font-awesome/css/font-awesome.css') ?>" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="<?= base_url('/assets/css/style.css') ?>" rel="stylesheet">
    <link href="<?= base_url('/assets/css/style-responsive.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('/assets/lib/toast/toast.min.css') ?>">

</head>

<body>
    <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
    <div id="login-page">
        <div class="container">
            <div class="form-login">
                <h2 class="form-login-heading">
                    <p>UNIT TRANSFUSI DARAH</p> PALANG MERAH INDONESIA
                </h2>
                <div class="login-wrap">
                    <form id="loginForm">
                        <input type="text" class="form-control" name="username" placeholder="Username" oninvalid="this.setCustomValidity('Username tidak boleh kosong')" oninput="setCustomValidity('')" required autofocus>
                        <br>
                        <input type="password" class="form-control" name="password" placeholder="Password" oninvalid="this.setCustomValidity('Password tidak boleh kosong')" oninput="setCustomValidity('')" required>
                        <label class="checkbox">
                            <!-- <span class="pull-right">
                            <a data-toggle="modal" href="login.html#myModal"> Lupa Password?</a>
                        </span> -->
                        </label>
                        <button class="btn btn-theme04 btn-block" id="submitBtn" type="submit"><i class="fa fa-lock"></i> LOGIN</button>
                    </form>
                </div>
                <!-- Modal -->
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Forgot Password ?</h4>
                            </div>
                            <div class="modal-body">
                                <p>Enter your e-mail address below to reset your password.</p>
                                <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
                            </div>
                            <div class="modal-footer">
                                <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                                <button class="btn btn-theme" type="button">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal -->
            </div>
        </div>
    </div>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?= base_url('/assets/lib/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('/assets/lib/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('/assets/lib/toast/toast.min.js') ?>"></script>
    <script src="<?= base_url('/assets/formProses.js') ?>"></script>


    <script>
        formProses = new formProses();
        myForm = $('#loginForm');

        myForm.submit((evt) => {
            evt.preventDefault();
        })

        $('#submitBtn').on('click', (e) => {
            const required = $('input,textarea,select').filter('[required]:visible');

            const allRequired = true;
            required.each(function() {
                if ($(this).val() == '') {
                    allRequired = false;
                }
            });

            if (allRequired) {
                const data = myForm.serializeArray()
                    .reduce(function(a, x) {
                        a[x.name] = x.value;
                        return a;
                    }, {});

                const res = formProses.getData("<?php echo base_url() ?>" + "login/cekLogin", data);

                if (res[0]) {
                    toastr.success('Anda berhasil login', 'Informasi', {
                        timeOut: 1000
                    })

                    setTimeout(function() {
                        window.location = res[1] + "/"
                    }, 1000);
                } else {
                    toastr.error('Username atau password salah', 'Informasi', {
                        timeOut: 1000
                    })
                }
            }
        })
    </script>
</body>

</html>