<?php

if($title == 'Connexion') {
    $path = "../logs";
    $line = date('Y/m/d - H:i:s') . ' - Tentative de connexion ' . (isset($_SESSION['email']) ? 'réussie' : 'échouée') . ' de : ' . (empty($_POST['email']) ? 'utilisateur non connecté (' . $_SERVER['REMOTE_ADDR'] . ').' : $_POST['email']);
} else if ($title == 'Inscription') {
    $path = "../logs";
    $line = date('Y/m/d - H:i:s') . ' - Tentative d\'inscription ' . (isset($_SESSION['email']) ? 'réussie' : 'échouée') . ' de : ' . (empty($_POST['email']) ? 'utilisateur non connecté (' . $_SERVER['REMOTE_ADDR'] . ').' : $_POST['email']);
} else if (preg_match('/^Admin_/', $title))
{
    $path = "logs";
    $line = date('Y/m/d - H:i:s') . ' - Tentative d\'accès aux fonctions admin ' . (isset($_SESSION['email']) ? 'réussie' : 'échouée') . ' de : ' . (isset($_SESSION['email']) ? $_SESSION['email'] : 'utilisateur non connecté (' . $_SERVER['REMOTE_ADDR'] . ').');
} else if ($title == 'Admin_users_verif') {
    $path = "../logs";
    $line = date('Y/m/d - H:i:s') . ' - Tentative de modification de ' . $_POST[0] . ' par ' . (isset($_SESSION['email']) ? $_SESSION['email'] : 'utilisateur non connecté (' . $_SERVER['REMOTE_ADDR'] . ').');
} else { 
    $path = "logs";
    $line = date('Y/m/d - H:i:s') . ' - Chargement de la page ' . $title . ' par ' . (isset($_SESSION['email']) ? $_SESSION['email'] : 'utilisateur non connecté (' . $_SERVER['REMOTE_ADDR'] . ').');
}

if (!file_exists($path))
{
    mkdir($path);
}

$file_log = $path . '/' . $title . '_logs.txt';
if (!file_exists($file_log))
{
    file_put_contents($file_log, "");
}

$log = file_get_contents($file_log);
$log_lines = explode("\n", $log);

$first_line = $log_lines[0];
if (explode(' - ', $first_line)[0] != 'Nombre de lignes'){
    array_unshift($log_lines, 'Nombre de lignes - 0' . "\n");
    $first_line = $log_lines[0];
}

$prev_line = $log_lines[count($log_lines)-1];
$prev_date = explode(' - ', $prev_line)[0];

if ($prev_date != date('Y/m/d')){
    array_push($log_lines, "\n" . 'Logs pour le ' . date('Y/m/d') . ':' . "\n");
}

array_push($log_lines, $line);

unlink($file_log);
file_put_contents($file_log, implode("\n", $log_lines));

?>