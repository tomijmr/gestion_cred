<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Inicio</title>
    <style>
        /* Estilos para centrar el contenido */
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .menu {
            text-align: center;
            background: white;
            padding: 40px 60px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .menu a {
            display: inline-block;
            background: #007bff;
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            font-size: 18px;
            border-radius: 6px;
            transition: background 0.3s ease;
        }
        .menu a:hover {
            background:rgb(197, 43, 43);
        }
    </style>
</head>
<body>
    <div class="menu">
        <a href="login.php">Iniciar sesión</a>
    </div>
</body>
</html>
