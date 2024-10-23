<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvel utilisateur enregistré</title>
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
        <h1>Nouvel utilisateur enregistré</h1>
        <p>Un nouvel utilisateur a été enregistré avec les détails suivants :</p>
        <ul>
            <li>Nom : {{ $user->prenom }} {{ $user->nom }}</li>
            <li>Email : {{ $user->email }}</li>
            <li>Téléphone : {{ $user->telephone }}</li>
            <li>Rôle : GP</li>
        </ul>
        <div class="footer">
            <p>Merci de votre attention.</p>
        </div>
    </div>
</body>
</html>
