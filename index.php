<?php
ini_set('max_execution_time', 900); // увеличить время обработки скрипта
ini_set("display_errors",1);        // ошибки
error_reporting(E_ALL);

require('Dijkstra.php');                                // Подключение файла // https://www.sitepoint.com/data-structures-4/
require('Graph.php');                                   // https://www.sitepoint.com/data-structures-4/
require('GraphCreator.php');

$words = "dump.txt";
$first_word = "Лужа";
$finish_word = "Море";
$filename = 'graph.txt';
$data = file_get_contents($filename);
if($data == null){
    $graphCreator = new GraphCreator;
    $graph = $graphCreator->createGraphFromFile($words);
    $data = serialize($graph);
    file_put_contents($filename, $data);
} else {
    $graph = unserialize($data);
}

$g = new Dijkstra($graph);                      // нужно создать отдельные графы для реализации с указанием наименьшей длины

// least number of hops between D and C
$g->shortestPath($first_word, $finish_word);  // https://www.sitepoint.com/data-structures-4/
echo "<br>\n";
$g = new Graph($graph);

// least number of hops between D and C
$g->breadthFirstSearch($first_word, $finish_word); // https://www.sitepoint.com/data-structures-4/
echo "<br>";

exit();

$graph = array(
    'A' => array('B' => 3, 'D' => 3, 'F' => 6),
    'B' => array('A' => 3, 'D' => 1, 'E' => 3),
    'C' => array('E' => 2, 'F' => 3),
    'D' => array('A' => 3, 'B' => 1, 'E' => 1, 'F' => 2),
    'E' => array('B' => 3, 'C' => 2, 'D' => 1, 'F' => 5),
    'F' => array('A' => 6, 'C' => 3, 'D' => 2, 'E' => 5),
);

$graph = array(
    'A' => array('B', 'F'),
    'B' => array('A', 'D', 'E'),
    'C' => array('F'),
    'D' => array('B', 'E'),
    'E' => array('B', 'D', 'F'),
    'F' => array('A', 'E', 'C'),
);

