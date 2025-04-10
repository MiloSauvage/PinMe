<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Introuvable</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #fafafa;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .error-container {
      text-align: center;
      background-color: white;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      max-width: 500px;
      width: 100%;
    }

    .error-title {
      font-size: 36px;
      font-weight: bold;
      color: #E94E77;
      margin-bottom: 20px;
    }

    .error-message {
      font-size: 18px;
      color: #333;
      margin-bottom: 20px;
    }

    .error-pic {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid #E94E77;
      margin: 20px auto;
    }

    .back-button {
      padding: 10px 20px;
      font-size: 16px;
      color: #fff;
      background-color: #4A90E2;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
    }

    .back-button:hover {
      background-color: #357ABD;
    }
  </style>
</head>
<body>

  <div class="error-container">
    <div class="error-title">404</div>
    <div class="error-message">Le profil que vous recherchez est introuvable.</div>
    <img src="https://picsum.photos/120?random=6" alt="Image d'erreur" class="error-pic">
    <a href="/pin-me/" class="back-button">Retour à l'accueil</a>
  </div>

</body>
</html>
