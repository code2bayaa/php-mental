<?php
include('DataBase.php');

$db = new DataBase();

$response = "Security breach!";
$doctorsData = [];

if(isset($_POST['permit'])) {

    if ($db->dbConnect()) {

        $stmt = "SELECT *
                 FROM users
                 INNER JOIN doctor ON doctor.Email = users.Email";

        $obtainRecord = $db->getData($stmt);

        foreach($obtainRecord as $doctorFile){

           $doctorsData[] = array(
                "name" => $doctorFile['Name'],
                "telephone" => $doctorFile['Telephone'],
                "age" => $doctorFile['Age'],
                "image" => $doctorFile['Image'],
                "email" => $doctorFile['Email'],
                "wAddress" => $doctorFile['wAddress'],
                "biography" => $doctorFile['biography'],
                "certification" => $doctorFile['certification']
           );

        }

        $response = "Success!";
    }

}
    print_r(json_encode(["message" => $response,"data" => $doctorsData]));
?>