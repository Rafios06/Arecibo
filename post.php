<!doctype html>
<html lang="en">

<?php
//include "connected.php";
include "dbconnect.php";
include_once "getters.php";

session_start();

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

    <title>Signal - Arecibo</title>

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
                            <a class="nav-link dropdown-toggle" href="" id="dropdown09" data-bs-toggle="dropdown" aria-expanded="false">Signal</a>
                            <ul class="dropdown-menu" aria-labelledby="dropdown09">

                                <?php
                                if (isset($_SESSION['loggedin'])) {
                                    if (isAdmin()) {
                                        echo '<li><a class="dropdown-item text-danger" href="profile.php">' . htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8') . '</a></li>';
                                        echo '<li><a class="dropdown-item" href="adminp.php">Admin</a></li>';
                                    } else {
                                        echo '<li><a class="dropdown-item" href="profile.php">' . htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8') . '</a></li>';
                                    }
                                
                                    echo '<li>
                                    <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="add.php">Add signal</a></li>
                                    <li><a class="dropdown-item" href="activities.php">Activities</a></li>
                                    <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="signout.php">Sign out</a></li>';
                                } else {
                                    echo '<li><a class="dropdown-item" href="index.php">Home</a></li>';
                                }
                                ?>
                            </ul>
                        </li>
                    </ul>
                    <form action="search.php" method="POST" required>
                        <input class="form-control text-light bg-dark" type="text" placeholder="Search" name="s" id="s" maxlength="255" aria-label="Search">
                    </form>
                </div>
            </div>
        </nav>

        <div class="container-fluid mt-1 text-center">

            <?php
            $id_post = (int)$_GET['id'];
            $id_post = filter_var($id_post, FILTER_SANITIZE_NUMBER_INT);

            // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
            if ($stmt = $con->prepare('SELECT * FROM posts WHERE id = ?')) {
                $stmt->bind_param('i', $id_post);
                $stmt->execute();
                // Store the result so we can check if the account exists in the database.
                $stmt->store_result();

                $stmt->bind_result($id, $id_author, $title, $frequency, $time_reception, $signal_location, $signal_description, $filename_spectrogram, $filename_sample, $report_result);
                $row = $stmt->fetch();

                if (isset($id, $id_author, $title, $frequency, $time_reception, $signal_location, $signal_description)) {
                    if (!empty($id) && !empty($id_author) && !empty($title) && !empty($frequency) && !empty($time_reception) && !empty($signal_location) && !empty($signal_description)) {
                        $title = htmlentities($title, ENT_QUOTES, 'UTF-8');
                        $frequency = htmlentities($frequency, ENT_QUOTES, 'UTF-8');
                        $time_reception = htmlentities($time_reception, ENT_QUOTES, 'UTF-8');
                        $signal_location = htmlentities($signal_location, ENT_QUOTES, 'UTF-8');
                        $signal_description = htmlentities($signal_description, ENT_QUOTES, 'UTF-8');

                        //<!-- signal -->
                        echo '<div class="mb-1">
            <a class="link-primary fw-bold text-dark" href="post.php?id=' . $id . '">
                <p class="mb-1 fs-5" style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">' .
                            $title . '</p>
            </a>
            <a href="search.php?se=' . $frequency . '"><span class="badge bg-primary">' . $frequency . '</span></a>' . PHP_EOL;
                        if (!empty($report_result)) {
                            echo '<a href="search.php?se=tag:report"><span class="badge bg-secondary">Automatic Report</span></a>' . PHP_EOL;
                        }
                        if (!empty($filename_sample)) {
                            echo '<a href="search.php?se=tag:sample"><span class="badge bg-secondary">Sample</span></a>' . PHP_EOL;
                        }
                        echo '<a href="search.php?se=' . idToUsername($id_author) . '"><span class="badge bg-secondary">' . idToUsername($id_author) . '</span></a>
            <a href="search.php?se=' . $signal_location . '"><span class="badge bg-secondary">' . $signal_location . '</span></a>
            <a href="search.php?se=' . explode(" ", $time_reception)[0] . '"><span class="badge bg-secondary">' . $time_reception . '</span></a>
            <p class="text-start fw-light mb-0 mt-1">Description</p>
            <p class="text-start border border-secondary mx-auto" style="text-overflow: ellipsis; white-space: pre-line; word-wrap: break-word;">' . $signal_description . '</p>';

                        if (!empty($report_result)) {
                            echo '<p class="text-start fw-light mb-0 mt-1">Automatic report</p>
                <div class="border border-secondary">
                <p class="text-start mx-auto" style="text-overflow: ellipsis; white-space: pre-line; word-wrap: break-word;">' . htmlentities($report_result, ENT_QUOTES, 'UTF-8') . '</p>';
                            echo '<img src="' . getRelativePathSpectrogram($id) . '" class="img-fluid mt-1" alt="Spectrogram"></div>';
                        }
                        if (!empty($filename_sample)) {
                            echo '<a class="link-secondary btn btn-secondary btn-sm text-decoration-none text-light mt-3" href="' . getRelativePathSample($id) . '">Download sample</a>';
                        }
                        echo '</div>';
                        echo '<a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-hashtags="Arecibo #SDR" data-text="'. urlencode($frequency . ' - ' . $title) .'" data-size="large" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>';
                        
                        global $status_admin_user;

                        if ($_SESSION['account_status'] === $status_admin_user || $_SESSION['id'] === $id_author) { // Admin or author
                            echo '<hr class="bg-danger border-2 border-top border-danger ms-2 me-2">
                        <a class="link-secondary btn btn-secondary btn-sm text-decoration-none text-light" href="edit_signal.php?id=' . $id_post . '">Edit</a>
                        <a class="link-secondary ms-1 btn btn-danger btn-sm text-decoration-none text-light" href="delete_signal.php?id=' . $id_post . '">Delete signal</a>';
                            if (!empty($filename_sample)) {
                                echo '<a class="link-secondary ms-1 btn btn-danger btn-sm text-decoration-none text-light" href="dsample.php?id=' . $id_post . '">Delete sample</a>';
                            }
                        }
                    } else {
                        echo '<p class="fs-3">Error ID</p>';
                        echo '<script>document.location.href="/activities.php";</script>';
                    }
                } else {
                    echo '<p class="fs-3">Error ID</p>';
                    echo '<script>document.location.href="/activities.php";</script>';
                }
                $stmt->close();
            } else {
                echo 'error';
            }
            ?>
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