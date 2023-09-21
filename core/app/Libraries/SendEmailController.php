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
        $to = $data['to'] ?? '';
        $bcc = $data['bcc'] ?? '';
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

        // LOOP TO HANDLE MULTIPLE TO RECEPIENT
        if(is_array($to)) {
            $to_recepients = [];
            foreach($to as $value) {
                $to_recepients[] = $value->email;
            }
        } else {
            $to_recepients = $to;
        }

        // LOOP TO HANDLE MULTIPLE BCC RECEPIENT
        if(is_array($bcc)) {
            $bcc_recepients = [];
            foreach($bcc as $value) {
                $bcc_recepients[] = $value->email;
            }
        } else {
            $bcc_recepients = $bcc;
        }

        $this->email->setTo($to_recepients);
        $this->email->setBCC($bcc_recepients);

        // PREPRARE SUBJECT OF THE EMAIL
        $this->email->setSubject($subject);
        $this->email->setMessage($message);

        // SEND EMAIL; CHECK IF EMAIL SENT OR NOT
        
        if($this->email->send()) {
            $status = [
                'status' => 'success'
            ];

            return $status;
        } else {
            $status = [
                'status' => 'error',
                'message' => $this->email->printDebugger(['message'])
            ];
            return $status;
        }
    }

    public function template($body) {
        $header = '
        <!DOCTYPE html>
        <html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" lang="en">
        <head>
            <title></title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <meta name="viewport" content="width=device-width,initial-scale=1">
            <!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]-->
            <!--[if !mso]><!-->
            <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;700;900&amp;display=swap" rel="stylesheet" type="text/css">
            <!--<![endif]-->
            <style>
                * {
                    box-sizing: border-box
                }

                body {
                    margin: 0;
                    padding: 0;
                    color: #323232;
                }

                p {
                    font-size: 15px;
                }

                a[x-apple-data-detectors] {
                    color: inherit !important;
                    text-decoration: inherit !important
                }

                #MessageViewBody a {
                    color: inherit;
                    text-decoration: none
                }

                p {
                    line-height: inherit
                }

                .desktop_hide,
                .desktop_hide table {
                    mso-hide: all;
                    display: none;
                    max-height: 0;
                    overflow: hidden
                }

                .image_block img+div {
                    display: none
                }

                .im {
                    color: #323232 !important;
                    font-size: 14px !important;
                }

                @media (max-width:768px) {

                    .row-6 .column-2 .block-2.button_block .alignment a,
                    .row-6 .column-2 .block-2.button_block .alignment div {
                        display: inline-block !important
                    }

                    .image_block img.fullWidth {
                        max-width: 100% !important
                    }

                    .mobile_hide {
                        display: none
                    }

                    .row-content {
                        width: 100% !important
                    }

                    .stack .column {
                        width: 100%;
                        display: block
                    }

                    .mobile_hide {
                        min-height: 0;
                        max-height: 0;
                        max-width: 0;
                        overflow: hidden;
                        font-size: 0
                    }

                    .desktop_hide,
                    .desktop_hide table {
                        display: table !important;
                        max-height: none !important
                    }

                    .row-2 .column-2 .block-3.paragraph_block td.pad {
                        padding: 10px 25px 20px !important
                    }

                    .row-2 .column-2 .block-2.image_block td.pad {
                        padding: 0 15px 40px !important
                    }

                    .row-1 .column-1 .block-1.spacer_block,
                    .row-2 .column-1 .block-1.spacer_block {
                        height: 55px !important
                    }

                    .row-2 .column-2 .block-6.divider_block td.pad {
                        padding: 15px 10px 15px 5px !important
                    }

                    .row-2 .column-2 .block-6.divider_block .alignment table,
                    .row-2 .column-2 .block-8.divider_block .alignment table {
                        display: inline-table
                    }

                    .row-2 .column-2 .block-5.paragraph_block td.pad {
                        padding: 0 25px !important
                    }

                    .row-2 .column-2 .block-8.divider_block td.pad {
                        padding: 15px 10px !important
                    }

                    .row-2 .column-2 .block-11.button_block td.pad {
                        padding: 25px 30px 15px !important
                    }

                    .row-2 .column-2 .block-11.button_block a,
                    .row-2 .column-2 .block-11.button_block div,
                    .row-2 .column-2 .block-11.button_block span,
                    .row-6 .column-2 .block-2.button_block a,
                    .row-6 .column-2 .block-2.button_block div,
                    .row-6 .column-2 .block-2.button_block span {
                        font-size: 16px !important;
                        line-height: 16px !important
                    }

                    .row-2 .column-2 .block-7.paragraph_block td.pad,
                    .row-2 .column-2 .block-9.paragraph_block td.pad {
                        padding: 0 30px !important
                    }

                    .row-2 .column-2 .block-10.list_block td.pad {
                        padding: 10px 15px !important
                    }

                    .row-2 .column-2 .block-10.list_block ol,
                    .row-2 .column-2 .block-10.list_block ul {
                        line-height: auto !important
                    }

                    .row-4 .column-2 .block-2.paragraph_block td.pad>div,
                    .row-6 .column-2 .block-1.paragraph_block td.pad>div {
                        font-size: 16px !important
                    }

                    .row-4 .column-2 .block-2.paragraph_block td.pad {
                        padding: 20px 0 !important
                    }

                    .row-6 .column-2 .block-1.paragraph_block td.pad {
                        padding: 15px 60px 30px !important
                    }

                    .row-4 .column-2 .block-1.paragraph_block td.pad>div {
                        font-size: 36px !important
                    }

                    .row-4 .column-2 .block-1.paragraph_block td.pad {
                        padding: 0 !important
                    }

                    .row-6 .column-2 .block-2.button_block td.pad {
                        padding: 10px 0 30px !important
                    }

                    .row-6 .column-2 .block-2.button_block .alignment {
                        text-align: center !important
                    }

                    .row-4 .column-1 {
                        padding: 30px 0 0 !important
                    }

                    .row-4 .column-2 {
                        padding: 5px 60px !important
                    }
                }
            </style>
        </head>
        ';

        $footer = '
        </html>
        ';

        return $header . $body . $footer;

    }
}