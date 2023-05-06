<!doctype html>
<html lang="en">

<?php
include "connected.php";
include "dbconnect.php";
include "config.php";
include_once "getters.php";
include "setters.php";

if (!isAdmin()) {
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

    <title>Administration - Arecibo</title>

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

        <!-- navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Navigation bar">
            <div class="container-fluid">
                <a class="navbar-brand" href="activities.php">
                    <img class="bi mb-2" alt="Arecibo" loading="lazy" src="assets/static_pages/arecibo_logo.svg">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample09" aria-controls="navbarsExample09" aria-expanded="true" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="navbar-collapse collapse" id="navbarsExample09">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" id="dropdown09" data-bs-toggle="dropdown" aria-expanded="false">Administration</a>
                            <ul class="dropdown-menu" aria-labelledby="dropdown09">

                                <?php
                                if (isAdmin()) {
                                    echo '<li><a class="dropdown-item text-danger" href="profile.php">' . htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8') . '</a></li>';
                                    echo '<li><a class="dropdown-item" href="adminp.php">Admin</a></li>';
                                } else {
                                    echo '<li><a class="dropdown-item" href="profile.php">' . htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8') . '</a></li>';
                                }
                                ?>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="add.php">Add signal</a></li>
                                <li><a class="dropdown-item" href="activities.php">Activities</a></li>
                                <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="signout.php">Sign out</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form action="search.php" method="POST" required>
                        <input class="form-control text-light bg-dark" type="text" placeholder="Search" name="s" id="s" maxlength="255" aria-label="Search">
                    </form>
                </div>
            </div>
        </nav>

        <div class="card text-center mx-auto mt-5" style="width: 23rem;">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></h5>
                <?php
                if (isAdmin()) {
                    echo '<h6 class="card-subtitle mb-2 text-muted">Admin</h6>';
                } else {
                    echo '<h6 class="card-subtitle mb-2 text-muted">User</h6>';
                }
                ?>

                <hr class="border-1 border-dark ms-2 me-2">

                <h6 class="mb-2 text-muted" >Statistics</h6>

                <?php echo getNbSignals() . ' signals added - ' . getNbUsers() . ' users created'; ?>

                <hr class="border-1 border-dark ms-2 me-2">

                <h6 class="mb-2 text-muted" >Lists</h6>

                <?php
                if (isAdmin()) {
                    echo '<a href="list_users.php" class="card-link"><span class="mb-2 btn btn-sm btn-outline-dark">List Users</span></a></br>
                    <a href="list_bots.php" class="card-link"><span class="mb-0 btn btn-sm btn-outline-dark">List Bots</span></a></br>
                    <hr class="border-1 border-dark ms-2 me-2">';
                }
                ?>

                <h6 class="mb-2 text-muted" >Configuration</h6>

                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header mb-2" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                Accounts
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <?php if ($new_registration_account) {
                                echo '<h6 class="mb-1" style="text-align: start;">new_registration_account : enabled</h6>';
                            } else {
                                echo '<h6 class="mb-1" style="text-align: start;">new_registration_account : disabled</h6>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header mb-2" id="flush-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                Captcha (hCaptcha)
                            </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1">Secret key</span>
                                <input class="form-control" type="text" aria-describedby="basic-addon1" placeholder="API_SECRET_KEY" name="captcha_secret_key" id="captcha_secret_key" maxlength="255" aria-label="API_SECRET_KEY" <?php echo 'value="' . htmlentities($captcha_api_secret_key, ENT_QUOTES, 'UTF-8') . '"'; ?>>
                            </div>

                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1">Sitekey</span>
                                <input class="form-control" type="text" aria-describedby="basic-addon1" placeholder="API_PUBLIC_KEY" name="captcha_public_key" id="captcha_public_key" maxlength="255" aria-label="API_PUBLIC_KEY" <?php echo 'value="' . htmlentities($captcha_api_public_key, ENT_QUOTES, 'UTF-8') . '"'; ?>>
                            </div>

                            <?php if ($captcha_add_signal_enabled) {
                                echo '<h6 class="mb-1" style="text-align: start;">captcha_add_signal : enabled</h6>';
                            } else {
                                echo '<h6 class="mb-1" style="text-align: start;">captcha_add_signal : disabled</h6>';
                            }
                            ?>

                            <?php if ($captcha_edit_signal_enabled) {
                                echo '<h6 class="mb-1" style="text-align: start;">captcha_edit_signal : enabled</h6>';
                            } else {
                                echo '<h6 class="mb-1" style="text-align: start;">captcha_edit_signal : disabled</h6>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header mb-2" id="flush-headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                Samples
                            </button>
                        </h2>
                        <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                            <?php if ($enable_uploads) {
                                echo '<h6 class="mb-1" style="text-align: start;">enable_uploads : enabled</h6>';
                            } else {
                                echo '<h6 class="mb-1" style="text-align: start;">enable_uploads : disabled</h6>';
                            }
                            ?>

                            <?php if ($keep_sample_after_automatic_report) {
                                echo '<h6 class="mb-1" style="text-align: start;">keep_sample_after_automatic_report : enabled</h6>';
                            } else {
                                echo '<h6 class="mb-1" style="text-align: start;">keep_sample_after_automatic_report : disabled</h6>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header mb-2" id="flush-headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                Companion Automatic Report
                            </button>
                        </h2>
                        <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                            <?php if ($companion_automatic_report) {
                                echo '<h6 class="mb-1" style="text-align: start;">companion_automatic_report : enabled</h6>';
                            } else {
                                echo '<h6 class="mb-1" style="text-align: start;">companion_automatic_report : disabled</h6>';
                            }
                            ?>
                        </div>
                    </div>
                </div>

            </div>
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