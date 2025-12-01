<?php
    //LIST OF USER & PASSWORD
    // $users = [
    //     "rakha@gmail.com" => "123456",
    //     "john@gmail.com" => "654321"
    // ];

    //CONNECT DB
    $host = "localhost";
    $user = "root";
    $pass = "";
    $database_name = "bagpackers";
    $conn = mysqli_connect($host, $user, $pass, $database_name);
    $failed = "";

    //START SESSION
    session_start();

    //VERIFY THE LOGIN
    if(isset($_POST['login'])){
        if (isset($_POST['email']) && !isset($_SESSION['email'])){
            //CHECK

            $email = $_POST['email'];
            $password = $_POST['password'];
            $sql = mysqli_query($conn, ("SELECT * FROM user where Email = '$email'"));
            $data = mysqli_fetch_array($sql);

            if($data != null){
                if($data['Password'] == $password){
                    $failed = "";
                    $_SESSION['email'] = $data['Email'];
                }else{
                    $failed = "Password is incorrect";
                }
            }else{
                $failed = "Email is incorrect";
            }
            
        }
    }
    
    //VALID LOGIN
    if(isset($_SESSION['email'])){
        header("Location: index.php");
        exit();
    }
?>