<?php
include('DataBase.php');

$db = new DataBase();

$response = "Security breach!";
$returnData = [];

if (isset($_POST['permit']) && isset($_POST['user'])) {

    if ($db->dbConnect()) {

        $email = $_POST['user'];

        $stmt = "SELECT * from users where Email = '$email'";
        $obtain = $db->getData($stmt);

        if ($obtain){
           $returnData = array(
                "name" => $obtain['Name'],
                "email" => $obtain['Email'],
                "telephone" => $obtain['Telephone'],
                "age" => $obtain['Age'],
                "address" => $obtain['Address'],
                "image" => $obtain['Image']
           );

        }
        $response = "Success!";
    }
}

    print_r(json_encode(["message" => $response,"data" => $returnData]));

?>