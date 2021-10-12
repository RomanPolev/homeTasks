<?php

// Коннект к БД
$link = mysqli_connect("db", "bitrix", "123", "bitrix");

// Обработка ошибки подключения
if ($link == false) {
    print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
}

// Укладываем параметры из адресной строки (кажется лучше использовать POST запрос, но с ним в докере проблемы)
$attributes = [
    "name" => $_GET["name"],
    "phone" => $_GET["phone"],
    "email" => $_GET["email"],
    "street" => $_GET["street"],
    "home" => $_GET["home"],
    "part" => $_GET["part"],
    "appt" => $_GET["appt"],
    "floor" => $_GET["floor"],
    "comment" => $_GET["comment"],
];

// SQL запрос для получения записи с данным email
$sel = "SELECT * FROM users WHERE email = \"$attributes[email]\"";

// SQL запрос для инкрементирования счётчиков заказов
$increment_count = "UPDATE users SET order_count = order_count + 1 WHERE email = \"$attributes[email]\"";

// SQL для вставки записи в таблицу
$registration = "INSERT INTO users (email, name, phone, order_count) VALUES (\"$attributes[email]\", \"$attributes[name]\", \"$attributes[phone]\", 1)";

// SQL для добавления записи в таблицу orders
$add_order = "INSERT INTO orders (email, address, comment) VALUES (\"$attributes[email]\", \"улица $attributes[street], дом $attributes[home], корпус $attributes[part], квартира $attributes[appt],  этаж $attributes[floor]\", \"$attributes[comment]\")";

// Пытаемся найти в базе запись email (обрабатываем лишь одну строку, потому что email - уникальны)
$result = mysqli_fetch_assoc(mysqli_query($link, $sel));

if ($result) {  // Если нашли, инкрементируем счётчик заказов, создаём запись в таблице orders
    mysqli_query($link, $increment_count);
    mysqli_query($link, $add_order);
} else { // Иначе, создаём запись, инициализируем счётчик единицей, создаём запись в таблице orders
    mysqli_query($link, $registration);
    mysqli_query($link, $add_order);
}

// Получение id заказа
$order_id = mysqli_fetch_assoc(mysqli_query($link, "SELECT MAX(id) FROM orders"))["MAX(id)"];

// Получение значения счётчика заказов
$count = mysqli_fetch_assoc(mysqli_query($link, "SELECT order_count FROM users WHERE email = \"$attributes[email]\""))["order_count"];

$file = "../mail/mails.txt";
$current = file_get_contents($file);
$current .= "To: " . $attributes["email"] . "\n" . "Order id: " . $order_id . "\n" . "<p>Ваш заказ: DarkBeefBurger - 1 шт. = 500р.</p><p>Спасибо, это ваш $count заказ</p>" . "\n" . "Дата отправки: " . date("d.m.Y H:m") . "\n";
file_put_contents($file, $current);