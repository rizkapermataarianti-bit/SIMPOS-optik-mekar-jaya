
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($judul) ?> - SIMPOS</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <span class="navbar-brand fw-bold">
                👓 SIMPOS Optik Mekar Jaya
            </span>

            <form action="<?= site_url('logout') ?>" method="post">
                <?= csrf_field() ?>
                <button class="btn btn-outline-light btn-sm" type="submit">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <main class="container py-5">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">

                <h2 class="fw-bold mb-2">
                    <?= esc($judul) ?>
                </h2>

                <p class="text-secondary">
                    Selamat datang,
                    <strong><?= esc(session()->get('nama')) ?></strong>.
                    Kamu berhasil login ke sistem.
                </p>

                <hr>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 bg-light">
                            <div class="text-secondary small">Username</div>
                            <div class="fw-semibold">
                                <?= esc(session()->get('username')) ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 rounded-3 bg-light">
                            <div class="text-secondary small">Peran</div>
                            <div class="fw-semibold">
                                <?= esc(session()->get('role')) ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 rounded-3 bg-light">
                            <div class="text-secondary small">ID Cabang</div>
                            <div class="fw-semibold">
                                <?= esc((string) (
                                    session()->get('cabang_id') ?? 'Seluruh cabang'
                                )) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info mt-4 mb-0">
                    Ini adalah dashboard awal untuk menguji login.
                    Fitur operasional akan ditambahkan secara bertahap.
                </div>

            </div>
        </div>
    </main>

</body>
</html>
