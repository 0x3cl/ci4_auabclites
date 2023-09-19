<?php

namespace App\Controllers\Admin\Process;

use App\Controllers\BaseController;
use App\Models\CustomModel;
use App\Libraries\LogsController;

class SMTPController extends BaseController {

    protected $logs;

    public function __construct() {
        $this->logs = new LogsController;
    }

    public function validation($type) {
        $rules = [
            'update_data' => [
                'hostname' => [
                    'label' => 'Host Name',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} is required'
                    ]
                ],
                'port' => [
                    'label' => 'Port',
                    'rules' => 'required|is_numeric',
                    'errors' => [
                        'required' => '{field} is required',
                        'is_numeric' => '{field} must be numberic'
                    ]
                ],
                'sender' => [
                    'label' => 'Sender',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} is required'
                    ]
                ],
                'username' => [
                    'label' => 'Username',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} is required'
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} is required'
                    ]
                ],
            ]
        ];

        if($this->validate($rules[$type]))
        {
            return true;
        }

        return false;
    }


    public function update_data() {
        if($this->request->getMethod() === 'post') {
            if($this->validation('update_data')) {
                $model = new CustomModel;

                $data = [
                    'hostname' => $this->request->getPost('hostname'),
                    'port' => $this->request->getPost('port'),
                    'sender' => $this->request->getPost('sender'),
                    'username' => $this->request->getPost('username'),
                    'password' => $this->request->getPost('password'),
                ];

                try {
                    if($model->updateData('lites_smtp', 'lites_smtp.id', 1, $data)) {
                        $flashdata = [
                            'status' => 'success',
                            'message' => 'smtp updated successfully'
                        ];
                        $this->logs->init('[smtp] ~ '.$data['hostname'].' successfully updated');
                    }
                } catch (Exception $e) {
                    $flashdata = [
                        'status' => 'error',
                        'message' => 'error: ' . $e->getMessage()
                    ];
                }

            } else {
                $message = array_values($this->validator->getErrors());
                $flashdata = [
                    'status' => 'error',
                    'message' => $message,
                    'fields' => $this->request->getPost(),
                    'scrollTo' => 'update-banner'
                ];
            }

            session()->setFlashdata('flashdata', $flashdata);
            return redirect()->back();

        }
    }

    public function update_password() {
        if($this->request->getMethod() === 'post') {
            if($this->validation('update_password')) {
                $id = $this->request->getPost('id'); 
                $old_password = $this->request->getPost('old-password');               
                $new_password = $this->request->getPost('new-password');
                $confirm_password = $this->request->getPost('confirm-password');
                $model = new CustomModel;

                try {
                    $result = $model->get_data([
                        'table' => 'lites_users',
                        'condition' => [
                            'column' => 'lites_users.id',
                            'value' => $id
                        ]  
                    ]);
                   
                    if(password_verify($old_password, $result[0]->password)) {
                        if($new_password === $confirm_password) {
                            $data = [
                                'password' => password_hash($new_password, PASSWORD_BCRYPT)
                            ];
                            if($model->updateData('lites_users', 'lites_users.id', $id, $data)) {
                                $flashdata = [
                                    'status' => 'success',
                                    'message' => 'your password updated successfully'
                                ];
                            }
                        } else {
                            $flashdata = [
                                'status' => 'error',
                                'message' => 'passwords do not match'
                            ];
                        }
                    } else {
                        $flashdata = [
                            'status' => 'error',
                            'message' => 'old password is incorrect'
                        ];
                    }
                } catch (\Exception $e) {
                    $flashdata = [
                        'status' => 'error',
                        'message' => 'error: ' . $e->getMessage()
                    ];
                }
            } else {
                $message = array_values($this->validator->getErrors());
                $flashdata = [
                    'status' => 'error',
                    'message' => $message,
                    'fields' => $this->request->getPost(),
                    'scrollTo' => 'update-banner'
                ];
            }

            session()->setFlashdata('flashdata', $flashdata);
            return redirect()->back();

        }
    }
}