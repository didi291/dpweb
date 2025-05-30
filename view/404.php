<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #ffcccb;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .error-container {
            max-width: 600px;
            width: 90%;
            padding: 40px;
        }
        .error-container img {
            max-width: 50%;
            height: auto;
            border-radius: 10px;
        }
        .home-button {
            text-decoration: none;
            color: white;
            background-color: #FF5733;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <img src="img/netflix.jpg" alt="netflix" style="width: 100%; height: auto; border-radius: 10px;">
        <h1>404</h1>
        <p>Error: Página no encontrada. Probablemente esté viendo Netflix en lugar de trabajar</p>
        <p>¡Vuelve al trabajo o al menos a la página principal!</p>
        <span class="home-button">Volver</span>
    </div>
</body>
</html>