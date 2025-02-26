<?php
require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $login = $_POST['login'];
    $mdp = $_POST['mdp'];
    $mdp_confirm = $_POST['mdp_confirm'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $birthdate = $_POST['birthdate'];

    if ($mdp !== $mdp_confirm) {
            $error_message = "Les mots de passe ne correspondent pas.";}

    $hashedPassword = password_hash($mdp, PASSWORD_BCRYPT);
    
    try {
        $stmt = $pdo->prepare("
            INSERT INTO users (nom, prenom, login, mdp, email, phone, birthdate) 
            VALUES (:nom, :prenom, :login, :mdp, :email, :phone, :birthdate)
        ");
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':login' => $login,
            ':mdp' => $hashedPassword,
            ':email' => $email,
            ':phone' => $phone,
            ':birthdate' => $birthdate
        ]);
        header("Location: profile.php");
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $message = "L'email ou le login existe déjà.";
        } else {
            $message = "Erreur : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <a href="index.php" class="btn-return-home"><-Accueil</a>
        <h1>Inscription</h1>
        <?php if ($message): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="text" name="login" placeholder="Login" required>
            <input type="password" name="mdp" placeholder="Mot de passe" required>
            <input type="password" name="mdp_confirm" class="form-control" placeholder="Confirmer votre mot de passe" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Téléphone" required>
            <input type="date" name="birthdate" placeholder="Date de naissance" required>
            <button type="submit">S'inscrire</button>
        </form>
        <p>Déjà un compte ? <a href="login.php">Connectez-vous ici</a>.</p>
    </div>
</body>
</html>
