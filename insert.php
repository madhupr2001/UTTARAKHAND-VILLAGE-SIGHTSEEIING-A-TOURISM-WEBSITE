<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['f_name']) && isset($_POST['l_name']) &&
        isset($_POST['place']) && isset($_POST['age']) &&
        isset($_POST['email'])&&
        isset($_POST['newplaces'])&&
        isset($_POST['reviews'])&&
        isset($_POST['favplaces'])){
        
        $f_name = $_POST['f_name'];
        $l_name= $_POST['l_name'];
        $place= $_POST['place'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $favplaces= $_POST['favplaces'];
        $newplaces = $_POST['newplaces'];
        $reviews = $_POST['reviews'];
       
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "Neo678";
        $dbName = "register";
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT email FROM users_info WHERE email = ? LIMIT 1";
            $Insert = "INSERT INTO users_info(f_name, l_name, place, age, email,newplaces,reviews,favplaces) values(?, ?, ?, ?, ?, ?, ?, ?)";
           $stmt = $conn->prepare($Select);
           $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;
            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("sssissss",$f_name, $l_name, $place, $age,$email,$newplaces,$reviews,$favplaces);
                if ($stmt->execute()) {
                    echo "New User record inserted sucessfully!";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "User details already entered in our database!";
            }
            $stmt->close();
            $conn->close();
        }
    }
   else {
        echo "All fields are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
?>