<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/omobio/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// required to encode json web token
include_once '../../config/core.php';
include_once '../../config/Database.php';
include_once './../models/User.php';
include_once '../../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../../libs/php-jwt-master/src/ExpiredException.php';
include_once '../../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;
 
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
    // instantiate user object
    $user = new User($db);

    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    
    // get jwt
    $jwt=isset($data->jwt) ? $data->jwt : "";

    // if jwt is not empty
    if($jwt){
        // if decode succeed, show user details
        try {
            // decode jwt
            $decoded = JWT::decode($jwt, $key, array('HS256'));
    
            // set user property values
            $user->first_name = $data->first_name;
            $user->last_name = $data->last_name;
            $user->email = $data->email;
            $user->password = $data->password;
            $user->id = $decoded->data->id;

                    // update the user record
            if($user->update()){
                        // set response code
                http_response_code(200);
                echo json_encode(array("message" => "User was updated."));
            }else{
                // set response code
                http_response_code(401);
            
                // show error message
                echo json_encode(array("message" => "Unable to update user."));
            }
        }catch (Exception $e){
    
            // set response code
            http_response_code(401);
        
            // show error message
            echo json_encode(array(
                "message" => "Access denied.",
                "error" => $e->getMessage()
            ));
        }
    }
?>