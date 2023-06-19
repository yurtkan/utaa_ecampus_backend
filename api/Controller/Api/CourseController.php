<?php
    class CourseController extends BaseController
    {

        public function listAction(){

            $strErrorDesc = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            
            if (strtoupper($requestMethod) == 'POST') {

                if (isset($_POST['hash'])){

                    $hash = $_POST['hash'];

                    try {
                    
                        $userModel = new UserModel();
                        $user = $userModel->isAuth($hash);
                        
                        if(!empty($user)){
                            $id = $user[0]['user_course'];
                            
                            if(!empty($id)){
                                
                                $id_ = explode(",", $id);
                                
                                $courseModel = new CourseModel();
                                $courses = $courseModel->getInfo($id_);
                                


                                if(!empty($courses)){

                                    foreach($courses as $course){
                                       $lec_id = $course[0]['course_lecturer_id'];
                                       $lec = $userModel->getUser($lec_id);
                                       $course[0]['course_lecturer'] = $lec[0]['user_name'];
                                       $courses_[] = $course;
                                    }

                                    $responseData = json_encode($courses_);          
                                    $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
                                } else{
                                    $responseData = json_encode(array('error' => 'There are no lectures!'));
                                    $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 401 Unauthorized'));
                                }
                            } else{
                                $responseData = json_encode(array('error' => 'Student does not have any active lectures!'));
                                $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 401 Unauthorized'));
                            }
                        } else {
                            $responseData = json_encode(array('error' => 'Invalid credentials'));
                            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 401 Unauthorized'));
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