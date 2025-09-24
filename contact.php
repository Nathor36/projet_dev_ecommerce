<!-- filepath: /Applications/MAMP/htdocs/projet_dev_ecommerce/contact.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactez-nous</title>
    <link rel="stylesheet" href="style.contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <h1>Contactez-nous</h1>
            <p>Nous sommes là pour répondre à toutes vos questions. Remplissez le formulaire ci-dessous ou utilisez les informations de contact pour nous joindre.</p>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <div class="contact-section">
                <!-- Informations de contact -->
                <div class="contact-info">
                    <h2>Nos coordonnées</h2>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> 123 Rue Exemple, Paris, France</li>
                        <li><i class="fas fa-map-marker-alt"></i> 123 av des champs elysée, Paris, France</li>
                        <li><i class="fas fa-phone"></i> +33 1 23 45 67 89</li>
                        <li><i class="fas fa-envelope"></i> contact@exemple.com</li>
                        <li><i class="fas fa-envelope"></i> Haappel@contact.com</li>
                    </ul>
                </div>

                <!-- Formulaire de contact -->
                <div class="contact-form">
                    <h2>Envoyez-nous un message</h2>
                    <form action="submit_contact.php" method="POST">
                        <div class="form-group">
                            <label for="name">Nom complet</label>
                            <input type="text" id="name" name="name" placeholder="Votre nom" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Adresse e-mail</label>
                            <input type="email" id="email" name="email" placeholder="Votre e-mail" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Objet</label>
                            <input type="text" id="subject" name="subject" placeholder="Objet de votre message" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" placeholder="Votre message" required></textarea>
                        </div>
                        <button type="submit" class="submit-btn">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2023 Votre Entreprise. Tous droits réservés.</p>
            <p>&copy; 2025 Votre Entreprise. Tous droits sortis du passé.</p>
        </div>
    </footer>
</body>
</html>