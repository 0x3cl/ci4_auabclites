<?php

namespace App\Controllers\Admin\Process;

use App\Controllers\BaseController;
use App\Models\CustomModel;
use App\Libraries\LogsController;
use App\Libraries\SendEmailController;

class BulletinController extends BaseController {

    protected $validation;
    protected $logs;

    public function __construct() {
        $this->validation = \Config\Services::validation();
        $this->logs = new LogsController();
    }

    public function validation($category = NULL) {        
        $initRule = [
            'category' => [
                'label' => 'Category',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} cannot be blank',
                ]
            ]
        ];
    
        $ruleType = [
            'announcements' => [
                'category' => [
                    'label' => 'Category',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                    ]
                ],
                'title' => [
                    'label' => 'Title',
                    'rules' => 'required|min_length[4]',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'min_length' => '{field} must be atleast 4 characters'
                    ]
                ],
                'content' => [
                    'label' => 'Content',
                    'rules' => 'required|min_length[4]',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'min_length' => '{field} must be atleast 4 characters'
                    ]
                ],
                'banner-image' => [
                    'label' => 'Banner Image',
                    'rules' => 'uploaded[banner-image]|max_size[banner-image,5000]|is_image[banner-image]',
                    'errors' => [
                        'uploaded' => '{field} is required',
                        'max_size' => '{field} size exceeds the allowed limit',
                        'is_image' => '{field} must be a valid image file'
                    ]
                ],
            ],
            'news' => [
                'category' => [
                    'label' => 'Category',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                    ]
                ],
                'title' => [
                    'label' => 'Title',
                    'rules' => 'required|min_length[4]',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'min_length' => '{field} must be atleast 4 characters'
                    ]
                ],
                'content' => [
                    'label' => 'Content',
                    'rules' => 'required|min_length[4]',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'min_length' => '{field} must be atleast 4 characters'
                    ]
                ],
                'banner-image' => [
                    'label' => 'Banner Image',
                    'rules' => 'uploaded[banner-image]|max_size[banner-image,5000]|is_image[banner-image]',
                    'errors' => [
                        'uploaded' => '{field} is required',
                        'max_size' => '{field} size exceeds the allowed limit',
                        'is_image' => '{field} must be a valid image file'
                    ]
                ],
            ],
            'update_announcements' => [
                'category' => [
                    'label' => 'Category',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                    ]
                ],
                'title' => [
                    'label' => 'Title',
                    'rules' => 'required|min_length[4]',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'min_length' => '{field} must be atleast 4 characters'
                    ]
                ],
                'content' => [
                    'label' => 'Content',
                    'rules' => 'required|min_length[4]',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'min_length' => '{field} must be atleast 4 characters'
                    ]
                ],
            ],
            'update_banner' => [
                'banner-image' => [
                    'label' => 'Banner Image',
                    'rules' => 'uploaded[banner-image]|max_size[banner-image,5000]|is_image[banner-image]',
                    'errors' => [
                        'uploaded' => '{field} is required',
                        'max_size' => '{field} size exceeds the allowed limit',
                        'is_image' => '{field} must be a valid image file'
                    ]
                ],
            ],
            'add_image' => [
                'content-image[]' => [
                    'label' => 'Content Image',
                    'rules' => 'uploaded[content-image]|max_size[content-image,5000]|is_image[content-image]',
                    'errors' => [
                        'uploaded' => '{field} is required',
                        'max_size' => '{field} size exceeds the allowed limit',
                        'is_image' => '{field} must be a valid image file'
                    ]
                ],
            ]
        ];
   
        if(!$category) {
            if($this->validate($initRule)) {
                $category = $this->request->getPost('category');
                if($this->validate($ruleType[$category])) {
                    return true;
                }
                return false;
            } 
        } else {
            if($this->validate($ruleType[$category])) {
                return true;
            }
        }

        return false;
    }
    
    public function add() {
        if($this->request->getMethod() === 'post') {
            if($this->validation()) {
                $data = $this->request->getPost();
                $category = $this->request->getPost('category');
                switch($category) {
                    case 'announcements':
                        $files = $this->request->getFile('banner-image');
                        return $this->upload_announcements($data, $files);
                        break;
                    case 'news': 
                        $files = [
                            'banner-image' => $this->request->getFile('banner-image'),
                            'content-image' => $this->request->getFileMultiple('content-image')
                        ];
                        return $this->upload_news($data, $files);
                    break;
                }
            } else {
                $message = array_values($this->validator->getErrors());
                $flashdata = [
                    'status' => 'error',
                    'message' => $message,
                    'fields' => $this->request->getPost(),
                    'isNews' => $this->request->getPost('category') == 'news' ? 'true' : 'false'
                ];
            }

            session()->setFlashData('flashdata', $flashdata);
            return redirect()->back();
        }
    }

    public function upload_announcements($data, $file) {
        $filename = $file->getRandomName();
        $path = './assets/home/images/bulletin/announcements/';
        $model = new CustomModel();

        $data_content = [
            'category' => '1',
            'title' => $data['title'],
            'content' => $data['content'],
        ];

        $send_enail = $data['send_enail'] ?? '';

        try {
            $inserted_id = $model->insertData('lites_bulletin', $data_content);
            if ($inserted_id) {
                $data = [
                    'bulletin_id' => $inserted_id,
                    'image' => $filename,
                    'is_banner' => 1
                ];
                if ($model->insertData('lites_bulletin_image', $data) 
                    && optimizeImageUpload($path, $file, $filename)) {
                    if ($send_enail == 1 && $this->sendEmail('announcement')) {
                        $flashdata = [
                            'status' => 'success',
                            'message' => 'announcement bulletin was successfully created and the newsletter has been sent.',
                        ];
                        $this->logs->init('[announcement bulletin] ~ '.$data_content['title'].' successfully created and the newsletter has been sent');
                    } else {
                        $flashdata = [
                            'status' => 'success',
                            'message' => 'announcement bulletin was successfully created.',
                        ];
                        $this->logs->init('[announcement bulletin] ~ '.$data_content['title'].' successfully created');
                    }
                }
                
            } else {
                $flashdata = [
                    'status' => 'error',
                    'message' => 'an error occurred during insertion process'
                ];
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
    
    public function upload_news($data, $files) {
        $banner_file = $files["banner-image"];
        $content_file = $files["content-image"];
        $banner_filename = $banner_file->getRandomName();
        $path = './assets/home/images/bulletin/news/';
        $model = new CustomModel();

        $data_content = [
            'category' => '2',
            'title' => $data['title'],
            'content' => $data['content']
        ];
    
        $send_enail = $data['send_enail'] ?? '';
        
        try {
            $insert_id = $model->insertData('lites_bulletin', $data_content);
            if ($insert_id && optimizeImageUpload($path, $banner_file, $banner_filename)) {
                $images[] = [
                    'bulletin_id' => $insert_id,
                    'image' => $banner_filename,
                    'is_banner' => 1,
                ];
    
                if(!empty($content_file[0]->getName())) {
                    foreach($content_file as $files) {
                        $filename = $files->getRandomName();
                        $images[] = [
                            'bulletin_id' => $insert_id,
                            'image' => $filename,
                            'is_banner' => 0
                        ];
                        optimizeImageUpload($path, $files, $filename);
                    }
                }
                if($model->insertDataBatch('lites_bulletin_image', $images)) {
                    if ($send_enail == 1 && $this->sendEmail('announcement')) {
                        $flashdata = [
                            'status' => 'success',
                            'message' => 'news bulletin was successfully created and the newsletter has been sent.',
                        ];
                        $this->logs->init('[news bulletin] ~ '.$data_content['title'].' successfully created and the newsletter has been sent');
                    } else {
                        $flashdata = [
                            'status' => 'success',
                            'message' => 'news bulletin was successfully created.',
                        ];
                        $this->logs->init('[news bulletin] ~ '.$data_content['title'].' successfully created');
                    }
                }
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

    public function update() {
        if($this->request->getMethod() === 'post') {
            if($this->validation('update_announcements')) {
                $data = $this->request->getPost();
                $category_id = ($data['category'] == 'announcements' ?  1 : ($data['category']  == 'news' ? 2 : ''));
                $model = new CustomModel;


                $previous_data = $model->get_data([
                    'table' => 'lites_bulletin',
                    'join' => [
                        'table' => 'lites_bulletin_image',
                        'on' => 'lites_bulletin.id = lites_bulletin_image.bulletin_id',
                        'type' => 'inner'
                    ],
                    'condition' => [
                        [
                            'column' => 'lites_bulletin.id',
                            'value' => $data['id']
                        ],
                        [
                            'column' => 'lites_bulletin_image.is_banner',
                            'value' => 1
                        ]
                    ]
                ])[0];


                if($previous_data->category != $category_id) {
                    $image = $previous_data->image;
                    $previous_path = './assets/home/images/bulletin/'.format_bulletin_category($previous_data->category) . '/' . $image;
                    $new_path = './assets/home/images/bulletin/'.format_bulletin_category($category_id) . '/' . $image;
                    rename($previous_path , $new_path);
                }

                $prepared_data = [
                    'category' => $category_id,
                    'title' => $data['title'],
                    'content' => $data['content']
                ];

                try {
                    if($model->updateData('lites_bulletin', 'lites_bulletin.id', $data['id'], $prepared_data)) {
                        $flashdata = [
                            'status' => 'success',
                            'message' => $data['category'] . ' successfully updated',
                            'fields' => $this->request->getPost(),
                            'isNews' => $this->request->getPost('category') == 'news' ? 'true' : 'false',
                            'scrollTo' => 'form-details'
                        ];
                        $this->logs->init('[bulletin] ~ '.$prepared_data['title'].' updated successfully');
                    }
                } catch (\Exception $e) {
                    $flashdata = [
                        'status' => 'error',
                        'message' => 'error: ' . $e->getMessage(),
                        'fields' => $this->request->getPost(),
                        'isNews' => $this->request->getPost('category') == 'news' ? 'true' : 'false',
                        'scrollTo' => 'form-details'
                    ];
                }
            } else {
                $message = array_values($this->validator->getErrors());
                $flashdata = [
                    'status' => 'error',
                    'message' => $message,
                    'fields' => $this->request->getPost(),
                    'isNews' => $this->request->getPost('category') == 'news' ? 'true' : 'false',
                    'scrollTo' => 'form-details'
                ];
            }

            session()->setFlashdata('flashdata', $flashdata);
            return redirect()->back();
        }
    }

    public function update_banner() {
        if($this->request->getMethod() === 'post') {
            if($this->validation('update_banner')) {
                $id = $this->request->getPost('id');
                $file = $this->request->getFile('banner-image');
                $model = new CustomModel;
                $temp_data = [];

                try {
                    $temp_data = $model->get_data([
                        'table' => 'lites_bulletin_image',
                        'select' => 'lites_bulletin.category, lites_bulletin_image.image, lites_bulletin_image.id',
                        'join' => [
                            'table' => 'lites_bulletin',
                            'on' => 'lites_bulletin.id = lites_bulletin_image.bulletin_id',
                            'type' => 'inner'
                        ],
                        'condition' => [
                            [
                                'column' => 'lites_bulletin_image.is_banner',
                                'value' => 1
                            ],
                            [
                                'column' => 'lites_bulletin_image.bulletin_id',
                                'value' => $id
                            ]
                        ],
                    ]);

                    $previous_id = $temp_data[0]->id;
                    $previous_image = $temp_data[0]->image;

                    $path = format_bulletin_category($temp_data[0]->category);
                    $path = './assets/home/images/bulletin/'.$path.'/';

                    if(removeImage($path . $previous_image)) {
                        $filename = $file->getRandomName();
                        $prepared_data = [
                            'image' => $filename
                        ];

                        if($model->updateData('lites_bulletin_image', 'lites_bulletin_image.id', $previous_id, $prepared_data)
                            && (optimizeImageUpload($path, $file, $filename))) {
                            $flashdata = [
                                'status' => 'success',
                                'message' => 'image banner updated successfully',
                                'scrollTo' => 'form-banner'
                            ];
                            $title = $model->get_data([
                                'table' => 'lites_bulletin',
                                'condition' => [
                                    'column' => 'id',
                                    'value' => $id
                                ]
                            ])[0]->title;
                            $this->logs->init('[bulletin] ~ '.$title.' banner updated successfully');
                        } else {
                            $flashdata = [
                                'status' => 'success',
                                'message' => 'error: failed to move image banner',
                                'scrollTo' => 'form-banner'
                            ];
                        }
                    }

                } catch (\Exception $e) {
                    $flashdata = [
                        'status' => 'error',
                        'message' => 'error ' . $e->getMessage(),
                        'scrollTo' => 'form-banner'
                    ];
                }
            } else {
                $message = array_values($this->validator->getErrors());
                $flashdata = [
                    'status' => 'error',
                    'message' => $message,
                    'fields' => $this->request->getPost(),
                    'isNews' => $this->request->getPost('category') == 'news' ? 'true' : 'false',
                    'scrollTo' => 'form-banner'
                ];
            }

            session()->setFlashdata('flashdata', $flashdata);
            return redirect()->back();
        }
        
    }

    public function delete_image() {
        if($this->request->getMethod() === 'post') {
            $id = $this->request->getPost('id');
            $model = new CustomModel;
            try {
                $temp_data = $model->get_data([
                    'table' => 'lites_bulletin_image',
                    'select' => 'lites_bulletin.category, lites_bulletin_image.image, lites_bulletin_image.id',
                    'join' => [
                        'table' => 'lites_bulletin',
                        'on' => 'lites_bulletin.id = lites_bulletin_image.bulletin_id',
                        'type' => 'inner'
                    ],
                    'condition' => [
                        'column' => 'lites_bulletin_image.id',
                        'value' => $id
                    ]
                ]);
                $previous_id = $temp_data[0]->id;
                $previous_image = $temp_data[0]->image;

                $path = format_bulletin_category($temp_data[0]->category);
                $path = './assets/home/images/bulletin/'.$path.'/';

                if($model->delete_data('lites_bulletin_image', ['id' => $id])
                    && removeImage($path . $previous_image)) {
                    $flashdata = [
                        'status' => 'success',
                        'message' => 'Image content deleted successfully',
                        'scrollTo' => 'form-image'
                    ];
                    $this->logs->init('[bulletin] ~ image deleted successfully');
                }

            } catch (\Exception $e) {
                $flashdata = [
                    'status' => 'error',
                    'message' => 'error: ' . $e->getMessage(),
                    'scrollTo' => 'form-image'
                ];
            }

            session()->setFlashData('flashdata', $flashdata);
            return redirect()->back();
        }
    }  

    public function add_image() {
        if($this->request->getMethod() === 'post') {
            if($this->validation('add_image')) {
                $id = $this->request->getPost('id');
                $files = $this->request->getFileMultiple('content-image');
                $path = './assets/home/images/bulletin/news/';
                $model = new CustomModel;

                foreach($files as $file) {
                    $filename = $file->getRandomName();
                    $images[] = [
                        'bulletin_id' => $id,
                        'image' => $filename,
                        'is_banner' => 0
                    ];
                    optimizeImageUpload($path, $file, $filename);
                }

                try {
                    if($model->insertDataBatch('lites_bulletin_image', $images)) {
                        $flashdata = [
                            'status' => 'success',
                            'message' => 'Bulletin images for news added successfully',
                            'scrollTo' => 'form-add-image'
                        ];
                        $this->logs->init('[bulletin] ~ image added successfully');
                    }
                } catch (\Exception $e) {
                    $flashdata = [
                        'status' => 'error',
                        'message' => 'error: ' . $e->getMessage(),
                        'scrollTo' => 'form-add-image'
                    ];
                }
            } else {
                $message = array_values($this->validator->getErrors());
                $flashdata = [
                    'status' => 'error',
                    'message' => $message,
                    'fields' => $this->request->getPost(),
                    'scrollTo' => 'form-add-image'
                ];
            }

            session()->setFlashData('flashdata', $flashdata);
            return redirect()->back(); 
            
        }
    }
  
    public function delete_data() {
        if($this->request->getMethod() === 'post') {
            $id = $this->request->getPost('id');
            $model = new CustomModel;
            try {
                $category = $model->get_data([
                    'table' => 'lites_bulletin',
                    'select' => 'lites_bulletin.category',
                    'condition' => [
                        'column' => 'id',
                        'value' => $id
                    ]
                ])[0]->category;

                $category = format_bulletin_category($category);
                $path = './assets/home/images/bulletin/'.$category.'/';

                $previous_image = $model->get_data([
                    'table' => 'lites_bulletin_image',
                    'condition' => [
                        'column' => 'lites_bulletin_image.bulletin_id',
                        'value' => $id
                    ],
                ]);
                $title = $model->get_data([
                    'table' => 'lites_bulletin',
                    'condition' => [
                        'column' => 'id',
                        'value' => $id
                    ]
                ])[0]->title;

                if($model->delete_data('lites_bulletin', ['id' => $id])
                    && $model->delete_data('lites_bulletin_image', ['bulletin_id' => $id])) {
                    foreach($previous_image as $value) {
                        removeImage($path . $value->image);
                    }
                    $flashdata = [
                        'status' => 'success',
                        'message' => 'Bulletin deleted successfully',
                    ];    
                    $this->logs->init('[bulletin] ~ '.$title.' deleted successfully');
                }
            } catch (\Exception $e) {
                $flashdata = [
                    'status' => 'error',
                    'message' => 'error: ' . $e->getMessage(),
                ];    
            }

            session()->setFlashData('flashdata', $flashdata);
            return redirect()->to('/admin/manage/page/bulletin'); 

        }
    }

    public function sendEmail($type) {
        
        $mail_lists = $this->getSubscribedEmails();
        
        if($type === 'announcement') {
            $subject = 'New Announcement Posted';
        } else if($subject === 'news') {
            $subject = 'New News Posted';
        }

        $config = [
            'to' => $mail_lists,
            'subject' => $subject,
            'message' => 'test email from carl'
        ];

        $email = new SendEmailController;

        return $email->sendEmail($config);
    }

    public function getSubscribedEmails() {
        $model = new CustomModel;
        try {
            $data = $model->get_data([
                'select' => 'email',
                'table' => 'lites_newsletter'
            ]);

            return $data;
        } catch (\Exception $e) {
            echo 'error: ' . $e->getMessage();
        }
    }

}