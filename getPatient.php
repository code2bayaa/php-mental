<?php
include('DataBase.php');

$db = new DataBase();

$response = "Security breach!";
$patientData = [];

if (isset($_POST['email'])) {
    if ($db->dbConnect()) {

        $email = $_POST['email'];
        $stmt = "SELECT *
                 FROM records
                 WHERE patient = '$email'";

        $obtainRecord = $db->getData($stmt);

        $stmt = "SELECT *
                 FROM users
                 WHERE Email = '$email'";

        $obtainUser = $db->getData($stmt);

        if ($obtainRecord && $obtainUser){
           $patientData = array(
                "info" => array(
                    "name" => $obtainUser['Name'],
                    "telephone" => $obtainUser['Telephone'],
                    "age" => $obtainUser['Age'],
                    "image" => $obtainUser['Image']
                )
           );
           $addRecord = [];
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
                    "doctorName" => $obtainDoctor['Name'],
                    "doctorImage" => $obtainDoctor['Image']
                ];
           }
           $patientData["records"] = $addRecord;
        }

        $response = "Success!";
    }
}

    print_r(json_encode(["message" => $response,"data" => $patientData]));
?>