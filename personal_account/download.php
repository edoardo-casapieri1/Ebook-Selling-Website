<?php

require_once realpath(__DIR__ . '/../vendor/autoload.php');

if (!isset($_GET["id"])) {

    http_response_code(404);
    exit();

} else if (!Session::is_user_logged_in()) {

    http_response_code(403);
    exit();

} else {

    $dao = new Dao();
    $file = $dao->get_path_to_ebook($_SESSION["user_id"], $_GET["id"]);

    if ($file === '') {
        http_response_code(403);
        exit();
    }

    $file = realpath('../' . $file);
    $filename = basename($file);

    if (file_exists($file)) {
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Type: application/epub+zip');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($file));
        header('Accept-Ranges: bytes');
        readfile($file);
        exit;
    } else {
        http_response_code(500);
        exit();
    }
}

