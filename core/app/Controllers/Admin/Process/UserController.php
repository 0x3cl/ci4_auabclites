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
                    if($model->insert_data('lites_users', $data)
                        && optimizeImageUpload($path, $file, $filename)) {
                            if ($send_email == 1) {
                                $smtp = $this->sendEmail($uncrypt_password, $data);
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
        $email_add = $data['email'];
        $role = $data['position'];
        $username = $data['username'];
        $password = $uncrypt_password;

        $message = '
        <body style="background-color:#f0f0f0;margin:0;padding:0;-webkit-text-size-adjust:none;text-size-adjust:none">
            <table class="nl-container" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;background-color:#f0f0f0;background-size:auto;background-image:none;background-position:top left;background-repeat:no-repeat">
                <tbody>
                    <tr>
                        <td>
                            <table class="row row-1" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;background-size:auto">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;background-size:auto;border-radius:0;color:#000;width:825px;margin:0 auto" width="825">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="100%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;padding-bottom:5px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                            <div class="spacer_block block-1" style="height:100px;line-height:100px;font-size:1px">&#8202;</div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="row row-2" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;background-size:auto">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;background-size:auto;border-radius:0;color:#000;width:825px;margin:0 auto" width="825">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="16.666666666666668%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;border-top:26px solid transparent;vertical-align:top;border-right:0;border-bottom:0;border-left:0">
                                                            <div class="spacer_block block-1 mobile_hide" style="height:60px;line-height:60px;font-size:1px">&#8202;</div>
                                                        </td>
                                                        <td class="column column-2" width="66.66666666666667%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;background-color:#fff;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                            <div class="spacer_block block-1" style="height:50px;line-height:50px;font-size:1px">&#8202;</div>
                                                            <table class="m_image_block m_block-2" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                                                <tr>
                                                                    <td class="m_pad" style="padding-left:30px;padding-right:45px;width:100%">
                                                                        <div class="m_alignment" align="right" style="line-height:10px"><img src="https://ci4.googleusercontent.com/proxy/CbISjZ9ern2yLeaHcH0gIAtSpk2bAxEoarekAmeQvHIaCQHtUd9puumha5uVFzE1UEnAVVM4ILn-58LG02GoJJU4qGs1xhyaveBX4XxLt85enMPqIx2hNZA-dfcQapUlcM7dTegRO099ut2dR6SEibsqGFw98fbP7Kj2cLIu4JsVrmbJfAG62JmvoxtYShq2VxjrZgs-V_cWTazaszK9FrViJSfo2tjMIgQ=s0-d-e1-ft#https://d15k2d11r6t6rl.cloudfront.net/public/users/Integrators/0db9f180-d222-4b2b-9371-cf9393bf4764/0bd8b69e-4024-4f26-9010-6e2a146401fb/site_logo.png" style="display:block;height:auto;border:0;max-width:110px;width:100%" width="110"></div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="paragraph_block block-4" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word">
                                                                <tr>
                                                                    <td class="pad" style="padding-bottom:20px;padding-left:60px;padding-right:60px;padding-top:20px">
                                                                        <div style="color:#323232;direction:ltr;font-family:Roboto,Tahoma,Verdana,Segoe,sans-serif;font-size:18px;font-weight:400;letter-spacing:0;line-height:120%;text-align:left;mso-line-height-alt:21.599999999999998px">
                                                                            <p style="margin: 15px 0 0 0"><strong>Hello '.ucwords($fullname).',</strong></p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="paragraph_block block-5" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word">
                                                                <tr>
                                                                    <td class="pad" style="padding-left:60px;padding-right:60px">
                                                                        <div style="color:#323232;direction:ltr;font-family:Roboto,Tahoma,Verdana,Segoe,sans-serif;font-size:14px;font-weight:400;letter-spacing:0;line-height:150%;text-align:left;mso-line-height-alt:21px">
                                                                            <p style="margin:0">
                                                                                You have received an invitation from Carl Llemos to assume the role of an administrator on the prestigious League of Information Technology Education (LITES) website. Enclosed herein are your assigned duties in this capacity. We express our heartfelt appreciation for your willingness to undertake this position.</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="divider_block block-6" width="100%" border="0" cellpadding="15" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div class="alignment" align="center">
                                                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="85%" style="mso-table-lspace:0;mso-table-rspace:0">
                                                                                <tr>
                                                                                    <td class="divider_inner" style="font-size:1px;line-height:1px;border-top:5px solid #640f0f"><span>&#8202;</span></td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="paragraph_block block-7" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word">
                                                                <tr>
                                                                    <td class="pad" style="padding-left:60px;padding-right:60px">
                                                                        <div style="color:#323232;direction:ltr;font-family:Roboto,Tahoma,Verdana,Segoe,sans-serif;font-size:14px;font-weight:400;letter-spacing:0;line-height:150%;text-align:left;mso-line-height-alt:21px">
                                                                            <p style="margin:0"><strong>ROLE:</strong> '.ucwords(format_position($role)).'<br><strong>USERNAME:&nbsp;</strong>'.$username.'<br><strong>PASSWORD:</strong> '.$password.'</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="divider_block block-8" width="100%" border="0" cellpadding="15" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div class="alignment" align="center">
                                                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="85%" style="mso-table-lspace:0;mso-table-rspace:0">
                                                                                <tr>
                                                                                    <td class="divider_inner" style="font-size:1px;line-height:1px;border-top:5px solid #640f0f"><span>&#8202;</span></td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="paragraph_block block-9" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word">
                                                                <tr>
                                                                    <td class="pad" style="padding-left:60px;padding-right:60px">
                                                                        <div style="color:#323232;direction:ltr;font-family:Roboto,Tahoma,Verdana,Segoe,sans-serif;font-size:14px;font-weight:400;letter-spacing:0;line-height:150%;text-align:left;mso-line-height-alt:21px">
                                                                            <p style="margin:0"><strong>TO LOGIN:</strong></p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <!--[if mso]><style>#list-r1c1m9 ol li{mso-special-format: number; text-align: -webkit-match-parent; display: list-item;}#list-r1c1m9 .levelOne li {margin-top: 0 !important;} #list-r1c1m9 .levelOne {margin-left: -20px !important;}#list-r1c1m9 .levelTwo li {margin-top: 0 !important;} #list-r1c1m9 .levelTwo {margin-left: 20px !important;}#list-r1c1m9 .levelThree li {margin-top: 0 !important;} #list-r1c1m9 .levelThree {margin-left: 60px !important;}#list-r1c1m9 .levelFour li {margin-top: 0 !important;} #list-r1c1m9 .levelFour {margin-left: 100px !important;}</style><![endif]-->
                                                            <table class="list_block block-10" id="list-r1c1m9" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word">
                                                                <tr>
                                                                    <td class="pad" style="padding-bottom:10px;padding-left:50px;padding-right:50px;padding-top:10px">
                                                                        <div class="levelTwo" style="margin-left:40px">
                                                                            <ol class="leftList" style="margin-top:0;margin-bottom:0;padding:0;padding-left:20px;direction:ltr;font-family:Roboto,Tahoma,Verdana,Segoe,sans-serif;font-size:14px;font-weight:400;letter-spacing:0;line-height:120%;text-align:left;mso-line-height-alt:16.8px;color:#323232;list-style-type:decimal">
                                                                                <li style="margin-bottom:0;text-align:left">&nbsp;Open admin panel at <a href="'.base_url('/admin/login').'" style="text-decoration: underline; color: #323232">'.base_url('/admin/login').'</a>.</li>
                                                                                <li style="margin-bottom:0;text-align:left">&nbsp;Enter username and password.</li>
                                                                                <li style="margin-bottom:0;text-align:left">
                                                                                    &nbsp;Go to settings and change password.</li>
                                                                            </ol>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="button_block block-11" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0">
                                                                <tr>
                                                                    <td class="pad" style="padding-bottom:15px;padding-left:60px;padding-right:60px;padding-top:25px;text-align:left">
                                                                        <div class="alignment" align="left">
                                                                            <!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="test.com" style="height:62px;width:176px;v-text-anchor:middle;" arcsize="13%" stroke="false" fillcolor="#640f0f"><w:anchorlock/><v:textbox inset="0px,0px,0px,0px"><center style="color:#ffffff; font-family:Tahoma, Verdana, sans-serif; font-size:14px"><![endif]-->
                                                                            <a href="'.base_url('/admin/login').'" target="_blank" style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#640f0f;border-radius:8px;width:auto;border-top:0px solid transparent;font-weight:400;border-right:0px solid transparent;border-bottom:0px solid transparent;border-left:0px solid transparent;padding-top:23px;padding-bottom:23px;font-family:Roboto, Tahoma, Verdana, Segoe, sans-serif;font-size:14px;text-align:center;mso-border-alt:none;word-break:keep-all;"><span style="padding-left:30px;padding-right:30px;font-size:14px;display:inline-block;letter-spacing:normal;"><span style="word-break: break-word; line-height: 16.8px;"><strong>Open Admin Panel</strong></span></span></a>
                                                                            <!--[if mso]></center></v:textbox></v:roundrect><![endif]-->
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="column column-3" width="16.666666666666668%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                            <div class="spacer_block block-1 mobile_hide" style="height:60px;line-height:60px;font-size:1px">&#8202;</div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="row row-3 mobile_hide" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;border-radius:0;color:#000;width:825px;margin:0 auto" width="825">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="16.666666666666668%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;background-color:#03203c;padding-bottom:5px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                            <div class="spacer_block block-1" style="height:60px;line-height:60px;font-size:1px">&#8202;</div>
                                                        </td>
                                                        <td class="column column-2" width="66.66666666666667%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;background-color:#fff;padding-bottom:5px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                            <div class="spacer_block block-1" style="height:70px;line-height:70px;font-size:1px">&#8202;</div>
                                                        </td>
                                                        <td class="column column-3" width="16.666666666666668%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;background-color:#03203c;padding-bottom:5px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                            <div class="spacer_block block-1" style="height:60px;line-height:60px;font-size:1px">&#8202;</div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="row row-4" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;border-radius:0;color:#000;width:825px;margin:0 auto" width="825">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="16.666666666666668%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;background-color:#03203c;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                            <div class="spacer_block block-1 mobile_hide" style="height:60px;line-height:60px;font-size:1px">&#8202;</div>
                                                        </td>
                                                        <td class="column column-2" width="66.66666666666667%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;background-color:#03203c;padding-bottom:5px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                            <table class="paragraph_block block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word">
                                                                <tr>
                                                                    <td class="pad" style="padding-bottom:10px;padding-left:10px;padding-right:10px;padding-top:45px">
                                                                        <div style="color:#fff;direction:ltr;font-family:Roboto,Tahoma,Verdana,Segoe,sans-serif;font-size:22px;font-weight:400;letter-spacing:0;line-height:120%;text-align:left;mso-line-height-alt:26.4px">
                                                                            <p style="margin:0"><strong>Visit Arellano University</strong></p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="paragraph_block block-2" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div style="color:#fff;direction:ltr;font-family:Roboto,Tahoma,Verdana,Segoe,sans-serif;font-size:14px;font-weight:400;letter-spacing:0;line-height:120%;text-align:left;mso-line-height-alt:16.8px">
                                                                            <p style="margin:0">Are you ready to embark on a thrilling journey into the world of Information Technology? Look no further than the School of Information Technology Education (SITE) at Arellano University - Andres Bonifacio Campus! Here, we&apos;re not just shaping students; we&apos;re crafting future tech leaders.
                                                                            </p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <!--[if mso]><style>#list-r3c1m2 ul{margin: 0 !important; padding: 0 !important;} #list-r3c1m2 ul li{mso-special-format: bullet;}#list-r3c1m2 .levelOne li {margin-top: 0 !important;} #list-r3c1m2 .levelOne {margin-left: -20px !important;}#list-r3c1m2 .levelTwo li {margin-top: 0 !important;} #list-r3c1m2 .levelTwo {margin-left: 20px !important;}#list-r3c1m2 .levelThree li {margin-top: 0 !important;} #list-r3c1m2 .levelThree {margin-left: 60px !important;}#list-r3c1m2 .levelFour li {margin-top: 0 !important;} #list-r3c1m2 .levelFour {margin-left: 100px !important;}</style><![endif]-->
                                                            <table class="list_block block-3" id="list-r3c1m2" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div class="levelOne" style="margin-left:0">
                                                                            <ul class="leftList" start="1" style="margin-top:0;margin-bottom:0;padding:0;padding-left:20px;direction:ltr;font-family:Roboto,Tahoma,Verdana,Segoe,sans-serif;font-size:14px;font-weight:400;letter-spacing:0;line-height:120%;text-align:left;mso-line-height-alt:16.8px;color:#fff;list-style-type:disc">
                                                                                <li style="margin-bottom:0;text-align:left">
                                                                                    Our programs are meticulously designed to keep pace with the rapidly evolving tech industry. From programming languages to cybersecurity and data analytics, SITE&apos;s curriculum covers it all.</li>
                                                                                <li style="margin-bottom:0;text-align:left">Learn from industry experts and experienced professors who are passionate about nurturing your IT skills. They&apos;re dedicated to your success.<br><br></li>
                                                                                <li style="margin-bottom:0;text-align:left">
                                                                                    A degree from SITE opens doors to diverse career options. Whether you dream of software development, IT consultancy, or digital entrepreneurship, we&apos;ll prepare you for success.</li>
                                                                                <li style="margin-bottom:0;text-align:left">Join the SITE community at Arellano University - Andres Bonifacio Campus and be part of an innovative and dynamic IT education journey that will prepare you for the digital age. Your future in technology starts here!<br><br></li>
                                                                                <li style="margin-bottom:0;text-align:left">
                                                                                    Ready to take the first step? Contact us today to learn more about our programs, admissions, and how you can become a part of the SITE success story. Don&apos;t miss out on this opportunity to shape your IT future with us!</li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="column column-3" width="16.666666666666668%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;background-color:#03203c;padding-bottom:5px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                            <div class="spacer_block block-1 mobile_hide" style="height:60px;line-height:60px;font-size:1px">&#8202;</div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="row row-5" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;border-radius:0;color:#000;width:825px;margin:0 auto" width="825">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="16.666666666666668%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;background-color:#03203c;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                            <div class="spacer_block block-1 mobile_hide" style="height:60px;line-height:60px;font-size:1px">&#8202;</div>
                                                        </td>
                                                        <td class="column column-2" width="66.66666666666667%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;background-color:#03203c;padding-bottom:5px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                            <table class="image_block block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0">
                                                                <tr>
                                                                    <td class="pad" style="width:100%">
                                                                        <div class="alignment" align="center" style="line-height:10px"><img src="https://d15k2d11r6t6rl.cloudfront.net/public/users/Integrators/0db9f180-d222-4b2b-9371-cf9393bf4764/0bd8b69e-4024-4f26-9010-6e2a146401fb/au-1_2.jpg" style="display:block;height:auto;border:0;max-width:550px;width:100%" width="550"></div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="column column-3" width="16.666666666666668%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;background-color:#03203c;padding-bottom:5px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                            <div class="spacer_block block-1 mobile_hide" style="height:60px;line-height:60px;font-size:1px">&#8202;</div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="row row-6" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;border-radius:0;color:#000;width:825px;margin:0 auto" width="825">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="16.666666666666668%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;background-color:#03203c;padding-bottom:5px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                            <div class="spacer_block block-1 mobile_hide" style="height:60px;line-height:60px;font-size:1px">&#8202;</div>
                                                        </td>
                                                        <td class="column column-2" width="66.66666666666667%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;background-color:#03203c;padding-bottom:5px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                            <table class="paragraph_block block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word">
                                                                <tr>
                                                                    <td class="pad" style="padding-bottom:25px;padding-top:30px">
                                                                        <div style="color:#fff;direction:ltr;font-family:Roboto,Tahoma,Verdana,Segoe,sans-serif;font-size:14px;font-weight:400;letter-spacing:0;line-height:150%;text-align:left;mso-line-height-alt:21px">
                                                                            <p style="margin:0"><strong>Website:&nbsp;</strong><a href="https://www.auabcsite.com" style="text-decoration: underlinel; color: #fff">https://www.auabcsite.com</a><br><strong>Email:&nbsp;</strong><a href="mailto:contact@auabcsite.com" style="color: #fff">contact@auabcsite.com</a><br><strong>Phone:&nbsp;</strong>8-641-4203</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="button_block block-2" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0">
                                                                <tr>
                                                                    <td class="pad" style="padding-bottom:60px;padding-top:10px;text-align:left">
                                                                        <div class="alignment" align="left">
                                                                            <!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" style="height:52px;width:176px;v-text-anchor:middle;" arcsize="16%" stroke="false" fillcolor="#640f0f"><w:anchorlock/><v:textbox inset="0px,0px,0px,0px"><center style="color:#ffffff; font-family:Tahoma, Verdana, sans-serif; font-size:14px"><![endif]-->
                                                                            <div style="text-decoration:none;display:inline-block;color:#fff;background-color:#640f0f;border-radius:8px;width:auto;border-top:0 solid transparent;font-weight:400;border-right:0 solid transparent;border-bottom:0 solid transparent;border-left:0 solid transparent;padding-top:18px;padding-bottom:18px;font-family:Roboto,Tahoma,Verdana,Segoe,sans-serif;font-size:14px;text-align:center;mso-border-alt:none;word-break:keep-all">
                                                                                <span style="padding-left:60px;padding-right:60px;font-size:14px;display:inline-block;letter-spacing:normal;"><span style="word-break: break-word; line-height: 16.8px;"><strong>Direction </strong></span></span>
                                                                            </div>
                                                                            <!--[if mso]></center></v:textbox></v:roundrect><![endif]-->
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="column column-3" width="16.666666666666668%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;background-color:#03203c;padding-bottom:5px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                            <div class="spacer_block block-1 mobile_hide" style="height:60px;line-height:60px;font-size:1px">&#8202;</div>
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
            </table><!-- End -->
        </body>
        ';

        $email = new SendEmailController;

        $config = [
            'to' => $email_add,
            'subject' => 'Admin Invitation for AUABCLITES Website',
            'message' => $email->template($message)
        ];


        return $email->sendEmail($config);
    }
}