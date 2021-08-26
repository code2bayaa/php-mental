<?php
include('DataBase.php');

$db = new DataBase();

$response = "Security breach!";
$patientsData = array();

if (isset($_POST['permit']) && isset($_POST['user'])) {

        $email = $_POST['user'];

        $stmt = "SELECT SQL_CALC_FOUND_ROWS *
                 FROM records
                 WHERE doctor = '$email'";

        $obtainRecord = $db->getData($stmt);

        if($obtainRecord){
            foreach($obtainRecord as $medicalFile){
                $stmt = "SELECT SQL_CALC_FOUND_ROWS *
                         FROM users
                         WHERE Email = '".$medicalFile['patient']."'";

                $obtainUser = $db->getData($stmt);

                if($_POST['permit'] == "patients"){ //For All Patients currently sick

                    if(empty($medicalFile['sickness'])){

                       $patientsData[] = array(
                            "name" => $obtainUser[0]['Name'],
                            "telephone" => $obtainUser[0]['Telephone'],
                            "age" => $obtainUser[0]['Age'],
                            "image" => $obtainUser[0]['Image'],
                            "email" => $obtainUser[0]['Email'],
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
                            "name" => $obtainUser[0]['Name'],
                            "telephone" => $obtainUser[0]['Telephone'],
                            "age" => $obtainUser[0]['Age'],
                            "image" => $obtainUser[0]['Image'],
                            "email" => $obtainUser[0]['Email'],
                            "symptoms" => $medicalFile['symptoms'],
                            "height" => $medicalFile['height'],
                            "weight" => $medicalFile['weight'],
                            "sickness" => $medicalFile['sickness'],
                            "date" => $medicalFile['date']
                       );
                    }
                }

            }

        }

        $response = "Success!";

}

    $tab["message"] = $response;
    $tab["data"] = $patientsData;

    print_r(json_encode($tab));
?>