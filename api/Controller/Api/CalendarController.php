<?php
    class CalendarController extends BaseController
    {
        public function listAction(){
            $strErrorDesc = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            
            if (strtoupper($requestMethod) == 'POST') {
                
                if(isset($_POST['hash'])){
                    $hash = $_POST['hash'];

                    try{

                        $userModel = new UserModel;
                        $user = $userModel->isAuth($hash);

                        if(!empty($user)){
                            $id = $user[0]['user_course'];

                            if(!empty($id)){

                                $str_date = date("Y-m-01");
                                $end_date = date("Y-m-01", strtotime($str_date . '+3 months'));
                                
                                $calendarModel = new CalendarModel();
                                $calendar = $calendarModel->getItems($str_date, $end_date, $id);
                                
                                if(!empty($calendar)){
                                    $responseData = json_encode($calendar);          
                                    $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
                                } else {
                                    $responseData = json_encode(array('error' => 'There is no activities!'));
                                    $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 401 Unauthorized'));
                                }
                            }else{
                                $responseData = json_encode(array('error' => 'Student does not have any active lectures!'));
                                $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 401 Unauthorized'));
                            }

                        } else{
                            $responseData = json_encode(array('error' => 'Invalid credentials'));
                            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 401 Unauthorized'));
                        }

                    } catch (Exception $e){
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