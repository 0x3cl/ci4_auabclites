<?php

namespace App\Libraries;
use App\Controllers\BaseController;
use App\Models\CustomModel;

class SendEmailController extends BaseController {

    protected $email;
    public function __construct() {
        $this->email = \Config\Services::email();
    }

    public function getSMTP() {
        $model = new CustomModel;

        try {
            $data = $model->get_data([
                'table' => 'lites_smtp'
            ]);

            return $data;

        } catch (\Exception $e) {   
            echo 'error: ' . $e->getMessage();
        }

    }

    public function sendEmail($data) {

        // INITIALIZE SMTP CONFIG SAVED FROM DATABASE
        $smtp = $this->getSMTP();

        // EXTRACT DATA
        $to = $data['to'];
        $subject = $data['subject'];
        $message = $data['message'];

        // SMTP CONFIGURATIONS
        
        $config = [
            'protocol' => 'smtp',
            'SMTPHost' => $smtp[0]->hostname,
            'SMTPPort' => $smtp[0]->port,
            'SMTPUser' => $smtp[0]->username,
            'SMTPPass' => $smtp[0]->password,
            'SMTPTimeout' => 7,
            'charset' => 'utf-8',
            'newline' => "\r\n",
            'mailType' => 'html', 
            'validate' => true, 
        ];

        $this->email->initialize($config);
        $this->email->setFrom($smtp[0]->sender);

         // LOOP TO HANDLE MULTIPLE RECEPIENT
        if(is_array($to)) {
            $recepients = [];
            foreach($to as $value) {
                $recepients[] = $value->email;
            }
        } else {
            $recepients = $to;
        }

        $this->email->setTo($recepients);

        // PREPRARE SUBJECT OF THE EMAIL
        $this->email->setSubject($subject);
        $this->email->setMessage($message);

        // SEND EMAIL; CHECK IF EMAIL SENT OR NOT
        
        if($this->email->send()) {
            return true;
        } else {
            return false;
        }
    }

}