<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from smarthr.co.in/demo/html/template/login-2 by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 29 Sep 2025 09:11:12 GMT -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Smarthr - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, html5, responsive, Projects">
    <meta name="author" content="Dreams technologies - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>MIT</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="https://smarthr.co.in/demo/html/template/assets/img/favicon.png">

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="https://smarthr.co.in/demo/html/template/assets/img/apple-touch-icon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://smarthr.co.in/demo/html/template/assets/css/bootstrap.min.css">

    <!-- Feather CSS -->
    <link rel="stylesheet" href="https://smarthr.co.in/demo/html/template/assets/plugins/icons/feather/feather.css">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="https://smarthr.co.in/demo/html/template/assets/plugins/tabler-icons/tabler-icons.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="https://smarthr.co.in/demo/html/template/assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://smarthr.co.in/demo/html/template/assets/plugins/fontawesome/css/all.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="https://smarthr.co.in/demo/html/template/assets/css/style.css">

</head>

<body class="bg-white">

    <div id="global-loader" style="display: none;">
        <div class="page-loader"></div>
    </div>
    <?php include_once('connection_db.php'); ?>
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <div class="container-fuild">
            <div class="w-100 overflow-hidden position-relative flex-wrap d-block vh-100">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="d-lg-flex align-items-center justify-content-center d-none flex-wrap vh-100 bg-primary-transparent">
                            <div>
                                <img src="https://smarthr.co.in/demo/html/template/assets/img/bg/authentication-bg-03.svg" alt="Img">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-12 col-sm-12">
                        <div class="row justify-content-center align-items-center vh-100 overflow-auto flex-wrap ">
                            <div class="col-md-7 mx-auto ">
                                <form action="" method="POST" >
                                    <div class=" d-flex flex-column justify-content-between p-4 pb-0">
                                        <div class="mx-auto mb-5 text-center">
                                            <img src="https://smarthr.co.in/demo/html/template/assets/img/logo.svg" class="img-fluid" alt="Logo">
                                        </div>
                                        <div class="">
                                            <div class="text-center mb-3">
                                                <h2 class="mb-2">Sign In</h2>
                                                <p class="mb-0">Please enter your details to sign in</p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Email Address</label>
                                                <div class="input-group">
                                                    <input type="text" name="email" class="form-control border-end-0">
                                                    <span class="input-group-text border-start-0">
                                                        <i class="ti ti-mail"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Password</label>
                                                <div class="pass-group">
                                                    <input type="password" name="password" class="pass-input form-control">
                                                    <span class="ti toggle-password ti-eye-off"></span>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <input type="submit" class="btn btn-primary w-100" value="Sign In" name="submit">
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Main Wrapper -->
    <?php
    if (isset($_POST['submit'])) {
        $email    = $_POST['email'];
        $password = $_POST['password'];

        $sql  = "SELECT * FROM user WHERE username=? AND password=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['user'] = $email;
            echo '<script>location.replace("dashboard.php")</script>';
            exit;
        } else {
            echo "<script>alert('Invalid Email or Password'); window.history.back();</script>";
        }
    }
    ?>
    <!-- jQuery -->
    <script src="https://smarthr.co.in/demo/html/template/assets/js/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="https://smarthr.co.in/demo/html/template/assets/js/bootstrap.bundle.min.js"></script>

    <!-- Feather Icon JS -->
    <script src="https://smarthr.co.in/demo/html/template/assets/js/feather.min.js"></script>

    <!-- Custom JS -->
    <script src="https://smarthr.co.in/demo/html/template/assets/js/script.js"></script>

</body>


<!-- Mirrored from smarthr.co.in/demo/html/template/login-2 by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 29 Sep 2025 09:11:12 GMT -->

</html>