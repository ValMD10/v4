<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .welcome-container {
            text-align: center;
            padding: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            max-width: 500px;
            width: 90%;
        }

        .welcome-title {
            font-size: 2.8rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #ffcc00;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.4);
        }

        .welcome-text {
            font-size: 1.2rem;
            margin-bottom: 30px;
            line-height: 1.6;
            color: #e0e0e0;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .btn {
            flex: 1;
            padding: 15px 20px;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: bold;
            border-radius: 50px;
            text-align: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-primary {
            background: linear-gradient(90deg, #6a11cb, #2575fc);
            color: #fff;
        }

        .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(38, 85, 200, 0.5);
        }

        .btn-secondary {
            background: linear-gradient(90deg, #ff8c00, #ffcc00);
            color: #fff;
        }

        .btn-secondary:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(255, 140, 0, 0.5);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .welcome-container {
            animation: fadeIn 0.8s ease-out;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1 class="welcome-title">Bienvenue</h1>
        <p class="welcome-text">
            Découvrez votre espace personnel et commencez votre aventure. Connectez-vous ou créez un compte pour accéder à toutes nos fonctionnalités.
        </p>
        <div class="button-container">
            <a href="login.php" class="btn btn-primary">Se connecter</a>
            <a href="signup.php" class="btn btn-secondary">S'inscrire</a>
        </div>
    </div>
</body>
</html>
