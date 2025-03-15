<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
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

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="<?= route_to('employee_manage', 'new') ?>" class="btn btn-success">
            + Add Employee
        </a>
        <h2 class="text-primary">Employee List</h2>
        <a href="/logout" class="btn btn-secondary">
            Logout
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Sl No</th>
                    <th>Employee ID</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Salary</th>
                    <th>Designation</th>
                    <th>Photo</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($employees)) {
                    $count = $offset; ?>
                    <?php foreach ($employees as $employee) { ?>
                        <tr>
                            <td><?= ++$count ?></td>
                            <td><?= $employee['id'] ?></td>
                            <td><?= $employee['username'] ?></td>
                            <td><?= $employee['name'] ?></td>
                            <td><?= $employee['address'] ?></td>
                            <td>₹<?= number_format($employee['salary'], 2) ?></td>
                            <td><?= $employee['designation'] ?></td>
                            <td>
                                <img src="<?= base_url('uploads/employees/' . (!empty($employee['picture']) ? $employee['picture'] : 'default.jpg')) ?>"
                                    alt="Employee Image" width="50" height="50">
                            </td>

                            <td class="text-center">
                                <a href="<?= route_to('employee_manage', $employee['id']) ?>" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <button onclick="deleteEmployee(<?= $employee['id'] ?>)" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted">No employees found.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <ul class="pagination">
        <?php for ($i = 1; $i <= $totalPage; $i++) { ?>
            <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                <a class="page-link" href="<?= site_url('list/employees/' . $i) ?>"><?= $i ?></a>
            </li>
        <?php } ?>
    </ul>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    async function deleteEmployee(id) {
        const result = await Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        });

        if (result.isConfirmed) {
            const response = await fetch(`<?= base_url('delete/employee') ?>/${id}`, {
                method: "DELETE"
            });
            const data = await response.json();
            if (data.logout) {
                await Swal.fire("Deleted!", "Your account has been deleted.", "success");
                window.location.href = "<?= base_url('login') ?>"; // Redirect to login page
            } else if (data.success) {
                await Swal.fire("Deleted!", "Employee has been deleted.", "success");
                location.reload();
            } else {
                await Swal.fire("Error!", "Something went wrong.", "error");
            }
        }
    }
</script>
<?= $this->endSection() ?>