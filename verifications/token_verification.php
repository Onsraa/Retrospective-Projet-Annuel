<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Email verification</title>
</head>

<body>
    <main>
        <?php

        require('create_account_verification.php'); //Vérification des conditions de création de compte au préalable.

        if (isset($_GET('resend')) && !empty($_GET('resend')) && $_GET('resend') == 1 && isset($_GET('email')) && !empty($_GET('email'))) {

            $q = 'SELECT id FROM users WHERE email = ?';
            $req = $bdd->prepare($q);
            $req->execute([htmlspecialchars($_GET['email'])]);
            $result = $req->fetchAll(PDO::FETCH_ASSOC);

            $token = rand(222222, 999999);

            if (!empty($result)) {

                $q = 'UPDATE users SET token = ? WHERE email = ?';
                $req = $bdd->prepare($q);
                $result = $req->execute([$token, htmlspecialchars($_GET['email'])]);

                if ($result) {
                    require_once('gmail.php');

                    $subject = 'Retrospective verification code.';
                    $message = '<h1>Voici votre code de vérification : ' . $token . '</h1>';
                    $altMessage = 'Voici votre code de vérification : ' . $token;
                    $to = $_GET['email'];

                    sendMail($subject, $message, $altMessage, $to);
                } else {
                    echo '<p>Le renvoi du code a échoué</p>';
                }
            }
        }

        if (isset($_GET['token'])) { //Si le token a été envoyé en paramètre GET

            $q = 'SELECT id FROM users WHERE email = ? AND is_banned = ?'; //Pour éviter qu'une personne change la valeur d'is_banned dans la BDD en insérant dans l'URL son email et un token NULL en paramètre GET.
            $req = $bdd->prepare($q);
            $req->execute([htmlspecialchars($_GET['email']), 1]);
            $result = $req->fetchAll(PDO::FETCH_ASSOC);

            if (empty($result)) {

                $q = 'SELECT id FROM users WHERE email = ? AND token = ?'; //On regarde dans la BDD si l'email et le token correspondent aux valeurs dans la BDD.
                $req = $bdd->prepare($q);
                $req->execute([htmlspecialchars($_GET['email']), htmlspecialchars($_GET['token'])]);
                $result = $req->fetchAll(PDO::FETCH_ASSOC);

                if (empty($result)) {
                    echo '<p>Le code est incorrect.</p>';
                } else {
                    $q = 'UPDATE users SET status = "user", token = NULL WHERE email = ?'; //Si elles correspondent alors on change le status de l'utilisateur pour qu'il puisse avoir accès aux fonctionnalités.
                    $req = $bdd->prepare($q);
                    $result = $req->execute([htmlspecialchars($_GET['email'])]);

                    if ($result) {
                        echo '<div class="tokenIsValid-el">';
                        echo '<p>Compte vérifié avec succès</p>';
                        echo '<button><a href="../index.php">Retourner à la page d\'accueil.</a></button>';
                        echo '</div>';
                    } else {
                        echo '<p>La vérification a rencontré un problème.</p>';
                    }
                }
            }
        } else {

            $q = 'SELECT id FROM users WHERE email = ?';
            $req = $bdd->prepare($q);
            $req->execute([$_POST['email']]);
            $result = $req->fetchAll(PDO::FETCH_ASSOC);

            $token = rand(222222, 999999);

            if (empty($result)) {

                $q = 'INSERT INTO users(nickname, email, password, token) VALUES(:nickname, :email, :password, :token)';
                $req = $bdd->prepare($q);
                $result = $req->execute([
                    'nickname' => $_POST['nickname'],
                    'email' => $_POST['email'],
                    'password' => $_POST['password'],
                    'token' => $token
                ]);
                if (!$result) {
                    header('location: ../index.php?message=La création du compte a échoué.');
                    exit;
                };
            }

            require_once('gmail.php');

            $subject = 'Retrospective verification code.';
            $message = '<h1>Voici votre code de vérification : ' . $token . '</h1>';
            $altMessage = 'Voici votre code de vérification : ' . $token;
            $to = $_POST['email'];

            echo '<div class="token-el">';

            sendMail($subject, $message, $altMessage, $to);

            echo '<h2>Saisissez votre code de vérification</h2>';
            echo '<form method="get">';
            echo    '<input type="hidden" name="email" value="' . (isset($_POST['email']) ? $_POST['email'] : htmlspecialchars($_GET['email'])) . '" />';
            echo    '<input type="text" name="token" placeholder="Entrez le code de vérification !">';
            echo    '<button class="token-buttonEl" type="submit">Vérifier le token</button>';
            echo '</form>';
            echo '<form method="get">';
            echo    '<input type="hidden" name="email" value="' . (isset($_POST['email']) ? $_POST['email'] : htmlspecialchars($_GET['email'])) . '" />';
            echo    'input type="hidden" name="resend" value="1"';
            echo    '<button class="token-buttonEl" type="submit">Renvoyer un code</button>';
            echo '</form>';
            echo '</div>';
        }

        ?>
    </main>
</body>

</html>