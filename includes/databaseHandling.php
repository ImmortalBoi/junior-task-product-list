<?php
    //Connection to server
    $dbServerName = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "product_list";

    $con = mysqli_connect($dbServerName, $dbUsername, $dbPassword, $dbName);
    $method = $_SERVER['REQUEST_METHOD'];
    $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $received_data = json_decode(file_get_contents("php://input"),true);

    $data = array();

    switch ($method) {
        case 'GET':
            $sql = "
            SELECT * FROM `products`
            ORDER BY primary_key DESC;
            ";
            break;

        case 'POST':
            $flag = false;
            $sku = $_POST["sku"];
            $name = $_POST["name"];
            $price = $_POST["price"];
            $specific_attr = $_POST["specific_attr"];

            // Check if already in database
            $result = mysqli_query($con,"
            SELECT * FROM `products`
            ORDER BY primary_key DESC;
            ");

            while($row = $result->fetch_assoc()) {
                if($row["sku"]==$sku){
                    http_response_code(403);
                    die(mysqli_error($con));
                }
            }

            $sql = "INSERT INTO `products`(`sku`, `name`, `price`, `specific_attr`, `primary_key`) VALUES ('$sku', '$name', '$price', '$specific_attr', DEFAULT)"; 
            break;

        case 'DELETE':
            $key = $received_data['key'];
            echo $key;
            $sql = "DELETE FROM `products` WHERE `products`.`primary_key` = $key";
            break;
    }


    $result = mysqli_query($con,$sql);


    if (!$result) {
        http_response_code(400);
        die(mysqli_error($con));
    }

    if ($method == 'GET') {
        if (!$id) echo '[';
        for ($i=0 ; $i<mysqli_num_rows($result) ; $i++) {
            echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
        }
        if (!$id) echo ']';
    } elseif ($method == 'POST') {
        echo json_encode($result);
    } else {
        echo mysqli_affected_rows($con);
    } 
    
    $con->close();
        
?>