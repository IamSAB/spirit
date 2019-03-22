<?php

require_once 'vendor/level-2/axel/axel.php';

$axel = new \Axel\Axel;
$axel->addModule(new Axel\Module\PSR4(__DIR__.'/Model', '\\Model'));
$axel->addModule(new Axel\Module\PSR4(__DIR__.'/Controller', '\\Controller'));
$axel->addModule(new Axel\Module\PSR4(__DIR__.'/View', '\\View'));
$axel->addModule(new Axel\Module\PSR4(__DIR__.'/vendor/level-2/maphper/Maphper', '\\Maphper'));
