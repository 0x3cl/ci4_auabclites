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
                    if($model->update_data('lites_smtp', 'lites_smtp.id', 1, $data)) {
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

}