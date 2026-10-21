
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMPOS Optik Mekar Jaya</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            min-height: 100vh;
            background: #f2f5f9;
            font-family: Arial, sans-serif;
        }

        .login-card {
            width: 100%;
            max-width: 430px;
            border: none;
            border-radius: 18px;
        }

        .brand-icon {
            width: 58px;
            height: 58px;
            background: #e7efff;
            color: #2457a7;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 28px;
        }

        .btn-login {
            background: #2457a7;
            color: white;
        }

        .btn-login:hover {
            background: #194582;
            color: white;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center p-3">

    <div class="card login-card shadow-sm p-4 p-md-5">

        <div class="text-center mb-4">
            <div class="brand-icon">👓</div>

            <h4 class="fw-bold mb-2">SIMPOS Optik Mekar Jaya</h4>

            <p class="text-secondary mb-0">
                Silakan login untuk melanjutkan
            </p>
        </div>

       <?php if ($error = session()->getFlashdata('error')): ?>
    <div class="alert alert-danger" role="alert">
        <?= esc($error) ?>
    </div>
<?php endif; ?>

<?php if ($success = session()->getFlashdata('success')): ?>
    <div class="alert alert-success" role="alert">
        <?= esc($success) ?>
    </div>
<?php endif; ?>


        
<?php
$errorMessage = session()->getFlashdata('error');
$successMessage = session()->getFlashdata('success');
?>

<?php if ($errorMessage): ?>
    <div class="alert alert-danger" role="alert">
        <?= esc($errorMessage) ?>
    </div>
<?php endif; ?>

<?php if ($successMessage): ?>
    <div class="alert alert-success" role="alert">
        <?= esc($successMessage) ?>
    </div>
<?php endif; ?>


        <form action="<?= site_url('login') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="username" class="form-label">
                    Username
                </label>

                <input
                    type="text"
                    name="username"
                    id="username"
                    class="form-control form-control-lg"
                    placeholder="Masukkan username"
                    value="<?= esc(old('username') ?? '') ?>"
                    autocomplete="username"
                    maxlength="50"
                    required
                    autofocus
                >
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control form-control-lg"
                    placeholder="Masukkan password"
                    autocomplete="current-password"
                    required
                >
            </div>

            <button
                type="submit"
                class="btn btn-login btn-lg w-100"
            >
                Login
            </button>
        </form>

        <p class="text-center text-secondary small mt-4 mb-0">
            Sistem Informasi Manajemen Penjualan dan Inventaris
        </p>

    </div>

</body>
</html>
