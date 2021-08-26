<?php
require "DataBase.php";
$db = new DataBase();

$response = "All fields are required";

if (isset($_POST['nameImg']) && isset($_POST['image']) && isset($_POST['telephone']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['special']) && isset($_POST['age']) && isset($_POST['wAddress']) && isset($_POST['address']) && isset($_POST['biography']) && isset($_POST['certification']) && isset($_POST['email'])) {

    $name = $_POST["nameImg"];
    $image = $_POST["image"];
    $decodedImage = base64_decode("$image");
    //$ext = pathinfo($image,PATHINFO_EXTENSION);
    $return = file_put_contents("./../mentalImgs/" . $name . "jpg", $decodedImage);

    $holdData = ["biography" => $_POST['biography'], "certification" => $_POST['certification'], "wAddress" => $_POST['wAddress'], "Email" => $_POST['email']];

    $response =  "Sign up Failed";
    $creep = 0;
    if ($db->insertData("doctor",$holdData))
        $creep++;

    $holdData = ["Image" => $name . "jpg", "Password" => $_POST['password'], "Age" => $_POST['age'], "Name" => $_POST['name'], "Specialization" => $_POST['special'], "Telephone" => $_POST['telephone'], "Email" => $_POST['email'], "Address" => $_POST['address']];

    if ($db->insertData("users",$holdData))
        $creep++;

    if($creep == 2)
        $response =  "Sign Up Success";

}
print_r(json_encode($response));
?>