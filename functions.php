<?php
function renderTemplate($path, $array) {
    if (file_exists($path)) {
        ob_start();  //Turn on buffering
        extract($array); //Import variables from array
        require_once($path);//Connect $path
        return ob_get_clean(); //Get current buffer
    }
    return "";
}

function format_t($test) {
    $other = ceil($test);
    if ($other >= 1000) {
        $other = number_format($test, 0, '', ' ');
    }
    $other .= ' <b class="rub">р</b>' ;
    return $other;
}

function searchUserByEmail($email, $users) {
    $result = null;
    foreach ($users as $user) {
        if ($user['email'] == $email) {
            $result = $user;
            break;
        }
    }
    return $result;
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
}

function show_error(&$content, $error) {
    $content = renderTemplate('templates/error.php', ['error' => $error]);
}



/**
 * получение списка категорий
 *
 * @param array $connection ресурс подключения
 * @return array список категорий
 */
function getItemList($connection) {
    $sql = 'SELECT c.id, c.category FROM categories c ORDER BY c.id';
    return checkResult($connection, $sql);
}

/**
 * проверка запроса и возврат результатов выборки
 *
 * @param array $connection ресурс подключения
 * @param string $sql текст запроса
 * @return array|null
 */
function checkResult($connection, $sql) {
    $mysqliResult = mysqli_query($connection, $sql);
    $error = '';
    if ($mysqliResult === false) {
        $error = mysqli_error($connection);
        print('Ошибка MySQL: '. $error);
        die();
    }
    $rows = mysqli_fetch_all($mysqliResult, MYSQLI_ASSOC );
    return $rows;
}
