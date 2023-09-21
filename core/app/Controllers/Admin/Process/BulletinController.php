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
                'source' => [
                    'label' => 'Source',
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
                'source' => [
                    'label' => 'Source',
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
                'source' => [
                    'label' => 'Source',
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
            'source' => $data['source'],
            'title' => $data['title'],
            'content' => $data['content'],
        ];

        $send_enail = $data['send_enail'] ?? '';

        try {
            $inserted_id = $model->insert_data('lites_bulletin', $data_content);
            if ($inserted_id) {
                $data = [
                    'bulletin_id' => $inserted_id,
                    'image' => $filename,
                    'is_banner' => 1
                ];
                if ($model->insert_data('lites_bulletin_image', $data) 
                    && optimizeImageUpload($path, $file, $filename)) {
                    $data = [
                        'id' => $inserted_id,
                        'category' => format_bulletin_category(1),
                        'source' => $data_content['source'],
                        'title' => $data_content['title'],
                        'content' => substr(strip_tags($data_content['content']), 0, 300),
                        'date' => date('F d, Y')
                    ];
                    if ($send_enail == 1 && $this->sendEmail('announcement', $data)) {
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
            'source' => $data['source'],
            'title' => $data['title'],
            'content' => $data['content']
        ];
    
        $send_enail = $data['send_enail'] ?? '';
        
        try {
            $inserted_id = $model->insert_data('lites_bulletin', $data_content);
            if ($inserted_id && optimizeImageUpload($path, $banner_file, $banner_filename)) {
                $images[] = [
                    'bulletin_id' => $inserted_id,
                    'image' => $banner_filename,
                    'is_banner' => 1,
                ];
    
                if(!empty($content_file[0]->getName())) {
                    foreach($content_file as $files) {
                        $filename = $files->getRandomName();
                        $images[] = [
                            'bulletin_id' => $inserted_id,
                            'image' => $filename,
                            'is_banner' => 0
                        ];
                        optimizeImageUpload($path, $files, $filename);
                    }
                }
                if($model->insert_data_batch('lites_bulletin_image', $images)) {
                    $data = [
                        'id' => $inserted_id,
                        'category' => format_bulletin_category(2),
                        'source' => $data_content['source'],
                        'title' => $data_content['title'],
                        'content' => substr(strip_tags($data_content['content']), 0, 300),
                        'date' => date('F d, Y')
                    ];
                    if($send_enail == 1 && $this->sendEmail('announcement', $data)) {
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
                    'source' => $data['source'],
                    'title' => $data['title'],
                    'content' => $data['content']
                ];

                try {
                    if($model->update_data('lites_bulletin', 'lites_bulletin.id', $data['id'], $prepared_data)) {
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

                        if($model->update_data('lites_bulletin_image', 'lites_bulletin_image.id', $previous_id, $prepared_data)
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
                    if($model->insert_data_batch('lites_bulletin_image', $images)) {
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

    public function sendEmail($type, $data) {
        
        $mail_lists = $this->getSubscribedEmails();
        
        if($type === 'announcement') {
            $subject = 'New Announcement Posted';
        } else if($type === 'news') {
            $subject = 'New News Posted';
        }

        $path = $data['category'];

        if($path == 'announcements') {
            $path = 'announcement';
        }

        $message = '
        <body><u></u>
            <div class="m_forceBgColor" style="background-color:transparent;margin:0;padding:0">
                <table class="m_nl-container" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:transparent">
                    <tbody>
                        <tr>
                            <td>
                                <table class="m_row m_row-1" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#e3e5e8">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table class="m_row-content m_stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="color:#000;width:600px;margin:0 auto" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td class="m_column m_column-1" width="100%" style="font-weight:400;text-align:left;padding-left:5px;padding-right:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                                <div class="m_spacer_block m_block-1" style="height:60px;line-height:60px;font-size:1px"> </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="m_row m_row-2" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#e3e5e8">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table class="m_row-content m_stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#fff;color:#000;width:600px;margin:0 auto" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td class="m_column m_column-1" width="100%" style="font-weight:400;text-align:left;padding-bottom:20px;padding-left:20px;padding-right:20px;padding-top:40px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                                <table class="m_text_block m_block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="word-break:break-word">
                                                                    <tr>
                                                                        <td class="m_pad" style="padding-bottom:15px;padding-left:15px;padding-right:15px;padding-top:45px">
                                                                            <div style="font-family:sans-serif">
                                                                                <div style="font-size:12px;font-family:Arial,Helvetica Neue,Helvetica,sans-serif;color:#393a3d;line-height:1.2">
                                                                                    <p style="margin:0;font-size:14px;text-align:center"><span style="font-size:36px;color:#393a3d"><strong>New Bulletin Posted! </strong>Visit our website now.</span></p>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="m_row m_row-3" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#e3e5e8">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table class="m_row-content m_stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#fff;color:#000;width:600px;margin:0 auto" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td class="m_column m_column-1" width="100%" style="font-weight:400;text-align:left;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                                <table class="m_image_block m_block-1" width="100%" border="0" cellpadding="30" cellspacing="0" role="presentation">
                                                                    <tr>
                                                                        <td class="m_pad">
                                                                            <div class="m_alignment" align="center" style="line-height:10px"><img src="https://ci6.googleusercontent.com/proxy/R5wK8CRHUCI7MahrOsRdVHOj0ArIi4KZAXp4sIx2yXXmKxYi4oXdXyk5xtk_NKfyQoAxRnU21amjF_2fS1WIt2Toc0D4W1Dzo0Zle2k22L6afLvRi0_kQggZXxSj-64htxsWmjALXsMXpFgRprRksTm_6vuykKGhDbDMjo5a6SRxtu2Tuq7hZirgsYwlvSinI68jyA1NM6rMNUvI-0fTmBVbGpu_7sue0GZFDMKNBe6NMa9qd-4=s0-d-e1-ft#https://d15k2d11r6t6rl.cloudfront.net/public/users/Integrators/0db9f180-d222-4b2b-9371-cf9393bf4764/0bd8b69e-4024-4f26-9010-6e2a146401fb/X%24a9nuhKW%20%281%29.jpg" style="display:block;height:auto;border:0;max-width:600px;width:100%" width="600"></div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="m_row m_row-4" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#e3e5e8">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table class="m_row-content m_stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="color:#000;width:600px;margin:0 auto" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td class="m_column m_column-1" width="100%" style="font-weight:400;text-align:left;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                                <table class="m_image_block m_block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                                                    <tr>
                                                                        <td class="m_pad" style="width:100%">
                                                                            <div class="m_alignment" align="center" style="line-height:10px"><img src="https://ci6.googleusercontent.com/proxy/LqYOpYLLNfB4p0KPJxlWvLw2FZ4NH3HMJScks2IbzmddAa0wI-uxLAgIU6jcWybreDfzUz1EATEKJFqG9ihbnCyFEIjxEx7zxjUbRPMXVIC4Eos_wS0rqRwaIe1w5ZuuHBc2o-Vs60q5bsFIaNAThkOynr_1GNUB7leZO8WzeawxzEMFTUd2T-z-SkkVcq-qQUjWS8Cqri1wiFZqdy3oUWiG8Uvaz8U93WNwRkXVdAR7eTykRiG19dn5wuqJKe2Webmcn9BKaPvZT1JzIdh_1YtT_KV6JTA=s0-d-e1-ft#https://pro-bee-user-content-eu-west-1.s3.amazonaws.com/public/users/Integrators/0db9f180-d222-4b2b-9371-cf9393bf4764/98761911-7cfb-4977-a5ec-1d41dfdd40f1/templates_images/up-white-grey-angle.png" style="display:block;height:auto;border:0;max-width:600px;width:100%" width="600" alt="Image" title="Image"></div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="m_row m_row-5" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#e3e5e8">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table class="m_row-content m_stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#eceef1;color:#000;width:600px;margin:0 auto" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td class="m_column m_column-1" width="100%" style="font-weight:400;text-align:left;padding-bottom:15px;padding-left:30px;padding-right:30px;padding-top:15px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                                <table class="m_text_block m_block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="word-break:break-word">
                                                                    <tr>
                                                                        <td class="m_pad" style="padding-bottom:10px;padding-left:10px;padding-right:10px;padding-top:30px">
                                                                            <div style="font-family:sans-serif">
                                                                                <div style="color: #323232; font-family:Arial,Helvetica Neue,Helvetica,sans-serif;color:#393a3d;line-height:1.2">
                                                                                    <p style="margin:0;">
                                                                                        <span style="font-size:18px"><strong><span>'.ucwords($data['title']).'<br></span></strong></span>
                                                                                    </p>
                                                                                    <p style="margin:8px 0 0 0;font-size:16px;color:#323232"><span style="font-size:16px"><strong style="font-family:Arial,Helvetica Neue,Helvetica,sans-serif;font-family:Arial,Helvetica Neue,Helvetica,sans-serif;font-size:16px;color:#323232">Posted on: </span><span style="color: #323232">'.$data['date'].'</span></p>
                                                                                    <p style="margin:3px 0 0 0;font-size:16px;color:#323232"><span style="font-size:16px"><strong style="color:#323232"><span>Source: </span></strong>'.$data['source'].'</span></p>
                                                                                    <p style="margin:0;font-size:13px"></p>
                                                                                    <p style="margin:15px 0 0 0;font-size:18px;background-color:transparent">
                                                                                        <span style="font-size:18px">'.$data['content'].'...</span>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                                <table class="m_button_block m_block-2" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                                                    <tr>
                                                                        <td class="m_pad" style="padding-bottom:10px;padding-left:10px;padding-right:10px;padding-top:25px;text-align:left">
                                                                            <div class="m_alignment" align="left">

                                                                                <a href="'.base_url('/bulletin/'.$path.'/'.$data["id"].'').'" style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#640f0f;border-radius:3px;width:auto;border-top:0px solid transparent;font-weight:700;border-right:0px solid transparent;border-bottom:0px solid transparent;border-left:0px solid transparent;padding-top:15px;padding-bottom:15px;font-family:Arial,Helvetica Neue,Helvetica,sans-serif;font-size:16px;text-align:center;word-break:keep-all" target="_blank" rel="noreferrer"><span style="padding-left:35px;padding-right:35px;font-size:16px;display:inline-block;letter-spacing:normal"><span style="word-break:break-word;line-height:32px">READ FULL STORY</span></span></a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="m_row m_row-6" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#e3e5e8">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table class="m_row-content m_stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="color:#000;width:600px;margin:0 auto" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td class="m_column m_column-1" width="100%" style="font-weight:400;text-align:left;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                                <table class="m_image_block m_block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                                                    <tr>
                                                                        <td class="m_pad" style="width:100%">
                                                                            <div class="m_alignment" align="center" style="line-height:10px"><img src="https://ci4.googleusercontent.com/proxy/20Mywd-3F2ObCrNjjcVzwgyG8KZvpyHj9U2_E8oMlpfjnU8r0cNs63Ff0tvcTE1Me2Rmgd48rmUHM8ii3TrmxzIX7_45DpdydT3ya_0d5TbyL7tAyZsIqwimooz-ffLyUOB1mP8VAErKqBQrTGsF_XQGPw8VXDOszxHjPE1HOuJTPiFjPBs5CMbm9qvyr_BVAV4ZlTzNh1KHEdiLEM5_4Zb7Wp_ASjFO5hzIFa5vbjjsFxJOXXc6X0i7jysRGi8vx3GXJFkf8_7mHHbaEkaRBzrUHRJYx97Inw=s0-d-e1-ft#https://pro-bee-user-content-eu-west-1.s3.amazonaws.com/public/users/Integrators/0db9f180-d222-4b2b-9371-cf9393bf4764/98761911-7cfb-4977-a5ec-1d41dfdd40f1/templates_images/down-grey-white-angle.png" style="display:block;height:auto;border:0;max-width:600px;width:100%" width="600" alt="Image" title="Image"></div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="m_row m_row-7" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#e3e5e8">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table class="m_row-content m_stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#fff;color:#000;width:600px;margin:0 auto" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td class="m_column m_column-1" width="100%" style="font-weight:400;text-align:left;padding-bottom:5px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                                <table class="m_divider_block m_block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation">
                                                                    <tr>
                                                                        <td class="m_pad">
                                                                            <div class="m_alignment" align="center">
                                                                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                                                                    <tr>
                                                                                        <td class="m_divider_inner" style="font-size:1px;line-height:1px;border-top:1px solid #babec5"><span> </span></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                                <table class="m_text_block m_block-2" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="word-break:break-word">
                                                                    <tr>
                                                                        <td class="m_pad" style="padding-bottom:10px;padding-left:45px;padding-right:45px;padding-top:25px">
                                                                            <div style="font-family:sans-serif">
                                                                                <div style="font-size:12px;font-family:Arial,Helvetica Neue,Helvetica,sans-serif;color:#393a3d;line-height:1.2">
                                                                                    <p style="margin:0;font-size:14px"><span style="font-size:18px">You are currently receiving the latest updates because you subscribed to our newsletter. To unsubscribe, click the button below.</span></p>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                                <table class="m_button_block m_block-3" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                                                    <tr>
                                                                        <td class="m_pad" style="padding-bottom:10px;padding-left:40px;padding-right:40px;padding-top:30px;text-align:left">
                                                                            <div class="m_alignment" align="left">

                                                                                <a href="https://www.google.com/url?q=http://au.com&amp;source=gmail-html&amp;ust=1695362537198000&amp;usg=AOvVaw0oZt5q4bH3U2BhLPuB4-yx" style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#640f0f;border-radius:3px;width:auto;border-top:0px solid transparent;font-weight:700;border-right:0px solid transparent;border-bottom:0px solid transparent;border-left:0px solid transparent;padding-top:15px;padding-bottom:15px;font-family:Arial,Helvetica Neue,Helvetica,sans-serif;font-size:16px;text-align:center;word-break:keep-all" target="_blank" rel="noreferrer"><span style="padding-left:35px;padding-right:35px;font-size:16px;display:inline-block;letter-spacing:normal"><span style="word-break:break-word;line-height:32px">UNSUBSCRIBE</span></span></a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                                <div class="m_spacer_block m_block-4" style="height:110px;line-height:110px;font-size:1px"> </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="m_row m_row-8" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#e3e5e8">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table class="m_row-content m_stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="color:#000;width:600px;margin:0 auto" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td class="m_column m_column-1" width="100%" style="font-weight:400;text-align:left;padding-bottom:40px;padding-top:40px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                                                <div class="m_spacer_block m_block-1" style="height:60px;line-height:60px;font-size:1px"> </div>
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
                </table>
            </div>
        </body>
        ';

        $email = new SendEmailController;

        $config = [
            'to' => 'no-reply@iamcarlllemos.online',
            'bcc' => $mail_lists,
            'subject' => $subject,
            'message' => $email->template($message)
        ];


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