<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Inicio - Gestión de Créditos</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f0f2f5, #dfe6e9);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .container {
            background: white;
            padding: 50px 80px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        .logo {
            width: 150px;
            margin-bottom: 30px;
        }

        .btn-login {
            background: #007bff;
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            font-size: 20px;
            border-radius: 8px;
            transition: background 0.3s ease;
            display: inline-block;
        }

        .btn-login:hover {
            background: #0056b3;
        }

        footer {
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }

        footer a {
            color: #007bff;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Aquí podes poner tu logo -->
       <center> <img src="assets/logo.png" alt="Logo Empresa" class="logo" onerror="this.style.display='none'"></center>

        <a href="login.php" class="btn-login">Iniciar sesión</a>

        <footer>
            Este sistema fue realizado por 
            <a href="https://www.linkedin.com/in/tomas-canavidez" target="_blank">Tomás Canavidez</a>
        </footer>
    </div>

</body>
</html>
