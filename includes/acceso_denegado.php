<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Acceso Denegado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8d7da;
            color: #721c24;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .container {
            text-align: center;
            background-color: #f5c6cb;
            border: 1px solid #f5c2c7;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(114, 28, 36, 0.5);
            max-width: 400px;
            width: 90%;
        }
        h1 {
            font-size: 2.5em;
            margin-bottom: 0.2em;
        }
        p {
            margin: 20px 0;
            font-size: 1.2em;
        }
        a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #721c24;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        a:hover {
            background-color: #501217;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Acceso Denegado</h1>
        <p>No tienes permiso para acceder a esta página.</p>
        <a href="/index.php">Volver al Inicio</a>
    </div>
</body>
</html>
