<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 400px;">
        <?php if ($status == 'not_logged_in') { ?>

            <h3 class="text-center">Login</h3>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="<?= base_url('/') ?>" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        <?php } else { ?>
            <h4 class="text-center">Welcome back, you are already logged in!</h4>
            <p class="text-center">Would you like to continue or logout?</p>
            <div class="text-center">
                <a href="<?= route_to('all_employees', 1) ?>" class="btn btn-primary">Continue</a>
                <a href="/logout" class="btn btn-danger">Logout</a>
            </div>
        <?php } ?>
    </div>
</div>
<?= $this->endSection() ?>