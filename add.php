<!doctype html>
<html lang="en">

<?php
include "config.php";
include "connected.php";
include "dbconnect.php";
include_once "getters.php";
include "add_signal.php";

date_default_timezone_set('UTC');
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

    <script src='uploadfile.js'></script>

    <title>Add signal - Arecibo</title>

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
                            <a class="nav-link dropdown-toggle" href="" id="dropdown09" data-bs-toggle="dropdown" aria-expanded="false">Add signal</a>
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

        <div class="container-fluid mt-1">
            <form action="add_signal.php" method="POST"  enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="inputTitleSignal">Title</label>
                    <input placeholder="Title" type="text" class="form-control" id="titleSignal" name="titleSignal" maxlength="256" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label for="inputFrequency">Frequency</label>
                    <div class="input-group mb-2">
                        <input placeholder="Frequency" type="text" class="form-control" autocomplete="off" id="frequency" name="frequency" maxlength="32" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="inputDate">Date UTC</label>
                    <input placeholder="Date" value="<?= date('Y-m-d') ?>" id="date" name="date" type="date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="inputTimeUTC">Time UTC</label>
                    <input placeholder="Time UTC" value="<?= date('H:i') ?>" type="time" id="time" name="time" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="inputLocation">Receiver location</label>
                    <input placeholder="Receiver location" type="text" class="form-control" autocomplete="on" id="location" name="location" maxlength="192" required>
                </div>
                <div class="mb-3">
                    <label for="floatingTextareaDescription">Description</label>
                    <textarea class="form-control" placeholder="Description" autocomplete="off" rows="8" id="description" name="description" maxlength="5120"></textarea>
                </div>
                <?php
                if($enable_uploads){
                    echo '<hr class="dropdown-divider">
                    <div class="mb-3">
                        <p class="fs-6 mb-1">Upload sample</p>
                        <p class="fs-6 mb-2">Only WAV (mono) file. Size limit of 2 mb.</p>
                        <input type="hidden" name="MAX_FILE_SIZE" value="'. $max_sample_size .'" />
                        <input type="file" class="form-control mb-2" id="samplefile" name="samplefile" accept=".wav" onchange="checkSizeFile()">

                        <progress id="progressBar" value="0" max="100" style="display:none;"></progress>

                        <p id="size"></p>
                        <h4 id="status"></h4>
                        <p id="loaded_n_total"></p>
                    </div>
                    <hr class="dropdown-divider">';
                }

                if ($captcha_add_signal_enabled) {
                    echo '<div class="h-captcha" data-sitekey="'.$captcha_api_public_key.'"></div>';
                }
                ?>
                <input type="submit" name="submit" id="submit" value="SUBMIT" class="mt-2 mb-2 btn btn-dark">
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