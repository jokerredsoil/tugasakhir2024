<?php
require '../functions.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['txt_username']);
    $password = trim($_POST['txt_password']);

   
    
    // Call the login function
    $loginError = login($username, $password);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mt-5 text-center">Login</h2>
                <?php if (isset($loginError)): ?>
                    <div class="alert alert-danger">
                        <?php echo $loginError; ?>
                    </div>
                <?php endif; ?>
                <form method="post" action="login.php" class="mt-4">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" name="txt_username" id="username" class="form-control" placeholder="insert username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" name="txt_password" id="password" class="form-control" placeholder="insert password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
