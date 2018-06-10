<?php

require_once ('functions.php');
require_once ('config.php');
//require_once ('data.php');
require_once ('init.php');

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
    $sql = 'SELECT l.id, l.name, c.category, l.image, l.lot_rate FROM lots l '
        . 'JOIN categories c ON l.category_id = c.id '
        .'ORDER BY id DESC LIMIT 9';

    if ($res = mysqli_query($link, $sql)) {
        $lots = mysqli_fetch_all($res, MYSQLI_ASSOC);
        $main_cont = renderTemplate('templates/index.php', ['lot_list' => $lots, 'lot_time_remaining' => $remaining]);
    }

    $nav_cont = renderTemplate('templates/cat_list.php', ['categories' => $categories]);

}

$header_cont = renderTemplate('templates/header-common.php', ['user' => $_SESSION['user']]);
$footer_cont = renderTemplate('templates/footer-common.php', ['nav_cont' => $nav_cont]);

$layout_cont = renderTemplate('templates/layout.php', [
    'title' => $title,
    'main_class' => 'class="container"',
    'header_cont' => $header_cont,
    'content' => $main_cont,
    'footer_cont' => $footer_cont,
]);

print($layout_cont);
