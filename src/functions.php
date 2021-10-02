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
        echo "<td>" . $address->Street . ", " . $address->City . ", " . $address->State. ", ". $address->Zip . ", " . $address->Country . "</td>";
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
