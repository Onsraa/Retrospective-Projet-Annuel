<?php

try {
    $bdd = new PDO('mysql:host=localhost;dbname=retrospective', 'retro', 'TeSeAn070422!', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

?>