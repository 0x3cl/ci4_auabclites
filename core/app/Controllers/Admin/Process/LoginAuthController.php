<?php

namespace App\Controllers\Admin\Process;

use App\Controllers\BaseController;
use App\Libraries\LogsController;
use App\Models\LoginAuthModel;

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

}