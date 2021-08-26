<?php
include('DataBase.php');

$db = new DataBase();

$response = "Security breach!";
$profileData = [];

if (isset($_POST['permit']) && isset($_POST['user'])) {

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
            "name" => $obtain[0]['Name'],
            "email" => $obtain[0]['Email'],
            "telephone" => $obtain[0]['Telephone'],
            "age" => $obtain[0]['Age'],
            "image" => $obtain[0]['Image'],
            "biography" => $obtainWork[0]['biography'],
            "w_address" => $obtainWork[0]['wAddress'],
            "certification" => $obtainWork[0]['certification'],
            "address" => $obtain[0]['Address']
       );

    }

    $response = "Success!";

}

    print_r(json_encode(["message" => $response,"data" => $profileData]));
?>