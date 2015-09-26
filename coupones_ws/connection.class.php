<?php

/**
 * Connet with the database.
 * @author Jairo Guerra (jairo.guerragm@gmail.com)
 * 
 */
class connection {
    /* ------------- BD Cupones ------------ */

    var $db_host = "localhost";
    var $db_user = "root";
    var $db_password = "root";
    var $db_name = "db_coupon_backend";

    /*
     * function getConnection()
     * creates and returns a connection link
     */

    function getConnection() {
        $conn = mysql_connect($this->db_host, $this->db_user, $this->db_password);
        mysql_select_db($this->db_name, $conn);
        return $conn;
    }

}

?>
