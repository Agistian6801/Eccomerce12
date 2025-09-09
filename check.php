<?php
    //LIST OF USER & PASSWORD
    $users = [
        "rakha@gmail.com" => "123456",
        "john@gmail.com" => "654321"
    ];

    //START SESSION
    session_start();

    //VERIFY THE LOGIN
    if (isset($_POST['email']) && !isset($_SESSION['email'])){
        //CHECK PASSWORD
        if($users[$_POST['email']] == $_POST['password']){
            $_SESSION['email'] = $_POST['email'];
        }
    }

    //FAILED
    if(!isset($_SESSION['email'])){
        $failed = true;
    }

    //VALID LOGIN
    if(isset($_SESSION['email'])){
        header("Location: index.php");
        exit();
    }
?>