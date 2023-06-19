<?php
    class RingController extends BaseController
    {

        public function listAction() {

            $strErrorDesc = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            if (strtoupper($requestMethod) == 'POST') {
           
                try {
                    $ringModel = new RingModel();
                    $rings = $ringModel->getRings();
                        
                    if(!empty($rings)){
                        $responseData = json_encode($rings);          
                        $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
                    }
                    else {
                        $responseData = json_encode(array('error' => 'No rings found!'));
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
