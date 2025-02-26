<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $birthdate = $_POST['birthdate'];
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    try {
        $stmt = $pdo->prepare("UPDATE users SET nom = :nom, prenom = :prenom, email = :email, phone = :phone, birthdate = :birthdate WHERE id = :id");
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':phone' => $phone,
            ':birthdate' => $birthdate,
            ':id' => $user['id']
        ]);

        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
            $stmt->execute([
                ':password' => $hashedPassword,
                ':id' => $user['id']
            ]);
        }

        $_SESSION['user']['nom'] = $nom;
        $_SESSION['user']['prenom'] = $prenom;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['phone'] = $phone;
        $_SESSION['user']['birthdate'] = $birthdate;

        $message = "Informations mises à jour avec succès.";

        header("Location: edit-profile.php");
        exit();
    } catch (PDOException $e) {
        $message = "Erreur lors de la mise à jour : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier mes informations</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const checkbox = document.getElementById('show-password');
            passwordField.type = checkbox.checked ? 'text' : 'password';
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Modifier mes informations</h1>
        <?php if ($message): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="nom" placeholder="Nom" value="<?= htmlspecialchars($user['nom']) ?>" required>
            <input type="text" name="prenom" placeholder="Prénom" value="<?= htmlspecialchars($user['prenom']) ?>" required>
            <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($user['email']) ?>" required>
            <input type="text" name="phone" placeholder="Téléphone" value="<?= htmlspecialchars($user['phone']) ?>" required>
            <input type="date" name="birthdate" placeholder="Date de naissance" value="<?= htmlspecialchars($user['birthdate']) ?>" required>
            <input type="password" id="password" name="password" placeholder="Nouveau mot de passe (optionnel)">
            <label>
                <input type="checkbox" id="show-password" onclick="togglePasswordVisibility()"> Afficher le mot de passe
            </label>
            <button type="submit">Enregistrer</button>
        </form>
        <a href="profile.php" class="btn-return-home">Annuler</a>
    </div>
</body>
</html>
