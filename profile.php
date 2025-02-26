<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $file = $_FILES['profile_picture'];
    $fileName = $user['id'] . '_' . basename($file['name']);
    $targetFile = $uploadDir . $fileName;

    $check = getimagesize($file['tmp_name']);
    if ($check !== false) {
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            $stmt = $pdo->prepare("UPDATE users SET profile_picture = :profile_picture WHERE id = :id");
            $stmt->execute([':profile_picture' => $fileName, ':id' => $user['id']]);
            $_SESSION['user']['profile_picture'] = $fileName;
            $message = "Photo de profil mise à jour.";
            header("Location: profile.php");
            exit();
        } else {
            $message = "Erreur lors du téléchargement.";
        }
    } else {
        $message = "Fichier non valide.";
    }
}

$profilePicture = isset($user['profile_picture']) && file_exists('uploads/' . $user['profile_picture']) 
    ? 'uploads/' . $user['profile_picture'] 
    : 'default-profile.png';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil utilisateur</title>
    <link rel="stylesheet" href="style.css">
    <style>
        
        .profile-container {
            width: 90%;
            max-width: 800px;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            padding: 30px;
            backdrop-filter: blur(8px);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 3px solid rgba(89, 0, 255, 0.69);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3),
                        0 6px 20px rgba(0, 0, 0, 0.19);
            transition: box-shadow 0.3s ease;
        }

        .profile-avatar:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4), 
                        0 12px 30px rgba(0, 0, 0, 0.25);
        }


                .user-name {
            font-size: 24px;
            font-weight: bold;
            color: #fff;
        }

        .user-email {
            font-size: 16px;
            color: #ddd;
        }

        

        .user-info {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 30px;
        }

        .info-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            flex: 1 1 calc(30% - 20px);
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3),
                        0 6px 20px rgba(0, 0, 0, 0.19);
            transition: box-shadow 0.3s ease;
        }

        .info-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4), 
                        0 12px 30px rgba(0, 0, 0, 0.25);
        }


        .info-card h4 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #fff;
        }

        
        .edit-profile-btn {
            display: inline-block;
            margin-top: 20px;
            font-size: 16px;
            background: #6a11cb;
            padding: 10px 20px;
            border-radius: 8px;
            color: #fff;
            text-decoration: none;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .edit-profile-btn:hover {
            background: #2575fc;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }


        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            margin-top: 20px;
        }

    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <img src="<?= htmlspecialchars($profilePicture) ?>" alt="Photo de profil" class="profile-avatar">
            <h1 class="user-name"><?= htmlspecialchars($user['login']) ?></h1>
            <p class="user-email"><?= htmlspecialchars($user['email']) ?></p>
            <form method="POST" enctype="multipart/form-data">
                <input type="file" name="profile_picture" accept="image/*" required>
                <button type="submit">Mettre à jour la photo</button>
            </form>
            <?php if ($message): ?>
                <p class="message"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>
            <a href="logout.php" class="logout-btn">Se déconnecter</a>
        </div>

        <div class="user-info">
            <div class="info-card">
                <h4>Nom</h4>
                <p><?= htmlspecialchars($user['nom']) ?></p>
            </div>
            <div class="info-card">
                <h4>Prénom</h4>
                <p><?= htmlspecialchars($user['prenom']) ?></p>
            </div>
            <div class="info-card">
                <h4>Email</h4>
                <p><?= htmlspecialchars($user['email']) ?></p>
            </div>
            <div class="info-card">
                <h4>Téléphone</h4>
                <p><?= htmlspecialchars($user['phone']) ?></p>
            </div>
            <div class="info-card">
                <h4>Date de naissance</h4>
                <p><?= htmlspecialchars($user['birthdate']) ?></p>
            </div>
            <div class="info-card">
                <h4>Date de création</h4>
                <p><?= htmlspecialchars($user['create_at']) ?></p>
            </div>
            <a href="edit-profile.php" class="edit-profile-btn">Modifier mes informations</a>

        </div>
        
    </div>
</body>
</html>
