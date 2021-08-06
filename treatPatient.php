<?php
require "DataBase.php";
$db = new DataBase();

$response = "All fields are required";
if (isset($_POST['uniqueRecord']) && isset($_POST['sickness']) && isset($_POST['medicine']) && isset($_POST['analysis'])) {
    if ($db->dbConnect()) {

        $stmt = "UPDATE records SET sickness = '".$_POST['sickness']."', medicine = '".$_POST['medicine']."', analysis = '".$_POST['analysis']."' WHERE recordsId = '".$_POST['uniqueRecord']."'";

        if ($db->updateData($stmt))
            $response = "Treated successfully";
        else
            $response = "Treatment Failed";
    }else
        $response = "Error: Database connection";

}
print_r(json_encode($response));
?>
