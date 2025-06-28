<!DOCTYPE html>
<html lang="en">

<head>
    <title>Capsys &bull; Web - Carga de Documentos</title>
    <?= link_tag('assets/img/icon.png', 'apple-touch-icon-precomposed'); ?>
    <?= link_tag('assets/img/icon.png', 'shortcut icon'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/documentos_app/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/documentos_app/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/documentos_app/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/documentos_app/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/documentos_app/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/documentos_app/css/util.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/documentos_app/css/main.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>

<body>
    <style>
        .wrap-login100 {
            width: unset !important;
            padding: 100px 35px 35px 35px !important;
        }

        #backdrop {
            position: absolute;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: rgb(0, 0, 0, 0.2);
            padding-top: 50vh;
        }

        .text-primary {
            color: #663ab5 !important;
        }

        @-webkit-keyframes spinner-border {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes spinner-border {
            to {
                transform: rotate(360deg);
            }
        }

        .spinner-border {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            vertical-align: text-bottom;
            border: 0.25em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            -webkit-animation: .75s linear infinite spinner-border;
            animation: .75s linear infinite spinner-border;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 0.2em;
        }

        @-webkit-keyframes spinner-grow {
            0% {
                transform: scale(0);
            }

            50% {
                opacity: 1;
                transform: none;
            }
        }

        @keyframes spinner-grow {
            0% {
                transform: scale(0);
            }

            50% {
                opacity: 1;
                transform: none;
            }
        }

        .spinner-grow {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            vertical-align: text-bottom;
            background-color: currentColor;
            border-radius: 50%;
            opacity: 0;
            -webkit-animation: .75s linear infinite spinner-grow;
            animation: .75s linear infinite spinner-grow;
        }

        .spinner-grow-sm {
            width: 1rem;
            height: 1rem;
        }

        @media (prefers-reduced-motion: reduce) {

            .spinner-border,
            .spinner-grow {
                -webkit-animation-duration: 1.5s;
                animation-duration: 1.5s;
            }
        }
    </style>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">

                <div class="login100-form validate-form">
                    <span class="login100-form-title">
                        <img src="https://www.capitalsegurosgmm.com/img/logo.png" alt="" height="60px" width="70%">
                    </span>
                    <!-- <span class="login100-form-title">
						Acceso para subir documentos
					</span> -->

                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="user" id="user" placeholder="usuario" autocomplete="new_user_gap">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user-circle" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="pass" id="pass" placeholder="contraseña" autocomplete="new_pass_gap">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn access" style="background-color: #663ab5!important;">
                            Acceder
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="overlay" id="backdrop" style="display: none;">
        <div class="d-flex justify-content-center">
            <div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div>
        </div>
    </div>




    <!--===============================================================================================-->
    <script src="<?= base_url() ?>assets/documentos_app/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="<?= base_url() ?>assets/documentos_app/vendor/bootstrap/js/popper.js"></script>
    <script src="<?= base_url() ?>assets/documentos_app/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="<?= base_url() ?>assets/documentos_app/vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="<?= base_url() ?>assets/documentos_app/vendor/tilt/tilt.jquery.min.js"></script>
    <!--===============================================================================================-->

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?= base_url() ?>assets/documentos_app/js/main.js"></script>
    <script>
        $(document).ready(function() {
            var Url = "<?= base_url() ?>";

            $(document).on('click', '.access', function(e) {
                Login();
            });

            window.Login = function() {
                $("#upProgressModal").css("display", "block");
                var usuario = $("#user").val();
                var pass = $("#pass").val();
                $.ajax({
                    type: 'POST',
                    url: `${Url}documentos/Login`,
                    data: {
                        "user": usuario,
                        "pass": pass,
                    },
                    success: function(data) {
                        if (data.code == 200) {
                            window.location.href = `${Url}documentos/up/${data.data.data}`;
                        } else {
                            console.log(data.data.data)
                            toastr.error(data.data.data);
                        }
                        $("#upProgressModal").css("display", "none");
                    },
                    error: function(data) {
                        toastr.error("Error, intentelo mas tarde");
                        $("#upProgressModal").css("display", "none");
                    }
                });
            }
        });
    </script>

</body>

</html>