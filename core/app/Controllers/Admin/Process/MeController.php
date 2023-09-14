<?php

namespace App\Controllers\Admin\Process;

use App\Controllers\BaseController;
use App\Models\CustomModel;

class MeController extends BaseController {

    public function validation($type) {
        $rules = [
            'update_image' => [
                'image' => [
                    'label' => 'Image',
                    'rules' => 'uploaded[image]|max_size[image,5000]|is_image[image]',
                    'errors' => [
                        'uploaded' => '{field} is required',
                        'max_size' => '{field} size exceeds the allowed limit',
                        'is_image' => '{field} must be a valid image file'
                    ]
                ],
            ],
            'update_data' => [
                'firstname' => [
                    'label' => 'First Name',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} is required'
                    ]
                ],
                'lastname' => [
                    'label' => 'Last Name',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} is required'
                    ]
                ],
            ],
            'update_password' => [
                'old-password' => [
                    'label' => 'Old Password',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} is required'
                    ]
                ],
                'new-password' => [
                    'label' => 'New Password',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} is required'
                    ]
                ],
                'confirm-password' => [
                    'label' => 'Confirm Password',
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

    public function update_image() {
        if($this->request->getMethod() === 'post') {
            if($this->validation('update_image')) {
                $id = $this->request->getPost('id');
                $file = $this->request->getFile('image');
                $filename = $file->getRandomName();
                $path = './assets/admin/uploads/avatar/';
                $model = new CustomModel;


                try {
                    $previous_image = $model->get_data([
                        'table' => 'lites_users',
                        'condition' => [
                            'column' => 'lites_users.id',
                            'value' => $id
                        ],
                    ])[0]->image;

                    $data = [
                        'image' => $filename
                    ];

                    if(removeImage($path . $previous_image) 
                        && $model->updateData('lites_users', 'lites_users.id', $id, $data)
                        && $file->move($path, $filename)) {
                        $flashdata = [
                            'status' => 'success',
                            'message' => 'your profile image successfully updated'
                        ];

                        $session_token = session()->get('session_token');
                        $session_token['image'] = $filename;
                        session()->set('session_token', $session_token);
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

    public function update_data() {
        if($this->request->getMethod() === 'post') {
            if($this->validation('update_data')) {
                $id = $this->request->getPost('id');                
                $model = new CustomModel;

                $data = [
                    'first_name' => $this->request->getPost('firstname'),
                    'last_name' => $this->request->getPost('lastname'),
                ];

                try {
                    if($model->updateData('lites_users', 'lites_users.id', $id, $data)) {
                        $flashdata = [
                            'status' => 'success',
                            'message' => 'your profile information updated successfully'
                        ];
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