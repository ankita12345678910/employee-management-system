<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg p-4">
                    <h2 class="mb-4 text-center">Employee <?= $id === 'new' ? 'Registration' : 'Update' ?></h2>
                    
                    <?php if (isset($validation) && is_array($validation)) : ?>
                        <div class="alert alert-danger">
                            <?php foreach ($validation as $error) : ?>
                                <p class="mb-0"> <?= esc($error) ?> </p>
                            <?php endforeach; ?>
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
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
