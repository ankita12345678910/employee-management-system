<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg p-4">

                <h2 class="mb-4 text-center">Employee <?= $id === 'new' ? 'Registration' : 'Update' ?></h2>
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <form action="<?= route_to('employee_manage', $id) ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?= isset($employee['name']) ? esc($employee['name']) : set_value('name') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" id="address" class="form-control" value="<?= isset($employee['address']) ? esc($employee['address']) : set_value('address') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="designation" class="form-label">Designation</label>
                        <input type="text" name="designation" id="designation" class="form-control" value="<?= isset($employee['designation']) ? esc($employee['designation']) : set_value('designation') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="salary" class="form-label">Salary</label>
                        <input type="number" name="salary" id="salary" class="form-control" value="<?= isset($employee['salary']) ? esc($employee['salary']) : set_value('salary') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control" value="<?= isset($employee['username']) ? esc($employee['username']) : set_value('username') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" <?= $id !== 'new' ? 'placeholder="Leave blank to keep current password"' : 'required' ?>>
                    </div>

                    <div class="mb-3">
                        <label for="picture" class="form-label">Picture</label>
                        <input type="file" name="picture" id="picture" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary w-100"> <?= $id === 'new' ? 'Add Employee' : 'Update Employee' ?> </button>
                </form>
                <a href="javascript:history.back()" class="btn btn-secondary mt-2">
                    ← Back
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>