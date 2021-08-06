<?php
include('DataBase.php');

$db = new DataBase();

$response = "Security breach!";
$patientsData = [];

if (isset($_POST['permit']) && isset($_POST['user'])) {

    if ($db->dbConnect()) {

        $email = $_POST['user'];

        $stmt = "SELECT *
                 FROM records
                 WHERE patient = '$email'";

        $obtainRecord = $db->getData($stmt);

        foreach($obtainRecord as $medicalFile){
            $stmt = "SELECT *
                     FROM users
                     WHERE Email = '".$medicalFile['doctor']."'";

            $obtainUser = $db->getData($stmt);

           $patientsData[] = array(
                "name" => $obtainUser['Name'],
                "telephone" => $obtainUser['Telephone'],
                "age" => $obtainUser['Age'],
                "image" => $obtainUser['Image'],
                "email" => $obtainUser['Email'],
                "symptoms" => $medicalFile['symptoms'],
                "height" => $medicalFile['height'],
                "weight" => $medicalFile['weight'],
                "sickness" => $medicalFile['sickness'],
                "date" => $medicalFile['date']
           );

        }

        $response = "Success!";
    }

}
    print_r(json_encode(["message" => $response,"data" => $patientsData]));
?>