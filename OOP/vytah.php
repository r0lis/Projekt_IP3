<?php
require_once("vytah.class.php");

$lift  = new Vytah(-1, 12);
echo $lift; // zavolá magickou __toString() a vypíše popis výtahu
echo "Patro: {$lift->getPatro()}"; //-1
$lift->nahoru(); //lze, vyjede
echo "Patro: {$lift->getPatro()}"; //0
$lift->dolu(); //lze, sjede
echo "Patro: {$lift->getPatro()}"; //-1
$lift->dolu(); //nelze, jen oznámí
echo "Patro: {$lift->getPatro()}"; //-1
$lift->azNahoru();
echo "Patro: {$lift->getPatro()}"; //1