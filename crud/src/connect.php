<?php
    /**
     * Trying to connect
     * HOST = 'localhost'
     * USER = 'root'
     * PASSWORD = ''
     * DATABASE = 'CRUD'
     * */
    $con = new mysqli('localhost', 'root', '', 'CRUD');

    if (!$con) {
        die(mysqli_error($con));
    }
?>