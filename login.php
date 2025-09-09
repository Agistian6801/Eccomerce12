<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eccomerce</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        require "check.php";
        if(isset($failed)){
            echo "<div>INVALID ID USER/PASSWORD!</div>";
        }
    ?>
    <div class="login-box">
        <form method="post">
            <h2>Login</h2>

            <div class="input-box">
                <input type="email" required>
                <label>Email</label>
            </div>

            <div class="input-box">
                <input type="password" required>
                <label>Password</label>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>