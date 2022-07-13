<?php

include('../includes/servers/db.php');
$q = 'SELECT is_banned, email FROM USERS WHERE id = ?';
$req = $bdd->prepare($q);
$req->execute([$_POST['id']]);
$results = $req->fetch();

include('gmail.php');
$subject = (($results['is_banned']) ? 'Unban' : 'Ban') . ' notification';
$message = '<h1>You have been ' . (($results['is_banned']) ? 'unbanned' : 'banned') . '</h1>
            <h3>by the staff of Retrospective</h3>';

if (!$results['is_banned'])
{
  $message = $message . '<p>We are sorry to inform you that, due to a non-respect of our terms and policy, your account has been banned from our website.</p>
                        <small>For any further information or if you have a reclamation, please <a href="http://152.228.217.209/contactUs.php">contact us</a>. Retrospective ©></small>';
  $altMessage = 'You have been banned by the staff of Retrospective. 
                We are sorry to inform you that, due to a non-respesct of our terms and policy, your account has been banned from our website. 
                For any further information or if you have a reclamation, please contact us : http://152.228.217.209/contactUs.php. Retrospective ©';
} else {
  $message = $message . '<p>We are pleased to inform you that your account has been unbanned from our website.</p>
                        <small>For any further information or if you have a reclamation, please <a href="http://152.228.217.209/contactUs.php">contact us</a>. Retrospective ©></small>';
  $altMessage = 'You have been unbanned by the staff of Retrospective. 
                We are pleased to inform you that your account has been unbanned from our website.
                For any further information or if you have a reclamation, please contact us : http://152.228.217.209/contactUs.php. Retrospective ©';
}

sendMail($subject, $message, $altMessage, $results['email']);

$q = 'UPDATE USERS SET is_banned = (is_banned+1)%2 WHERE id = ?';
$req = $bdd->prepare($q);
$req->execute([$_POST['id']]);

header('location: ../admin.php?page=users');
?>