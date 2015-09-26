<?php

require_once('connection.class.php');

/**
 * Return Basic information about cupons with json string format
 * 
 */
function getCoupons() {
    // Make connection
    $connectionClass = new connection();
    $conn = $connectionClass->getConnection();

    // create query that retreives all coupons
    $stmt = <<<SQL
            SELECT cup_id, cup_name, cup_exp_date, cup_max_use, cup_stock
            FROM coupon
SQL;

    // Perform Query 
    $result = mysql_query($stmt, $conn);

    //echo $stmt;
    // Use result 
    $resp = array();
    if ($result) {
        $resp['status'] = 10; // 10 means ok
        // Build the array with the information 
        while ($row = mysql_fetch_assoc($result)) {
            $resp[] = array(
                'cup_id' => $row['cup_id'],
                'cup_name' => $row['cup_name'],
                'cup_exp_date' => $row['cup_exp_date'],
                'cup_max_use' => $row['cup_max_use'],
                'cup_stock' => $row['cup_stock']
            );
        }
    }
//    print_r($resp);
    mysql_free_result($result);
    mysql_close($conn);
    return json_encode($resp); // Return the array in json format 
}

/**
 * Return Basic information about a cupon with json string format by ID
 * @var cupId is the identifier of the coupun
 * 
 */
function getCouponById($cupId) {
    // validate if is well invokated
    if (is_null($cupId)) {
        return json_encode(array('status' => 20, 'error' => 'No cup id received'));
    }
    // Make connection
    $connectionClass = new connection();
    $conn = $connectionClass->getConnection();

    // create query that retreives all coupons
    $stmt = <<<SQL
            SELECT cup_id, cup_name, cup_exp_date, cup_max_use, cup_stock
            FROM coupon
            WHERE cup_id = $cupId
SQL;

    // Perform Query 
    $result = mysql_query($stmt, $conn);

    //echo $stmt;
    // Use result 
    $resp = array();
    if ($result) {

        // Build the array with the information 
        while ($row = mysql_fetch_assoc($result)) {
            $resp[] = array(
                'cup_id' => $row['cup_id'],
                'cup_name' => $row['cup_name'],
                'cup_exp_date' => $row['cup_exp_date'],
                'cup_max_use' => $row['cup_max_use'],
                'cup_stock' => $row['cup_stock']
            );
        }
    }
//    print_r($resp);
    mysql_free_result($result);
    mysql_close($conn);
    return json_encode($resp); // Return the array in json format 
}

/**
 * 
 * @param string $cupId this is the coupon id
 * @param string $username the user that is exchanging the coupon
 * @param string $ip is the user ip
 * @return bool true if success false if failed
 * 
 */
function exchangeCoupon($cupId, $username, $ip) {
    //Make connection
    $connection = new connection();
    $conn = $connection->getConnection(); //selecciona la base de datos dependiendo de la region a la que esta aplicando el candidato
    // lets try to insert data
    try {
        $stmt = <<<SQL
                INSERT INTO consumption (cns_cup_id, cns_username, cns_ip, cns_created_at) VALUES ('$cupId','$username','$ip',now())
SQL;
        $result = mysql_query($stmt, $conn);
        if (!$result) {
            echo mysql_error();
            return false;
        } else {
            return true;
        }
    } catch (Exception $e) {
        return false;
    }


    mysql_close($conn);
    return json_encode($resp); //Return the array in json format//
}

?>
