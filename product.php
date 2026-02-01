<?php

    // Include File db.php
    include 'db.php';

    // ROTECTED PAGE
    session_start();

    if(!isset($_SESSION['email'])){
        header("Location: index.php");
        exit();
    }

    //PHP code to add new user
    if (isset($_POST['addProduct'])) {
        $name   = $_POST['name'];
        $code    = $_POST['code'];
        $merk = $_POST['merk'];
        $price   = $_POST['price'];
        $category  = $_POST['category'];
       
        // Image upload
        $imageName = $_FILES['image']['name'];
        $tmpName   = $_FILES['image']['tmp_name'];

        move_uploaded_file($tmpName, "images/" . $imageName);

        $query = "INSERT INTO products (ID_Cat, Code, Merk, Name, Price, Image)
                VALUES ('$category', '$code', '$merk', '$name', '$price','$imageName')";

        if (mysqli_query($conn, $query)) {
            header("Location: product.php?success=1");
            exit();
        }
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
                    <li><a href="dashboard.php">User</a></li>
                    <li class="active"><a href="product.php">Product</a></li>
                </ul>
            </div>
        </div>
        <div class="right-content">
            <h1>Data Product</h1>
            <hr>
            <div class="content">
                <button class="buttons" onclick="openModal()">Add New Product</button>
                <table>
                    <tr>
                        <th>No</th>
                        <th>ID Product</th>
                        <th>Category</th>
                        <th>Code</th>
                        <th>Merk</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th colspan=2>Actions</th>
                    </tr>
                    
                    <?php 

                        $no = 1;

                        $sql = mysqli_query($conn, " SELECT products.*, categories.Name AS category
                                                    FROM products
                                                    JOIN categories ON products.ID_Cat = categories.ID_Cat ");
                                            
                        while ($data = mysqli_fetch_array($sql)) { ?>
                    <tr>
                        <td>
                            <?= $no++; ?>
                        </td>
                        <td>
                            <?= $data['ID_Product']; ?>
                        </td>
                        <td>
                            <?= $data['category']; ?>
                        </td>
                        <td>
                            <?= $data['Code']; ?>
                        </td>
                        <td>
                            <?= $data['Merk']; ?>
                        </td>
                        <td>
                            <?= $data['Name']; ?>
                        </td>
                        <td>
                            <?= $data['Price']; ?>
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

    <!-- Modal to add new data -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Add New Product</h3>
            <hr>
            <br>

            <form method="POST" enctype="multipart/form-data">

                <select name="category" required>
                    <option value="">Select Category</option>

                    <?php
                    $sql = mysqli_query($conn, " SELECT * FROM categories");
                                            
                    while ($data = mysqli_fetch_array($sql)) { ?>

                    <option value="<?= $data['ID_Cat']; ?>"><?= $data['Name']; ?></option>
                    
                    <?php } ?>

                </select><br><br>

                <input type="text" name="code" placeholder="Code" required><br><br>
                <input type="text" name="merk" placeholder="Merk" required><br><br>
                <input type="text" name="name" placeholder="Name" required><br><br>
                <input type="text" name="price" placeholder="Price" required><br><br>

                <input type="file" name="image" required><br><br>

                <button class="buttons" type="submit" name="addProduct">Save</button>

            </form>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <h4 style="color:green;">✅ Successfully Added!</h4>
        </div>
    </div>

    <script>

        function openModal() {
            document.getElementById("productModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("productModal").style.display = "none";
        }

        function closeSuccess() {
            document.getElementById("successModal").style.display = "none";
        }

        // display the success modal and automatically closed after 3 seconds
        <?php if (isset($_GET['success'])) : ?>
            document.addEventListener("DOMContentLoaded", function() {
                var successModal = document.getElementById("successModal");

                if (successModal) {
                    successModal.style.display = "block";

                    setTimeout(function() {
                        successModal.style.display = "none";
                        window.history.replaceState(null, null, "product.php");
                    }, 3000);
                }
            });
        <?php endif; ?>

        // Close if click outside modal when add new data
        window.onclick = function(event) {
            var modal = document.getElementById("productModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

    </script>

</body>
</html>