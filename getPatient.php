<?php
include('DataBase.php');

$db = new DataBase();

$response = "Security breach!";
$patientData = [];
$addRecord = [];

if (isset($_REQUEST['user'])) {

    $email = $_REQUEST['user'];
    $stmt = "SELECT *
             FROM records
             WHERE patient = '$email'";

    $obtainRecord = $db->getData($stmt);

    $stmt = "SELECT *
             FROM users
             WHERE Email = '$email'";

    $obtainUser = $db->getData($stmt);

    //print_r(json_encode(["y" => $obtainRecord,"i" => $obtainUser]));
    
    if ($obtainRecord && $obtainUser){
       $patientData = array(
                "name" => $obtainUser[0][1],
                "age" => $obtainUser[0][8],
                "image" => $obtainUser[0][5]
       );

       foreach($obtainRecord as $record){

            $stmt = "SELECT *
                     FROM users
                     WHERE Email = '".$record['doctor']."'";

            $obtainDoctor = $db->getData($stmt);

            $addRecord[] = [
                "unique" => $record['recordsId'],
                "date" => $record['date'],
                "analysis" => $record['analysis'],
                "medicine" => $record['medicine'],
                "sickness" => $record['sickness'],
                "symptoms" => $record['symptoms'],
                "height" => $record['height'],
                "weight" => $record['weight'],
                "doctorName" => $obtainDoctor[0]['Name'],
                "doctorImage" => $obtainDoctor[0]['Image']
            ];
       }

    $response = "Success!";
    }

}

    print_r(json_encode(["message" => $response,"info" => $patientData,"records" => $addRecord]));
?>