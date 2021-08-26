<?php
include('DataBase.php');

$db = new DataBase();

$response = "Security breach!";
$returnData = [];

if (isset($_POST['permit']) && isset($_POST['user'])) {

    $email = $_POST['user'];

    $stmt = "SELECT * from users where Email = '$email'";
    $obtain = $db->getData($stmt);

    if ($obtain){
       $returnData = array(
            "name" => $obtain[0]['Name'],
            "email" => $obtain[0]['Email'],
            "telephone" => $obtain[0]['Telephone'],
            "age" => $obtain[0]['Age'],
            "address" => $obtain[0]['Address'],
            "image" => $obtain[0]['Image']
       );

    }
    $response = "Success!";

}

    print_r(json_encode(["message" => $response,"data" => $returnData]));

?>