<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/GYMTRACK/VISTA/LAYOUT/layout.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>
        <?php echo $data['title']; ?>
    </title>
</head>

<body>
    <header>
        <h1>GymTrack</h1>
    </header>

    <main>
        <?php include $data['body']; ?>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> GymTrack. Todos los derechos reservados</p>
    </footer>
</body>

</html>