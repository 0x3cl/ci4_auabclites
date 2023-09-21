<?php

namespace App\Controllers\Admin\Process;

use App\Controllers\BaseController;
use App\Models\CustomModel;
use App\Libraries\LogsController;

class HomeController extends BaseController {

    protected $logs;

    public function __construct() {
        $this->logs = new LogsController();
    }

    public function validation($type) {
        $rules = [
            'single_image' => [
                'id' => [
                    'label' => 'ID',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} is required',
                    ]
                ],
                'image' => [
                    'label' => 'Image',
                    'rules' => 'uploaded[image]|max_size[image,5000]|is_image[image]',
                    'errors' => [
                        'uploaded' => '{field} is required',
                        'max_size' => '{field} size exceeds the allowed limit',
                        'is_image' => '{field} must be a valid image file'
                    ]
                ]
            ],
        ];

        if($this->validate($rules[$type])) {
            return true;
        }

        return false;

    }

    public function update_logo() {
        if($this->request->getMethod() === 'post') {
            if($this->validation('single_image')) {
                $id = $this->request->getPost('id');
                $target = $this->request->getPost('target');
                $file = $this->request->getFile('image');
                $filename = $file->getRandomName();
                $model = new CustomModel;

                try {
                    $previous_image = $model->get_data([
                        'table' => 'lites_images',
                        'condition' => [
                            'column' => 'lites_images.id',
                            'value' => $id
                        ]
                    ])[0]->image;
                    $this->logs->init('[home] ~ banner updated successfully');


                    if($target == 'banner') {
                        $path = './assets/home/images/banner/';
                    } else if ($target == 'logo') {
                        $path = './assets/home/images/logo/';
                    }
    
                    $data = [
                        'image' => $filename
                    ];

                    if(removeImage($path . $previous_image) 
                        && $model->update_data('lites_images', 'lites_images.id', $id, $data)
                        && optimizeImageUpload($path, $file, $filename)) {
                        $flashdata = [
                            'status' => 'success',
                            'message' => 'image banner updated successfully',
                        ];
                    } else {
                        $flashdata = [
                            'status' => 'error',
                            'message' => 'error: failed to move image banner',
                        ];
                    }

                } catch (\Exception $e) {
                    $flashdata = [
                        'status' => 'error',
                        'message' => 'error: ' . $e->getMessage(),
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