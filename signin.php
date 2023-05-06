<!doctype html>
<html lang="en">

<?php
include "config.php";

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

    <title>Login - Arecibo</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="assets/static_pages/favicon.ico">
    <link rel="apple-touch-icon" href="assets/static_pages/favicon_original.png">
    <link rel="image_src" href="assets/static_pages/favicon_original.png">
</head>

<body>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <div class="content">
        <!-- noscript -->
        <noscript>
            <p class="text-danger text-center fs-5">Arecibo needs javascript to work</p>
        </noscript>

        <div class="d-flex justify-content-center text-center row mx-auto" style="width: 350px;">
            <?php
            $error = isset($_GET['err']) ? $_GET['err'] : -1; // -1 = OK

            if (strcmp($error, "0") == 0) { // You have successfully registered, you can now login!
                echo '<p class="text-success text-center fs-5 fw-light">You have successfully registered, you can now login!</p>';
            }

            if (strcmp($error, "1") == 0) { // Incorrect username and/or password!
                echo '<p class="text-danger text-center fs-5 fw-light">Incorrect username and/or password!</p>';
            }
            ?>

            <a href="index.php"><img class="my-5" src="assets/static_pages/min_arecibo_logo.svg" alt="" width="72" height="57"></a>
            <h1 class="h3 mb-3 fw-normal">Log in</h1>

            <form action="authenticate.php" method="post">
                <div class="form-floating">
                    <input type="text" class="form-control mb-1" id="username" name="username" placeholder="Username" autocomplete="off" required>
                    <label for="username">Username</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control mb-4" id="password" name="password" placeholder="Password" required>
                    <label for="password">Password</label>
                </div>

                <?php
                if(!empty($captcha_api_secret_key) && !empty($captcha_api_public_key)){
                    echo '<div class="h-captcha mb-3" data-sitekey="'.$captcha_api_public_key.'"></div>';
                }
                ?>
                <button class="btn btn-lg btn-primary" type="submit" value="submit">Login</button>
            </form>
        </div>
    </div>

    <footer class="footer">
        <div class="sticky-bottom container-fluid d-grid gap-2">
            <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-2 border-top">
                <div class="col-md-4 d-flex align-items-center ms-1">
                    <span class="text-muted">© 2021 Tortillum</span>
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