<?php
    class UserController extends BaseController
    {

        public function loginAction()
        {
            $strErrorDesc = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            
            if (strtoupper($requestMethod) == 'POST') {
                
                if (isset($_POST['mail']) && isset($_POST['pass'])) {
                    $mail = $_POST['mail'];
                    $pass = sha1($_POST['pass']);
                    
                    try {
                        $userModel = new UserModel();
                        $userInfo = $userModel->getinfo($mail);

                        if (!empty($userInfo) && ($pass == $userInfo[0]["user_pass"])) {
                            
                            $hash = $userInfo[0]["user_hash"]; 
                            $uname = $userInfo[0]["user_name"]; 
                            $mail = $userInfo[0]["user_mail"]; 
                            $stuNo = $userInfo[0]["user_stu_no"];
                            $idNo = $userInfo[0]["user_id_no"];
                            $facTr = $userInfo[0]["user_fac_tr"];
                            $facEn = $userInfo[0]["user_fac_en"];
                            $depTr = $userInfo[0]["user_dep_tr"];
                            $depEn = $userInfo[0]["user_dep_en"];
                            $photo = $userInfo[0]["user_photo"];
                            $courses = $userInfo[0]["user_course"];

                            
                            if($userInfo[0]["user_active"]){
                                $active = true;
                            } else {
                                $active = false;
                            }
                        
                            $responseData = json_encode(array('hash' => $hash, 'uname' => $uname, 'mail' => $mail, 'stuNo' => $stuNo, 'idNo' => $idNo, 'facTr' => $facTr, 'facEn' => $facEn, 'depTr' => $depTr, 'depEn' => $depEn, 'photo' => $photo, 'courses' => $courses, 'active' => $active ));
                            
                            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
                        } else {
                            // Invalid credentials
                            $responseData = json_encode(array('error' => 'Invalid credentials'));
                            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 401 Unauthorized'));
                        }
                    } catch (Exception $e) {
                        $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                        $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                    }
                } else {
                    $strErrorDesc = 'Missing required parameters here';
                    $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
                }
            } else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = 'HTTP/1.1 405 Method Not Allowed';
            }
            
            // Send output
            if ($strErrorDesc) {
                $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                    array('Content-Type: application/json', $strErrorHeader)
                );
            }
        }

        public function changepassAction()
        {
            
            $strErrorDesc = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            
            if (strtoupper($requestMethod) == 'POST') {

                if(isset($_POST['hash']) && isset($_POST['old_pass']) && isset($_POST['new_pass'])){

                    $hash = $_POST['hash'];
                    $old_pass = sha1($_POST['old_pass']);
                    $new_pass = sha1($_POST['new_pass']);

                    try{
                        $userModel = new UserModel();
                        $userInfo = $userModel->isAuth($hash);
                        
                        if (!empty($userInfo) && ($old_pass == $userInfo[0]["user_pass"])){
                            
                            $id = $userInfo[0]["user_id"];
                            $passUpdate = $userModel->changePass($id, $new_pass);

                            $responseData = json_encode(array('success' => 'Password changed successfully!'));
                            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
                        } else{
                             // Invalid credentials
                             $responseData = json_encode(array('error' => 'Invalid credentials'));
                             $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 401 Unauthorized'));
                        }

                    } catch(Exception $e){
                        $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                        $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                    }

                } else {
                    $strErrorDesc = 'Missing required parameters here';
                    $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
                }

            } else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = 'HTTP/1.1 405 Method Not Allowed';
            }

        }

        public function updateAction()//!!!!!!
        {
            $strErrorDesc = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];

            if (strtoupper($requestMethod) == 'POST') {
                if (isset($_POST['mail']) && isset($_POST['pass']) && isset($_POST['uname'])) {
                    $mail = $_POST['mail'];
                    $pass = sha1($_POST['pass']);
                    $uname = $_POST['uname'];
                    $hash = sha1(md5($_POST["mail"]));

                    try {
                        $userModel = new UserModel();
                        $existingUser = $userModel->getinfo($mail);

                        if (empty($existingUser)) {
                            // User does not exist, proceed with registration
                            $insertId = $userModel->insertUser($mail, $pass, $uname, $hash);

                            if ($insertId) {
                                // User registered successfully
                                //$responseData = json_encode(array('userId' => $insertId));
                                //$responseData = json_encode(array('Status' => "User Created"));
                                $responseData = json_encode(array('token' => $token));
                                $this->sendOutput($responseData,array('Content-Type: application/json', 'HTTP/1.1 201 Created'));
                                //$this->sendOutput(array('Content-Type: application/json', 'HTTP/1.1 201 Created'));
                            } else {
                                // Failed to register user
                                $responseData = json_encode(array('error' => 'Failed to register user'));
                                $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 500 Internal Server Error'));
                            }
                        } else {
                            // User already registered
                            $responseData = json_encode(array('error' => 'User already registered'));
                            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 409 Conflict'));
                        }
                    } catch (Exception $e) {
                        $strErrorDesc = $e->getMessage() . ' Something went wrong! Please contact support.';
                        $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                    }
                } else {
                    $strErrorDesc = 'Missing required parameters';
                    $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
                }
            } else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = 'HTTP/1.1 405 Method Not Allowed';
            }

            // Send output
            if ($strErrorDesc) {
                $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                    array('Content-Type: application/json', $strErrorHeader)
                );
            }
        }
    }