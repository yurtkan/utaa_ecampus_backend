<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Gerekli dosyaları include ediyoruz
require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/Exception.php";
require_once "PHPMailer/SMTP.php";

class ContactController extends BaseController
{

    public function confirmAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (strtoupper($requestMethod) == 'POST') {
            if (isset($_POST['hash']) && isset($_POST['title']) && isset($_POST['text'])) {
                $token = $_POST['hash'];
                $title = $_POST['title'];
                $text = $_POST['text'];

                try {
                    $userModel = new UserModel();
                    $userInfo = $userModel->isAuth($token);

                    if (!empty($userInfo) && ($token == $userInfo[0]["user_hash"])) {
                                    
                        $mailStatusCustomer = $this->sendMail(('Copy of your contact form\n\n'.$_POST['title'].'\n'.$_POST['text']), 'eCampus - Contact Form Confirmation', $userInfo[0]["user_mail"], $userInfo[0]["user_name"], 'ecampus@domain');
                        $mailStatusBusiness = $this->sendMail(($_POST['title'].'\n'.$_POST['text']), 'eCampus Contact Form', 'ecampus@domain', 'UTAA eCampus', $userInfo[0]["user_mail"]);

                        if ($mailStatusCustomer == true && $mailStatusBusiness == true) {
                            $responseData = json_encode(array('Status' => 'Mail Sended'));
                            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
                        } else {
                            $strErrorDesc = ' Something went wrong! Please contact support.';
                            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                        }
                    } else {
                        // Invalid credentials
                        $responseData = json_encode(array('error' => 'Invalid credentials'));
                        $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 401 Unauthorized'));
                    }
                } catch (Exception $e) {
                    $strErrorDesc = $e->getMessage() . ' Something went wrong! Please contact support.';
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

    protected function sendMail($mailbody, $mailsubject, $sendto, $cusname, $replyto)
    {
        try {
            $mail = new PHPMailer(true);

            //SMTP Sunucu Ayarları
            $mail->SMTPDebug = 0; // DEBUG Kapalı: 0, DEBUG Açık: 2
            $mail->isSMTP();
            $mail->Host = 'smtp.yandex.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'mail';
            $mail->Password = 'pass';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('mail', 'mailname');

            //Alici Ayarları
            $mail->addAddress($sendto, $cusname);
            $mail->addReplyTo($replyto);

            // İçerik
            $mail->isHTML(true);
            $mail->CharSet = 'utf-8';
            $mail->Subject = $mailsubject;
            $mail->Body = $mailbody;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return "Error: {$mail->ErrorInfo}";
        }
    }
}
