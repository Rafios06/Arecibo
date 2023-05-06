<!doctype html>
<html lang="en">

<?php
// Already connected
session_start();
if (isset($_SESSION['loggedin'])) {
    header('Location: activities.php');
    exit;
}
?>

<head>
    <!-- meta tags -->
    <meta charset="utf-8" />
    <meta name="theme-color" content="#212529">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="styles.css">

    <!-- hCaptcha -->
    <script src='https://www.hCaptcha.com/1/api.js' async defer></script>

    <title>Arecibo</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="assets/static_pages/favicon.ico">
    <link rel="apple-touch-icon" href="assets/static_pages/favicon_original.png">
    <link rel="image_src" href="assets/static_pages/favicon_original.png">
</head>

<body>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <div class="content bg-dark">
        <!-- noscript -->
        <noscript>
            <p class="text-danger text-center fs-5">Arecibo needs javascript to work</p>
        </noscript>

        <div class="container-fluid mt-4">
            <div class="container col-xxl-8 px-4 py-5">
                <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
                    <div class="col-10 col-sm-8 col-lg-6">
                        <img src="assets/static_pages/arecibo_logo.svg" class="d-block mx-lg-auto img-fluid" alt="Arecibo" loading="lazy" width="700" height="500">
                    </div>
                    <div class="col-lg-6">
                        <h1 class="display-5 fw-bold lh-1 mb-3 text-light">Radio signal observation network</h1>
                        <p class="lead text-light mb-5">Add, upload, analyze and share your signal observations on Arecibo. Download audio samples of posted signals. See the reports of the signals.</p>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                            <a href="signin.php"><button type="button" class="btn btn-outline-primary btn-lg px-4 me-md-2">Log in</button></a>
                            <a href="signup.php"><button type="button" class="btn btn-outline-secondary btn-lg px-4">Sign up</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <footer class="footer">
        <div class="sticky-bottom container-fluid d-grid gap-2">
            <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-2 mt-0">
                <div class="col-md-4 d-flex align-items-center ms-1">
                    <span class="text-muted"><a href="https://tortillum.com/frameio/commencer.html">©</a> 2022 Tortillum</span>
                </div>

                <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                    <li class="me-1">
                        <a class="text-muted" href="https://twitter.com/tortillum">
                            <svg class="bi" width="24" height="24">
                                <use xlink:href="#twitter"></use>
                            </svg></a>
                    </li>
                </ul>
            </footer>
        </div>
    </footer>
</body>

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="twitter" viewBox="0 0 16 16">
        <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
    </symbol>
</svg>

</html>