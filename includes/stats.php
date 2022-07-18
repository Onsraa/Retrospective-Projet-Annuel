<?php
include('servers/db.php');

$q = 'SELECT COUNT(id) as count FROM ' . $stat;
$req = $bdd->query($q);
$result = $req->fetch(PDO::FETCH_ASSOC);


$statPath = $path . "/" . $stat . ".txt";

$stat = file_get_contents($statPath);
$stat_lines = explode("\n", $stat);
$last_line = explode(' - ', $stat_lines[sizeof($stat_lines) - 1]);


if ($last_line[0] != date('d/m/Y')) {
    array_push($stat_lines, "\n");
}

$stat_lines[sizeof($stat_lines) - 1] = date('d/m/Y') . ' - ' . $result['count'];

unlink($statPath);
file_put_contents($statPath, implode("\n", $stat_lines));
