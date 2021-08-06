<?php
require "DataBase.php";
$db = new DataBase();

$response = "All fields are required";
$obtain = "Invalid user";

if (isset($_POST['email']) && isset($_POST['password'])) {

    if ($db->dbConnect()) {
        if ($db->logIn("users", $_POST['email'], $_POST['password'])){
            $response = "Login Success";

            $stmt = "SELECT *
                     FROM users
                     WHERE Email = '".$_POST['email']."'";

            $obtain = $db->getData($stmt)['Specialization'];
            //$obtain = $obtainT[0]['Specialization'];
        }else
            $response = "Username or Password wrong";
    }else
        $response = "Error: Database connection";
}

print_r(json_encode(["message" => $response, "user" => $obtain]));
?>
