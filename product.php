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

    //Edit data
    if (isset($_POST['editProduct'])) {

        $id       = $_POST['id'];
        $category = $_POST['category'];
        $code     = $_POST['code'];
        $merk     = $_POST['merk'];
        $name     = $_POST['name'];
        $price    = $_POST['price'];

        // Check Image
        if($_FILES['image']['name'] == ''){
            $query = "UPDATE products SET
                ID_Cat='$category',
                Code='$code',
                Merk='$merk',
                Name='$name',
                Price='$price'
              WHERE ID_Product='$id'";
        }else{
            $imageName = $_FILES['image']['name'];
            $tmpName   = $_FILES['image']['tmp_name'];

            move_uploaded_file($tmpName, "images/" . $imageName);

            $query = "UPDATE products SET
                ID_Cat='$category',
                Code='$code',
                Merk='$merk',
                Name='$name',
                Price='$price',
                Image='$imageName'
              WHERE ID_Product='$id'";
        }

        mysqli_query($conn, $query);

        header("Location: product.php?updated=1");
        exit();
    }

    // Delete product data
    if (isset($_GET['delete'])) {

        $id = $_GET['delete'];

        // Ambil nama file gambar dulu untuk dihapus dari folder
        $sql = mysqli_query($conn, "SELECT Image FROM products WHERE ID_Product = '$id'");
        $data = mysqli_fetch_array($sql);

        if ($data) {
            $imagePath = "images/" . $data['Image'];

            if (file_exists($imagePath)) {
                unlink($imagePath); // hapus file gambar
            }
        }

        // Hapus data dari database
        mysqli_query($conn, "DELETE FROM products WHERE ID_Product = '$id'");

        header("Location: product.php?deleted=1");
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
                            <a href="#" class="btn-edit" onclick="editModal(
                                    '<?= $data['ID_Product']; ?>',
                                    '<?= $data['ID_Cat']; ?>',
                                    '<?= $data['Code']; ?>',
                                    '<?= $data['Merk']; ?>',
                                    '<?= $data['Name']; ?>',
                                    '<?= $data['Price']; ?>',
                                    '<?= $data['Image']; ?>'
                                )">Edit</a>
                        </td>
                        <td>
                            <a href="product.php?delete=<?= $data['ID_Product']; ?>" class="btn-delete" onclick="return confirm('Wanna delete this data?')">
                                Delete
                            </a>
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
            <h4 style="color:green;">✅ Successfully Added or Updated!</h4>
        </div>
    </div>

    <!-- Modal to update  data -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Update Product</h3>
            <hr><br>

            <form method="POST" enctype="multipart/form-data">

                <input type="hidden" name="id" id="edit_product_id">

                <select name="category" id="edit_category" required>

                    <option value="">Select Category</option>

                    <?php
                        $sql = mysqli_query($conn, " SELECT * FROM categories");
                                            
                        while ($data = mysqli_fetch_array($sql)) { ?>

                    <option value="<?= $data['ID_Cat']; ?>"><?= $data['Name']; ?></option>
                    
                    <?php } ?>

                </select><br><br>

                <input type="text" name="code" placeholder="Code" id="edit_code" required><br><br>
                <input type="text" name="merk" placeholder="Merk" id="edit_merk" required><br><br>
                <input type="text" name="name" placeholder="Name" id="edit_name" required><br><br>
                <input type="text" name="price" placeholder="Price" id="edit_price" required><br><br>

                <input type="file" name="image"><br><br>

                <button class="buttons" type="submit" name="editProduct">Update</button>

            </form>
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

            if (event.target == document.getElementById("editModal")){
                document.getElementById("editModal").style.display = "none";
            }
        }

        //Edit data
        function editModal(id, category, code, merk, name, price, image){
            document.getElementById("edit_product_id").value = id;
            document.getElementById("edit_category").value = category; 
            document.getElementById("edit_code").value = code;
            document.getElementById("edit_merk").value = merk;
            document.getElementById("edit_name").value = name;
            document.getElementById("edit_price").value = price;

            document.getElementById("editModal").style.display = "block";
        }
        
        //Close modal edit data
        function closeEditModal(){
            document.getElementById("editModal").style.display = "none";
        }

        //Success edit
        <?php if (isset($_GET['updated'])) : ?>
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

        //Success script for pop up
        <?php if (isset($_GET['deleted'])) : ?>
            document.addEventListener("DOMContentLoaded", function() {
                var successModal = document.getElementById("successModal");

                if (successModal) {
                    successModal.innerHTML = "<div class='modal-content'><h4 style='color:red;'>🗑️ Successfully Deleted!</h4></div>";
                    successModal.style.display = "block";

                    setTimeout(function() {
                        successModal.style.display = "none";
                        window.history.replaceState(null, null, "product.php");
                    }, 3000);
                }
            });
        <?php endif; ?>

    </script>

</body>
</html>