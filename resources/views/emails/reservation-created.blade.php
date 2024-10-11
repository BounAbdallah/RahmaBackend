<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Réservation</title>
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
            color: #074C72; /* Utilisation de la couleur #074C72 pour le titre */
        }
        p {
            line-height: 1.5;
        }
        .details {
            margin-top: 20px;
        }
        .details p {
            margin: 5px 0;
            color: #B50302; /* Utilisation de la couleur #B50302 pour les détails */
        }
        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #666;
        }
        .highlight {
            color: #FF9F02; /* Utilisation de la couleur #FF9F02 pour les informations importantes */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bonjour,</h1>

        <p>Votre réservation a été créée avec succès. Vous trouverez ci-dessous les détails de votre réservation.</p>

        <div class="details">
            <p><strong>ID de la réservation :</strong> <span class="highlight">{{ $reservation->id }}</span></p>
            <p><strong>Annonce concernée :</strong> <span class="highlight">{{ $reservation->annonce->titre }}</span></p>
            <p><strong>Utilisateur :</strong> <span class="highlight">{{ $reservation->user->name }}</span></p>
            <p><strong>Date de la réservation :</strong> <span class="highlight">{{ $reservation->date_reservation }}</span></p>
        </div>

        <p>Nous vous remercions pour votre confiance et nous restons à votre disposition pour toute question.</p>

        <div class="footer">
            <p>Cordialement,</p>
            <p>L'équipe de Rahma Delivery</p>
        </div>
    </div>
</body>
</html>
