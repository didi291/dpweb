<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            background-color: #F8C8DC;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .image-container {
            width: 100%;
            height: 200px;
            background-image: url('view/img/img2.webp');
            background-size: cover;
            background-position: center;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .login-container {
            max-width: 400px;
            width: 90%;
            padding: 40px;
            background-color: white;
            border-radius: 10px;
        }
        .login-container h2 {
            margin-bottom: 20px;
        }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            border: none;
        }
        </style>
</head>
<body>
    <div class="login-container">
        <div class="image-container"></div>
        <h2>Iniciar Sesión</h2>
        <form action="/login" method="POST">
            <input type="text" placeholder="Usuario" name="username" required>
            <input type="password" placeholder="Contraseña" name="password" required>
            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>