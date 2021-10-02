<?php
/**
 * Created by PhpStorm.
 * User: z-player
 * Date: 24.09.21
 * Time: 11:55
 */


/**
 * @param $path - путь до создоваемого файла
 * @param $inputData - данные, которые будут записаны в файл
 */
function createF($path, $inputData)
{
    $fd = fopen($path, 'w') or die("<h1>не удалось открыть файл</h1>");
    fwrite($fd, $inputData);
    fclose($fd);
}

/**
 * @param $path - путь до файла, который будет открыт
 */
function readF($path)
{
    $fd = fopen($path, 'r') or die("не удалось открыть файл");
    while (!feof($fd)) {
        $str = fgets($fd);
        echo $str . "<br />";
        echo htmlentities($str);
    }
    fclose($fd);
}

//createF("/home/z-player/PhpstormProjects/test/testProject/app/test.txt", "Hello <b>again</b>");
createF("task12test.txt", "<h1>Hello again</h1>");
readF("task12test.txt");
