<?php
include('DataBase.php');

$db = new DataBase();

$response = "Security breach!";
$patientsData = array();

if (isset($_POST['permit']) && isset($_POST['user'])) {

        $email = $_POST['user'];

        $user = $_POST['permit'];
        $group = "patient";
        if($user == "patient")
            $group = "doctor";


        $stmt = "SELECT SQL_CALC_FOUND_ROWS *
                 FROM records
                 WHERE $user = '$email'";

        $obtainRecord = $db->getData($stmt);

        if($obtainRecord){
            $noIteration = [];
            foreach($obtainRecord as $medicalFile){
                $stmt = "SELECT SQL_CALC_FOUND_ROWS *
                         FROM users
                         WHERE Email = '".$medicalFile[$group]."'";

                $obtainUser = $db->getData($stmt);

                if(!in_array($obtainUser[0]['Email'],$noIteration)){
                   $patientsData[] = array(
                        "name" => $obtainUser[0]['Name'],
                        "image" => $obtainUser[0]['Image'],
                        "type" => $obtainUser[0]['Specialization'],
                        "email" => $obtainUser[0]['Email']
                   );
                   array_push($noIteration,$obtainUser[0]['Email']);
                   continue;
                }

            }
        }

        $response = "Success!";

}

    $tab["message"] = $response;
    $tab["data"] = $patientsData;

    print_r(json_encode($tab));
?>