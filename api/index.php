<?php
    require __DIR__ . "/inc/bootstrap.php";
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode( '/', $uri );
    if ((isset($uri[2]) && $uri[2] != 'api') || !isset($uri[4])) {
        header("HTTP/1.1 404 Not Found");
        exit();
    }
    if($uri[4]=='user'){
        require PROJECT_ROOT_PATH . "/Controller/Api/UserController.php";
        $objFeedController = new UserController();
        $strMethodName = $uri[5] . 'Action';
        $objFeedController->{$strMethodName}();
    } elseif ($uri[4]=='contact'){
        require PROJECT_ROOT_PATH . "/Controller/Api/ContactController.php";
        $objFeedController = new ContactController();
        $strMethodName = $uri[5] . 'Action';
        $objFeedController->{$strMethodName}();
    } elseif ($uri[4]=='meal'){
        require PROJECT_ROOT_PATH . "/Controller/Api/MealController.php";
        $objFeedController = new MealController();
        $strMethodName = $uri[5] . 'Action';
        $objFeedController->{$strMethodName}();
    } elseif ($uri[4]=='ring'){
        require PROJECT_ROOT_PATH . "/Controller/Api/RingController.php";
        $objFeedController = new RingController();
        $strMethodName = $uri[5] . 'Action';
        $objFeedController->{$strMethodName}();
    } elseif ($uri[4]=='notice'){
        require PROJECT_ROOT_PATH . "/Controller/Api/NoticeController.php";
        $objFeedController = new NoticeController();
        $strMethodName = $uri[5] . 'Action';
        $objFeedController->{$strMethodName}();
    } elseif ($uri[4]=='course'){
        require PROJECT_ROOT_PATH . "/Controller/Api/CourseController.php";
        $objFeedController = new CourseController();
        $strMethodName = $uri[5] . 'Action';
        $objFeedController->{$strMethodName}();
    } elseif ($uri[4]=='calendar'){
        require PROJECT_ROOT_PATH . "/Controller/Api/CalendarController.php";
        $objFeedController = new CalendarController();
        $strMethodName = $uri[5] . 'Action';
        $objFeedController->{$strMethodName}();
    } else {
        header("HTTP/1.1 404 Not Found");
        exit();
    }
?>