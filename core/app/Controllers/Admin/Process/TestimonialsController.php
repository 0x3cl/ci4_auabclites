<?php

namespace App\Controllers\Admin\Process;

use App\Controllers\BaseController;
use App\Models\CustomModel;
use App\Libraries\LogsController;

class TestimonialsController extends BaseController {

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
                'testimonial' => [
                    'label' => 'Testimonial',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} is required',
                    ]
                ],
                'testimonial-label' => [
                    'label' => 'Testimonial Label',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} is required',
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
                'testimonial' => [
                    'label' => 'Testimonial',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} is required',
                    ]
                ],
                'testimonial-label' => [
                    'label' => 'Testimonial Label',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} is required',
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
                $path = './assets/home/images/testimonials/';
                $model = new CustomModel();

                $data = [
                    'image' => $filename,
                    'first_name' => $this->request->getPost('firstname'),
                    'last_name' => $this->request->getPost('lastname'),
                    'testimonial' => $this->request->getPost('testimonial'),
                    'testimonial_label' => $this->request->getPost('testimonial-label')
                ];


                try {
                    if($model->insertData('lites_testimonials', $data)
                    && optimizeImageUpload($path, $file, $filename)) {
                        $flashdata = [
                            'status' => 'success',
                            'message' => 'testimonial successfully added'
                        ];
                        $this->logs->init('[testimonial] ~ ' . $data['first_name'] . ' ' . $data['last_name'] . ' added successfully');
                    } 
                } catch (\Exception $e) {
                    $flashdata = [
                        'status' => 'error',
                        'message' => 'error: ' . $e
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
                $path = './assets/home/images/testimonials/';
                $model = new CustomModel;

                try {
                    
                    $previous_image = $model->get_data([
                        'table' => 'lites_testimonials',
                        'condition' => [
                            'column' => 'lites_testimonials.id',
                            'value' => $id
                        ],
                    ])[0]->image;
    
                    
                    $data = [
                        'image' => $filename
                    ];
    
    
                    if(removeImage($path . $previous_image)
                        && $model->updateData('lites_testimonials', 'lites_testimonials.id', $id, $data)
                        && optimizeImageUpload($path, $file, $filename)) {
                        $flashdata = [
                            'status' => 'success',
                            'message' => 'image successfully updated'
                        ];

                        $info = $model->get_data([
                            'table' => 'lites_testimonials',
                            'condition' => [
                                'column' => 'id',
                                'value' => $id
                            ]
                        ])[0];
                        
                        $this->logs->init('[testimonial] ~ ' . $info->first_name . ' ' . $info->last_name . ' image updated successfully');
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
                    'testimonial' => $this->request->getPost('testimonial'),
                    'testimonial_label' => $this->request->getPost('testimonial-label')
                ];

                try {
                    if($model->updateData('lites_testimonials', 'lites_testimonials.id', $id, $data)) {
                        $flashdata = [
                            'status' => 'success',
                            'message' => 'testimonial&apos;s information updated successfully'
                        ];
                        $info = $model->get_data([
                            'table' => 'lites_testimonials',
                            'condition' => [
                                'column' => 'id',
                                'value' => $id
                            ]
                        ])[0];
                        $this->logs->init('[testimonial] ~ ' . $info->first_name . ' ' . $info->last_name . ' information updated successfully');
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
            $model = new CustomModel;

            try {
                $info = $model->get_data([
                    'table' => 'lites_testimonials',
                    'condition' => [
                        'column' => 'id',
                        'value' => $id
                    ]
                ])[0];
                $previous_image = $model->get_data([
                    'table' => 'lites_testimonials',
                    'condition' => [
                        'column' => 'lites_testimonials.id',
                        'value' => $id
                    ],
                ])[0]->image;
                
                if($model->deleteData('lites_testimonials', ['id' => $id]) && removeImage('./assets/home/images/testimonials/'. $previous_image)) {
                    $flashdata = [
                        'status' => 'success',
                        'message' => 'testimonial successfully deleted'
                    ];
                    $this->logs->init('[testimonial] ~ ' . $info->first_name . ' ' . $info->last_name . ' deleted successfully');
                }
            } catch (\Exception $e) {
                $flashdata = [
                    'status' => 'error',
                    'message' => 'error: ' . $e->getMessage()
                ];
            }

            session()->setFlashdata('flashdata', $flashdata);
            return redirect()->to('/admin/manage/page/testimonials');
            
        }
    }

}