<?php

// status account
$status_admin_user = -1; // admin user

// id_user to username
function idToUsername($id_user)
{
    include "dbconnect.php";

    if ($stmt = $con->prepare('SELECT username FROM accounts WHERE id = ?')) {
        $id_user = (int)$id_user;
        $stmt->bind_param('i', $id_user);
        $stmt->execute();
        $stmt->store_result();

        do {
            $stmt->bind_result($username);

            if (!empty($username)) {
                return htmlentities($username, ENT_QUOTES, 'UTF-8');
            }
        } while ($row = $stmt->fetch());
    } else {
        echo 'error';
    }

    $stmt->close();
    return 'anonyme';
}

// username to id_user
function usernameToId($username)
{
    include "dbconnect.php";

    if ($stmt = $con->prepare('SELECT id FROM accounts WHERE username LIKE ?')) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        do {
            $stmt->bind_result($id_user);

            if (!empty($id_user)) {
                return (int)$id_user;
            }
        } while ($row = $stmt->fetch());
    } else {
        echo 'error';
    }

    $stmt->close();
    return 0;
}

function checkIfAuthor($id_post)
{
    include "dbconnect.php";
    global $status_admin_user;

    $id_post = (int)$id_post;

    if ($stmt = $con->prepare('SELECT id_author FROM posts WHERE id = ?')) {
        $stmt->bind_param('i', $id_post);
        $stmt->execute();
        $stmt->store_result();

        do {
            $stmt->bind_result($id_author);

            if ($_SESSION['id'] === $id_author || $_SESSION['account_status'] === $status_admin_user) {
                return true;
            }
        } while ($row = $stmt->fetch());
    } else {
        return false;
    }

    $stmt->close();
    return false;
}

function isAdmin()
{
    global $status_admin_user;
    if ($_SESSION['account_status'] === $status_admin_user) { // Admin
        return true;
    }

    return false;
}

function getApiKey($id_user)
{
    include "dbconnect.php";
    include "connected.php";

    if ($stmt = $con->prepare('SELECT api_key FROM accounts WHERE id = ?')) {
        $id_user = (int)$id_user;
        $stmt->bind_param('i', $id_user);
        $stmt->execute();
        $stmt->store_result();

        do {
            $stmt->bind_result($api_key);

            if (!empty($api_key)) {
                return htmlentities($api_key, ENT_QUOTES, 'UTF-8');
            }
        } while ($row = $stmt->fetch());
    } else {
        echo 'error';
    }

    $stmt->close();
    return 'Please reset API Key.';
}

function checkApiKey($api_key)
{
    include "dbconnect.php";

    if ($stmt = $con->prepare('SELECT id FROM accounts WHERE api_key = ?')) {
        $stmt->bind_param('s', $api_key);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return TRUE;
        } else {
            return FALSE;
            exit;
        }

        $stmt->close();
    }
}

function checkBotApiKey($api_key)
{
    include "dbconnect.php";

    if ($stmt = $con->prepare('SELECT id FROM bots WHERE api_key = ?')) {
        $stmt->bind_param('s', $api_key);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return TRUE; // OK
        } else {
            return FALSE;
        }

        $stmt->close();
    }
}

function checkPassword($id_user, $password)
{
    include "dbconnect.php";
    include "connected.php";

    if ($stmt = $con->prepare('SELECT password FROM accounts WHERE id = ?')) {
        $stmt->bind_param('i', $id_user);
        $stmt->execute();
        $stmt->store_result();

        do {
            $stmt->bind_result($hash_password);

            if (!empty($hash_password)) {
                if (password_verify($password, $hash_password)) {
                    return TRUE;
                }
            }
        } while ($row = $stmt->fetch());
    } else {
        echo FALSE;
    }

    $stmt->close();
    return FALSE;
}

function getPostIDWithoutAutoReport()
{
    include "dbconnect.php";

    if ($stmt = $con->prepare('SELECT id FROM posts WHERE CHAR_LENGTH(filename_sample) > 0 AND CHAR_LENGTH(report_result) <= 0')) {
        $stmt->execute();
        $stmt->store_result();
        do {
            $stmt->bind_result($id);

            if (!empty($id)) {
                return $id;
            }
        } while ($row = $stmt->fetch());
    } else {
        return -1;
    }

    $stmt->close();
    return -1;
}

function getPathSample($id)
{
    include "dbconnect.php";
    include "config.php";

    if ($stmt = $con->prepare('SELECT filename_sample FROM posts WHERE id = ?')) {
        $id = (int)$id;
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();

        do {
            $stmt->bind_result($filename_sample);

            if (!empty($filename_sample)) {
                // Generate path
	        	$uploadfile_sample = $uploaddir_samples . $filename_sample;
                return htmlentities($uploadfile_sample, ENT_QUOTES, 'UTF-8');
            }
        } while ($row = $stmt->fetch());
    } else {
        return '';
    }

    $stmt->close();
    return '';
}

function getRelativePathSample($id)
{
    include "dbconnect.php";
    include "config.php";

    if ($stmt = $con->prepare('SELECT filename_sample FROM posts WHERE id = ?')) {
        $id = (int)$id;
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();

        do {
            $stmt->bind_result($filename_sample);

            if (!empty($filename_sample)) {
                // Generate path
	        	$uploadfile_sample = $uploaddir_path_samples . $filename_sample;
                return htmlentities($uploadfile_sample, ENT_QUOTES, 'UTF-8');
            }
        } while ($row = $stmt->fetch());
    } else {
        echo '';
    }

    $stmt->close();
    return '';
}

function getPathSpectrogram($id)
{
    include "dbconnect.php";
    include "config.php";

    if ($stmt = $con->prepare('SELECT filename_spectrogram FROM posts WHERE id = ?')) {
        $id = (int)$id;
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();

        do {
            $stmt->bind_result($filename_spectrogram);

            if (!empty($filename_spectrogram)) {
                // Generate path
	        	$uploadfile_spectrogram = $uploaddir_spectrograms . $filename_spectrogram;
                return htmlentities($uploadfile_spectrogram, ENT_QUOTES, 'UTF-8');
            }
        } while ($row = $stmt->fetch());
    } else {
        return '';
    }

    $stmt->close();
    return '';
}

function getRelativePathSpectrogram($id)
{
    include "dbconnect.php";
    include "config.php";

    if ($stmt = $con->prepare('SELECT filename_spectrogram FROM posts WHERE id = ?')) {
        $id = (int)$id;
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();

        do {
            $stmt->bind_result($filename_spectrogram);

            if (!empty($filename_spectrogram)) {
                // Generate path
	        	$uploadfile_spectrogram = $uploaddir_path_spectrograms . $filename_spectrogram;
                return htmlentities($uploadfile_spectrogram, ENT_QUOTES, 'UTF-8');
            }
        } while ($row = $stmt->fetch());
    } else {
        return '';
    }

    $stmt->close();
    return '';
}

function echoListUsers()
{
    include "dbconnect.php";
    include "config.php";

    global $status_admin_user;

    if(!isAdmin()){
        return '';
    }

    if ($stmt = $con->prepare('SELECT * FROM accounts')) {
        $stmt->execute();
        $stmt->store_result();

        do {
            $stmt->bind_result($id, $account_status, $username, $password, $api_key);
            if(!empty($id)){
                echo '<tr>
                <th scope="row">'.$id.'</th>';
                if($account_status == $status_admin_user){
                    echo '<td class="text-danger fw-bold text-break">'.htmlentities($username, ENT_QUOTES, 'UTF-8').'</td>';
                } else {
                    echo '<td>'.htmlentities($username, ENT_QUOTES, 'UTF-8').'</td>';
                }
                echo '<td class="text-break"><div class="input-group input-group-sm"><input class="form-control" type="text" aria-label="API_KEY" value="'.$api_key.'"></div></td>
                <td><a href="search.php?se='.$username.'" class="card-link"><span class="mb-0 btn btn-sm btn-outline-dark">&#128269;</span></a>
                <a href="daaccount.php?id='.$id.'" class="card-link"><span class="mb-0 btn btn-sm btn-outline-danger">&#128465;</span></a></td>
                </tr>';
            }
        } while ($row = $stmt->fetch());
    } else {
        echo '';
    }

    $stmt->close();
    return '';
}

function echoListBots()
{
    include "dbconnect.php";
    include "config.php";

    global $status_admin_user;

    if(!isAdmin()){
        return '';
    }

    if ($stmt = $con->prepare('SELECT * FROM bots')) {
        $stmt->execute();
        $stmt->store_result();

        do {
            $stmt->bind_result($id, $username, $api_key);
            if(!empty($id)){
                echo '<tr>
                <th scope="row">'.$id.'</th>
                <td class="text-break">'.htmlentities($username, ENT_QUOTES, 'UTF-8').'</td>
                <td class="text-break"><div class="input-group input-group-sm"><input class="form-control" type="text" aria-label="API_KEY" value="'.$api_key.'"></div></td>
                <td><a href="search.php?se='.$username.'" class="card-link"><span class="mb-0 btn btn-sm btn-outline-dark">&#128269;</span></a>
                <a href="rbotapikey.php?id='.$id.'" class="card-link"><span class="mb-0 btn btn-sm btn-outline-dark">&#128259;</span></a>
                <a href="dbot.php?id='.$id.'" class="card-link"><span class="mb-0 btn btn-sm btn-outline-danger">&#128465;</span></a></td>
                </tr>';
            }
        } while ($row = $stmt->fetch());
    } else {
        echo '';
    }

    $stmt->close();
    return '';
}

function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        // Le modifieur 'G' est disponible
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }

    return $val;
}

function getNbSignals()
{
    include "dbconnect.php";
    include "config.php";

    if ($stmt = $con->prepare('SELECT COUNT(*) FROM posts')) {
        $stmt->execute();
        $stmt->store_result();

        do {
            $stmt->bind_result($nbPosts);

            if (!empty($nbPosts)) {
                return htmlentities($nbPosts, ENT_QUOTES, 'UTF-8');
            }
        } while ($row = $stmt->fetch());
    } else {
        return '0';
    }

    $stmt->close();
    return '0';
}

function getNbUsers()
{
    include "dbconnect.php";
    include "config.php";

    if ($stmt = $con->prepare('SELECT COUNT(*) FROM accounts')) {
        $stmt->execute();
        $stmt->store_result();

        do {
            $stmt->bind_result($nbUsers);

            if (!empty($nbUsers)) {
                return htmlentities($nbUsers, ENT_QUOTES, 'UTF-8');
            }
        } while ($row = $stmt->fetch());
    } else {
        return '0';
    }

    $stmt->close();
    return '0';
}