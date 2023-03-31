<?php
require_once "vendor/autoload.php";



$m = new Mustache_Engine(['entity_flags' => ENT_QUOTES]);

$template = "Dobry den vas ucet {{email}} ... vyhral v loterii 5kc";

$winner = [
    "email" => "patrik je maniak",
    "account" => "erem movie"
];

echo $m->render($template, $winner);