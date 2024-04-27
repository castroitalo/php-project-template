<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= get_url("/static/styles/pages/base.view.css"); ?>">
    <?= $this->section("styles"); ?>

    <title>App - <?= $this->e($title); ?></title>
</head>

<body>
    <!-- Main content -->
    <?= $this->section("content"); ?>

    <!-- Scripts -->
    <script src="<?= get_url("/static/javascript/resources/jQuery/jquery-3.7.1.min.js") ?>"></script>
    <script src="<?= get_url("/static/javascript/pages/base.view.js") ?>"></script>
    <?= $this->section("scripts"); ?>
</body>

</html>
