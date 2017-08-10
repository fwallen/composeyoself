<?php

require_once(__DIR__.'/../vendor/autoload.php');

use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

VarDumper::setHandler(function ($var) {
    $cloner = new VarCloner();
    $dumper = 'cli' === PHP_SAPI ? new CliDumper() : new HtmlDumper();

    $dumper->dump($cloner->cloneVar($var));
});

$var = (object)[
    'property_1' => 'First Property',
    'property_2' => 'Second Property',
    'property_3' => [
        'name' => 'Third Property',
        'someData' => [
            1,2,3
        ]
    ]
];
dump( $var );


