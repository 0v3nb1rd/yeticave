<?php

require_once ('functions.php');
require_once ('config.php');
require_once ('data.php');

session_start();

$page_cont = renderTemplate('templates/index.php', [
    'lot_list' => $lot_list,
    'lot_time_remaining' => $remaining
]);

$layout_cont = renderTemplate('templates/layout.php', [
    'title' => $title,
    'username' => $_SESSION['user']['name'],
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'user_avatar' => $user_avatar,
    'content' => $page_cont,
    'category_arr' => $category_arr
]);

//print($layout_cont);


//if ($config['enable']) {
//    $content = require_once ($config['tpl_path'] . 'layout.php');
//} else {
//    $error_msg = "Сайт на ремонте =)";
//    $content =require_once ($config['tpl_path'] . 'layout.php');
//}

print($layout_cont);
