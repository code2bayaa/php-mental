<?php
require "DataBase.php";
$db = new DataBase();

$response = "All fields are required";
if (isset($_POST['user']) && isset($_POST['doctor']) && isset($_POST['symptoms']) && isset($_POST['height']) && isset($_POST['weight'])) {
    if ($db->dbConnect()) {

        $holdData = ["patient" => $_POST['user'], "doctor" => $_POST['doctor'], "symptoms" => $_POST['symptoms'], "height" => $_POST['height'], "weight" => $_POST['weight']];

        if ($db->insertData("records",$stmt))
            $response = "Consulted successfully";
        else
            $response = "Consulted Failed";
    }else
        $response = "Error: Database connection";

}
print_r(json_encode($response));
?>
