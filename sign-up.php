<?php

require_once ('functions.php');
require_once ('config.php');
require_once ('data.php');
require_once ('userdata.php');

require_once ('init.php');
require_once ('config/db.php');

session_start();


if (!$link) {
    $error = mysqli_connect_error();
    $main_cont = renderTemplate('templates/error.php', ['error' => $error]);
}
else {
    $sql = 'SELECT `id`, `category` FROM categories';
    $result = mysqli_query($link, $sql);

    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
        $error = mysqli_error($link);
        $content = renderTemplate('templates/error.php', ['error' => $error]);
    }
    $nav_cont = renderTemplate('templates/cat_list.php', ['categories' => $categories]);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $form = $_POST;
        $required = ['email', 'password', 'name', 'contacts'];
        $errors = [];



        $sql = 'INSERT INTO users (`name`, `email`, `password_hash`) VALUES (?, ?, ?)' ;
        $password_hash = password_hash($form['password'], PASSWORD_DEFAULT);
        $stmt = db_get_prepare_stmt($link, $sql, [$form['name'], $form['email'], $password_hash]);
        $res = mysqli_stmt_execute($stmt);
        if ($res) {
            $lot_id = mysqli_insert_id($link);
            header('location: /yeticave/index.php');
        }
        else {
            $main_cont = renderTemplate('templates/error.php', ['error' => mysqli_error($link)]);
        }


        foreach ($required as $field) {
            if (empty($form[$field])) {
                $errors[$field] = 'Єто поле надо заполнить';
            }
        }


        if (count($errors)) {
            $main_cont = renderTemplate('templates/sign-up.php', [
                'nav_cont' => $nav_cont,
                'form' => $form,
                'errors' => $errors
            ]);
        }
        else {
            header("Location: /yeticave/index.php");
            exit();
        }
    }
    else {
        $main_cont = renderTemplate('templates/sign-up.php', ['nav_cont' => $nav_cont, 'lot_list' => $lot_list, 'lot_time_remaining' => $remaining]);
    }
}


$header_cont = renderTemplate('templates/header-common.php', []);
$footer_cont = renderTemplate('templates/footer-common.php', ['nav_cont' => $nav_cont]);

$layout_cont = renderTemplate('templates/layout.php', [
    'title' => $title,
    'username' => $_SESSION['user']['name'],
    'header_cont' => $header_cont,
    'content' => $main_cont,
    'footer_cont' => $footer_cont
]);

print($layout_cont);
