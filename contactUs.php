<?php session_start() ?>
<!DOCTYPE html>

<html>
<?php
$title = "Contact Us";
include("includes/head.php") ?>

<body>
    <?php
    include("includes/header.php");
    if (!isset($_SESSION['email'])) {
        include("includes/log_forms.php");
    }
    ?>
    <main <?php echo !isset($_SESSION['email']) ? 'onclick="fermer()" class="blur-el"' : ''; ?>>
        <div class="contact-us-el">
            <h1>CONTACT US</h1>
            <h1>...</h1>
            <div class="contact-us-div">
                <?php echo !isset($_SESSION['email']) ? '<p>Vous devez être connecté(e) pour envoyer une demande.</p>' : ''; ?>
                <h2>Envoyer une demande</h2>
                <p>Quel que soit le souci, nous sommes là pour vous aider !
                    Envoyez une requête ! À moins qu'elle tombe dans un portail, nous y répondrons très vite.</p>
                <?php if(isset($_SESSION['email'])){

                    echo '<form class="contact-us-form">';
                    echo '<div class="contact-us-form-div">';
                    echo '<label>1. Choisissez un type de requête</label>';
                    echo '<select class="reqList-el" name="problem_type">';
    
                            $types = [
                                '...',
                                'Signaler un joueur',
                                'Récupérer mon compte',
                                'Gestion de compte, demande de données ou suppression',
                                'Problèmes techniques: installation, patchs, latence, plantage',
                                'Question générale'
                            ];
                            foreach ($types as $key => $value) {
                                echo '<option value="' . $key . '">' . ucfirst($value) . '</option>';
                            }
                            
                    echo   '</select>';
                    echo '</div>';
                    echo '</form>';
                    }
                ?>
            </div>
        </div>

    </main>
    <?php include("includes/footer.php") ?>
    <script src="js/index.js"></script>
</body>

</html>