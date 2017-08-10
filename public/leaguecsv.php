<?php

require_once('../vendor/autoload.php');

use League\Csv\Writer;
use League\Csv\Reader;

//For MacOs X you may need:
//if (!ini_get("auto_detect_line_endings")) {
//    ini_set("auto_detect_line_endings", '1');
//}

//Easily instantiate
$reader = Reader::createFromPath('league/read.csv');
echo $reader;
//$reader->output('downloaded.csv');

//Get all rows as an array
dump($reader->fetchAll());

//Get an iterator of associated rows
dump($reader->fetchAssoc());
foreach($reader->fetchAssoc() as $idx => $row) {
    dump($row);
}

echo $reader->toHTML();
echo '<br/>';
echo json_encode($reader);

$reader->addFilter(function($row,$rowOffset,$iterator) {
   if ($row[1] == 'PHPUgly') {
       return false;
   }

   return true;
});

dump('Using a filter',$reader->fetchAll());

$writer = Writer::createFromPath('league/write.csv','a+');
$header = [
    'ID', 'Name'
];

$rows = [
    [1, 'John'],
    [2, 'Eric'],
    [3, 'Thomas'],
    [4, 'PHPUgly'],
];

$writer->insertOne($header);
$writer->insertAll($rows);

$differentWriter = Writer::createFromPath('league/write_different.csv','a+');
$differentWriter->setDelimiter('|');
$differentWriter->insertOne($header);
$differentWriter->insertAll($rows);

dump($reader,$writer);
