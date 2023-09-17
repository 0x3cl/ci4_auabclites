<?php 

namespace App\Controllers\Home;
use App\Controllers\BaseController;
use App\Models\CustomModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ViewsController extends BaseController {

    protected $model;

    public function __construct() {
        $this->model = new CustomModel;
    }

    public function isPageNotExists($view) {
        if(is_array($view)) {

            $page = $view['page'];
            $isSubPage = $view['isSubPage'];
            
            $viewPath = APPPATH . 'Views/Home/';
            if ($isSubPage === 'false') {
                $viewPath .= $page . '.php';
            } elseif ($isSubPage === 'true') {
                $viewPath .= 'sub-pages/' . $page . '.php';
            }
            
            if (!file_exists($viewPath)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function renderView($view, $data = null) {
        if ($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();
        }

        return 
        view('home/templates/header', $data) .
        view($view) . 
        view('home/templates/footer');
        
    }

    public function index() {
        return redirect()->to('/home');
    }

    // HANDLE HOME PAGES 

    public function home($page = 'home') {

        $view = [
            'page' => $page,
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $model = new CustomModel;

        $data['site_images'] = $model->get_data([
            'table' => 'lites_images'
        ]);

        $data['site_carousel'] = $model->get_data([
            'table' => 'lites_carousel_images'
        ]);

        $data['site_bulletin'] = $model->get_data([
            'table' => 'lites_bulletin',
            'select' => 'lites_bulletin.*, lites_bulletin_image.image, lites_bulletin_image.is_banner',
            'join' => [
                'table' => 'lites_bulletin_image',
                'on' => 'lites_bulletin_image.bulletin_id = lites_bulletin.id',
                'type' => 'inner'
            ],
            'condition' => [
                'column' => 'lites_bulletin_image.is_banner',
                'value' => '1'
            ],
            'limit' => '10',
            'order' => 'lites_bulletin.id DESC'
        ]);

        $data['site_testimonials'] = $model->get_data([
            'table' => 'lites_testimonials',
            'limit' => '4',
            'order' => 'lites_testimonials.id DESC'
        ]);

        $data['site_contacts'] = $model->get_data([
            'table' => 'lites_contacts',
        ]);

        $render = [
            'title' => 'SITES | LITES | Arellano University - Andres Bonifacio Campus',
            'active' => 'home',
            'data' => $data
        ];

        return $this->renderView('Home/'.$page.'', $render);
        
    }

    public function about($page = 'about') {

        $view = [
            'page' => $page,
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $model = new CustomModel;

        $data['site_images'] = $model->get_data([
            'table' => 'lites_images'
        ]);

        $data['site_contacts'] = $model->get_data([
            'table' => 'lites_contacts',
        ]);

        $render = [
            'title' => 'SITES | LITES | Arellano University - Andres Bonifacio Campus',
            'active' => '',
            'data' => $data
        ];

        return $this->renderView('Home/'.$page.'', $render);
        
    }

    public function privacy($page = 'privacy') {

        $view = [
            'page' => $page,
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $model = new CustomModel;

        $data['site_images'] = $model->get_data([
            'table' => 'lites_images'
        ]);

        $data['site_contacts'] = $model->get_data([
            'table' => 'lites_contacts',
        ]);

        $render = [
            'title' => 'SITES | LITES | Arellano University - Andres Bonifacio Campus',
            'active' => '',
            'data' => $data
        ];

        return $this->renderView('Home/'.$page.'', $render);
        
    }

    public function developers($page = 'developers') {

        $view = [
            'page' => $page,
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $model = new CustomModel;

        $data['site_images'] = $model->get_data([
            'table' => 'lites_images'
        ]);

        $data['site_contacts'] = $model->get_data([
            'table' => 'lites_contacts',
        ]);

        $render = [
            'title' => 'SITES | LITES | Arellano University - Andres Bonifacio Campus',
            'active' => '',
            'data' => $data
        ];

        return $this->renderView('Home/'.$page.'', $render);
        
    }

    public function admission($page = 'admission') {

        $view = [
            'page' => $page,
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $model = new CustomModel;

        $data['site_images'] = $model->get_data([
            'table' => 'lites_images'
        ]);

        $data['site_carousel'] = $model->get_data([
            'table' => 'lites_carousel_images'
        ]);

        $data['site_contacts'] = $model->get_data([
            'table' => 'lites_contacts',
        ]);

        $render = [
            'title' => 'SITES | LITES | Arellano University - Andres Bonifacio Campus',
            'active' => 'admission',
            'data' => $data
        ];

        return $this->renderView('Home/'.$page.'', $render);
        
    }

    public function bulletin($page = 'bulletin') {

        $view = [
            'page' => $page,
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $model = new CustomModel;

        $data['site_images'] = $model->get_data([
            'table' => 'lites_images'
        ]);

        $data['site_announcements'] = $model->get_data([
            'table' => 'lites_bulletin',
            'select' => 'lites_bulletin.*, lites_bulletin_image.image, lites_bulletin_image.is_banner',
            'join' => [
                'table' => 'lites_bulletin_image',
                'on' => 'lites_bulletin_image.bulletin_id = lites_bulletin.id',
                'type' => 'inner'
            ],
            'condition' => [
                [
                    'column' => 'lites_bulletin_image.is_banner',
                    'value' => '1'
                ],
                [
                    'column' => 'lites_bulletin.category',
                    'value' => '1'
                ]
            ],
            'limit' => '3',
            'order' => 'lites_bulletin.id DESC'
        ]);

        $data['site_news'] = $model->get_data([
            'table' => 'lites_bulletin',
            'select' => 'lites_bulletin.*, lites_bulletin_image.image, lites_bulletin_image.is_banner',
            'join' => [
                'table' => 'lites_bulletin_image',
                'select' => 'lites_bulletin.*, lites_bulletin_image.image, lites_bulletin_image.is_banner',
                'on' => 'lites_bulletin_image.bulletin_id = lites_bulletin.id',
                'type' => 'inner'
            ],
            'condition' => [
                [
                    'column' => 'lites_bulletin_image.is_banner',
                    'value' => '1'
                ],
                [
                    'column' => 'lites_bulletin.category',
                    'value' => '2'
                ]
            ],
            'limit' => '10',
            'order' => 'lites_bulletin.id DESC'
        ]);


        $data['site_contacts'] = $model->get_data([
            'table' => 'lites_contacts',
        ]);

        $render = [
            'title' => 'SITES | LITES | Arellano University - Andres Bonifacio Campus',
            'active' => 'bulletin',
            'data' => $data
        ];

        return $this->renderView('Home/'.$page.'', $render);
        
    }

    public function bulletin_announcement($id = null, $page = 'view-announcement-page') {

        $page_number = $id;
        $limit = 10;
        $offset = ($page_number - 1) * $limit;

        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $model = new CustomModel;

        $data['site_images'] = $model->get_data([
            'table' => 'lites_images'
        ]);

        $data['site_contacts'] = $model->get_data([
            'table' => 'lites_contacts',
        ]);

        $data['set'] = [
            'total_pages' =>  ($model->get_data([
                'table' => 'lites_bulletin',
                'select' => 'COUNT(*) as result_count',
                'condition' => [
                    'column' => 'lites_bulletin.category',
                    'value' => '1'
                ]
            ])[0]->result_count / $limit),
            'current_page' => $id
        ];


        if($id == null || empty($id)) {
            $data['site_announcements'] = $model->get_data([
                'table' => 'lites_bulletin',
                'select' => 'lites_bulletin.*, lites_bulletin_image.image, lites_bulletin_image.is_banner',
                'join' => [
                    'table' => 'lites_bulletin_image',
                    'select' => 'lites_bulletin.*, lites_bulletin_image.image, lites_bulletin_image.is_banner',
                    'on' => 'lites_bulletin_image.bulletin_id = lites_bulletin.id',
                    'type' => 'inner'
                ],
                'condition' => [
                    [
                        'column' => 'lites_bulletin_image.is_banner',
                        'value' => '1'
                    ],
                    [
                        'column' => 'lites_bulletin.category',
                        'value' => '1'
                    ]
                ],
                'limit' => $limit,
                'order' => 'lites_bulletin.id DESC'
            ]);
        } else {
           
            if($page_number > 1) {
                $data['site_announcements'] = $model->get_data([
                    'table' => 'lites_bulletin',
                    'select' => 'lites_bulletin.*, lites_bulletin_image.image, lites_bulletin_image.is_banner',
                    'join' => [
                        'table' => 'lites_bulletin_image',
                        'select' => 'lites_bulletin.*, lites_bulletin_image.image, lites_bulletin_image.is_banner',
                        'on' => 'lites_bulletin_image.bulletin_id = lites_bulletin.id',
                        'type' => 'inner'
                    ],
                    'condition' => [
                        [
                            'column' => 'lites_bulletin_image.is_banner',
                            'value' => '1'
                        ],
                        [
                            'column' => 'lites_bulletin.category',
                            'value' => '1'
                        ]
                    ],
                    'limit' => $limit,
                    'offset' => $offset,
                    'order' => 'lites_bulletin.id DESC'

                ]);
            } else {
                $data['site_announcements'] = $model->get_data([
                    'table' => 'lites_bulletin',
                    'select' => 'lites_bulletin.*, lites_bulletin_image.image, lites_bulletin_image.is_banner',
                    'join' => [
                        'table' => 'lites_bulletin_image',
                        'select' => 'lites_bulletin.*, lites_bulletin_image.image, lites_bulletin_image.is_banner',
                        'on' => 'lites_bulletin_image.bulletin_id = lites_bulletin.id',
                        'type' => 'inner'
                    ],
                    'condition' => [
                        [
                            'column' => 'lites_bulletin_image.is_banner',
                            'value' => '1'
                        ],
                        [
                            'column' => 'lites_bulletin.category',
                            'value' => '1'
                        ]
                    ],
                    'limit' => $limit,
                    'order' => 'lites_bulletin.id DESC'
                ]);
            }
        }

        $render = [
            'title' => 'SITES | LITES | Arellano University - Andres Bonifacio Campus',
            'active' => 'bulletin',
            'data' => $data
        ];

        return $this->renderView('Home/sub-pages/'.$page.'', $render);
        
    }
  
    public function bulletin_news($id = null, $page = 'view-news-page') {

        $page_number = $id;
        $limit = 10;
        $offset = ($page_number - 1) * $limit;

        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $model = new CustomModel;

        $data['site_images'] = $model->get_data([
            'table' => 'lites_images'
        ]);

        $data['site_contacts'] = $model->get_data([
            'table' => 'lites_contacts',
        ]);

        $data['set'] = [
            'total_pages' =>  ($model->get_data([
                'table' => 'lites_bulletin',
                'select' => 'COUNT(*) as result_count',
                'condition' => [
                    'column' => 'lites_bulletin.category',
                    'value' => '2'
                ]
            ])[0]->result_count / $limit),
            'current_page' => $id
        ];


        if($id == null || empty($id)) {
            $data['site_news'] = $model->get_data([
                'table' => 'lites_bulletin',
                'select' => 'lites_bulletin.*, lites_bulletin_image.image, lites_bulletin_image.is_banner',
                'join' => [
                    'table' => 'lites_bulletin_image',
                    'select' => 'lites_bulletin.*, lites_bulletin_image.image, lites_bulletin_image.is_banner',
                    'on' => 'lites_bulletin_image.bulletin_id = lites_bulletin.id',
                    'type' => 'inner'
                ],
                'condition' => [
                    [
                        'column' => 'lites_bulletin_image.is_banner',
                        'value' => '1'
                    ],
                    [
                        'column' => 'lites_bulletin.category',
                        'value' => '2'
                    ]
                ],
                'limit' => $limit,
                'order' => 'lites_bulletin.id DESC'
            ]);
        } else {
           
            if($page_number > 1) {
                $data['site_news'] = $model->get_data([
                    'table' => 'lites_bulletin',
                    'select' => 'lites_bulletin.*, lites_bulletin_image.image, lites_bulletin_image.is_banner',
                    'join' => [
                        'table' => 'lites_bulletin_image',
                        'select' => 'lites_bulletin.*, lites_bulletin_image.image, lites_bulletin_image.is_banner',
                        'on' => 'lites_bulletin_image.bulletin_id = lites_bulletin.id',
                        'type' => 'inner'
                    ],
                    'condition' => [
                        [
                            'column' => 'lites_bulletin_image.is_banner',
                            'value' => '1'
                        ],
                        [
                            'column' => 'lites_bulletin.category',
                            'value' => '2'
                        ]
                    ],
                    'limit' => $limit,
                    'offset' => $offset,
                    'order' => 'lites_bulletin.id DESC'

                ]);
            } else {
                $data['site_news'] = $model->get_data([
                    'table' => 'lites_bulletin',
                    'select' => 'lites_bulletin.*, lites_bulletin_image.image, lites_bulletin_image.is_banner',
                    'join' => [
                        'table' => 'lites_bulletin_image',
                        'select' => 'lites_bulletin.*, lites_bulletin_image.image, lites_bulletin_image.is_banner',
                        'on' => 'lites_bulletin_image.bulletin_id = lites_bulletin.id',
                        'type' => 'inner'
                    ],
                    'condition' => [
                        [
                            'column' => 'lites_bulletin_image.is_banner',
                            'value' => '1'
                        ],
                        [
                            'column' => 'lites_bulletin.category',
                            'value' => '2'
                        ]
                    ],
                    'limit' => $limit,
                    'order' => 'lites_bulletin.id DESC'
                ]);
            }
        }

        $render = [
            'title' => 'SITES | LITES | Arellano University - Andres Bonifacio Campus',
            'active' => 'bulletin',
            'data' => $data
        ];

        return $this->renderView('Home/sub-pages/'.$page.'', $render);
        
    }

    public function bulletin_view($type, $id, $title, $page = 'view-bulletin') {
        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $model = new CustomModel;

        $data['site_images'] = $model->get_data([
            'table' => 'lites_images'
        ]);

        $data['site_contacts'] = $model->get_data([
            'table' => 'lites_contacts',
        ]);

        $allowedType = ['announcement', 'news'];

        if(in_array($type, $allowedType)) {
        
            $model = new CustomModel;
            if($type === 'announcement') {
                $data['bulletin_data'] = $model->get_data([
                    'table' => 'lites_bulletin',
                    'select' => 'lites_bulletin.*, lites_bulletin_image.image, lites_bulletin_image.is_banner',
                    'join' => [
                        'table' => 'lites_bulletin_image',
                        'on' => 'lites_bulletin_image.bulletin_id = lites_bulletin.id',
                        'type' => 'inner'
                    ],
                    'condition' => [
                        [
                            'column' => 'lites_bulletin_image.is_banner',
                            'value' => '1'
                        ],
                        [
                            'column' => 'lites_bulletin.category',
                            'value' => '1'
                        ],
                        [
                            'column' => 'lites_bulletin.id',
                            'value' => $id
                        ]
                    ],
                    'order' => 'lites_bulletin.id DESC',
                ]);

                $data['bulletin_other'] = $model->get_data([
                    'table' => 'lites_bulletin',
                    'select' => 'lites_bulletin.*, lites_bulletin_image.image, lites_bulletin_image.is_banner',
                    'join' => [
                        'table' => 'lites_bulletin_image',
                        'on' => 'lites_bulletin_image.bulletin_id = lites_bulletin.id',
                        'type' => 'inner'
                    ],
                    'condition' => [
                        [
                            'column' => 'lites_bulletin_image.is_banner',
                            'value' => '1'
                        ],
                        [
                            'column' => 'lites_bulletin.category',
                            'value' => '1'
                        ],
                        [
                            'column' => 'lites_bulletin.id !=',
                            'value' => $id
                        ]
                    ],
                    'limit' => '8',
                    'order' => 'lites_bulletin.id DESC',
                ]);
            }

            if($type === 'news') {
                $data['bulletin_data'] = $model->get_data([
                    'table' => 'lites_bulletin',
                    'select' => 'lites_bulletin.*, lites_bulletin_image.image, lites_bulletin_image.is_banner',
                    'join' => [
                        'table' => 'lites_bulletin_image',
                        'on' => 'lites_bulletin_image.bulletin_id = lites_bulletin.id',
                        'type' => 'inner'
                    ],
                    'condition' => [
                        [
                            'column' => 'lites_bulletin_image.is_banner',
                            'value' => '1'
                        ],
                        [
                            'column' => 'lites_bulletin.category',
                            'value' => '2'
                        ],
                        [
                            'column' => 'lites_bulletin.id',
                            'value' => $id
                        ]
                    ],
                    'order' => 'lites_bulletin.id DESC',
                ]);
    
                $data['bulletin_images'] = $model->get_data([
                    'table' => 'lites_bulletin_image',
                    'condition' => [
                        [
                            'column' => 'lites_bulletin_image.is_banner',
                            'value' => '0'
                        ],
                        [
                            'column' => 'lites_bulletin_image.bulletin_id',
                            'value' => $id
                        ]
                    ],
                ]);

                $data['bulletin_other'] = $model->get_data([
                    'table' => 'lites_bulletin',
                    'select' => 'lites_bulletin.*, lites_bulletin_image.image, lites_bulletin_image.is_banner',
                    'join' => [
                        'table' => 'lites_bulletin_image',
                        'on' => 'lites_bulletin_image.bulletin_id = lites_bulletin.id',
                        'type' => 'inner'
                    ],
                    'condition' => [
                        [
                            'column' => 'lites_bulletin_image.is_banner',
                            'value' => '1'
                        ],
                        [
                            'column' => 'lites_bulletin.category',
                            'value' => '2'
                        ],
                        [
                            'column' => 'lites_bulletin.id !=',
                            'value' => $id
                        ]
                    ],
                    'limit' => '8',
                    'order' => 'lites_bulletin.id DESC',
                ]);
            }
        }

        $render = [
            'title' => 'SITES | LITES | Arellano University - Andres Bonifacio Campus',
            'active' => 'bulletin',
            'data' => $data
        ];

        return $this->renderView('Home/sub-pages/'.$page.'', $render);
        
    }

    public function faculty($page = 'faculty') {
        $view = [
            'page' => $page,
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $model = new CustomModel;

        $data['site_images'] = $model->get_data([
            'table' => 'lites_images'
        ]);

        $data['site_contacts'] = $model->get_data([
            'table' => 'lites_contacts',
        ]);

        $data['site_faculty'] = $model->get_data([
            'table' => 'lites_faculty',
            'select' => 'lites_faculty.id, lites_faculty.image, lites_faculty.first_name, lites_faculty.last_name, 
                        lites_faculty_positions.id as position_id, lites_faculty_positions.position as position, lites_faculty.description',
            'join' => [
                'table' => 'lites_faculty_positions',
                'on' => 'lites_faculty.position_id = lites_faculty_positions.id',
                'type' => 'inner'
            ],
            'order' => 'lites_faculty_positions.id ASC'
        ]);

        $render = [
            'title' => 'SITES | LITES | Arellano University - Andres Bonifacio Campus',
            'active' => 'faculty',
            'data' => $data
        ];

        return $this->renderView('Home/'.$page.'', $render);
    }

    public function officers($page = 'officers') {
        $view = [
            'page' => $page,
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $model = new CustomModel;

        $data['site_images'] = $model->get_data([
            'table' => 'lites_images'
        ]);

        $data['site_contacts'] = $model->get_data([
            'table' => 'lites_contacts',
        ]);

        $data['site_officers'] = $model->get_data([
            'table' => 'lites_officers',
            'select' => 'lites_officers.first_name, lites_officers.last_name,
                        lites_officers.image, lites_positions.name as position, lites_positions.id as position_id',
            'join' => [
                'table' => 'lites_positions',
                'on' => 'lites_officers.position_id = lites_positions.id',
                'type' => 'inner'
            ],
            'order' => 'lites_officers.position_id ASC'
        ]);

        $render = [
            'title' => 'SITES | LITES | Arellano University - Andres Bonifacio Campus',
            'active' => 'officers',
            'data' => $data
        ];

        // print_r($data);

        return $this->renderView('Home/'.$page.'', $render);
    }

    public function research($page = 'research') {
        $view = [
            'page' => $page,
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $model = new CustomModel;

        $data['site_images'] = $model->get_data([
            'table' => 'lites_images'
        ]);

        $data['site_contacts'] = $model->get_data([
            'table' => 'lites_contacts',
        ]);

        $data['site_research'] = $model->get_data([
            'table' => 'lites_research',
            'select' => 'lites_research.id, lites_research.title, lites_research.abstract, lites_research_image.filename as image, lites_research.date_updated',
            'join' => [
                'table' => 'lites_research_image',
                'on' => 'lites_research.id = lites_research_image.research_id',
                'type' => 'inner'
            ],
            'condition' => [
                'column' => 'lites_research_image.is_banner',
                'value' => '1'
            ],
            'limit' => '10',
            'order' => 'lites_research.id DESC'
        ]);

        $render = [
            'title' => 'SITES | LITES | Arellano University - Andres Bonifacio Campus',
            'active' => 'research',
            'data' => $data
        ];

        return $this->renderView('Home/'.$page.'', $render);
    }

    public function research_view($id, $title, $page = 'view-research') {

        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $model = new CustomModel;

        $data['site_images'] = $model->get_data([
            'table' => 'lites_images'
        ]);

        $data['site_contacts'] = $model->get_data([
            'table' => 'lites_contacts',
        ]);

        $data['site_research_data'] = $this->model->get_data([
            'table' => 'lites_research',
            'select' => 'lites_research.*, lites_research_image.filename as image,
                        lites_platforms.name as platform, lites_repositories.name as repository, 
                        lites_research_repositories.link',
            'join' => [
                [
                    'table' => 'lites_research_image',
                    'on' => 'lites_research.id = lites_research_image.research_id',
                    'type' => 'inner'
                ],
                [
                    'table' => 'lites_research_platforms',
                    'on' => 'lites_research.id = lites_research_platforms.research_id',
                    'type' => 'inner'
                ],
                [
                    'table' => 'lites_research_repositories',
                    'on' => 'lites_research.id = lites_research_repositories.research_id',
                    'type' => 'inner'
                ],
                [
                    'table' => 'lites_repositories',
                    'on' => 'lites_repositories.id = lites_research_repositories.repositories_id',
                    'type' => 'inner'
                ],
                [
                    'table' => 'lites_platforms',
                    'on' => 'lites_platforms.id = lites_research_platforms.platform_id',
                    'type' => 'inner'
                ]
            ],
            'condition' => [
                [
                    'column' => 'lites_research_image.is_banner',
                    'value' => '1'
                ],
                [
                    'column' => 'lites_research.id',
                    'value' => $id
                ]
            ],
            'group' => 'lites_research.id'
        ]);
        $data['site_research_technologies'] = $this->model->get_data([
            'table' => 'lites_research_technologies',
            'select' => 'lites_technologies.name as technologies',
            'join' => [
                'table' => 'lites_technologies',
                'on' => 'lites_technologies.id = lites_research_technologies.technologies_id',
                'type' => 'inner'
            ],
            'condition' => [
                'column' => 'lites_research_technologies.research_id',
                'value' => $id
            ],
        ]);
        $data['site_research_images'] = $this->model->get_data([
            'table' => 'lites_research_image',
            'select' => 'lites_research_image.filename as image',
            'condition' => [
                [
                    'column' => 'lites_research_image.is_banner',
                    'value' => '0'
                ],
                [
                    'column' => 'lites_research_image.research_id',
                    'value' => $id
                ]
            ],
        ]);
        $data['site_research_authors'] = $this->model->get_data([
            'table' => 'lites_research_authors',
            'condition' => [
                'column' => 'lites_research_authors.research_id',
                'value' => $id
            ],
        ]);
    
        $render = [
            'title' => 'SITES | LITES | Arellano University - Andres Bonifacio Campus',
            'active' => 'research',
            'data' => $data
        ];

        return $this->renderView('Home/sub-pages/'.$page.'', $render);
        
    }

    public function research_page($id = null, $page = 'view-research-page') {

        $page_number = $id;
        $limit = 10;
        $offset = ($page_number - 1) * $limit;

        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $model = new CustomModel;

        $data['site_images'] = $model->get_data([
            'table' => 'lites_images'
        ]);

        $data['site_contacts'] = $model->get_data([
            'table' => 'lites_contacts',
        ]);

        $data['set'] = [
            'total_pages' =>  ($model->get_data([
                'table' => 'lites_research',
                'select' => 'COUNT(*) as result_count',
            ])[0]->result_count / $limit),
            'current_page' => $id
        ];


        if($id == null || empty($id)) {
            $data['site_research'] = $model->get_data([
                'table' => 'lites_research',
                'select' => 'lites_research.*, lites_research_image.filename as image, lites_research_image.is_banner',
                'join' => [
                    'table' => 'lites_research_image',
                    'on' => 'lites_research_image.research_id = lites_research.id',
                    'type' => 'inner'
                ],
                'condition' => [
                    [
                        'column' => 'lites_research_image.is_banner',
                        'value' => '1'
                    ],
                ],
                'limit' => $limit,
                'order' => 'lites_research.id DESC'
            ]);
        } else {
           
            if($page_number > 1) {
                $data['site_research'] = $model->get_data([
                    'table' => 'lites_research',
                    'select' => 'lites_research.*, lites_research_image.filename as image, lites_research_image.is_banner',
                    'join' => [
                        'table' => 'lites_research_image',
                        'on' => 'lites_research_image.research_id = lites_research.id',
                        'type' => 'inner'
                    ],
                    'condition' => [
                        [
                            'column' => 'lites_research_image.is_banner',
                            'value' => '1'
                        ],
                    ],
                    'limit' => $limit,
                    'offset' => $offset,
                    'order' => 'lites_research.id DESC'

                ]);
            } else {
                $data['site_research'] = $model->get_data([
                    'table' => 'lites_research',
                    'select' => 'lites_research.*, lites_research_image.filename as image, lites_research_image.is_banner',
                    'join' => [
                        'table' => 'lites_research_image',
                        'on' => 'lites_research_image.research_id = lites_research.id',
                        'type' => 'inner'
                    ],
                    'condition' => [
                        [
                            'column' => 'lites_research_image.is_banner',
                            'value' => '1'
                        ],
                    ],
                    'limit' => $limit,
                    'order' => 'lites_research.id DESC'
                ]);
            }
        }

        $render = [
            'title' => 'SITES | LITES | Arellano University - Andres Bonifacio Campus',
            'active' => 'research',
            'data' => $data
        ];

        return $this->renderView('Home/sub-pages/'.$page.'', $render);
        
    }

    public function testimonial($page = 'testimonial') {
        $view = [
            'page' => $page,
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $model = new CustomModel;

        $data['site_images'] = $model->get_data([
            'table' => 'lites_images'
        ]);

        $data['site_contacts'] = $model->get_data([
            'table' => 'lites_contacts',
        ]);

        $data['site_testimonials'] = $model->get_data([
            'table' => 'lites_testimonials',
            'order' => 'lites_testimonials.id DESC'
        ]);

        $render = [
            'title' => 'SITES | LITES | Arellano University - Andres Bonifacio Campus',
            'active' => 'testimonial',
            'data' => $data
        ];

        return $this->renderView('Home/'.$page.'', $render);
    }


    // HANDLE FORM VIEWS

    public function form_enroll($page = 'form-enroll') {
        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $model = new CustomModel;

        $data['site_images'] = $model->get_data([
            'table' => 'lites_images'
        ]);

        $data['site_contacts'] = $model->get_data([
            'table' => 'lites_contacts',
        ]);


        $render = [
            'title' => 'Online Enrollment | LITES | Arellano University - Andres Bonifacio Campus',
            'active' => 'admission',
            'data' => $data
        ];

        return $this->renderView('Home/sub-pages/'.$page.'', $render);
    }
}