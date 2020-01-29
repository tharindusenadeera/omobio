<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/omobio/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// files needed to connect to database
include_once '../../config/Database.php';
include_once './../models/User.php';
 
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
    var_dump($db);
    // instantiate product object
    $user = new User($db);
    
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
var_dump($data);
    // set product property values
    $user->first_name = $data->first_name;
    $user->last_name = $data->last_name;
    $user->email = $data->email;
    $user->password = $data->password;
    $user->user_type = $data->user_type;
 
    // create the user
    if(
        !empty($user->first_name) &&
        !empty($user->email) &&
        !empty($user->password) &&
        !empty($user->user_type) &&
        $user->create()
    ){
    
        // set response code
        http_response_code(200);
    
        // display message: user was created
        echo json_encode(array("message" => "User was created."));
    }else{
    
        // set response code
        http_response_code(400);
    
        // display message: unable to create user
        echo json_encode(array("message" => "Unable to create user."));
    }

?>