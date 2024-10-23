<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changement de Statut de Réservation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #1E4C72;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Changement de Statut de Réservation</h1>

        <p>Nous vous informons que le statut de la réservation pour votre annonce <strong>{{ $reservation->annonce->titre }}</strong> a été mis à jour.</p>
        <p>Statut actuel : <strong>{{ $status }}</strong></p>
        <p>Merci pour votre confiance !</p>
        <p>Cordialement,<br>L'équipe de votre plateforme</p>

        <div class="footer">
            <p>Si vous avez des questions, n'hésitez pas à nous contacter.</p>
        </div>
    </div>
</body>
</html>
