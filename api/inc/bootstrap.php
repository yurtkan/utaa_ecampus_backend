<?php
    define("PROJECT_ROOT_PATH", __DIR__ . "/../");
    // include main configuration file 
    require_once PROJECT_ROOT_PATH . "/inc/config.php";
    // include the base controller file 
    require_once PROJECT_ROOT_PATH . "/Controller/Api/BaseController.php";
    // include the use model file 
    require_once PROJECT_ROOT_PATH . "/Model/UserModel.php";
    // // include PHPMailer
    // require_once PROJECT_ROOT_PATH . "/PHPMailer/Exception.php";
    // require_once PROJECT_ROOT_PATH . "/PHPMailer/PHPMailer.php";
    // require_once PROJECT_ROOT_PATH . "/PHPMailer/SMTP.php";
    require_once PROJECT_ROOT_PATH . "/Model/MealModel.php";
    require_once PROJECT_ROOT_PATH . "/Model/RingModel.php";
    require_once PROJECT_ROOT_PATH . "/Model/NoticeModel.php";
    require_once PROJECT_ROOT_PATH . "/Model/CourseModel.php";
    require_once PROJECT_ROOT_PATH . "/Model/CalendarModel.php";

?>