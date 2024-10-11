<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation d'Inscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #074C72; /* Couleur pour le titre */
        }
        h2 {
            color: #B50302; /* Couleur pour le sous-titre */
        }
        p {
            line-height: 1.5;
        }
        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #666;
        }
        .highlight {
            color: #FF9F02; /* Couleur pour les informations importantes */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bonjour {{ $user->prenom }} {{ $user->nom }},</h1>

        <h2>Vous pouvez vous connecter sur l'espace : <span class="highlight">{{ $roles }}</span> pour profiter de nos services</h2>

        <p>Merci de vous être inscrit sur notre plateforme. Nous sommes ravis de vous accueillir!</p>

        <p>Votre adresse e-mail est : <strong class="highlight">{{ $user->email }}</strong></p>

        <p>Nous vous tiendrons informé des prochaines étapes et de nos nouvelles fonctionnalités.</p>

        <p>Pour vous connecter, veuillez suivre ce lien : <a href="https://rahmadeliveery.com" style="color: #074C72; text-decoration: none; font-weight: bold;">Se connecter</a></p>

        <p>Si vous avez des questions, n'hésitez pas à nous contacter.</p>

        <div class="footer">
            <p>Cordialement,<br>L'équipe de Rahma Delivery</p>
        </div>
    </div>
</body>
</html>
