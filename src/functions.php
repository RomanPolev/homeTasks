<?php
/**
 * Created by PhpStorm.
 * User: z-player
 * Date: 25.09.21
 * Time: 16:35
 */

function task1()
{
    $xml = new SimpleXMLElement(file_get_contents('data.xml'));
    echo "<h1>Purchase Order</h1>";
    echo "<table width = '80%'><tr>";
    echo "<td><h3>Purchase Order Number: " . $xml->attributes()['PurchaseOrderNumber'] . "</h3></td>";
    echo "<td><h3>Order Date: " . $xml->attributes()['OrderDate'] . "</h3></td>";
    echo "</tr></table>";
    echo "<table border='1px solid black' width='60%'>";
    echo "<tr><th>Name</th><th>Address</th></tr>";

    foreach ($xml->Address as $address) {
        echo "<tr>";
        echo "<td>" . $address->Name . "</td>";
        echo "<td>" . $address->Street . ", " . $address->City . ", " . $address->State . ", " . $address->Zip . ", " . $address->Country . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    echo "<h4>Deilvery Notes</h4>";
    echo "<p>$xml->DeliveryNotes</p>";
    echo "<table border='1px solid black' width='100%'>";
    echo "<tr><th>Part Number</th><th>Product Name</th><th>Qnt</th><th>USPrice</th><th>Comment</th><th>Ship Date</th></tr>";
    foreach ($xml->Items->Item as $item) {
        echo "<tr>";
        echo "<td>" . $item->attributes()["PartNumber"] . "</td>";
        echo "<td>" . $item->ProductName . "</td>";
        echo "<td>" . $item->Quantity . "</td>";
        echo "<td>" . $item->USPrice . "</td>";
        if (count($item->Comment) > 0) {
            echo "<td>" . $item->Comment . "</td>";
        } else {
            echo "<td>-</td>";
        }
        if (count($item->ShipDate) > 0) {
            echo "<td>" . $item->ShipDate . "</td>";
        } else {
            echo "<td>-</td>";
        }
        echo "</tr>";

    }
    echo "</table>";
}

function task2()
{

    function difference($arr1, $arr2)
    {
        if (count($arr1) != count($arr2)) {
            return "Размеры массивов не равны, сравнение невозможно";
        }
        $outDiff = [];
        for ($i = 0; $i < count($arr1); $i++) {
            $diff = array_diff($arr1[$i], $arr2[$i]);
            if (!empty($diff)) {
                array_push($outDiff, ['key' => $i, $diff]);
            }
        }
        return $outDiff;
    }

    function randChangeData($arr)
    {
        if (rand(0, 1)) {
            $tmp = $arr[rand(0, 2)]["name"];
            $arr[rand(0, 2)]["name"] = $tmp;
        }
        return $arr;
    }

    function createF($path, $inputData)
    {
        $fd = fopen($path, 'w') or die("<h1>не удалось открыть файл</h1>");
        fwrite($fd, $inputData);
        fclose($fd);
    }

    function readF($path)
    {
        $fd = fopen($path, 'r') or die("не удалось открыть файл");
        while (!feof($fd)) {
            $str = fgets($fd);
            echo $str . "<br /><br />";
        }
        fclose($fd);
    }

    $arr = [
        [
            'name' => 'Александр',
            'age' => 32,
            'job' => 'Программист'
        ],
        [
            'name' => 'Анастасия',
            'age' => 33,
            'job' => 'Визажист'
        ],
        [
            'name' => 'Иван',
            'age' => 29,
            'job' => 'Лесоруб'
        ]
    ];

    createF("output.json", json_encode($arr));
    readF("output.json");

    $arr2 = randChangeData($arr);
    createF("output2.json", json_encode($arr2));
    readF("output.json");

    var_dump($arr);
    var_dump($arr2);

    var_dump(difference($arr, $arr2));
}

function task3()
{
    $arr = [];
    for ($i = 0; $i < 50; $i++) {
        array_push($arr, rand(1, 100));
    }
    $fp = fopen("output3.csv", "w");
    fputcsv($fp, $arr, ";", "/");
    fclose($fp);
    var_dump($arr);


    if (($fp = fopen("output3.csv", "r")) !== false) {
        while (($data = fgetcsv($fp, 0, ";")) !== false) {
            $list[] = $data;
        }
        fclose($fp);
        $sum = 0;
        foreach ($list[0] as $key => $value) {
            if ($key % 2 == 0) {
                $sum += $value;
            }
        }
        var_dump($list);
        echo "<h1>${sum}</h1>";
    }
}

function task4()
{
    $info = file_get_contents("https://en.wikipedia.org/w/api.php?action=query&titles=Main%20Page&prop=revisions&rvprop=content&format=json");
    $res = json_decode($info, true);
    foreach ($res["query"]["pages"] as $page) {
        var_dump($page["pageid"]);
        var_dump($page["title"]);
    }
//    var_dump($res);
}

