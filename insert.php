<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php'); // dbcon.php 파일을 포함하는 함수


    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android"); // 유저가 안드로이드 기기일 경우


    if( ($_SERVER['REQUEST_METHOD'] == 'POST') || $android )
    {

        // 안드로이드 코드의 postParameters 변수에 적어준 이름을 가지고 값을 전달 받습니다.
        $id = $_POST['id'];
        $temp = $_POST['temp'];
        $humi = $_POST['humi'];
        $dust = $_POST['dust'];
        $co = $_POST['co'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];

        if(empty($id)){
            $errMSG = "id 값 없음.";
        }
        else if(empty($temp)){
            $errMSG = "temp 값 없음.";
        }
        else if(empty($humi)){
            $errMSG = "humi 값 없음.";
        }
        else if(empty($dust)){
            $errMSG = "dust 값 없음.";
        }
        else if(empty($co)){
            $errMSG = "co 값 없음.";
        }
        else if(empty($latitude)){
            $errMSG = "latitude 값 없음.";
        }
        else if(empty($longitude)){
            $errMSG = "longitude 값 없음.";
        }
        if(!isset($errMSG)) // 이름과 나라 모두 입력이 되었다면 
        {
            try{
                // SQL문을 실행하여 데이터를 MySQL 서버의 person 테이블에 저장합니다. 
                $stmt = $con->prepare('INSERT INTO testinfo(id, temp, humi, dust, co, latitude, longitude) VALUES(:id, :temp, :humi, :dust, :co, :latitude, :longitude) ON DUPLICATE KEY UPDATE temp=:temp, humi=:humi, dust=:dust, co=:co, latitude=:latitude, longitude=:longitude'); // 값 어떻게 넣을 지 생각좀 해보자
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':temp', $temp);
                $stmt->bindParam(':humi', $humi);
                $stmt->bindParam(':dust', $dust);
                $stmt->bindParam(':co', $co);
                $stmt->bindParam(':latitude', $latitude);
                $stmt->bindParam(':longitude', $longitude);

                if($stmt->execute())
                {
                    $successMSG = "데이터를 저장했습니다.";
                }
                else
                {
                    $errMSG = "에러";
                }

            } catch(PDOException $e) {
                die("Database error: " . $e->getMessage()); 
            }
        }

    }

?>


<?php 
    if (isset($errMSG)) echo $errMSG;
    if (isset($successMSG)) echo $successMSG; // 로그캣에 출력되는 디버깅용 코드
?>