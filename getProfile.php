<?php
include('DataBase.php');

$db = new DataBase();

$response = "Security breach!";
$profileData = [];

if (isset($_POST['permit']) && isset($_POST['user'])) {

if ($db->dbConnect()) {

    $email = $_POST['user'];
    $stmt = "SELECT *
             FROM users
             WHERE Email = '$email'";

    $obtain = $db->getData($stmt);

    $stmt = "SELECT *
             FROM doctor
             WHERE Email = '$email'";

    $obtainWork = $db->getData($stmt);

    if ($obtain && $obtainWork){
       $profileData = array(
            "name" => $obtain['Name'],
            "email" => $obtain['Email'],
            "telephone" => $obtain['Telephone'],
            "age" => $obtain['Age'],
            "image" => $obtain['Image'],
            "biography" => $obtainWork['biography'],
            "w_address" => $obtainWork['wAddress'],
            "certification" => $obtainWork['certification'],
            "address" => $obtain['Address']
       );

    }

    $response = "Success!";
}
}

    print_r(json_encode(["message" => $response,"data" => $profileData]));
?>