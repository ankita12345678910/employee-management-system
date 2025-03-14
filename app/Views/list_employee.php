<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <div class="container">

        <a href="<?= route_to('employee_manage', 'new') ?>" class="btn btn-success m-2">+ Add Employee</a>
        <Table>
            <thead>

                <tr>
                    <th>Sl No</th>
                    <th>Employee Id</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Salary</th>
                    <th>Designation</th>
                    <th>Action</th>
                </tr>

            </thead>
            <tbody>
                <?php if (!empty($employees)) {
                    $count = 0 ?>
                    <?php foreach ($employees as $employee) { ?>
                        <tr>
                            <td><?= $count += 1 ?></td>
                            <td><?= $employee['id'] ?></td>
                            <td><?= $employee['username'] ?></td>
                            <td><?= $employee['name'] ?></td>
                            <td><?= $employee['address'] ?></td>
                            <td><?= $employee['salary'] ?></td>
                            <td><?= $employee['designation'] ?></td>
                            <td><a href="<?= route_to('employee_manage', $id = $employee['id']) ?>" class="btn btn-primary">Edit</a>
                                <a href="#" id="delete-employee" onclick="deleteEmployee(<?= $employee['id'] ?>)" class="btn btn-danger">X Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>

            </tbody>
        </Table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
            })
            if (result.isConfirmed) {
                const response = await fetch(`<?= base_url('delete/employee') ?>/${id}`, {
                    method: "DELETE"
                })
                const data = await response.json();
                if (data.success) {
                    await Swal.fire("Deleted!", "Employee has been deleted.", "success");
                    location.reload();
                }
            } else {
                await Swal.fire("Error!", "Something went wrong.", "error");
            }
        }
    </script>
</body>

</html>