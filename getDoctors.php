<?php
include('DataBase.php');

$db = new DataBase();

$response = "Security breach!";
$doctorsData = [];

if(isset($_POST['permit'])) {

    $stmt = "SELECT *
             FROM doctor";

    $obtainRecord = $db->getData($stmt);

    if($obtainRecord){

        foreach($obtainRecord as $doctorFile){

            $stmt = "SELECT *
                     FROM users
                     WHERE Email = '".$doctorFile['Email']."'";

            $doctorRecord = $db->getData($stmt);

           $doctorsData[] = array(
                "name" => $doctorRecord[0]['Name'],
                "telephone" => $doctorRecord[0]['Telephone'],
                "age" => $doctorRecord[0]['Age'],
                "image" => $doctorRecord[0]['Image'],
                "email" => $doctorRecord[0]['Email'],
                "address" => $doctorRecord[0]['Address'],
                "wAddress" => $doctorFile['wAddress'],
                "biography" => $doctorFile['biography'],
                "certification" => $doctorFile['certification']
           );

        }
    }

    $response = "Success!";

}
    print_r(json_encode(["message" => $response,"data" => $doctorsData]));
?>