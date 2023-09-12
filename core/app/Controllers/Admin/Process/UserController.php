<?php

namespace App\Controllers\Admin\Process;

use App\Controllers\BaseController;
use App\Models\CustomModel;
use App\Libraries\LogsController;

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
                $table = 'lites_users';
                $path = './assets/admin/uploads/avatar/';
                $model = new CustomModel();
                $data = [
                    'username' => $this->request->getPost('username'),
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
                    'first_name' => $this->request->getPost('firstname'),
                    'last_name' => $this->request->getPost('lastname'),
                    'position' => $this->request->getPost('position'),
                    'image' => $filename
                ];

                try {
                    if($model->insertData($table, $data)) {
                        if(optimizeImageUpload($path, $file, $filename)) {
                            $flashdata = [
                                'status' => 'success',
                                'message' => 'user added successfully',
                            ];
                            $this->logs->init('[user] ~ ' . $data['username'] . ' added successfully');
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
            $model = new CustomModel();
            $id = $this->request->getPost('id');
            $username = $model->get_data([
                'table' => 'lites_users',
                'condition' => [
                    'column' => 'id',
                    'value' => $id
                ]
            ])[0]->username;
            try {
                $model->deleteData('lites_users', ['id' => $id]);
                $flashdata = [
                    'status' => 'success',
                    'message' => 'user deleted successfully',
                ];
                $this->logs->init('[user] ~ '.$username.' deleted successfully');
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
                $table = 'lites_users';
                $model = new CustomModel();
                $data = [
                    'first_name' => $this->request->getPost('firstname'),
                    'last_name' => $this->request->getPost('lastname'),
                    'position' => $this->request->getPost('position'),
                ];
                $username = $model->get_data([
                    'table' => 'lites_users',
                    'condition' => [
                        'column' => 'id',
                        'value' => $id
                    ]
                ])[0]->username;
                try {
                    $model->updateData($table, 'lites_users.id', $id, $data);
                    $flashdata = [
                        'status' => 'success',
                        'message' => 'user&apos;s profile information updated successfully',
                    ];
                    $this->logs->init('[user] ~ '.$username.' profile information updated successfully');
                } catch (\Exception $e) {
                    
                    $flashdata = [
                        'status' => 'error',
                        'message' => 'error: ' . $e->getMessage(),
                    ];
                }
                    
                session()->setFlashData('flashdata', $flashdata);
                return redirect()->back();            }    
            
        }
    }

    public function update_profile_image() {
        if($this->request->getMethod() === 'post') {
            if($this->validation('updateProfileImageRules')) {

                $id = $this->request->getPost('id');
                $file = $this->request->getFile('avatar');
                $filename = $file->getRandomName();
                $table = 'lites_users';
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
                } catch (\Exception $e) {
                    $flashdata = [
                        'status' => 'error',
                        'message' => 'error: ' . $e->getMessage(),
                    ];
                }

                if(removeImage($path . $previous_image)) {
                    $username = $model->get_data([
                        'table' => 'lites_users',
                        'conditions' => [
                            'column' => 'id',
                            'value' => $id
                        ]
                    ])[0]->username;
    
                    try {
                        if($model->updateData($table, 'id', $id, $data)) {
                            if(optimizeImageUpload($path, $file, $filename)) {
                                $flashdata = [
                                    'status' => 'success',
                                    'message' => 'user&apos;s profile image updated successfully',
                                ];
                                $this->logs->init('[user] ~ '.$username.' profile image updated successfully');
                            }
                        } else {
                            $flashdata = [
                                'status' => 'error',
                                'message' => 'error: failed to move user&apos;s profile image',
                            ];
                        }
                    } catch (\Exception $e) {
                        $flashdata = [
                            'status' => 'error',
                            'message' => 'error: ' . $e->getMessage(),
                        ];
                    }
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

}