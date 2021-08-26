<?php
require "DataBase.php";
$db = new DataBase();

$response = "All fields are required";
if (isset($_POST['nameImg']) && isset($_POST['image']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['age']) && isset($_POST['address']) && isset($_POST['special']) && isset($_POST['password']) && isset($_POST['telephone'])) {

    $name = $_POST["nameImg"];
    $image = $_POST["image"];
    $decodedImage = base64_decode("$image");
    //$ext = pathinfo($image,PATHINFO_EXTENSION);
    $return = file_put_contents("./../mentalImgs/" . $name . "jpg", $decodedImage);

    $holdData = ["Image" => $name . "jpg", "Password" => $_POST['password'], "Age" => $_POST['age'], "Name" => $_POST['name'], "Specialization" => $_POST['special'], "Telephone" => $_POST['telephone'], "Email" => $_POST['email'], "Address" => $_POST['address']];
    if ($db->insertData("users", $holdData))
        $response = "Sign Up Success";
    else
        $response = "Sign up Failed";

}
print_r(json_encode($response));
?>
