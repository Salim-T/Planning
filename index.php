<?php


// Connexion à la base de données MongoDB
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Connexion à MongoDB Atlas
        $manager = new MongoDB\Driver\Manager('mongodb+srv://trouver un moyen de sécuriser ma bdd');
        // Définition de la requête

        $username = $_POST['username'];
        $password = $_POST['password'];

        $filter = ['identifiant' => $username, 'password' => $password];
        $option = [];
        $read = new MongoDB\Driver\Query($filter, $option);
        //Exécution de la requête
        $users = $manager->executeQuery('planning.users', $read);

        $foundUser = false;
        foreach ($users as $document) {
            $foundUser = true;
        }

        if ($foundUser) {
            header('Location:success.php');
        } else {
            $errorMessage = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } catch (MongoDB\Driver\Exception\Exception $e) {
        echo "Probleme! : " . $e->getMessage();
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,500;0,700;1,400;1,500;1,700&family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <?php if (isset($errorMessage)) { ?>
    <p style="color: red;"><?php echo $errorMessage; ?></p>
    <?php } ?>
    <div class="center">
        <h1>Login</h1>
        <form method="POST">
            <div class="txtField">
                <input type="text" name="username" required>
                <span></span>
                <label>Username</label>
            </div>
            <div class="txtField">
                <input type="password" name="password" required>
                <span></span>
                <label>Password</label>
            </div>
            <input type="submit" class="submit-btn" value="Valider">
            <div class="signupLink">
                Not a member ? <a href="#">Sign up</a>
            </div>
        </form>
    </div>
</body>

</html>