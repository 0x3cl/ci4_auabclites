<?php

namespace App\Controllers\Admin\Process;

use App\Controllers\BaseController;
use App\Models\CustomModel;
use App\Libraries\LogsController;

class OfficersController extends BaseController {

    protected $logs;

    public function __construct() {
        $this->logs = new LogsController();
    }

    public function validation($type) {
        $rules = [
            'add' => [
                'image' => [
                    'label' => 'Image',
                    'rules' => 'uploaded[image]|max_size[image,5000]|is_image[image]',
                    'errors' => [
                        'uploaded' => '{field} is required',
                        'max_size' => '{field} size exceeds the allowed limit',
                        'is_image' => '{field} must be a valid image file'
                    ]
                ],
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
                'position' => [
                    'label' => 'Position',
                    'rules' => 'required|is_numeric',
                    'errors' => [
                        'required' => '{field} is required',
                        'is_numeric' => '{field} is invalid'
                    ]
                ]
            ],
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
                'position' => [
                    'label' => 'Position',
                    'rules' => 'required|is_numeric',
                    'errors' => [
                        'required' => '{field} is required',
                        'is_numeric' => '{field} is invalid'
                    ]
                ]
            ]
        ];

        if($this->validate($rules[$type]))
        {
            return true;
        }

        return false;
    }

    public function add_data() {
        if($this->request->getMethod() === 'post') {
            if($this->validation('add')){
                $file = $this->request->getFile('image');
                $filename = $file->getRandomName();
                $path = './assets/home/images/officers/';
                $data = [
                    'image' => $filename,
                    'first_name' => $this->request->getPost('firstname'),
                    'last_name' => $this->request->getPost('lastname'),
                    'position_id' => $this->request->getPost('position')
                ];

                $model = new CustomModel();

                try {
                    if($model->insertData('lites_officers', $data)
                    && optimizeImageUpload($path, $file, $filename)) {
                        $flashdata = [
                            'status' => 'success',
                            'message' => 'Officer successfully added'
                        ];
                        $this->logs->init('[officer] ~ '.$data['first_name']. ' ' . $data['last_name'] . ' added successfully');
                    } 
                } catch (\Exception $e) {
                    $flashdata = [
                        'status' => 'error',
                        'message' => 'Error: ' . $e
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

    public function update_image() {
        if($this->request->getMethod() === 'post') {
            if($this->validation('update_image')) {
                $id = $this->request->getPost('id');
                $file = $this->request->getFile('image');
                $filename = $file->getRandomName();
                $path = './assets/home/images/officers/';
                $model = new CustomModel;

                $previous_image = $model->get_data([
                    'table' => 'lites_officers',
                    'condition' => [
                        'column' => 'lites_officers.id',
                        'value' => $id
                    ]
                ])[0]->image;

                if(removeImage($path . $previous_image)) {
                    $data = [
                        'image' => $filename
                    ];
    
                    try  {
                        if($model->updateData('lites_officers', 'lites_officers.id', $id, $data)
                            && optimizeImageUpload($path, $file, $filename))
                        {
                            $flashdata = [
                                'status' => 'success',
                                'message' => 'image successfully updated'
                            ];
                            
                            $name = $model->get_data([
                                'table' => 'lites_officers',
                                'condition' => [
                                    'column' => 'id',
                                    'value' => $id
                                ]
                            ])[0];
    
                            $this->logs->init('[officer] ~ '.$name->first_name. ' ' . $name->last_name . ' image updated successfully');
                        }
                    } catch (Exception $e) {
                        $flashdata = [
                            'status' => 'error',
                            'message' => 'error: ' . $e->getMessage()
                        ];
                    }
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
                $data = [
                    'first_name' => $this->request->getPost('firstname'),
                    'last_name' => $this->request->getPost('lastname'),
                    'position_id' => $this->request->getPost('position')
                ];

                $model = new CustomModel;

                try {
                    if($model->updateData('lites_officers', 'lites_officers.id', $id, $data)) {
                        $flashdata = [
                            'status' => 'success',
                            'message' => 'officer&apos;s information updated successfully'
                        ];
                        $name = $model->get_data([
                            'table' => 'lites_officers',
                            'condition' => [
                                'column' => 'id',
                                'value' => $id
                            ]
                        ])[0];

                        $this->logs->init('[officer] ~ '.$name->first_name. ' ' . $name->last_name . ' information updated successfully');
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

    public function delete_data() {
        if($this->request->getMethod() === 'post') {
            
            $id = $this->request->getPost('id');
            $path = './assets/home/images/officers/';
            $model = new CustomModel;

            try {
                $previous_image = $model->get_data([
                    'table' => 'lites_officers',
                    'condition' => [
                        'column' => 'lites_officers.id',
                        'value' => $id
                    ]
                ])[0]->image;
                $name = $model->get_data([
                    'table' => 'lites_officers',
                    'condition' => [
                        'column' => 'id',
                        'value' => $id
                    ]
                ])[0];
                if($model->deleteData('lites_officers', ['id' => $id]) 
                    && removeImage($path . $previous_image)) {
                    $flashdata = [
                        'status' => 'success',
                        'message' => 'officer successfully deleted'
                    ];
                    $this->logs->init('[officer] ~ '.$name->first_name. ' ' . $name->last_name . ' deleted successfully');
                }
            } catch (\Exception $e) {
                $flashdata = [
                    'status' => 'error',
                    'message' => 'error: ' . $e->getMessage()
                ];
            }

            session()->setFlashdata('flashdata', $flashdata);
            return redirect()->to('/admin/manage/page/officers');
            
        }
    }

}