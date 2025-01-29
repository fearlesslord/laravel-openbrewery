<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Laravel</title>
    <style>
        /* Esempio stile minimale */
        body {
            font-family: Arial, sans-serif;
            margin: 2rem;
        }
        .container {
            text-align: center;
            margin-top: 5rem;
        }
        a.button {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            margin: 1rem;
            background-color: #3490dc;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        a.button:hover {
            background-color: #2779bd;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Benvenuto nella nostra Applicazione!</h1>

    <a href="{{ url('/breweries-test') }}" class="button">
        Vai alla Lista delle Birrerie
    </a>

</div>
</body>
</html>
