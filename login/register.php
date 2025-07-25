<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $nama     = $_POST['nama'];
    $email    = $_POST['email'];
    $password = md5($_POST['password']);  // <<< ini penting
    $role     = 'user'; // otomatis user biasa

    $sql = "INSERT INTO user (username, nama, email, password, role)
            VALUES ('$username', '$nama', '$email', '$password', '$role')";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../login/index.php?register=success");
        exit;
    } else {
        echo "Gagal register: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Tivo is a HTML landing page template built with Bootstrap to help you crate engaging presentations for SaaS apps and convert visitors into users.">
    <meta name="author" content="Inovatik">

    <!-- OG Meta Tags to improve the way the post looks when you share the page on LinkedIn, Facebook, Google+ -->
	<meta property="og:site_name" content="" /> <!-- website name -->
	<meta property="og:site" content="" /> <!-- website link -->
	<meta property="og:title" content=""/> <!-- title shown in the actual shared post -->
	<meta property="og:description" content="" /> <!-- description shown in the actual shared post -->
	<meta property="og:image" content="" /> <!-- image link, make sure it's jpg -->
	<meta property="og:url" content="" /> <!-- where do you want your post to link to -->
	<meta property="og:type" content="article" />

    <!-- Website Title -->
    <title>Sign Up FixLAN</title>
    
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700&display=swap&subset=latin-ext" rel="stylesheet">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/fontawesome-all.css" rel="stylesheet">
    <link href="../css/swiper.css" rel="stylesheet">
	<link href="../css/magnific-popup.css" rel="stylesheet">
	<link href="../css/styles.css" rel="stylesheet">
	
	<!-- Favicon  -->
    <link rel="icon" href="../images/logo spakar.jpg">
</head>
<body>
    
    <!-- Preloader -->
	<div class="spinner-wrapper">
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
    <!-- end of preloader -->
    
    <!-- Header -->
    <header class="ex-2-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Sign Up</h1>
                   <p>Already have an account? <a class="white" href="index.php">Log In</a></p> 
                    <!-- Sign Up Form -->
                    <div class="form-container">
                        <form id="signUpForm" data-toggle="validator" data-focus="false">
                            <div class="form-group">
                                <input type="text" class="form-control-input" name="username" required>
                                <label class="label-control">Username</label>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control-input" name="nama" required>
                                <label class="label-control">Nama Lengkap</label>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control-input" name="email" required>
                                <label class="label-control" for="semail">Email</label>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control-input" name="password" required>
                                <label class="label-control">Password</label>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control-submit-button">SIGN UP</button>
                            </div>
                            <div class="form-message">
                                <div id="smsgSubmit" class="h3 text-center hidden"></div>
                            </div>
                        </form>
                    </div> <!-- end of form container -->
                    <!-- end of sign up form -->

                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </header> <!-- end of ex-header -->
    <!-- end of header -->


    <!-- Scripts -->
    <script src="../js/jquery.min.js"></script> <!-- jQuery for Bootstrap's JavaScript plugins -->
    <script src="../js/popper.min.js"></script> <!-- Popper tooltip library for Bootstrap -->
    <script src="../js/bootstrap.min.js"></script> <!-- Bootstrap framework -->
    <script src="../js/jquery.easing.min.js"></script> <!-- jQuery Easing for smooth scrolling between anchors -->
    <script src="../js/swiper.min.js"></script> <!-- Swiper for image and text sliders -->
    <script src="../js/jquery.magnific-popup.js"></script> <!-- Magnific Popup for lightboxes -->
    <script src="../js/validator.min.js"></script> <!-- Validator.js - Bootstrap plugin that validates forms -->
    <script src="../js/scripts.js"></script> <!-- Custom scripts -->
</body>
</html>