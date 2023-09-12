<?php

namespace App\Controllers\Admin\Process;

use App\Controllers\BaseController;
use App\Models\CustomModel;
use App\Libraries\LogsController;

class ResearchController extends BaseController {

    protected $validation;
    protected $logs;

    public function __construct() {
        $this->validation = \Config\Services::validation();
        $this->logs = new LogsController;
    }

    public function validation($type) {   
        $ruleType = [
            'add_data' => [
                'title' => [
                    'label' => 'Title',
                    'rules' => 'required|min_length[4]',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'min_length' => '{field} must be atleast 4 characters'
                    ]
                ],
                'abstract' => [
                    'label' => 'Abstract',
                    'rules' => 'required|min_length[50]',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'min_length' => '{field} must be atleast 50 characters'
                    ]
                ],
                'features' => [
                    'label' => 'Features',
                    'rules' => 'required|min_length[4]',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'min_length' => '{field} must be atleast 4 characters'
                    ]
                ],
                'banner-image' => [
                    'label' => 'Images',
                    'rules' => 'uploaded[banner-image]|max_size[banner-image,5000]|is_image[banner-image]',
                    'errors' => [
                        'uploaded' => '{field} is required',
                        'max_size' => '{field} size exceeds the allowed limit',
                        'is_image' => '{field} must be a valid image file'
                    ]
                ],
                'content-image[]' => [
                    'label' => 'Banner Image',
                    'rules' => 'uploaded[content-image]|max_size[content-image,5000]|is_image[content-image]',
                    'errors' => [
                        'uploaded' => '{field} is required',
                        'max_size' => '{field} size exceeds the allowed limit',
                        'is_image' => '{field} must be a valid image file'
                    ]
                ],
                'platform' => [
                    'label' => 'Platform',
                    'rules' => 'required|is_numeric',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'is_numeric' => '{field} must be numeric',
                    ]
                ],
                'technology.*' => [
                    'label' => 'Technologies',
                    'rules' => 'required|is_numeric',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'is_numeric' => '{field} must be numeric',
                    ]
                ],
                'repo' => [
                    'label' => 'Repositories',
                    'rules' => 'required|is_numeric',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'is_numeric' => '{field} must be numeric',
                    ]
                ],
                'repo-link' => [
                    'label' => 'Repositories',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                    ]
                ],
            ],
            'update_data' => [
                'title' => [
                    'label' => 'Title',
                    'rules' => 'required|min_length[4]',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'min_length' => '{field} must be atleast 4 characters'
                    ]
                ],
                'abstract' => [
                    'label' => 'Abstract',
                    'rules' => 'required|min_length[50]',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'min_length' => '{field} must be atleast 50 characters'
                    ]
                ],
                'features' => [
                    'label' => 'Features',
                    'rules' => 'required|min_length[4]',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'min_length' => '{field} must be atleast 4 characters'
                    ]
                ],
                'platform' => [
                    'label' => 'Platform',
                    'rules' => 'required|is_numeric',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'is_numeric' => '{field} must be numeric',
                    ]
                ],
                'technology.*' => [
                    'label' => 'Technologies',
                    'rules' => 'required|is_numeric',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'is_numeric' => '{field} must be numeric',
                    ]
                ],
                'repo' => [
                    'label' => 'Repositories',
                    'rules' => 'required|is_numeric',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'is_numeric' => '{field} must be numeric',
                    ]
                ],
                'repo-link' => [
                    'label' => 'Repositories',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} cannot be blank',
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
                    'label' => 'Images',
                    'rules' => 'uploaded[content-image]|max_size[content-image,5000]|is_image[content-image]',
                    'errors' => [
                        'uploaded' => '{field} is required',
                        'max_size' => '{field} size exceeds the allowed limit',
                        'is_image' => '{field} must be a valid image file'
                    ]
                ],
            ],
            'add_author' => [
                'author-image[]' => [
                    'label' => 'Author&apos;s Image',
                    'rules' => 'uploaded[author-image]|max_size[author-image,5000]|is_image[author-image]',
                    'errors' => [
                        'uploaded' => '{field} is required',
                        'max_size' => '{field} size exceeds the allowed limit',
                        'is_image' => '{field} must be a valid image file'
                    ]
                ],
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
                'about' => [
                    'label' => 'About',
                    'rules' => 'required|min_length[4]',
                    'errors' => [
                        'required' => '{field} cannot be blank',
                        'min_length' => '{field} must be atleast 4 characters'
                    ]
                ],
            ]
            
        ];
   
        if($this->validate($ruleType[$type])) {
           return true;
        } 
        
        return false;

    }
    
    public function add_data() {
        if($this->request->getMethod() === 'post') {
            if($this->validation('add_data')) {
                $path = './assets/home/images/research/';
                $research_data = [
                    'title' => $this->request->getPost('title'),
                    'features' => $this->request->getPost('features'),
                    'abstract' => $this->request->getPost('abstract'),
                ];

                $model = new CustomModel;

                try {
                    $inserted_id = $model->insertData('lites_research', $research_data);
                } catch (\Exception $e) {
                    $flashdata = [
                        'status' => 'error',
                        'message' => 'error: ' . $e->getMessage()
                    ];
                }

                $research_platform = [
                    'research_id' => $inserted_id,
                    'platform_id' => $this->request->getPost('platform')
                ];

                $research_repository = [
                    'research_id' => $inserted_id,
                    'repositories_id' => $this->request->getPost('repo'),
                    'link' => $this->request->getPost('repo-link')
                ];

                $banner_image = $this->request->getFile('banner-image');
                $content_image = $this->request->getFileMultiple('content-image');

                $filename = [];

                $banner_filename = $banner_image->getRandomName();

                $research_image[] = [
                    'research_id' => $inserted_id,
                    'filename' => $banner_filename,
                    'is_banner' => 1,
                ];

                $filename_array[] = [
                    'inst' => $banner_image,
                    'name' => $banner_filename
                ];

                foreach($content_image as $image) {
                    $filename = $image->getRandomName();
                    $research_image[] = [
                        'research_id' => $inserted_id,
                        'filename' => $filename,
                        'is_banner' => 0
                    ];

                    $filename_array[] = [
                        'inst' => $image,
                        'name' => $filename
                    ];
                }

                $research_technologies = [];

                if(is_array($this->request->getPost('technology'))) {
                    foreach($this->request->getPost('technology') as $technology) {
                        $research_technologies[] = [
                            'research_id' => $inserted_id,
                            'technologies_id' => $technology
                        ];
                    }
                }

                try {
                    
                    if($model->insertData('lites_research_platforms', $research_platform)
                        && $model->insertData('lites_research_repositories', $research_repository)
                        && $model->insertDataBatch('lites_research_image', $research_image)
                        && $model->insertDataBatch('lites_research_technologies', $research_technologies)) {

                        foreach($filename_array as $filename) {
                            optimizeImageUpload($path, $filename['inst'], $filename['name']);
                        }

                        $flashdata = [
                            'status' => 'success',
                            'message' => 'research information inserted'
                        ];

                        $this->logs->init('[research] ~ '.$research_data['title']. ' added successfully');

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
                $path = './assets/home/images/research/';

                $research_data = [
                    'title' => $this->request->getPost('title'),
                    'features' => $this->request->getPost('features'),
                    'abstract' => $this->request->getPost('abstract'),
                ];

                $model = new CustomModel;
                $research_platform = [
                    'platform_id' => $this->request->getPost('platform')
                ];

                $research_repository = [
                    'repositories_id' => $this->request->getPost('repo'),
                    'link' => $this->request->getPost('repo-link')
                ];

                $research_technologies = [];

                if(is_array($this->request->getPost('technology'))) {
                    foreach($this->request->getPost('technology') as $technology) {
                        $research_technologies[] = [
                            'research_id' => $id,
                            'technologies_id' => $technology
                        ];
                    }
                }

                $updateData = [
                    [
                        'table' => 'lites_research',
                        'column' => 'id',
                        'value' => $id,
                        'data' => $research_data
                    ],
                    [
                        'table' => 'lites_research_platforms',
                        'column' => 'research_id',
                        'value' => $id,
                        'data' => $research_platform
                    ],
                    [
                        'table' => 'lites_research_repositories',
                        'column' => 'research_id',
                        'value' => $id,
                        'data' => $research_repository
                    ],
                ];


                foreach($updateData as $data) {
                    try {
                        $model->updateData($data['table'], $data['column'], $data['value'], $data['data']);
                        $flashdata = [
                            'status' => 'success',
                            'message' => 'research updated successfully'
                        ];
                    } catch (\Exception $e) {
                        $flashdata = [
                           'status' => 'error',
                           'message' => 'error: '. $e->getMessage()
                        ];
                    }
                }

                try {
                    $model->deleteData('lites_research_technologies', ['research_id' => $id]);
                    $model->insertDataBatch('lites_research_technologies', $research_technologies);
                    $flashdata = [
                        'status' => 'success',
                        'message' => 'research updated successfully'
                    ];
                    $this->logs->init('[research] ~ '.$research_data['title']. ' updated successfully');
                } catch (\Exception $e) {
                    $flashdata = [
                       'status' => 'error',
                       'message' => 'error: '. $e->getMessage()
                    ];
                }


            } else {
                $message = array_values($this->validator->getErrors());
                $flashdata = [
                    'status' => 'error',
                    'message' => $message,
                    'fields' => $this->request->getPost(),
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
                $path = './assets/home/images/research/';
                $banner_image = $this->request->getFile('banner-image');
                $banner_filename = $banner_image->getRandomName();
                $model = new CustomModel;

                $previous_obj = $model->get_data([
                    'table' => 'lites_research_image',
                    'condition' => [
                        [
                            'column' => 'research_id',
                            'value' => $id
                        ],
                        [
                            'column' => 'is_banner',
                            'value' => '1'
                        ]
                    ]
                ]);
                $previous_image = $previous_obj[0]->filename;
                $previous_id = $previous_obj[0]->id;

                if(removeImage($path . $previous_image)) {
                    $data = [
                        'filename' => $banner_filename
                    ];
    
                    try {
                        if($model->updateData('lites_research_image', 'id', $previous_id, $data)
                            && optimizeImageUpload($path, $banner_image, $banner_filename)) {
                            $flashdata = [
                                'status' => 'success',
                                'message' => 'research banner updated successfully'
                             ];
                             $info = $model->get_data([
                                 'table' => 'lites_research',
                                 'condition' => [
                                     'column' => 'id',
                                     'value' => $id
                                 ]
                             ])[0];
                             $this->logs->init('[research] ~ '.$info->title. ' banner updated successfully');
                        }
                    } catch (\Exception $e) {
                        $flashdata = [
                          'status' => 'error',
                          'message' => 'error: '. $e->getMessage()
                        ];
                    }
                }

                

            } else {
                $message = array_values($this->validator->getErrors());
                $flashdata = [
                    'status' => 'error',
                    'message' => $message,
                    'fields' => $this->request->getPost(),
                ];
            }
            
            session()->setFlashdata('flashdata', $flashdata);
            return redirect()->back();
        }
    }

    public function add_image() {
        if($this->request->getMethod() === 'post') {
            if($this->validation('add_image')) {
                $id = $this->request->getPost('id');
                $path = './assets/home/images/research/';
                $content_image = $this->request->getFileMultiple('content-image');
                
                foreach($content_image as $image) {
                    $filename = $image->getRandomName();
                    $data[] = [
                        'research_id' => $id,
                        'filename' => $filename
                    ];
                    optimizeImageUpload($path, $image, $filename);
                }

                $model = new CustomModel;

                try {
                    if($model->insertDataBatch('lites_research_image', $data)) {
                        $flashdata = [
                            'status' => 'success',
                            'message' => 'research image/s added successfully'
                         ];
                         $info = $model->get_data([
                             'table' => 'lites_research',
                             'condition' => [
                                 'column' => 'id',
                                 'value' => $id
                             ]
                         ])[0];
                         $this->logs->init('[research] ~ '.$info->title. ' image added successfully');
                    }
                } catch (\Exception $e) {
                    $flashdata = [
                      'status' => 'error',
                      'message' => 'error: '. $e->getMessage()
                    ];
                }
               

            } else {
                $message = array_values($this->validator->getErrors());
                $flashdata = [
                    'status' => 'error',
                    'message' => $message,
                    'fields' => $this->request->getPost(),
                ];
            }
            
            session()->setFlashdata('flashdata', $flashdata);
            return redirect()->back();
        }
    }

    public function add_author() {
        if($this->request->getMethod() === 'post') {
            if($this->validation('add_author')) {
                $id = $this->request->getPost('id');
                $path = './assets/home/images/authors/';
                $file = $this->request->getFile('author-image');
                $filename = $file->getRandomName();
                $data = [
                    'research_id' => $id,
                    'image' => $filename, 
                    'firstname' => $this->request->getPost('firstname'),
                    'lastname' => $this->request->getPost('lastname'),
                    'about' => $this->request->getPost('about'),
                ];

                $model = new CustomModel;
                try {
                    if($model->insertData('lites_research_authors', $data)
                        && optimizeImageUpload($path, $file, $filename)) {
                        $flashdata = [
                            'status' => 'success',
                            'message' => 'research author/s added successfully'
                        ];
                        $info = $model->get_data([
                            'table' => 'lites_research',
                            'condition' => [
                                'column' => 'id',
                                'value' => $id
                            ]
                        ])[0];
                        $this->logs->init('[research] ~ '.$info->title. ' author added successfully');
                    }                    
                } catch (\Exception $e) {
                    $flashdata = [
                      'status' => 'error',
                      'message' => 'error: '. $e->getMessage()
                    ];
                }
            } else {
                $message = array_values($this->validator->getErrors());
                $flashdata = [
                    'status' => 'error',
                    'message' => $message,
                    'fields' => $this->request->getPost(),
                ];
            }
            
            session()->setFlashdata('flashdata', $flashdata);
            return redirect()->back();
        }
    }

    public function delete_data() {
        if($this->request->getMethod() === 'post') {
            $id = $this->request->getPost('id');
            if(is_numeric($id)) {
                $model = new CustomModel;
                $path = './assets/home/images/research/';
                try {
                    $previous_images = $model->get_data([
                        'table' => 'lites_research_image',
                        'condition' => [
                            'column' => 'research_id',
                            'value' => $id
                        ]
                    ]);
                    foreach($previous_images as $image) {
                        removeImage($path . $image->filename);
                    }                    
                } catch (\Exception $e) {
                    $flashdata = [
                        'status' => 'error',
                        'message' => 'Error: ' . $e->getMessage()
                    ];
                }

                try {
                    $tables = [
                        'lites_research' => 'id',
                        'lites_research_image' => 'research_id',
                        'lites_research_platforms' => 'research_id',
                        'lites_research_repositories' => 'research_id',
                        'lites_research_technologies' => 'research_id',
                    ];
                
                    $success = true;
                    $info = $model->get_data([
                        'table' => 'lites_research',
                        'condition' => [
                            'column' => 'id',
                            'value' => $id
                        ]
                    ])[0];
                    foreach ($tables as $table => $column) {
                        $success &= $model->deleteData($table, [$column => $id]);
                    }
                    $flashdata = [
                        'status' => $success ? 'success' : 'error',
                        'message' => $success ? 'research deleted successfully' : 'error deleting research'
                    ];
                    $this->logs->init('[research] ~ '.$info->title. ' deleted successfully');
                } catch (\Exception $e) {
                    $flashdata = [
                        'status' => 'error',
                        'message' => 'Error: ' . $e->getMessage()
                    ];
                }
            }

            session()->setFlashdata('flashdata', $flashdata);
            return redirect()->to('/admin/manage/page/research');
        }
    }

    public function delete_image() {
        if($this->request->getMethod() === 'post') {
            $id = $this->request->getPost('id');
            if(is_numeric($id)) {
                $model = new CustomModel;
                $path = './assets/home/images/research/';

                try {
                    $previous_image = $model->get_data([
                        'table' => 'lites_research_image',
                        'condition' => [
                            'column' => 'id',
                            'value' => $id
                        ]
                    ])[0]->filename;
                    removeImage($path . $previous_image);
                } catch (\Exception $e) {
                    $flashdata = [
                        'status' => 'error',
                        'message' => 'error: ' . $e->getMessage()
                    ];
                }

                try {
                    $info = $model->get_data([
                        'table' => 'lites_research_image',
                        'join' => [
                            'table' => 'lites_research',
                            'on' => 'lites_research.id = lites_research_image.research_id',
                            'type' => 'inner'
                        ],
                        'condition' => [
                            'column' => 'lites_research_image.id',
                            'value' => $id
                        ]
                    ])[0];
                    if($model->deleteData('lites_research_image', ['id' => $id])) {
                        $flashdata = [
                           'status' =>'success',
                           'message' => 'image deleted successfully'
                        ];
                        $this->logs->init('[research] ~ '.$info->title. ' image deleted successfully');
                    }
                } catch (\Exception $e) {
                    $flashdata = [
                        'status' => 'error',
                        'message' => 'error: ' . $e->getMessage()
                    ];
                }

            }

            session()->setFlashdata('flashdata', $flashdata);
            return redirect()->back();
        }
    }

    public function delete_author() {
        if($this->request->getMethod() === 'post') {
            $id = $this->request->getPost('id');
            if(is_numeric($id)) {
                $model = new CustomModel;
                $path = './assets/home/images/authors/';

                try {
                    $previous_image = $model->get_data([
                        'table' => 'lites_research_authors',
                        'condition' => [
                            'column' => 'id',
                            'value' => $id
                        ]
                    ])[0]->image;
                    removeImage($path . $previous_image);
                } catch (\Exception $e) {
                    $flashdata = [
                        'status' => 'error',
                        'message' => 'error: ' . $e->getMessage()
                    ];
                }

                try {
                    $info = $model->get_data([
                        'table' => 'lites_research_authors',
                        'join' => [
                            'table' => 'lites_research',
                            'on' => 'lites_research.id = lites_research_authors.research_id',
                            'type' => 'inner'
                        ],
                        'condition' => [
                            'column' => 'lites_research_authors.id',
                            'value' => $id
                        ]
                    ])[0];
                    if($model->deleteData('lites_research_authors', ['id' => $id])) {
                        $flashdata = [
                           'status' =>'success',
                           'message' => 'author deleted successfully'
                        ];
                        $this->logs->init('[research] ~ '.$info->title. ' author deleted successfully');
                    }
                } catch (\Exception $e) {
                    $flashdata = [
                        'status' => 'error',
                        'message' => 'error: ' . $e->getMessage()
                    ];
                }

            }

            session()->setFlashdata('flashdata', $flashdata);
            return redirect()->back();
        }
    }

}