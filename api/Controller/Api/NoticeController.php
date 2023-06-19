<?php
    class NoticeController extends BaseController
    {

        public function listAction() {

            $strErrorDesc = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];

            if (strtoupper($requestMethod) == 'POST') {

                if (isset($_POST['case']) && isset($_POST['limit'])){

                    $case = $_POST['case'];
                    $limit = $_POST['limit'];
            
                    try {
                        $noticeModel = new NoticeModel();
                        $notices = $noticeModel->getNotice($case, $limit);
                        //var_dump($notices);
                        if(!empty($notices)){
                            $responseData = json_encode($notices);          
                            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
                        }
                        else {
                            $responseData = json_encode(array('error' => 'No notices found!'));
                            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 500 Internal Server Error'));
                        }
                    } 
                    catch (Exception $e) {
                        $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                        $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                    }
                } else {
                    $strErrorDesc = 'Missing required parameters!';
                    $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
                }
            }
            else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = 'HTTP/1.1 405 Method Not Allowed';
            }
        }
    }
