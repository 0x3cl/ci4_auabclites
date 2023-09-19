<?php

namespace App\Controllers\Admin\Process;

use App\Controllers\BaseController;
use App\Models\CustomModel;
use App\Libraries\LogsController;
use App\Libraries\SendEmailController;

class UserController extends BaseController {

    protected $validation;
    protected $logs;

    public function __construct() {
        $this->validation = \Config\Services::validation();
        $this->logs = new LogsController;
    }

    public function validation($type) {
        
        $ruleType = [
            'createUserRules' => [
                'firstname' => [
                    'label' => 'First Name',
                    'rules' => 'required|min_length[4]',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'min_length' => '{field} must be atleast 4 characters'
                    ]
                ],
                'lastname' => [
                    'label' => 'Last Name',
                    'rules' => 'required|min_length[4]',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'min_length' => '{field} must be atleast 4 characters'
                    ]
                ],
                'position' => [
                    'label' => 'Position',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email|is_unique[lites_users.email]',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'valid_email' => '{field} is not a valid email',
                        'is_unique' => '{field} is already taken'
                    ]
                ],
                'username' => [
                    'label' => 'Username',
                    'rules' => 'required|min_length[4]|is_unique[lites_users.username]',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'min_length' => '{field} must be atleast 4 characters',
                        'is_unique' => '{field} is already taken'
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required|min_length[4]|matches[confirm-password]',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'min_length' => '{field} must be atleast 4 characters',
                        'matches' => 'Passwords do not match'
                    ]
                ],
                'confirm-password' => [
                    'label' => 'Confirm Password',
                    'rules' => 'required|min_length[4]',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'min_length' => '{field} must be atleast 4 characters'
                    ]
                ],
                'avatar' => [
                    'label' => 'Profile Image',
                    'rules' => 'uploaded[avatar]|max_size[avatar,5000]|is_image[avatar]',
                    'errors' => [
                        'uploaded' => '{field} is required',
                        'max_size' => '{field} size exceeds the allowed limit',
                        'is_image' => '{field} must be a valid image file'
                    ]
                ]
            ],
            'updateProfileRules' => [
                'firstname' => [
                    'label' => 'First Name',
                    'rules' => 'required|min_length[4]',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'min_length' => '{field} must be atleast 4 characters'
                    ]
                ],
                'lastname' => [
                    'label' => 'Last Name',
                    'rules' => 'required|min_length[4]',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'min_length' => '{field} must be atleast 4 characters'
                    ]
                ],
                'position' => [
                    'label' => 'Position',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                    ]
                ],
            ],
            'updateProfileImageRules' => [
                'file' => [
                    'label' => 'Profile Image',
                    'rules' => 'uploaded[avatar]|max_size[avatar,5000]|is_image[avatar]',
                    'errors' => [
                        'uploaded' => '{field} is required',
                        'max_size' => '{field} size exceeds the allowed limit',
                        'is_image' => '{field} must be a valid image file'
                    ]
                ]
            ]
        ];
   
        if($this->validate($ruleType[$type])) {
           return true;
        } 
        
        return false;

    }
    
    public function add() {
        if($this->request->getMethod() === 'post') {
            if($this->validation('createUserRules')) {
                $file = $this->request->getFile('avatar');
                $filename = $file->getRandomName();
                $path = './assets/admin/uploads/avatar/';
                $model = new CustomModel();

                $uncrypt_password = $this->request->getPost('password');
                
                $send_email = $this->request->getPost('send_email') ?? '';

                $data = [
                    'username' => $this->request->getPost('username'),
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
                    'email' => $this->request->getPost('email'),
                    'first_name' => $this->request->getPost('firstname'),
                    'last_name' => $this->request->getPost('lastname'),
                    'position' => $this->request->getPost('position'),
                    'image' => $filename
                ];

                try {
                    if($model->insertData('lites_users', $data)
                        && optimizeImageUpload($path, $file, $filename)) {
                            if ($send_email == 1 && $this->sendEmail($uncrypt_password, $data)) {
                                $flashdata = [
                                    'status' => 'success',
                                    'message' => 'user was successfully created and email notification has been sent.',
                                ];
                                $this->logs->init('[user] ~ '.$data['username'].' successfully created and email notification has been sent');
                            } else {
                                $flashdata = [
                                    'status' => 'success',
                                    'message' => 'user was successfully created.',
                                ];
                                $this->logs->init('[user] ~ ' . $data['username'] . ' successfully created');
                            }
                    }
                } catch (\Exception $e) {
                    $flashdata = [
                        'status' => 'error',
                        'message' => 'error: ' . $e->getMessage(),
                    ];
                }

            }  else {
                $message = array_values($this->validator->getErrors());
                $flashdata = [
                    'status' => 'error',
                    'message' => $message,
                ];
            }

            session()->setFlashData('flashdata', $flashdata);
            return redirect()->back();
        }
    }

    public function delete_data() {
        if($this->request->getMethod() === 'post') {
            $id = $this->request->getPost('id');
            $path = './assets/admin/uploads/avatar/';
            $model = new CustomModel();
            
            try {
                $username = $model->get_data([
                    'table' => 'lites_users',
                    'condition' => [
                        'column' => 'id',
                        'value' => $id
                    ]
                ])[0]->username;
                
                 $previous_image = $model->get_data([
                    'table' => 'lites_users',
                    'condition' => [
                        'column' => 'id',
                        'value' => $id
                    ]
                ])[0]->image;

                if($model->delete_data('lites_users', ['id' => $id])
                    && removeImage($path . $previous_image)) {
                    $flashdata = [
                        'status' => 'success',
                        'message' => 'user deleted successfully',
                    ];
                    $this->logs->init('[user] ~ '.$username.' deleted successfully');
                }
            } catch (\Exception $e) {
                $flashdata = [
                    'status' => 'error',
                    'message' => 'error: ' . $e->getMessage(),
                ];
            }

            session()->setFlashData('flashdata', $flashdata);
            return redirect()->to('/admin/manage/users');
        }
    }

    public function update_profile() {
        if($this->request->getMethod() === 'post') {
            if($this->validation('updateProfileRules')) {
                $id = $this->request->getPost('id');                
                $model = new CustomModel();
                $data = [
                    'first_name' => $this->request->getPost('firstname'),
                    'last_name' => $this->request->getPost('lastname'),
                    'position' => $this->request->getPost('position'),
                ];

                try {
                    $username = $model->get_data([
                        'table' => 'lites_users',
                        'condition' => [
                            'column' => 'id',
                            'value' => $id
                        ]
                    ])[0]->username;
                    if($model->updateData('lites_users', 'lites_users.id', $id, $data)) {
                        $flashdata = [
                            'status' => 'success',
                            'message' => 'user&apos;s profile information updated successfully',
                        ];
                        $this->logs->init('[user] ~ '.$username.' profile information updated successfully');
                    }
                } catch (\Exception $e) {
                    $flashdata = [
                        'status' => 'error',
                        'message' => 'error: ' . $e->getMessage(),
                    ];
                }
                    
                session()->setFlashData('flashdata', $flashdata);
                return redirect()->back();      
            }    
        }
    }

    public function update_profile_image() {
        if($this->request->getMethod() === 'post') {
            if($this->validation('updateProfileImageRules')) {
                $id = $this->request->getPost('id');
                $file = $this->request->getFile('avatar');
                $filename = $file->getRandomName();
                $table = '';
                $path = './assets/admin/uploads/avatar/';
                $model = new CustomModel();

                $data = [
                    'image' => $filename
                ];

                try {
                    $previous_image = $model->get_data([
                        'table' => 'lites_users',
                        'condition' => [
                            'column' => 'id',
                            'value' => $id
                        ]
                    ])[0]->image;

                    if(removeImage($path . $previous_image)) {
                        $username = $model->get_data([
                            'table' => 'lites_users',
                            'conditions' => [
                                'column' => 'id',
                                'value' => $id
                            ]
                        ])[0]->username;
        
                        if($model->updateData('lites_users', 'id', $id, $data) 
                            && optimizeImageUpload($path, $file, $filename)) {
                                $flashdata = [
                                    'status' => 'success',
                                    'message' => 'user&apos;s profile image updated successfully',
                                ];
                                $this->logs->init('[user] ~ '.$username.' profile image updated successfully');
                        } else {
                            $flashdata = [
                                'status' => 'error',
                                'message' => 'error: failed to move user&apos;s profile image',
                            ];
                        }
                    }

                } catch (\Exception $e) {
                    $flashdata = [
                        'status' => 'error',
                        'message' => 'error: ' . $e->getMessage(),
                    ];
                }
                
            }  else {
                $message = array_values($this->validator->getErrors());
                $flashdata = [
                    'status' => 'error',
                    'message' => $message,
                ];
            }

            session()->setFlashData('flashdata', $flashdata);
            return redirect()->back();
        }
    }
    
    public function sendEmail($uncrypt_password, $data) {

        $fullname = ucwords($data['first_name'] . ' ' . $data['last_name']);
        $email = $data['email'];
        $role = $data['position'];
        $username = $data['username'];
        $password = $uncrypt_password;

        $message = '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="format-detection" content="telephone=no">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title></title>
            <style type="text/css" emogrify="no">
                #outlook a {
                    padding: 0;
                }

                .ExternalClass {
                    width: 100%;
                }

                .ExternalClass,
                .ExternalClass p,
                .ExternalClass span,
                .ExternalClass font,
                .ExternalClass td,
                .ExternalClass div {
                    line-height: 100%;
                }

                table td {
                    border-collapse: collapse;
                    mso-line-height-rule: exactly;
                }

                .editable.image {
                    font-size: 0 !important;
                    line-height: 0 !important;
                }

                .nl2go_preheader {
                    display: none !important;
                    mso-hide: all !important;
                    mso-line-height-rule: exactly;
                    visibility: hidden !important;
                    line-height: 0px !important;
                    font-size: 0px !important;
                }

                body {
                    width: 100% !important;
                    -webkit-text-size-adjust: 100%;
                    -ms-text-size-adjust: 100%;
                    margin: 0;
                    padding: 0;
                }

                img {
                    outline: none;
                    text-decoration: none;
                    -ms-interpolation-mode: bicubic;
                }

                a img {
                    border: none;
                }

                table {
                    border-collapse: collapse;
                    mso-table-lspace: 0pt;
                    mso-table-rspace: 0pt;
                }

                th {
                    font-weight: normal;
                    text-align: left;
                }

                *[class="gmail-fix"] {
                    display: none !important;
                }
            </style>
            <style type="text/css" emogrify="no">
                @media (max-width: 600px) {
                    .gmx-killpill {
                        content: " \03D1";
                    }
                }
            </style>
            <style type="text/css" emogrify="no">
                @media (max-width: 600px) {
                    .gmx-killpill {
                        content: " \03D1";
                    }

                    .r0-o {
                        border-style: solid !important;
                        margin: 0 auto 0 auto !important;
                        width: 320px !important
                    }

                    .r1-i {
                        background-color: #ffffff !important
                    }

                    .r2-c {
                        box-sizing: border-box !important;
                        text-align: center !important;
                        valign: top !important;
                        width: 100% !important
                    }

                    .r3-o {
                        border-style: solid !important;
                        margin: 0 auto 0 auto !important;
                        width: 100% !important
                    }

                    .r4-i {
                        padding-bottom: 0px !important;
                        padding-left: 15px !important;
                        padding-right: 15px !important;
                        padding-top: 0px !important
                    }

                    .r5-c {
                        box-sizing: border-box !important;
                        display: block !important;
                        valign: top !important;
                        width: 100% !important
                    }

                    .r6-o {
                        border-style: solid !important;
                        width: 100% !important
                    }

                    .r7-i {
                        padding-left: 0px !important;
                        padding-right: 0px !important
                    }

                    .r8-i {
                        padding-bottom: 0px !important;
                        padding-top: 0px !important
                    }

                    .r9-o {
                        background-size: cover !important;
                        border-style: solid !important;
                        margin: 0 auto 0 auto !important;
                        width: 100% !important
                    }

                    .r10-c {
                        box-sizing: border-box !important;
                        text-align: center !important;
                        valign: top !important;
                        width: 320px !important
                    }

                    .r11-i {
                        padding-bottom: 61px !important;
                        padding-left: 15px !important;
                        padding-right: 15px !important;
                        padding-top: 50px !important
                    }

                    .r12-i {
                        padding-bottom: 0px !important;
                        padding-left: 0px !important;
                        padding-right: 0px !important;
                        padding-top: 0px !important
                    }

                    .r13-c {
                        box-sizing: border-box !important;
                        text-align: left !important;
                        valign: top !important;
                        width: 100% !important
                    }

                    .r14-o {
                        border-style: solid !important;
                        margin: 0 auto 0 0 !important;
                        width: 100% !important
                    }

                    .r15-i {
                        text-align: left !important
                    }

                    .r16-i {
                        padding-top: 25px !important;
                        text-align: left !important
                    }

                    .r17-i {
                        padding-top: 5px !important;
                        text-align: left !important
                    }

                    .r18-c {
                        box-sizing: border-box !important;
                        text-align: left !important;
                        width: 100% !important
                    }

                    .r19-i {
                        padding-bottom: 10px !important;
                        padding-top: 10px !important
                    }

                    .r20-c {
                        box-sizing: border-box !important;
                        text-align: left !important;
                        valign: top !important;
                        width: 230px !important
                    }

                    .r21-o {
                        border-style: solid !important;
                        margin: 0 auto 0 0 !important;
                        margin-top: 17px !important;
                        width: 230px !important
                    }

                    .r22-i {
                        text-align: center !important
                    }

                    .r23-r {
                        background-color: #6e1815 !important;
                        border-radius: 30px !important;
                        padding-bottom: 15px !important;
                        padding-left: 5px !important;
                        padding-right: 5px !important;
                        padding-top: 16px !important;
                        text-align: center !important;
                        width: 220px !important
                    }

                    .r24-c {
                        box-sizing: border-box !important;
                        text-align: center !important;
                        width: 100% !important
                    }

                    .r25-i {
                        background-color: transparent !important
                    }

                    .r26-i {
                        background-color: #801313 !important;
                        padding-bottom: 42px !important;
                        padding-left: 15px !important;
                        padding-right: 15px !important;
                        padding-top: 37px !important
                    }

                    .r27-i {
                        padding-left: 15px !important;
                        padding-right: 15px !important
                    }

                    .r28-o {
                        border-style: solid !important;
                        margin: 0 auto 0 auto !important;
                        margin-top: 10px !important;
                        width: 100% !important
                    }

                    .r29-i {
                        padding-top: 20px !important;
                        text-align: left !important
                    }

                    .r30-i {
                        font-size: 0px !important;
                        padding-left: 0px !important;
                        padding-right: 134px !important;
                        padding-top: 15px !important
                    }

                    .r31-c {
                        box-sizing: border-box !important;
                        width: 32px !important
                    }

                    .r32-o {
                        border-style: solid !important;
                        margin-right: 10px !important;
                        width: 32px !important
                    }

                    .r33-i {
                        padding-bottom: 5px !important;
                        padding-top: 5px !important
                    }

                    .r34-o {
                        border-style: solid !important;
                        margin-right: 0px !important;
                        width: 32px !important
                    }

                    .r35-i {
                        padding-left: 0px !important;
                        padding-right: 0px !important;
                        padding-top: 30px !important
                    }

                    .r36-i {
                        padding-bottom: 15px !important;
                        padding-top: 15px !important
                    }

                    body {
                        -webkit-text-size-adjust: none
                    }

                    .nl2go-responsive-hide {
                        display: none
                    }

                    .nl2go-body-table {
                        min-width: unset !important
                    }

                    .mobshow {
                        height: auto !important;
                        overflow: visible !important;
                        max-height: unset !important;
                        visibility: visible !important;
                        border: none !important
                    }

                    .resp-table {
                        display: inline-table !important
                    }

                    .magic-resp {
                        display: table-cell !important
                    }
                }
            </style>
            <!--[if !mso]><!-->
            <style type="text/css" emogrify="no">
                @import url("https://fonts.googleapis.com/css2?family=Vollkorn:wght@700&display=swap");
                @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap");
            </style>
            <!--<![endif]-->
            <style type="text/css">
                p,
                h1,
                h2,
                h3,
                h4,
                ol,
                ul {
                    margin: 0;
                }

                a,
                a:link {
                    color: #ffffff;
                    text-decoration: none
                }

                .nl2go-default-textstyle {
                    color: #392F65;
                    font-family: Roboto, Arial, Helvetica, sans-serif;
                    font-size: 16px;
                    line-height: 1.5;
                    word-break: break-word
                }

                .default-button {
                    color: #ffffff;
                    font-family: Roboto, Arial, Helvetica, sans-serif;
                    font-size: 16px;
                    font-style: normal;
                    font-weight: normal;
                    line-height: 1.15;
                    text-decoration: none;
                    word-break: break-word
                }

                .nl2go_class_14_white_l {
                    color: #ffffff;
                    font-family: Roboto, Arial, Helvetica, sans-serif;
                    font-size: 14px;
                    font-weight: 300;
                    word-break: break-word
                }

                .nl2go_class_14_white_reg {
                    color: #ffffff;
                    font-family: Roboto, Arial, Helvetica, sans-serif;
                    font-size: 14px;
                    word-break: break-word
                }

                .nl2go_class_14_white_b {
                    color: #ffffff;
                    font-family: Roboto, Arial, Helvetica, sans-serif;
                    font-size: 14px;
                    font-weight: 700;
                    word-break: break-word
                }

                .nl2go_class_16_white_reg_up {
                    color: #ffffff;
                    font-family: Roboto, Arial, Helvetica, sans-serif;
                    font-size: 16px;
                    text-transform: uppercase;
                    word-break: break-word
                }

                .nl2go_class_16_blue_reg {
                    color: #392F65;
                    font-family: Roboto, Arial, Helvetica, sans-serif;
                    font-size: 16px;
                    word-break: break-word
                }

                .nl2go_class_24_blue_b {
                    color: #392F65;
                    font-family: Roboto, Arial, Helvetica, sans-serif;
                    font-size: 24px;
                    font-weight: 700;
                    word-break: break-word
                }

                .nl2go_class_48_blue_vollkorn_b {
                    color: #392F65;
                    font-family: Vollkorn, Georgia, Times, Times New Roman, serif, Arial;
                    font-size: 48px;
                    word-break: break-word
                }

                .nl2go_class_headline {
                    color: #677876;
                    font-family: Roboto, Arial, Helvetica, sans-serif;
                    font-size: 26px;
                    word-break: break-word
                }

                .nl2go_class_impressum {
                    color: #999999;
                    font-family: Roboto, Arial, Helvetica, sans-serif;
                    font-size: 12px;
                    font-style: italic;
                    word-break: break-word
                }

                .default-heading1 {
                    color: #392F65;
                    font-family: Vollkorn, Georgia, Times, Times New Roman, serif, Arial;
                    font-size: 48px;
                    word-break: break-word
                }

                .default-heading2 {
                    color: #392F65;
                    font-family: Roboto, Arial, Helvetica, sans-serif;
                    font-size: 24px;
                    word-break: break-word
                }

                .default-heading3 {
                    color: #392F65;
                    font-family: Roboto, Arial, Helvetica, sans-serif;
                    font-size: 20px;
                    word-break: break-word
                }

                .default-heading4 {
                    color: #392F65;
                    font-family: Roboto, Arial, Helvetica, sans-serif;
                    font-size: 18px;
                    word-break: break-word
                }

                a[x-apple-data-detectors] {
                    color: inherit !important;
                    text-decoration: inherit !important;
                    font-size: inherit !important;
                    font-family: inherit !important;
                    font-weight: inherit !important;
                    line-height: inherit !important;
                }

                .no-show-for-you {
                    border: none;
                    display: none;
                    float: none;
                    font-size: 0;
                    height: 0;
                    line-height: 0;
                    max-height: 0;
                    mso-hide: all;
                    overflow: hidden;
                    table-layout: fixed;
                    visibility: hidden;
                    width: 0;
                }
            </style>
            <!--[if mso]><xml> <o:OfficeDocumentSettings> <o:AllowPNG/> <o:PixelsPerInch>96</o:PixelsPerInch> </o:OfficeDocumentSettings> </xml><![endif]-->
            <style type="text/css">
                a:link {
                    color: #fff;
                    text-decoration: none;
                }
            </style>
        </head>
        <body bgcolor="#ffffff" text="#392F65" link="#ffffff" yahoo="fix" style="background-color: #ffffff;">
            <table cellspacing="0" cellpadding="0" border="0" role="presentation" class="nl2go-body-table" width="100%" style="background-color: #ffffff; width: 100%;">
                <tr>
                    <td>
                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="600" align="center" class="r0-o" style="table-layout: fixed; width: 600px;">
                            <tr>
                                <td valign="top" class="r1-i" style="background-color: #ffffff;">
                                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" align="center" class="r3-o" style="table-layout: fixed; width: 100%;">
                                        <tr>
                                            <td class="r4-i">
                                                <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                    <tr>
                                                        <th width="100%" valign="top" class="r5-c" style="font-weight: normal;">
                                                            <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r6-o" style="table-layout: fixed; width: 100%;">
                                                                <tr>
                                                                    <td valign="top" class="r7-i">
                                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                            <tr>
                                                                                <td class="r2-c" align="center">
                                                                                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="600" class="r3-o" style="table-layout: fixed; width: 600px;">
                                                                                        <tr>
                                                                                            <td class="r8-i" style="font-size: 0px; line-height: 0px;"> <img src="https://img.mailinblue.com/4387193/images/content_library/original/65090f4d74b3bb1d5462d459.png" width="600" border="0" style="display: block; width: 100%;"></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </th>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" align="center" class="r9-o" style="table-layout: fixed; width: 100%;">
                            <tr>
                                <td valign="top" class="r1-i" style="background-color: #ffffff;">
                                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="600" align="center" class="r0-o" style="table-layout: fixed; width: 600px;">
                                        <tr>
                                            <td class="r11-i" style="padding-bottom: 61px; padding-left: 59px; padding-right: 40px; padding-top: 50px;">
                                                <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                    <tr>
                                                        <th width="100%" valign="top" class="r5-c" style="font-weight: normal;">
                                                            <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r6-o" style="table-layout: fixed; width: 100%;">
                                                                <tr>
                                                                    <td valign="top" class="r12-i">
                                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                            <tr>
                                                                                <td class="r13-c" align="left">
                                                                                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r14-o" style="table-layout: fixed; width: 100%;">
                                                                                        <tr>
                                                                                            <td align="left" valign="top" class="r15-i nl2go-default-textstyle" style="color: #392f65; font-family: Roboto,Arial,Helvetica,sans-serif; font-size: 16px; word-break: break-word; line-height: 1.1; text-align: left;">
                                                                                                <div>
                                                                                                    <h1 class="default-heading1" style="margin: 0; color: #392f65; font-family: Vollkorn,Georgia,Times,Times New Roman,serif,Arial; font-size: 48px; word-break: break-word;"><span style="color: #6E1815;"><strong>You are Invited!</strong></span></h1>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="r13-c" align="left">
                                                                                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r14-o" style="table-layout: fixed; width: 100%;">
                                                                                        <tr>
                                                                                            <td align="left" valign="top" class="r16-i nl2go-default-textstyle" style="color: #000; font-family: Roboto,Arial,Helvetica,sans-serif; font-size: 16px; line-height: 1.5; word-break: break-word; padding-top: 25px; text-align: left;">
                                                                                                <div>
                                                                                                    <h2 class="default-heading2" style="margin: 0; color: #000; font-family: Roboto,Arial,Helvetica,sans-serif; font-size: 24px; word-break: break-word;"><span style="color: #060000; font-family: Palatino, "Palatino Linotype", "Palatino LT STD", "Book Antiqua", Georgia, serif;"><strong>Hello '.ucwords($fullname).', </strong></span></h2>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="r13-c" align="left">
                                                                                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r14-o" style="table-layout: fixed; width: 100%;">
                                                                                        <tr>
                                                                                            <td align="left" valign="top" class="r17-i nl2go-default-textstyle" style="color: #392f65; font-family: Roboto,Arial,Helvetica,sans-serif; font-size: 16px; line-height: 1.5; word-break: break-word; padding-top: 5px; text-align: left;">
                                                                                                <div>
                                                                                                    <p style="margin: 0;"><span style="color: #1C1C1C;">You have received an invitation from Carl Llemos to assume the role of an administrator on the prestigious League of Information Technology Education (LITES) website. Enclosed herein are your assigned duties in this capacity. We express our heartfelt appreciation for your willingness to undertake this position.</span></p>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="r18-c" align="left">
                                                                                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="501" class="r14-o" style="table-layout: fixed;">
                                                                                        <tr>
                                                                                            <td class="r19-i" style="padding-bottom: 10px; padding-top: 10px; height: 3px;">
                                                                                                <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" valign="" class="r19-i" height="3" style="border-top-style: solid; background-clip: border-box; border-top-color: #6e1815; border-top-width: 3px; font-size: 3px; line-height: 3px;">
                                                                                                                <tr>
                                                                                                                    <td height="0" style="font-size: 0px; line-height: 0px;">­</td>
                                                                                                                </tr>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="r13-c" align="left">
                                                                                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r14-o" style="table-layout: fixed; width: 100%;">
                                                                                        <tr>
                                                                                            <td align="left" valign="top" class="r17-i nl2go-default-textstyle" style="color: #392f65; font-family: Roboto,Arial,Helvetica,sans-serif; font-size: 16px; line-height: 1.5; word-break: break-word; padding-top: 5px; text-align: left;">
                                                                                                <div>
                                                                                                    <p style="margin: 0;"><span style="color: #070101;"><strong>ROLE: </strong>'.ucwords(format_position($role)).'</span></p>
                                                                                                    <p style="margin: 0;"><span style="color: #0D0101;"><strong>USERNAME</strong>: '.$username.'</span></p>
                                                                                                    <p style="margin: 0;"><span style="color: #0D0101;"><strong>PASSWORD</strong>: '.$password.'</span></p>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="r18-c" align="left">
                                                                                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="501" class="r14-o" style="table-layout: fixed;">
                                                                                        <tr>
                                                                                            <td class="r19-i" style="padding-bottom: 10px; padding-top: 10px; height: 3px;">
                                                                                                <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" valign="" class="r19-i" height="3" style="border-top-style: solid; background-clip: border-box; border-top-color: #6e1815; border-top-width: 3px; font-size: 3px; line-height: 3px;">
                                                                                                                <tr>
                                                                                                                    <td height="0" style="font-size: 0px; line-height: 0px;">­</td>
                                                                                                                </tr>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="r13-c" align="left">
                                                                                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r14-o" style="table-layout: fixed; width: 100%;">
                                                                                        <tr>
                                                                                            <td align="left" valign="top" class="r17-i nl2go-default-textstyle" style="color: #392f65; font-family: Roboto,Arial,Helvetica,sans-serif; font-size: 16px; line-height: 1.5; word-break: break-word; padding-top: 5px; text-align: left;">
                                                                                                <div>
                                                                                                    <p style="margin: 0;"><span style="color: #070000;"><strong>TO LOGIN</strong> </span></p>
                                                                                                    <ol style="margin: 0 0 30px 0;">
                                                                                                        <li><span style="color: #070000;">Go to '.base_url('/admin/login').'.</span></li>
                                                                                                        <li><span style="color: #070000;">Enter username and password.</span></li>
                                                                                                        <li><span style="color: #070000;">FIll up necessary admin information.</span></li>
                                                                                                        <li><span style="color: #070000;">Change your password.</span></li>
                                                                                                    </ol>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="r20-c" align="left">
                                                                                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="273" class="r21-o" style="table-layout: fixed; width: 273px;">
                                                                                        <tr class="nl2go-responsive-hide">
                                                                                            <td height="17" style="font-size: 17px; line-height: 17px;">­</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height="18" align="center" valign="top" class="r22-i nl2go-default-textstyle" style="color: #392f65; font-family: Roboto,Arial,Helvetica,sans-serif; font-size: 16px; line-height: 1.5; word-break: break-word;">
                                                                                                <!--[if mso]> <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="'.base_url('/admin/login').'" style="v-text-anchor:middle; height: 48px; width: 272px;" arcsize="50%" fillcolor="#6e1815" strokecolor="#6e1815" strokeweight="1px" data-btn="1"> <w:anchorlock> </w:anchorlock> <v:textbox inset="0,0,0,0"> <div style="display:none;"> <center class="default-button"><span>OPEN ADMIN PANEL</span></center> </div> </v:textbox> </v:roundrect> <![endif]-->
                                                                                                <!--[if !mso]><!-- --> <a href="'.base_url('/admin/login').'" class="r23-r default-button" target="_blank" data-btn="1" style="font-style: normal; font-weight: normal; line-height: 1.15; text-decoration: none; word-break: break-word; border-style: solid; word-wrap: break-word; display: block; -webkit-text-size-adjust: none; background-color: #6e1815; border-bottom-width: 0px; border-color: #6e1815; border-left-width: 0px; border-radius: 30px; border-right-width: 0px; border-top-width: 0px; color: #ffffff; font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 16px; height: 18px; mso-hide: all; padding-bottom: 15px; padding-left: 5px; padding-right: 5px; padding-top: 16px; width: 263px;"> <span>OPEN ADMIN PANEL</span></a>
                                                                                                <!--<![endif]-->
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="r24-c" align="center">
                                                                                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="501" class="r3-o" style="table-layout: fixed; width: 501px;">
                                                                                        <tr>
                                                                                            <td height="50" class="r25-i" style="font-size: 50px; line-height: 50px; background-color: transparent;"> ­ </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="r13-c" align="left">
                                                                                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r14-o" style="table-layout: fixed; width: 100%;">
                                                                                        <tr>
                                                                                            <td align="left" valign="top" class="r17-i nl2go-default-textstyle" style="color: #392f65; font-family: Roboto,Arial,Helvetica,sans-serif; font-size: 16px; line-height: 1.5; word-break: break-word; padding-top: 5px; text-align: left;">
                                                                                                <div>
                                                                                                    <p style="margin: 0;"><strong>SYSTEM GENERATED</strong></p>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </th>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="600" align="center" class="r0-o" style="table-layout: fixed; width: 600px;">
                            <tr>
                                <td valign="top" class="r1-i" style="background-color: #ffffff;">
                                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" align="center" class="r3-o" style="table-layout: fixed; width: 100%;">
                                        <tr>
                                            <td class="r26-i" style="background-color: #801313; padding-bottom: 42px; padding-left: 59px; padding-right: 58px; padding-top: 37px;">
                                                <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                    <tr>
                                                        <th width="50%" valign="top" class="r5-c" style="font-weight: normal;">
                                                            <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r6-o" style="table-layout: fixed; width: 100%;">
                                                                <tr>
                                                                    <td valign="top" class="r27-i" style="padding-left: 15px; padding-right: 15px;">
                                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                            <tr>
                                                                                <td class="r13-c" align="left">
                                                                                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r14-o" style="table-layout: fixed; width: 100%;">
                                                                                        <tr>
                                                                                            <td align="left" valign="top" class="r15-i nl2go-default-textstyle" style="color: #392f65; font-family: Roboto,Arial,Helvetica,sans-serif; font-size: 16px; line-height: 1.5; word-break: break-word; text-align: left;">
                                                                                                <div>
                                                                                                    <div class="nl2go_class_14_white_b" style="color: #fff; font-family: Roboto,Arial,Helvetica,sans-serif; font-size: 14px; font-weight: 700; word-break: break-word;"><span style="font-size: 18px;">ARELLANO UNIVERSITY</span></div>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="r13-c" align="left">
                                                                                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r14-o" style="table-layout: fixed; width: 100%;">
                                                                                        <tr>
                                                                                            <td align="left" valign="top" class="r15-i nl2go-default-textstyle" style="color: #392f65; font-family: Roboto,Arial,Helvetica,sans-serif; font-size: 16px; line-height: 1.5; word-break: break-word; text-align: left;">
                                                                                                <div>
                                                                                                    <div class="nl2go_class_14_white_l" style="color: #fff; font-family: Roboto,Arial,Helvetica,sans-serif; font-size: 14px; font-weight: 300; word-break: break-word;"><span style="font-size: 12px;"><strong>Pag-asa St. Caniogan Pasig City </strong></span></div>
                                                                                                    <div class="nl2go_class_14_white_l" style="color: #fff; font-family: Roboto,Arial,Helvetica,sans-serif; font-size: 14px; font-weight: 300; word-break: break-word;"><span style="font-size: 12px;"><strong>1606 Metro Manila</strong></span></div>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="r24-c" align="center">
                                                                                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="211" class="r28-o" style="table-layout: fixed;">
                                                                                        <tr class="nl2go-responsive-hide">
                                                                                            <td height="10" style="font-size: 10px; line-height: 10px;">­</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="r8-i" style="height: 2px;">
                                                                                                <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" valign="" class="r8-i" height="2" style="border-top-style: solid; background-clip: border-box; border-top-color: #b26e6e; border-top-width: 2px; font-size: 2px; line-height: 2px;">
                                                                                                                <tr>
                                                                                                                    <td height="0" style="font-size: 0px; line-height: 0px;">­</td>
                                                                                                                </tr>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="r13-c" align="left">
                                                                                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r14-o" style="table-layout: fixed; width: 100%;">
                                                                                        <tr>
                                                                                            <td align="left" valign="top" class="r29-i nl2go-default-textstyle" style="color: #392f65; font-family: Roboto,Arial,Helvetica,sans-serif; font-size: 16px; line-height: 1.5; word-break: break-word; padding-top: 7px; text-align: left;">
                                                                                                <div>
                                                                                                    <div class="nl2go_class_14_white_b" style="color: #fff; font-family: Roboto,Arial,Helvetica,sans-serif; font-size: 14px; font-weight: 700; word-break: break-word;"><span style="font-size: 18px;">KEEP IN TOUCH</span></div>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="r13-c" align="left">
                                                                                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r14-o" style="table-layout: fixed; width: 100%;">
                                                                                        <tr>
                                                                                            <td align="left" valign="top" class="r15-i nl2go-default-textstyle" style="color: #392f65; font-family: Roboto,Arial,Helvetica,sans-serif; font-size: 16px; line-height: 1.5; word-break: break-word; text-align: left;">
                                                                                                <div>
                                                                                                    <div class="nl2go_class_14_white_l" style="color: #fff; font-family: Roboto,Arial,Helvetica,sans-serif; font-size: 14px; font-weight: 300; word-break: break-word;"><strong>8-641-4203</strong></div>
                                                                                                    <div class="nl2go_class_14_white_l" style="color: #fff; font-family: Roboto,Arial,Helvetica,sans-serif; font-size: 14px; font-weight: 300; word-break: break-word;"><strong>contact@auabclites.com</strong></div>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="r18-c" align="left">
                                                                                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="211" align="left" class="r14-o" style="table-layout: fixed; width: 211px;">
                                                                                        <tr>
                                                                                            <td valign="top">
                                                                                                <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                                    <tr>
                                                                                                        <td class="r18-c" align="left" style="display: inline-block;">
                                                                                                            <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="211" align="left" class="r14-o" style="table-layout: fixed; width: 211px;">
                                                                                                                <tr>
                                                                                                                    <td class="r30-i" style="padding-right: 95px; padding-top: 15px;">
                                                                                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                                                                            <tr>
                                                                                                                                <th width="42" class="r31-c mobshow resp-table" style="font-weight: normal;">
                                                                                                                                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r32-o" style="table-layout: fixed; width: 100%;">
                                                                                                                                        <tr>
                                                                                                                                            <td class="r33-i" style="font-size: 0px; line-height: 0px; padding-bottom: 5px; padding-top: 5px;"> <a href="https://www.facebook.com/LITESofficial" target="_blank" style="color: #fff; text-decoration: none;"> <img src="https://creative-assets.mailinblue.com/editor/social-icons/original_light/facebook_32px.png" width="32" border="0" style="display: block; width: 100%;"></a> </td>
                                                                                                                                            <td class="nl2go-responsive-hide" width="10" style="font-size: 0px; line-height: 1px;">­ </td>
                                                                                                                                        </tr>
                                                                                                                                    </table>
                                                                                                                                </th>
                                                                                                                                <th width="42" class="r31-c mobshow resp-table" style="font-weight: normal;">
                                                                                                                                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r32-o" style="table-layout: fixed; width: 100%;">
                                                                                                                                        <tr>
                                                                                                                                            <td class="r33-i" style="font-size: 0px; line-height: 0px; padding-bottom: 5px; padding-top: 5px;"> <img src="https://creative-assets.mailinblue.com/editor/social-icons/original_light/instagram_32px.png" width="32" border="0" style="display: block; width: 100%;"></td>
                                                                                                                                            <td class="nl2go-responsive-hide" width="10" style="font-size: 0px; line-height: 1px;">­ </td>
                                                                                                                                        </tr>
                                                                                                                                    </table>
                                                                                                                                </th>
                                                                                                                                <th width="32" class="r31-c mobshow resp-table" style="font-weight: normal;">
                                                                                                                                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r34-o" style="table-layout: fixed; width: 100%;">
                                                                                                                                        <tr>
                                                                                                                                            <td class="r33-i" style="font-size: 0px; line-height: 0px; padding-bottom: 5px; padding-top: 5px;"> <img src="https://creative-assets.mailinblue.com/editor/social-icons/original_light/twitter_32px.png" width="32" border="0" style="display: block; width: 100%;"></td>
                                                                                                                                        </tr>
                                                                                                                                    </table>
                                                                                                                                </th>
                                                                                                                            </tr>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </th>
                                                        <th width="50%" valign="top" class="r5-c" style="font-weight: normal;">
                                                            <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="100%" class="r6-o" style="table-layout: fixed; width: 100%;">
                                                                <tr>
                                                                    <td valign="top" class="r35-i">
                                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                            <tr>
                                                                                <td class="r2-c" align="center">
                                                                                    <table cellspacing="0" cellpadding="0" border="0" role="presentation" width="147" class="r3-o" style="table-layout: fixed; width: 147px;">
                                                                                        <tr>
                                                                                            <td class="r36-i" style="font-size: 0px; line-height: 0px; padding-bottom: 15px; padding-top: 15px;"> <img src="https://img.mailinblue.com/4387193/images/content_library/original/65090393cd11ce7dcb1f169b.png" width="147" border="0" style="display: block; width: 100%;"></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </th>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        ';

        $config = [
            'to' => $email,
            'subject' => 'Admin Invitation for AUABCLITES Website',
            'message' => $message
        ];

        $email = new SendEmailController;

        return $email->sendEmail($config);
    }
}