<?php
require __DIR__ . '/creaPDF/vendor/autoload.php';
use \CloudConvert\Api;
 
$api = new Api("F1mCjAZMl83tAfLpzoYXGbShr52hLSocTEm3c4wDgnCBKvQ2o_beWj5nu1_w4JAyeVw-cnbVCm6-W2htVHPwtg");
 
$api->convert([
    "inputformat" => "rtf",
    "outputformat" => "pdf",
    "input" => "upload",
    "file" => fopen('C:\xampp\htdocs\conectaSQLSRV\quirofano\eliminar\quirofano.rtf', 'r'),
])
->wait()
->download('quirofano.pdf');
?>