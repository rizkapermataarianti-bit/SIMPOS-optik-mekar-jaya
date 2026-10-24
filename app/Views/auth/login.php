<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>

<div class="card login-card shadow-sm p-4 p-md-5">

    <div class="text-center mb-4">
        <div class="brand-icon">👓</div>

        <h4 class="fw-bold mb-2">SIMPOS Optik Mekar Jaya</h4>

        <p class="text-secondary mb-0">
            Silakan login untuk melanjutkan
        </p>
    </div>

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

<?= $this->endSection() ?>
