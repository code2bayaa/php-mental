<?php
include('DataBase.php');

$db = new DataBase();

$response = "Security breach!";
$patientsData = [];

if (isset($_POST['permit']) && isset($_POST['user'])) {

    $email = $_POST['user'];

    $stmt = "SELECT *
             FROM records
             WHERE patient = '$email'";

    $obtainRecord = $db->getData($stmt);

    if($obtainRecord){
        foreach($obtainRecord as $medicalFile){
            $stmt = "SELECT *
                     FROM users
                     WHERE Email = '".$medicalFile['doctor']."'";

            $obtainUser = $db->getData($stmt);

            if(!empty($medicalFile['sickness'])){

               $patientsData[] = array(
                    "name" => $obtainUser[0]['Name'],
                    "image" => $obtainUser[0]['Image'],
                    "symptoms" => $medicalFile['symptoms'],
                    "height" => $medicalFile['height'],
                    "weight" => $medicalFile['weight'],
                    "sickness" => $medicalFile['sickness'],
                    "medicine" => $medicalFile['medicine'],
                    "analysis" => $medicalFile['analysis'],
                    "date" => $medicalFile['date']
               );

            }

        }
        $response = "Success!";
    }

}
    print_r(json_encode(["message" => $response,"data" => $patientsData]));
?>