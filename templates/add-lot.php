<?php $class_name = isset($errors) ? "form--invalid" : "";?>

<?=$nav_cont;?>
<form class="form form--add-lot container <?=$class_name;?>" action="add-lot.php" method="post" enctype="multipart/form-data">
    <h2>Добавление лота</h2>

    <div class="form__container-two">

        <?php $class_name = isset($errors['Название']) ? "form__item--invalid" : "";
        $value = isset($lot['lot-name']) ? $lot['lot-name'] : ""?>
        <div class="form__item <?=$class_name;?>"> <!-- form__item--invalid -->
            <label for="lot-name">Наименование</label>
            <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?=$value;?>">
            <span class="form__error"></span>
        </div>

        <?php $class_name = isset($errors['Категория']) ? "form__item--invalid" : "";
        $value = isset($lot['category']) ? $lot['category'] : ""?>
        <div class="form__item <?=$class_name;?>">
            <label for="category">Категория</label>
            <select id="category" name="<?=$lot['category_id']; ?>">
                <option value="<?= $value;?>"></option>
                <option>Выберите категорию</option>
                <option>Доски и лыжи</option>
                <option>Крепления</option>
                <option>Ботинки</option>
                <option>Одежда</option>
                <option>Инструменты</option>
                <option>Разное</option>
            </select>
            <span class="form__error"></span>
        </div>
    </div>

    <?php $class_name = isset($errors['Описание']) ? "form__item--invalid" : "";
    $value = isset($lot['message']) ? $lot['message'] : ""?>
    <div class="form__item form__item--wide <?=$class_name;?>">
        <label for="message">Описание</label>
        <textarea id="message" name="message" placeholder="Напишите описание лота"><?= $value;?></textarea>
        <span class="form__error"></span>
    </div>

    <?php $class_name = isset($errors['Описание']) ? "form__item--invalid" : "";
    $value = isset($lot['photo_file']) ? $lot['photo_file'] : ""?>
    <div class="form__item form__item--file"> <!-- form__item--uploaded -->
        <label>Изображение</label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
            </div>
        </div>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="photo2" name="photo_file" value="<?= $value;?>">
            <label for="photo2">
                <span>+ Добавить</span>
            </label>
        </div>
    </div>
    <div class="form__container-three">

        <?php $class_name = isset($errors['Старт-цена']) ? "form__item--invalid" : "";
        $value = isset($lot['lot-rate']) ? $lot['lot-rate'] : ""?>
        <div class="form__item form__item--small <?=$class_name;?>">
            <label for="lot-rate">Начальная цена</label>
            <input id="lot-rate" type="number" name="lot-rate" placeholder="0" value="<?= $value;?>">
            <span class="form__error"></span>
        </div>

        <?php $class_name = isset($errors['Шаг ставки']) ? "form__item--invalid" : "";
        $value = isset($lot['lot-step']) ? $lot['lot-step'] : ""?>
        <div class="form__item form__item--small <?=$class_name;?>">
            <label for="lot-step">Шаг ставки</label>
            <input id="lot-step" type="number" name="lot-step" placeholder="0" value="<?= $value;?>">
            <span class="form__error"></span>
        </div>

        <?php $class_name = isset($errors['Дата завершения']) ? "form__item--invalid" : "";
        $value = isset($lot['lot-date']) ? $lot['lot-date'] : ""?>
        <div class="form__item <?=$class_name;?>">
            <label for="lot-date">Дата заверщения</label>
            <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="20.05.2017" value="<?= $value;?>">
            <span class="form__error"></span>
        </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.
    <?php foreach ($errors as $err => $val) : ?>
        <li><strong><?=$err;?>:</strong> <?=$val;?></li>
    <?php endforeach; ?>
    </span>
    <button type="submit" name="send" class="button">Добавить лот</button>
</form>
