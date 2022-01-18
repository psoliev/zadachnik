<?php

$html = file_get_contents("https://alef.im");

$dom = new DOMDocument;
$dom->loadHTML($html);

$node = $dom->getElementsByTagName('a');
$countZ = 0;
for ($i = 0; $i < $node->length; $i++) {
    $text = mb_strtolower($node->item($i)->textContent);
    $countZ += mb_substr_count($text,"з");
}
echo 'Буква "з" встречается '.$countZ.' раз!';