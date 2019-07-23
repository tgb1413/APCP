<?php 
    $mysql_hostname = 'localhost';
    $mysql_username = 'root';
    $mysql_password = '456123';
    $mysql_database = 'test';
    // $mysql_port = '포트(default:3306)';


    $con = mysqli_connect($mysql_hostname, $mysql_username, $mysql_password, $mysql_database);

    mysqli_select_db($con, $mysql_database) or die('DB 선택 실패');

    // mysqli_set_charset($con, utf8);

    $res = mysqli_query($con, "select * from testinfo");
    $result = array();

    while($row = mysqli_fetch_array($res)){
        array_push($result, array('id' => $row[0], 'temp' => $row[1], 'humi' => $row[2], 'dust' => $row[3], 'co' => $row[4], 'latitude' => $row[5], 'longitude' => $row[6]));
    }

    echo json_encode(array("result" => $result));

    mysqli_close($con);
?>