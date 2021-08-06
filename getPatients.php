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
                 WHERE doctor = '$email'";

        $obtainRecord = $db->getData($stmt);
        //$patientsData = $db->getData($stmt);

        foreach($obtainRecord as $medicalFile){
            $stmt = "SELECT *
                     FROM users
                     WHERE Email = '".$medicalFile['patient']."'";

            $obtainUser = $db->getData($stmt);

            if($_POST['permit'] == "patients"){ //For All Patients currently sick

                if(empty($medicalFile['sickness'])){
                   $patientsData[] = array(
                        "name" => $obtainUser['Name'],
                        "telephone" => $obtainUser['Telephone'],
                        "age" => $obtainUser['Age'],
                        "image" => $obtainUser['Image'],
                        "email" => $obtainUser['Email'],
                        "symptoms" => $medicalFile['symptoms'],
                        "height" => $medicalFile['height'],
                        "weight" => $medicalFile['weight'],
                        "uniqueRecord" => $medicalFile['recordsId'],
                        "date" => $medicalFile['date']
                   );
                }
            }

            if($_POST['permit'] == "cases"){//For All cases solved by the doctor

                if(!empty($medicalFile['sickness'])){
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
            }

        }

        $response = "Success!";
    }

}
    print_r(json_encode(["message" => $response,"data" => $patientsData]));
?>