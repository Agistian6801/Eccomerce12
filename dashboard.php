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
    if (isset($_POST['addUser'])) {
        $name   = $_POST['name'];
        $age    = $_POST['age'];
        $gender = $_POST['gender'];
        $city   = $_POST['city'];
        $phone  = $_POST['phone'];
        $email  = $_POST['email'];
        $password = $_POST['password'];

        // Image upload
        $imageName = $_FILES['image']['name'];
        $tmpName   = $_FILES['image']['tmp_name'];

        move_uploaded_file($tmpName, "images/" . $imageName);

        $query = "INSERT INTO user (Name, Age, Gender, City, Phone, Email,Password, Image)
                VALUES ('$name', '$age', '$gender', '$city', '$phone', '$email','$password', '$imageName')";

        if (mysqli_query($conn, $query)) {
            header("Location: dashboard.php?success=1");
            exit();
        }
    }

    //Edit data
    if (isset($_POST['editUser'])) {

        $id     = $_POST['id'];
        $name   = $_POST['name'];
        $age    = $_POST['age'];
        $gender = $_POST['gender'];
        $city   = $_POST['city'];
        $phone  = $_POST['phone'];
        $email  = $_POST['email'];
        $password = $_POST['password'];

        //Check session
        $sql = mysqli_query($conn, "SELECT user.Email FROM user WHERE ID_User = '$id'");
        $data = mysqli_fetch_array($sql);

        if($_SESSION['email'] == $data['Email']){
            $_SESSION['email'] = $_POST['email'];
        }

        // Check Image
        if($_FILES['image']['name'] == ''){
            $query = "UPDATE user SET 
                        Name = '$name',
                        Age = '$age',
                        Gender = '$gender',
                        City = '$city',
                        Phone = '$phone',
                        Email = '$email',
                        Password = '$password'
                    WHERE ID_User='$id'";
        }else{
            $imageName = $_FILES['image']['name'];
            $tmpName   = $_FILES['image']['tmp_name'];

            move_uploaded_file($tmpName, "images/" . $imageName);

            $query = "UPDATE user SET 
                        Name = '$name',
                        Age = '$age',
                        Gender = '$gender',
                        City = '$city',
                        Phone = '$phone',
                        Email = '$email',
                        Password = '$password',
                        Image = '$imageName'
                    WHERE ID_User='$id'";
        }
        

        mysqli_query($conn, $query);

        header("Location: dashboard.php?updated=1");
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
                <button class="buttons"  onclick="openModal()">Add New User</button>
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
                        <th>Password</th>
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
                            <?= $data['Password']; ?>
                        </td>
                        <td>
                            <img src="images/<?= $data['Image']; ?>"  width="50" height="50" alt="">
                        </td>
                        <td>
                            <a href="#" class="btn-edit" onclick="editModal(
                                    '<?= $data['ID_User']; ?>',
                                    '<?= $data['Name']; ?>',
                                    '<?= $data['Age']; ?>',
                                    '<?= $data['Gender']; ?>',
                                    '<?= $data['City']; ?>',
                                    '<?= $data['Phone']; ?>',
                                    '<?= $data['Email']; ?>',
                                    '<?= $data['Password']; ?>',
                                    '<?= $data['Image']; ?>'
                                )">Edit
                            
                            </a>
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
    <div id="userModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Add New User</h3>
            <hr>
            <br>

            <form method="POST" enctype="multipart/form-data">

                <input type="text" name="name" placeholder="Name" required><br><br>
                <input type="number" name="age" placeholder="Age" required><br><br>

                <select name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="0">Laki-laki</option>
                    <option value="1">Perempuan</option>
                </select><br><br>

                <input type="text" name="city" placeholder="City" required><br><br>
                <input type="text" name="phone" placeholder="Phone" required><br><br>
                <input type="email" name="email" placeholder="Email" required><br><br>
                <input type="text" name="password" placeholder="Password" required><br><br>

                <input type="file" name="image" required><br><br>

                <button class="buttons" type="submit" name="addUser">Save</button>

            </form>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <h4 style="color:green;">✅ Successfully Added or Updated!</h4>
        </div>
    </div>

     <!-- Modal to edit data -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h3>Edit Data</h3>
            <hr>
            <br>

            <form method="POST" enctype="multipart/form-data">

                <input type="hidden" name="id" id="edit_id">

                <input type="text" name="name" id="edit_name" required><br><br>
                <input type="number" name="age" id="edit_age" required><br><br>

                <select name="gender" id="edit_gender" required>
                    <option value="0">Laki-laki</option>
                    <option value="1">Perempuan</option>
                </select><br><br>

                <input type="text" name="city" id="edit_city" required><br><br>
                <input type="text" name="phone" id="edit_phone" required><br><br>
                <input type="email" name="email" id="edit_email" required><br><br>
                <input type="text" name="password" id="edit_password" required><br><br>

                <input type="file" name="image"><br><br>

                <button class="buttons" type="submit" name="editUser">Update</button>

            </form>
        </div>
    </div>

    <script>

        function openModal() {
            document.getElementById("userModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("userModal").style.display = "none";
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
                        window.history.replaceState(null, null, "dashboard.php");
                    }, 3000);
                }
            });
        <?php endif; ?>

        // Close if click outside modal when add new data
        window.onclick = function(event) {
            var modal = document.getElementById("userModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }

            if (event.target == document.getElementById("editModal")){
                document.getElementById("editModal").style.display = "none";
            }
        }

        //Edit data
        function editModal(id, name, age, gender, city, phone, email, password){
           document.getElementById("edit_id").value = id;
            document.getElementById("edit_name").value = name;
            document.getElementById("edit_age").value = age;
            document.getElementById("edit_gender").value = gender;
            document.getElementById("edit_city").value = city;
            document.getElementById("edit_phone").value = phone;
            document.getElementById("edit_email").value = email;
            document.getElementById("edit_password").value = password;

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
                        window.history.replaceState(null, null, "dashboard.php");
                    }, 3000);
                }
            });
        <?php endif; ?>

    </script>
    
</body>
</html>