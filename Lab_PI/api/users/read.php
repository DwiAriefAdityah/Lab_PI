<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/database.php';
include_once '../objects/users.php';

// instantiate databse adn address object
$database = new Database();
$db = $database->getConnection();

//initialize object
$users = new Users($db);

$stmt = $users->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
    //users array
    $users_arr=array();
    $users_arr["records"]=array();

    //retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        //extract row
        extract($row);

        $users_item=array(
            "username" => $username,
            "password" => $password    
        );

        array_push($users_arr["records"], $users_item);
    }

    // set response code - 200 OK
    http_response_code(200);
    // show address data in json format
    echo json_encode($users_arr);
}
?>