<?php

// Коннект к БД
$link = mysqli_connect("db", "bitrix", "123", "bitrix");

// Обработка ошибки подключения
if (!$link) {
    print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
}

$result = mysqli_query($link, "SELECT * FROM users");

echo "<table style='border: 1px solid black;'><caption>Таблица зарегистрированных заказчиков</caption><tr><th>Email</th><th>Name</th><th>Phone</th><th>Order count</th></tr>";
while ($row = mysqli_fetch_row($result)) {
    echo "<tr>";
    for ($i = 0; $i < count($row); $i++) {

        echo "<td style='text-align: center; padding: 0px 10px'>${row[$i]}</td>";
    }
    echo "</tr>";
}
echo "</table><br /><br /><br />";

$result = mysqli_query($link, "SELECT * FROM orders");

echo "<table style='border: 1px solid black;'><caption>Таблица заказов</caption><tr><th>Email</th><th>id</th><th>Address</th><th>Comment</th></tr>";
while ($row = mysqli_fetch_row($result)) {
    echo "<tr>";
    for ($i = 0; $i < count($row); $i++) {

        echo "<td style='text-align: center; padding: 0px 10px'>${row[$i]}</td>";
    }
    echo "</tr>";
}