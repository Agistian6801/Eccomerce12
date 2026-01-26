<?php
    // Include File db.php
    include 'db.php';

    // ROTECTED PAGE
    session_start();

     if(!isset($_SESSION['email'])){
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bagpackers</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <div class="left-content">
            <div class="homeBtn">
                <a href="index.php">
                    LOGO
                </a>
            </div>
            <div class="menus">
                <ul>
                    <li class="active"><a href="dashboard.php">User</a></li>
                    <li><a href="product.php">Product</a></li>
                </ul>
            </div>
        </div>

        <div class="right-content">
            <h1>Data User</h1>
            <hr>
            <div class="content">
                <button class="buttons" type="submit">Add New User</button>
                <table>
                
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>City</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Image</th>
                        <th colspan=2>Actions</th>
                    </tr>
                    
                    <?php 

                        $no = 1;

                        $sql = mysqli_query($conn, ("SELECT * FROM user"));
                    
                        while ($data = mysqli_fetch_array($sql)) { ?>
                    <tr>
                        <td>
                            <?= $no++; ?>
                        </td>
                        <td>
                            <?= $data['ID_User']; ?>
                        </td>
                        <td>
                            <?= $data['Name']; ?>
                        </td>
                        <td>
                            <?= $data['Age']; ?>
                        </td>
                        <td>
                            <?= ($data['Gender'] == 0) ? 'Laki-laki' : 'Perempuan'; ?>
                        </td>
                        <td>
                            <?= $data['City']; ?>
                        </td>
                        <td>
                            <?= $data['Phone']; ?>
                        </td>
                        <td>
                            <?= $data['Email']; ?>
                        </td>
                        <td>
                            <img src="images/<?= $data['Image']; ?>"  width="50" height="50" alt="">
                        </td>
                        <td>
                            <a href="#" class="btn-edit">Edit</a>
                        </td>
                        <td>
                            <a href="#" class="btn-delete">Delete</a>
                        </td>
                    </tr>

                    <?php } ?>

                </table>
            </div>
        </div>
    </div>

</body>
</html>

                    
