<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            background-image: url('view/img/cat5.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            margin: 0;
            padding: 0px;
        }

        nav {
            display: none !important;
        }

        .image-container {
            width: 100%;
            height: 200px;
            background-image: url('view/img/cat2.jpg');
            background-size: cover;
            background-position: center;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .login-container {
            max-width: 400px;
            width: 90%;
            padding: 40px;
            background-color: #A5AED6;
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
            background-color: #FFCFE2;
            color: white;
            border-radius: 5px;
            border: none;
        }
    </style>
    <script>
        const base_url = '<?= BASE_URL; ?>';
    </script>
</head>

<body>
    <div class="login-container">
        <div class="image-container"></div>
        <h2>Iniciar Sesión</h2>
        <form id="frm_login">
            <input type="text" placeholder="Usuario" name="username" id="username" required>
            <input type="password" placeholder="Contraseña" name="password" id="password" required>
            <button type="button" onclick="iniciar_sesion();">Iniciar Sesión</button>
        </form>
    </div>
    <script src="<?= BASE_URL; ?>view/function/user.js"></script>
</body>

</html>