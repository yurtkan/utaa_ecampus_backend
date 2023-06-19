<?php
    class MealController extends BaseController
    {

        public function listAction() {

            $strErrorDesc = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            if (strtoupper($requestMethod) == 'POST') {

            $date = date("Y/m/d");
           
                try {
                    $mealModel = new MealModel();
                    $meals = $mealModel->getMeals($date);
                        
                    if(!empty($meals)){
                        $responseData = json_encode($meals);          
                        $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
                    }
                    else {
                        $responseData = json_encode(array('error' => 'No meals found!'));
                        $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 500 Internal Server Error'));
                    }
                } 
                catch (Exception $e) {
                    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }
            }
            else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = 'HTTP/1.1 405 Method Not Allowed';
            }
        }
    }
