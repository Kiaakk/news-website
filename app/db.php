<?php
require '../../vendor/autoload.php';

function connectMongoDB()
{
    try {
        $client = new MongoDB\Client("mongodb://localhost:27017");
        return $client->BeritaNews;
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
