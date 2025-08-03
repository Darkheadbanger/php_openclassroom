<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - PHP Learn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <?php include 'bonjour.php'; ?>
        <h1>Bonjour <?php echo $name; ?></h1>
        <p>Vous avez <?php echo $userAge; ?> ans</p>

        <form method="POST" action="submit_contact.php" enctype="multipart/form-data">
            [...]
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required />
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Votre message:</label>
                <textarea
                    placeholder="Exprimez-vous ici..."
                    name="message"
                    id="message"
                    rows="4"
                    class="form-control"
                    required></textarea>
            </div>
            <div class="mb-3">
                <label for="screenshot" class="form-label">Capture d'écran</label>
                <input type="file" name="screenshot" id="screenshot" class="form-control" accept=".png, .jpg, .jpeg, .gif" />
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>

        <div class="mt-3">
            <a href="index.php" class="btn btn-secondary">Retour à l'accueil</a>
            <a href="bonjour.php?nom=Dupont&prenom=Jean" class="btn btn-info">Dis-moi bonjour !</a>
        </div>
    </div>
</body>

</html>