<?php
include('db.php');

$q = 'SELECT COUNT(*) FROM ' . $stat;
$req = $bdd->prepare($q);
$req->execute(['table' => $stat]);
$results = $req->fetch();

$statPath = $path . "/" . $stat . ".txt";

$stat = file_get_contents($statPath);
$stat_lines = explode("\n", $stat);
$last_line = explode(' - ', $stat_lines[sizeof($stat_lines)-1]);


if ($last_line[0] != date('d/m/Y')){
    array_push($stat_lines, "\n");
}

$stat_lines[sizeof($stat_lines)-1] = date('d/m/Y') . ' - ' . $results[0];

var_dump($stat_lines);

unlink($statPath);
file_put_contents($statPath, implode("\n", $stat_lines));
?>
