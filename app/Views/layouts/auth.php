<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($judul ?? 'Login') ?> - SIMPOS Optik Mekar Jaya</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet">
</head>

<body class="auth-page">

    <main class="container py-4">
        <div class="auth-wrap mx-auto">
            <?= $this->include('partials/flash') ?>

            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
