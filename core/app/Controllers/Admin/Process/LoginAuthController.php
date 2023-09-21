<?php

namespace App\Controllers\Admin\Process;

use App\Controllers\BaseController;
use App\Libraries\LogsController;
use App\Models\LoginAuthModel;
use App\Models\CustomModel;
use App\Libraries\SendEmailController;

class LoginAuthController extends BaseController {

    protected $logs;

    public function __construct() {
        $this->logs = new LogsController();
    }

    public function login() {
        if($this->request->getMethod() === 'post') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            if(empty($username || empty($password))) {
                $flashdata = [
                    'status' => 'error',
                    'message' => 'username and password cannot be blanked',
                ];                
            } else {
                $model = new LoginAuthModel;
                $data = $model->login('username', $username);
                if(count($data) > 0 && !empty($data)) {
                    $db_password = $data[0]->password;
                    $is_matched = password_verify($password, $db_password);
                    if($is_matched) {
                        $session_token = [
                            'id' => $data[0]->id,
                            'first_name' => $data[0]->first_name,
                            'last_name' => $data[0]->last_name,
                            'position' => $data[0]->position,
                            'username' => $username,
                            'image' => $data[0]->image
                        ];
                        session()->set('session_token', $session_token);
                        $this->logs->init('logged in');
                        return redirect()->to('/admin/dashboard');
                    } else {
                        $flashdata = [
                            'status' => 'error',
                            'message' => 'invalid username or password',
                        ];
                    }   
                } else {
                    $flashdata = [
                        'status' => 'error',
                        'message' => 'username does not exists',
                    ];
                }
            }
            session()->setFlashData('flashdata', $flashdata);
            return redirect()->to('admin/login');
        }
    }

    public function recover() {
        if($this->request->getMethod() === 'post') {
            $umail = $this->request->getPost('umail');
            if(!empty($umail)) {
                $model = new CustomModel;

                $result = $model->get_data([
                    'table' => 'lites_users',
                    'condition' => [
                        [
                            'column' => 'lites_users.email',
                            'value' => $umail
                        ],
                    ]
                ]);

                if(count($result) == 1) {

                    $is_recovery = $model->get_data([
                        'table' => 'lites_recovery',
                        'condition' => [
                            'column' => 'user_id',
                            'value' => $result[0]->id
                        ]
                    ]);

                    $fullname = ucwords($result[0]->first_name . ' ' . $result[0]->last_name);
                    $email = $result[0]->email;
                    $username = $result[0]->username;
                    $code = generateRandomCode(5, 8);
                    $expiration = time() + 300;
                    
                    $data = [
                        'user_id' => $result[0]->id,
                        'code' => $code,
                        'expiration' => $expiration
                    ];

                    $is_success = false;

                    if(count($is_recovery) > 0) {
                        if($model->update_data('lites_recovery', 'user_id', $result[0]->id, $data)) {
                            $is_success = true;
                        }
                    } else {
                        if($model->insert_data('lites_recovery', $data)) {
                            $is_success = true;
                        }
                    }

                    if($is_success) {


                        $data = [
                            'username' => $username,
                            'fullname' => $fullname,
                            'email' => $email,
                            'code' => $code,
                        ];

                        $message = '
                        <body><u></u>
                            <div style="background-color:#f0f0f0;margin:0;padding:0">
                                <table class="m_nl-container" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#f0f0f0;background-size:auto;background-image:none;background-position:top left;background-repeat:no-repeat">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table class="m_row m_row-1" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-size:auto">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <table class="m_row-content m_stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-size:auto;border-radius:0;color:#000;width:825px;margin:0 auto" width="825">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="m_column m_column-1" width="100%" style="font-weight:400;text-align:left;padding-bottom:5px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                                                <div class="m_spacer_block m_block-1" style="height:100px;line-height:100px;font-size:1px"> </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table class="m_row m_row-2" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-size:auto">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <table class="m_row-content m_stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-size:auto;border-radius:0;color:#000;width:825px;margin:0 auto" width="825">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="m_column m_column-1" width="16.666666666666668%" style="font-weight:400;text-align:left;border-top:26px solid transparent;vertical-align:top;border-right:0;border-bottom:0;border-left:0">
                                                                                <div class="m_spacer_block m_block-1 m_mobile_hide" style="height:60px;line-height:60px;font-size:1px"> </div>
                                                                            </td>
                                                                            <td class="m_column m_column-2" width="66.66666666666667%" style="font-weight:400;text-align:left;background-color:#fff;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                                                <div class="m_spacer_block m_block-1" style="height:50px;line-height:50px;font-size:1px"> </div>
                                                                                <table class="m_image_block m_block-2" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                                                                    <tr>
                                                                                        <td class="m_pad" style="padding-left:30px;padding-right:45px;width:100%">
                                                                                            <div class="m_alignment" align="right" style="line-height:10px"><img src="https://ci4.googleusercontent.com/proxy/CbISjZ9ern2yLeaHcH0gIAtSpk2bAxEoarekAmeQvHIaCQHtUd9puumha5uVFzE1UEnAVVM4ILn-58LG02GoJJU4qGs1xhyaveBX4XxLt85enMPqIx2hNZA-dfcQapUlcM7dTegRO099ut2dR6SEibsqGFw98fbP7Kj2cLIu4JsVrmbJfAG62JmvoxtYShq2VxjrZgs-V_cWTazaszK9FrViJSfo2tjMIgQ=s0-d-e1-ft#https://d15k2d11r6t6rl.cloudfront.net/public/users/Integrators/0db9f180-d222-4b2b-9371-cf9393bf4764/0bd8b69e-4024-4f26-9010-6e2a146401fb/site_logo.png" style="display:block;height:auto;border:0;max-width:110px;width:100%" width="110"></div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                                <table class="m_paragraph_block m_block-3" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="word-break:break-word">
                                                                                    <tr>
                                                                                        <td class="m_pad" style="padding-bottom:20px;padding-left:60px;padding-right:60px;padding-top:20px">
                                                                                            <div style="color:#323232;direction:ltr;font-family:Roboto,Tahoma,Verdana,Segoe,sans-serif;font-size:18px;font-weight:400;letter-spacing:0;line-height:120%;text-align:left">
                                                                                                <p style="margin:15px 0 0 0"><strong>Hello '.ucwords($data["fullname"]).',</strong></p>
                                                                                            </p>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                                <table class="m_paragraph_block m_block-4" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="word-break:break-word">
                                                                                    <tr>
                                                                                        <td class="m_pad" style="padding-left:60px;padding-right:60px">
                                                                                            <div style="color:#323232;direction:ltr;font-family:Roboto,Tahoma,Verdana,Segoe,sans-serif;font-size:14px;font-weight:400;letter-spacing:0;line-height:150%;text-align:left">
                                                                                                <p style="margin:0">
                                                                                                    We hope this message finds you well. We have recently received a request for account recovery for your auabcsite admin account. Below is your recovery guide.</p>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                                <table class="m_divider_block m_block-5" width="100%" border="0" cellpadding="15" cellspacing="0" role="presentation">
                                                                                    <tr>
                                                                                        <td class="m_pad">
                                                                                            <div class="m_alignment" align="center">
                                                                                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="85%">
                                                                                                    <tr>
                                                                                                        <td class="m_divider_inner" style="font-size:1px;line-height:1px;border-top:5px solid #640f0f"><span> </span></td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                                <table class="m_paragraph_block m_block-6" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="word-break:break-word">
                                                                                    <tr>
                                                                                        <td class="m_pad" style="padding-left:60px;padding-right:60px">
                                                                                            <div style="color:#323232;direction:ltr;font-family:Roboto,Tahoma,Verdana,Segoe,sans-serif;font-size:14px;font-weight:400;letter-spacing:0;line-height:150%;text-align:left">
                                                                                                <p style="margin:0;margin-bottom:20px;color:#323232 !important;text-decoration: none"><strong>USERNAME: </strong>'.$data["username"].'<br><strong style="color: #323232">EMAIL: </strong><a href="'.$data["email"].'" style="text-decoration: none; color: #323232">'.$data["email"].'</a><br><strong>RECOVERY CODE: </strong>'.$data["code"].'<br><strong style="color: #323232">NOTE: </strong><span style="color: #323232">Recovery code is only valid for 5 minutes</span>.</p>
                                                                                                <p style="margin:0; color: #323232;">
                                                                                                    <strong>Please ignore this message if it wasn&#39;t requested by you.</strong>
                                                                                                </p>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                                <table class="m_divider_block m_block-7" width="100%" border="0" cellpadding="15" cellspacing="0" role="presentation">
                                                                                    <tr>
                                                                                        <td class="m_pad">
                                                                                            <div class="m_alignment" align="center">
                                                                                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="85%">
                                                                                                    <tr>
                                                                                                        <td class="m_divider_inner" style="font-size:1px;line-height:1px;border-top:5px solid #640f0f"><span> </span></td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                                <table class="m_paragraph_block m_block-8" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="word-break:break-word">
                                                                                    <tr>
                                                                                        <td class="m_pad" style="padding-left:60px;padding-right:60px">
                                                                                            <div style="color:#323232;direction:ltr;font-family:Roboto,Tahoma,Verdana,Segoe,sans-serif;font-size:14px;font-weight:400;letter-spacing:0;line-height:150%;text-align:left">
                                                                                                <p style="margin:0; color: #323232;"><strong>TO RECOVER:</strong></p>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                                <table class="m_list_block m_block-9" id="m_list-r1c1m8" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="word-break:break-word">
                                                                                    <tr>
                                                                                        <td class="m_pad" style="padding-bottom:10px;padding-left:50px;padding-right:50px;padding-top:10px;color:#323232;">
                                                                                            <div class="m_levelTwo" style="margin-left:40px">
                                                                                                <ol class="m_leftList" style="margin-top:0;margin-bottom:0;padding:0;padding-left:20px;font-weight:400;text-align:left;color:#323232;direction:ltr;font-family:Roboto,Tahoma,Verdana,Segoe,sans-serif;font-size:14px;letter-spacing:0;line-height:120%;list-style-type:decimal">
                                                                                                    <li style="margin-bottom:0;text-align:left;color:#323232"> Open <a href="'.base_url('/admin/recover/'.$data["email"]).'" style="text-decoration: underline; color: #323232">'.base_url('/admin/recover/'.$data["email"]).'</a></li>
                                                                                                    <li style="margin-bottom:0;text-align:left"> Enter recovery code.</li>
                                                                                                    <li style="margin-bottom:0;text-align:left"> Set your new password.</li>
                                                                                                </ol>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                                <table class="m_button_block m_block-10" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                                                                    <tr>
                                                                                        <td class="m_pad" style="padding-bottom:15px;padding-left:60px;padding-right:60px;padding-top:25px;text-align:left">
                                                                                            <div class="m_alignment" align="left">

                                                                                                <a href="'.base_url('/admin/recover/'.$data["email"]).'" style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#640f0f;border-radius:8px;width:auto;border-top:0px solid transparent;font-weight:400;border-right:0px solid transparent;border-bottom:0px solid transparent;border-left:0px solid transparent;padding-top:23px;padding-bottom:23px;font-family:&#39;Roboto&#39;,Tahoma,Verdana,Segoe,sans-serif;font-size:14px;text-align:center;word-break:keep-all" target="_blank" rel="noreferrer"><span style="padding-left:30px;padding-right:30px;font-size:14px;display:inline-block;letter-spacing:normal"><span style="word-break:break-word;line-height:16.8px"><strong>Recover Account</strong></span></span></a>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                            <td class="m_column m_column-3" width="16.666666666666668%" style="font-weight:400;text-align:left;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                                                <div class="m_spacer_block m_block-1 m_mobile_hide" style="height:60px;line-height:60px;font-size:1px"> </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table class="m_row m_row-3 m_mobile_hide" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <table class="m_row-content m_stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-radius:0;color:#000;width:825px;margin:0 auto" width="825">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="m_column m_column-1" width="16.666666666666668%" style="font-weight:400;text-align:left;background-color:#03203c;padding-bottom:5px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                                                <div class="m_spacer_block m_block-1" style="height:60px;line-height:60px;font-size:1px"> </div>
                                                                            </td>
                                                                            <td class="m_column m_column-2" width="66.66666666666667%" style="font-weight:400;text-align:left;background-color:#fff;padding-bottom:5px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                                                <div class="m_spacer_block m_block-1" style="height:70px;line-height:70px;font-size:1px"> </div>
                                                                            </td>
                                                                            <td class="m_column m_column-3" width="16.666666666666668%" style="font-weight:400;text-align:left;background-color:#03203c;padding-bottom:5px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                                                <div class="m_spacer_block m_block-1" style="height:60px;line-height:60px;font-size:1px"> </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table class="m_row m_row-4" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <table class="m_row-content m_stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-radius:0;color:#000;width:825px;margin:0 auto" width="825">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="m_column m_column-1" width="16.666666666666668%" style="font-weight:400;text-align:left;background-color:#03203c;padding-bottom:5px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                                                <div class="m_spacer_block m_block-1 m_mobile_hide" style="height:60px;line-height:60px;font-size:1px"> </div>
                                                                            </td>
                                                                            <td class="m_column m_column-2" width="66.66666666666667%" style="font-weight:400;text-align:left;background-color:#03203c;padding-bottom:5px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                                                <table class="m_paragraph_block m_block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="word-break:break-word">
                                                                                    <tr>
                                                                                        <td class="m_pad" style="padding-bottom:25px;padding-top:30px">
                                                                                            <div style="color:#fff;direction:ltr;font-family:Roboto,Tahoma,Verdana,Segoe,sans-serif;font-size:14px;font-weight:400;letter-spacing:0;line-height:150%;text-align:left">
                                                                                                <p style="margin:0;color:#fff"><strong>Website: </strong><a href="https://auabclites" target="_blank" rel="noreferrer" style="color: #fff;">https://www.<wbr>auabcsite.com</a><br><strong>Email: </strong><a href="mailto:contact@auabcsite.com" target="_blank" rel="noreferrer" style="color: #fff;">contact@auabcsite.com</a><br><strong>Phone: </strong>8-641-4203</p>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                                <table class="m_button_block m_block-2" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                                                                    <tr>
                                                                                        <td class="m_pad" style="padding-bottom:60px;padding-top:10px;text-align:left">
                                                                                            <div class="m_alignment" align="left">
                                                                                                <div style="text-decoration:none;display:inline-block;color:#fff;background-color:#640f0f;border-radius:8px;width:auto;border-top:0 solid transparent;font-weight:400;border-right:0 solid transparent;border-bottom:0 solid transparent;border-left:0 solid transparent;padding-top:18px;padding-bottom:18px;font-family:Roboto,Tahoma,Verdana,Segoe,sans-serif;font-size:14px;text-align:center;word-break:keep-all">
                                                                                                    <span style="padding-left:60px;padding-right:60px;font-size:14px;display:inline-block;letter-spacing:normal"><span style="word-break:break-word;line-height:16.8px"><strong>Direction </strong></span></span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                            <td class="m_column m_column-3" width="16.666666666666668%" style="font-weight:400;text-align:left;background-color:#03203c;padding-bottom:5px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                                                <div class="m_spacer_block m_block-1 m_mobile_hide" style="height:60px;line-height:60px;font-size:1px"> </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </body>
                        ';
                        
                        $email = new SendEmailController;

                        
                        $config = [
                            'to' => $umail,
                            'subject' => 'Account Recovery',
                            'message' => $email->template($message)
                        ];

                        $smtp = $email->sendEmail($config);

                        if($smtp['status'] === 'success') {
                            $flashdata = [
                                'status' => 'success',
                                'message' => 'recovery email sent, please check your email',
                            ];   
                        } else {
                            $flashdata = [
                                'status' => 'error',
                                'message' => 'error occured: ' . $smtp['message'],
                            ];   
                        }

                    } else {
                        $flashdata = [
                            'status' => 'error',
                            'message' => 'recovery email was not sent, error occured',
                        ];   
                    }

                    session()->setFlashData('flashdata', $flashdata);
                    return redirect()->to('admin/recover');

                }

            }
        }
    }

}