<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mise à jour de votre réservation</title>
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
            color: #074C72;
        }
        p {
            line-height: 1.5;
        }
        .details {
            margin-top: 20px;
        }
        .details p {
            margin: 5px 0;
            color: #B50302;
        }
        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #666;
        }
        .highlight {
            color: #FF9F02;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bonjour,</h1>
        <p>Le statut de votre réservation a changé.</p>
        <div class="details">
            <p><strong>ID de la réservation :</strong> <span class="highlight">{{ $reservation->id }}</span></p>
            <p><strong>Annonce concernée :</strong> <span class="highlight">{{ $reservation->annonce->titre }}</span></p>
            <p><strong>Nouveau statut :</strong> <span class="highlight">{{ $status }}</span></p>
        </div>
        <p>Merci pour votre confiance, et n'hésitez pas à nous contacter pour toute question.</p>
        <div class="footer">
            <p>L'équipe de Rahma Delivery</p>
        </div>
    </div>
</body>
</html>
