<?php
    /**
     * Trying to connect
     * HOST = 'localhost'
     * USER = 'root'
     * PASSWORD = ''
     * DATABASE = 'CRUD'
     * */
    $con = new mysqli('localhost', 'root', '', 'CRUD');

    // Checking connection
    if (!$con) {
        // Connection Failed
        die(mysqli_error($con));
    }
?>