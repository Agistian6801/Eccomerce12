<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eccomerce</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="loginBody">
    <?php
        require "check.php";
    ?>
    <div class="login-box">
        <form method="post">
            <h2>Login</h2>

            <div class="input-box">
                <input type="email" name="email" required>
                <label>Email</label>
            </div>

            <div class="input-box">
                <input type="password" name="password" required>
                <label>Password</label>
            </div>

            <?php
                if($failed){ ?>
                    <p>
                        <?php echo $failed ?>
                    </p>
            <?php } ?>

            <button class="btnLogin" type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>