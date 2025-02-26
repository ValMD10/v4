<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Réinitialisation du mot de passe</h2>
        <p class="text-center">Veuillez entrer votre adresse email. Si un compte est associé à cet email, un lien de réinitialisation vous sera envoyé.</p>
        
        <form action="mailtest.php" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="email" class="form-label">Adresse email</label>
                <input 
                    type="email" 
                    class="form-control" 
                    id="email" 
                    name="email" 
                    placeholder="Entrez votre adresse email" 
                    required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Envoyer</button>
        </form>

        <?php if (isset($_GET['status'])): ?>
            <div class="mt-4 alert alert-<?php echo $_GET['status'] === 'success' ? 'success' : 'danger'; ?>">
                <?php 
                echo $_GET['status'] === 'success' 
                    ? "Si l'email est valide, un lien de réinitialisation vous a été envoyé."
                    : "Une erreur est survenue. Veuillez réessayer.";
                ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
