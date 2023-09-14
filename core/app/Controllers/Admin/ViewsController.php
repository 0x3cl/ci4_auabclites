<?php 

namespace App\Controllers\Admin;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Controllers\BaseController;
use App\Libraries\LogsController;
use App\Libraries\ReportsController;
use App\Models\CustomModel;

class ViewsController extends BaseController {

    protected $model;
    protected $error = [];
    protected $user_data = [];
    protected $logs;
    protected $reports;

    public function __construct() {
        $this->model = new CustomModel;
        $this->user_data = session()->get('session_token');
        $this->logs = new LogsController();
        $this->reports = new ReportsController();
    }


    public function isPageNotExists($view) {
        if(is_array($view)) {

            $page = $view['page'];
            $isSubPage = $view['isSubPage'];
            
            $viewPath = APPPATH . 'Views/Admin/';
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
        view('admin/templates/header', $data) .
        view($view) . 
        view('admin/templates/footer');
        
    }

    public function login($page = 'login') {

        $view = [
            'page' => $page,
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $render = [
            'title' => 'Admin Login',
            'active' => '',
        ];

        return $this->renderView('Admin/'.$page.'', $render);
    }

    public function signout() {
        $this->logs->init('logged out');
        session()->remove('session_token');
        return redirect()->to('/admin/login');
    }

    public function notify($page = 'notify') {
        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $render = [
            'title' => 'User Notice',
            'active' => 'accounts',
        ];

        return $this->renderView('Admin/sub-pages/'.$page.'', $render);
    }

    public function index() {
        if(session()->get('session_token')) {
            return redirect()->to('/admin/dashboard');
        } else {
            return redirect()->to('/admin/login');
        }
    }

    public function dashboard($page = 'dashboard') {

        $view = [
            'page' => $page,
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $data['user_widgets'] = $this->model->get_data([
            'table' => 'lites_user_widgets',
            'order' => 'widget_id ASC'
        ]);

        $data['get_logs'] = $this->model->get_data([
            'table' => 'lites_logs',
            'select' => 'lites_logs.id, lites_users.first_name, lites_users.last_name, 
                        lites_users.position, lites_logs.activity, 
                        lites_logs.ip_address, lites_logs.date_updated',
            'join' => [
                'table' => 'lites_users',
                'on' => 'lites_logs.user_id = lites_users.id',
                'type' => 'inner'
            ],
            'order' => 'lites_logs.id ASC'
        ]);

        $render = [
            'title' => 'Admin Dashboard',
            'active' => 'dashboard',
            'data' => $data,
        ];

        return $this->renderView('Admin/'.$page.'', $render);
    }

    public function widgets($page = 'widgets') {

        $view = [
            'page' => $page,
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $data['get_widgets'] = $this->model->get_data(['table' => 'lites_site_widgets']);
        $data['get_user_widgets'] = $this->model->get_data(['table' => 'lites_user_widgets']);

        $render = [
            'title' => 'Widgets | LITES',
            'active' => 'widgets',
            'data' => $data,
        ];

        return $this->renderView('Admin/'.$page.'', $render);
    }

    public function manage_users($page = 'manage-users') {

        $view = [
            'page' => ''.$page.'',
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $data['get_other_users'] = $this->model->get_data(
            [
                'table' => 'lites_users',
                'select' => 'lites_users.id, lites_users.username, lites_users.first_name, 
                            lites_users.last_name, lites_users.image, lites_positions.name as position_name, 
                            lites_positions.id as position_id, lites_users.password',
                'condition' => [
                    [
                        'column' => 'lites_users.id !=',
                        'value' => $this->user_data['id']
                    ],
                ],
                'join' => [
                    'table' => 'lites_positions',
                    'on' => 'lites_users.position = lites_positions.id',
                    'type' => 'inner'
                ]
            ]
        );

        $render = [
            'title' => 'Manage Users | LITES',
            'active' => 'accounts',
            'data' => $data,
        ];

        return $this->renderView('Admin/'.$page.'', $render);
    }

    public function add_users($page = 'add-users') {

        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $data['get_positions'] = $this->model->get_data(['table' => 'lites_positions']);

        $render = [
            'title' => 'Add Users | LITES',
            'active' => 'accounts',
            'data' => $data,
        ];

        return $this->renderView('Admin/sub-pages/'.$page.'', $render);
    }

    public function update_users($id, $page = 'update-users') {

        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $data['get_all_users'] = $this->model->get_data(
            [
                'table' => 'lites_users',
                'select' => 'lites_users.id, lites_users.username, lites_users.first_name, 
                            lites_users.last_name, lites_users.image, lites_positions.name as position_name, 
                            lites_positions.id as position_id, lites_users.password',
                'condition' => [
                    'column' => 'lites_users.id',
                    'value' => $id
                ],
                'join' => [
                    'table' => 'lites_positions',
                    'on' => 'lites_users.position = lites_positions.id',
                    'type' => 'inner'
                ]
            ]
        );

        $data['get_positions'] = $this->model->get_data(['table' => 'lites_positions']);

        if(empty($data['get_all_users'])) {
            $flashdata = [
                'route_visited' => request()->uri->getPath(),
                'position' => session()->get('session_token')['position'],
            ];
            session()->setFlashData('notify', $flashdata);
            return redirect()->to('/admin/notify?id=2');
        }

        $render = [
            'title' => 'Update User | LITES',
            'active' => 'accounts',
            'data' => $data,
        ];

        return $this->renderView('Admin/sub-pages/'.$page.'', $render);
    }

    public function delete_users($id, $page = 'delete-users') {

        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $data['get_all_users'] = $this->model->get_data(
            [
                'table' => 'lites_users',
                'select' => 'lites_users.id, lites_users.username, lites_users.first_name, 
                            lites_users.last_name, lites_users.image, lites_positions.name as position_name, 
                            lites_positions.id as position_id, lites_users.password',
                'condition' => [
                    'column' => 'lites_users.id',
                    'value' => $id
                ],
                'join' => [
                    'table' => 'lites_positions',
                    'on' => 'lites_users.position = lites_positions.id',
                    'type' => 'inner'
                ]
            ]
        );

        if(empty($data['get_all_users'])) {
            $flashdata = [
                'route_visited' => request()->uri->getPath(),
                'position' => session()->get('session_token')['position'],
            ];
            session()->setFlashData('notify', $flashdata);
            return redirect()->to('/admin/notify?id=2');
        }

        $render = [
            'title' => 'Delete User | LITES',
            'active' => 'accounts',
            'data' => $data,
        ];

        return $this->renderView('Admin/sub-pages/'.$page.'', $render);
    }

    public function manage_home($page = 'manage-home') {

        $view = [
            'page' => $page,
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $data['get_home_images'] = $this->model->get_data(['table' => 'lites_images']);
        $data['get_carousel_images'] = $this->model->get_data(['table' => 'lites_carousel_images']);


        $render = [
            'title' => 'Manage Home | LITES',
            'active' => 'pages',
            'data' => $data,
        ];

        return $this->renderView('Admin/'.$page.'', $render);
    }

    public function update_logo($id, $page = 'update-logo') {

        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $data['get_home_images'] = $this->model->get_data([
            'table' => 'lites_images',
            'condition' => [
                'column' => 'id',
                'value' => $id
            ]
        ]);

        if(empty($data['get_home_images'])) {
            $flashdata = [
                'route_visited' => request()->uri->getPath(),
                'position' => session()->get('session_token')['position'],
            ];
            session()->setFlashData('notify', $flashdata);
            return redirect()->to('/admin/notify?id=2');
        }

        $render = [
            'title' => 'Manage Users',
            'active' => 'pages',
            'data' => $data,
        ];

        return $this->renderView('Admin/sub-pages/'.$page.'', $render);
    }

    public function manage_admission($page = '') {
        return 'This page is currently under development';
    }

    public function manage_bulletin($page = 'manage-bulletin') {

        $view = [
            'page' => $page,
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $data['get_bulletin'] = $this->model->get_data([
            'table' => 'lites_bulletin',
            'select' => 'lites_bulletin.id, lites_bulletin.category, lites_bulletin.title,
                        lites_bulletin.content, lites_bulletin.date_created, lites_bulletin_image.image',
            'condition' => [
                [
                    'column' => 'lites_bulletin_image.is_banner',
                    'value' => 1
                ]
            ],
            'join' => [
                [
                    'table' => 'lites_bulletin_image',
                    'on' => 'lites_bulletin.id = lites_bulletin_image.bulletin_id',
                    'type' => 'inner'
                ]
            ],
        ]);


        $render = [
            'title' => 'Manage Bulletin | LITES',
            'active' => 'pages',
            'data' => $data,
        ];

        return $this->renderView('Admin/'.$page.'', $render);
    }

    public function add_bulletin($page = 'add-bulletin') {

        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $data['get_bulletin'] = $this->model->get_data([
            'table' => 'lites_bulletin',
            'select' => 'lites_bulletin.id, lites_bulletin.category, lites_bulletin.title,
                        lites_bulletin.content, lites_bulletin.date_created, lites_bulletin_image.image',
            'condition' => [
                'column' => 'lites_bulletin_image.is_banner',
                'value' => 1
            ],
            'join' => [
                [
                    'table' => 'lites_bulletin_image',
                    'on' => 'lites_bulletin.id = lites_bulletin_image.bulletin_id',
                    'type' => 'inner'
                ]
            ],
        ]);


        $render = [
            'title' => 'Add Bulletin | LITES',
            'active' => 'pages',
            'data' => $data,
        ];

        return $this->renderView('Admin/sub-pages/'.$page.'', $render);
    }

    public function update_bulletin($id, $page = 'update-bulletin') {

        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $data['get_bulletin_data'] = $this->model->get_data([
            'table' => 'lites_bulletin',
            'select' => 'lites_bulletin.id, lites_bulletin.category, lites_bulletin.title, 
                        lites_bulletin_image.is_banner, lites_bulletin.content, 
                        lites_bulletin_image.image, lites_bulletin.date_created',
            'condition' => [
                [
                    'column' => 'lites_bulletin_image.is_banner',
                    'value' => 1
                ],
                [
                    'column' => 'lites_bulletin.id',
                    'isNot' => 'false',
                    'value' => $id
                ]
            ],
            'join' => [
                [
                    'table' => 'lites_bulletin_image',
                    'on' => 'lites_bulletin.id = lites_bulletin_image.bulletin_id',
                    'type' => 'inner'
                ]
            ],
        ]);

        $data['get_bulletin_images'] = $this->model->get_data([
            'table' => 'lites_bulletin',
            'select' => 'lites_bulletin.id, lites_bulletin_image.id as image_id, 
                        lites_bulletin_image.is_banner, lites_bulletin_image.image',
            'condition' => [
                [
                    'column' => 'lites_bulletin_image.is_banner !=',
                    'value' => 1
                ],
                [
                    'column' => 'lites_bulletin.id',
                    'value' => $id
                ]
            ],
            'join' => [
                [
                    'table' => 'lites_bulletin_image',
                    'on' => 'lites_bulletin.id = lites_bulletin_image.bulletin_id',
                    'type' => 'inner'
                ]
            ],
        ]);

        if(empty($data['get_bulletin_data'])) {
            $flashdata = [
                'route_visited' => request()->uri->getPath(),
                'position' => session()->get('session_token')['position'],
            ];
            session()->setFlashData('notify', $flashdata);
            return redirect()->to('/admin/notify?id=2');
        }

        $render = [
            'title' => 'Update Bulletin | LITES',
            'active' => 'pages',
            'data' => $data,
        ];

        return $this->renderView('Admin/sub-pages/'.$page.'', $render);
    }

    public function delete_bulletin($id, $page = 'delete-bulletin') {

        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $data['get_bulletin_data'] = $this->model->get_data([
            'table' => 'lites_bulletin',
            'select' => 'lites_bulletin.id, lites_bulletin.category, lites_bulletin.title, 
                        lites_bulletin_image.is_banner, lites_bulletin.content, 
                        lites_bulletin_image.image, lites_bulletin.date_created',
            'condition' => [
                [
                    'column' => 'lites_bulletin_image.is_banner',
                    'value' => 1
                ],
                [
                    'column' => 'lites_bulletin.id',
                    'isNot' => 'false',
                    'value' => $id
                ]
            ],
            'join' => [
                [
                    'table' => 'lites_bulletin_image',
                    'on' => 'lites_bulletin.id = lites_bulletin_image.bulletin_id',
                    'type' => 'inner'
                ]
            ],
        ]);

        if(empty($data['get_bulletin_data'])) {
            $flashdata = [
                'route_visited' => request()->uri->getPath(),
                'position' => session()->get('session_token')['position'],
            ];
            session()->setFlashData('notify', $flashdata);
            return redirect()->to('/admin/notify?id=2');
        }

        $render = [
            'title' => 'Delete Bulletin | LITES',
            'active' => 'pages',
            'data' => $data,
        ];

        return $this->renderView('Admin/sub-pages/'.$page.'', $render);
    }

    public function manage_faculty($page = 'manage-faculty') {

        $view = [
            'page' => $page,
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $data['get_faculty'] = $this->model->get_data([
            'table' => 'lites_faculty',
            'select' => 'lites_faculty.id, lites_faculty.image, lites_faculty.first_name, lites_faculty.last_name, lites_faculty_positions.id as position_id, lites_faculty_positions.position as position',
            'join' => [
                [
                    'table' => 'lites_faculty_positions',
                    'on' => 'lites_faculty.position_id = lites_faculty_positions.id',
                    'type' => 'inner'
                ]
            ],
        ]);

        $render = [
            'title' => 'Manage Faculty | LITES',
            'active' => 'pages',
            'data' => $data,
        ];

        return $this->renderView('Admin/'.$page.'', $render);
    }

    public function add_faculty($page = 'add-faculty') {

        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $data['get_faculty_positions'] = $this->model->get_data(['table' => 'lites_faculty_positions']);

        $render = [
            'title' => 'Add Faculty | LITES',
            'active' => 'pages',
            'data' => $data,
        ];

        return $this->renderView('Admin/sub-pages/'.$page.'', $render);
    }

    public function update_faculty($id, $page = 'update-faculty') {

        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $data['get_faculty'] = $this->model->get_data([
            'table' => 'lites_faculty',
            'select' => 'lites_faculty.id, lites_faculty.image, lites_faculty.first_name, lites_faculty.last_name, 
                        lites_faculty_positions.id as position_id, lites_faculty_positions.position as position, lites_faculty.description',
            'join' => [
                'table' => 'lites_faculty_positions',
                'on' => 'lites_faculty.position_id = lites_faculty_positions.id',
                'type' => 'inner'
            ],
            'condition' => [
                [
                    'column' => 'lites_faculty.id',
                    'value' => $id
                ]
            ],
        ]);

        $data['get_faculty_positions'] = $this->model->get_data(['table' => 'lites_faculty_positions']);

        if(empty($data['get_faculty'])) {
            $flashdata = [
                'route_visited' => request()->uri->getPath(),
                'position' => session()->get('session_token')['position'],
            ];
            session()->setFlashData('notify', $flashdata);
            return redirect()->to('/admin/notify?id=2');
        }

        $render = [
            'title' => 'Update Faculty | LITES',
            'active' => 'pages',
            'data' => $data,
        ];

        return $this->renderView('Admin/sub-pages/'.$page.'', $render);
    }

    public function delete_faculty($id, $page = 'delete-faculty') {

        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $data['get_faculty'] = $this->model->get_data([
            'table' => 'lites_faculty',
            'select' => 'lites_faculty.id, lites_faculty.image, lites_faculty.first_name, lites_faculty.last_name, lites_faculty_positions.id as position_id, lites_faculty_positions.position as position',
            'condition' => [
                [
                    'column' => 'lites_faculty.id',
                    'value' => $id
                ]
            ],
            'join' => [
                [
                    'table' => 'lites_faculty_positions',
                    'on' => 'lites_faculty.position_id = lites_faculty_positions.id',
                    'type' => 'inner'
                ]
            ],
        ]);

        $data['get_faculty_positions'] = $this->model->get_data(['table' => 'lites_faculty_positions']);

        if(empty($data['get_faculty'])) {
            $flashdata = [
                'route_visited' => request()->uri->getPath(),
                'position' => session()->get('session_token')['position'],
            ];
            session()->setFlashData('notify', $flashdata);
            return redirect()->to('/admin/notify?id=2');
        }

        $render = [
            'title' => 'Delete Faculty | LITES',
            'active' => 'pages',
            'data' => $data,
        ];

        return $this->renderView('Admin/sub-pages/'.$page.'', $render);
    }

    public function manage_officers($page = 'manage-officers') {

        $view = [
            'page' => $page,
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $data['get_officers'] = $this->model->get_data([
            'table' => 'lites_officers',
            'select' => 'lites_officers.id, lites_officers.image, lites_officers.first_name, 
                        lites_officers.last_name, lites_positions.id as position_id, 
                        lites_positions.name as position',
            'join' => [
                [
                    'table' => 'lites_positions',
                    'on' => 'lites_officers.position_id = lites_positions.id',
                    'type' => 'inner'
                ]
            ],
        ]);

        $render = [
            'title' => 'Manage Officers | LITES',
            'active' => 'pages',
            'data' => $data,
        ];

        return $this->renderView('Admin/'.$page.'', $render);
    }

    public function add_officers($page = 'add-officers') {

        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $data['get_positions'] = $this->model->get_data(['table' => 'lites_positions']);

        $render = [
            'title' => 'Add Officers | LITES',
            'active' => 'pages',
            'data' => $data,
        ];

        return $this->renderView('Admin/sub-pages/'.$page.'', $render);
    }

    public function update_officers($id, $page = 'update-officers') {

        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }
        
        $data['get_positions'] = $this->model->get_data(['table' => 'lites_positions']);
        $data['get_officers'] = $this->model->get_data([
            'table' => 'lites_officers',
            'select' => 'lites_officers.id, lites_officers.image, lites_officers.first_name, lites_officers.last_name, 
                        lites_positions.id as position_id, lites_positions.name as position',
            'condition' => [
                'column' => 'lites_officers.id',
                'value' => $id
            ],                
            'join' => [
                [
                    'table' => 'lites_positions',
                    'on' => 'lites_officers.position_id = lites_positions.id',
                    'type' => 'inner'
                ]
            ],
        ]);

        if(empty($data['get_officers'])) {
            $flashdata = [
                'route_visited' => request()->uri->getPath(),
                'position' => session()->get('session_token')['position'],
            ];
            session()->setFlashData('notify', $flashdata);
            return redirect()->to('/admin/notify?id=2');
        }

        $render = [
            'title' => 'Update Officer | LITES',
            'active' => 'pages',
            'data' => $data,
        ];

        return $this->renderView('Admin/sub-pages/'.$page.'', $render);
    }

    public function delete_officers($id, $page = 'delete-officers') {

        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }
        
        $data['get_positions'] = $this->model->get_data(['table' => 'lites_positions']);
        $data['get_officers'] = $this->model->get_data([
            'table' => 'lites_officers',
            'select' => 'lites_officers.id, lites_officers.image, lites_officers.first_name, lites_officers.last_name, 
                        lites_positions.id as position_id, lites_positions.name as position',
            'condition' => [
                'column' => 'lites_officers.id',
                'value' => $id
            ],                
            'join' => [
                [
                    'table' => 'lites_positions',
                    'on' => 'lites_officers.position_id = lites_positions.id',
                    'type' => 'inner'
                ]
            ],
        ]);

        
        if(empty($data['get_officers'])) {
            $flashdata = [
                'route_visited' => request()->uri->getPath(),
                'position' => session()->get('session_token')['position'],
            ];
            session()->setFlashData('notify', $flashdata);
            return redirect()->to('/admin/notify?id=2');
        }

        $render = [
            'title' => 'Delete Officer | LITES',
            'active' => 'pages',
            'data' => $data,
        ];

        return $this->renderView('Admin/sub-pages/'.$page.'', $render);
    }

    public function manage_research($page = 'manage-research') {

        $view = [
            'page' => $page,
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $data['get_research_data'] = $this->model->get_data([
            'table' => 'lites_research',
            'select' => 'lites_research.*, lites_research_image.filename as image,
                        lites_research_platforms.platform_id, lites_research_repositories.repositories_id,
                        lites_research_repositories.link',
            'condition' => [
                [
                    'column' => 'lites_research_image.is_banner',
                    'value' => '1'
                ]
            ],
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
                ]
            ],
            'group' => 'lites_research.id'
            
        ]);

        $render = [
            'title' => 'Manage Research | LITES',
            'active' => 'pages',
            'data' => $data,
        ];

        return $this->renderView('Admin/'.$page.'', $render);
    }

    public function add_research($page = 'add-research') {

        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }
        
        $data['get_platforms'] = $this->model->get_data(['table' => 'lites_platforms']);
        $data['get_technologies'] = $this->model->get_data(['table' => 'lites_technologies']);
        $data['get_repositories'] = $this->model->get_data(['table' => 'lites_repositories']);

        $render = [
            'title' => 'Add Research | LITES',
            'active' => 'pages',
            'data' => $data,
        ];

        return $this->renderView('Admin/sub-pages/'.$page.'', $render);
    }

    public function update_research($id, $page = 'update-research') {

        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }
        
        $data['get_research_data'] = $this->model->get_data([
            'table' => 'lites_research',
            'select' => 'lites_research.*, lites_research_image.filename as image,
                        lites_research_platforms.platform_id, lites_research_repositories.repositories_id, 
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
        $data['get_research_technologies'] = $this->model->get_data([
            'table' => 'lites_research_technologies',
            'condition' => [
                'column' => 'lites_research_technologies.research_id',
                'value' => $id
            ],
        ]);
        $data['get_research_images'] = $this->model->get_data([
            'table' => 'lites_research_image',
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
        $data['get_research_authors'] = $this->model->get_data([
            'table' => 'lites_research_authors',
            'condition' => [
                'column' => 'lites_research_authors.research_id',
                'value' => $id
            ],
        ]);
        $data['get_platforms'] = $this->model->get_data(['table' => 'lites_platforms']);
        $data['get_technologies'] = $this->model->get_data(['table' => 'lites_technologies']);
        $data['get_repositories'] = $this->model->get_data(['table' => 'lites_repositories']);

        if(empty($data['get_research_data'])) {
            $flashdata = [
                'route_visited' => request()->uri->getPath(),
                'position' => session()->get('session_token')['position'],
            ];
            session()->setFlashData('notify', $flashdata);
            return redirect()->to('/admin/notify?id=2');
        }

        $render = [
            'title' => 'Update Research | LITES',
            'active' => 'pages',
            'data' => $data,
        ];

        return $this->renderView('Admin/sub-pages/'.$page.'', $render);
    }

    public function delete_research($id, $page = 'delete-research') {

        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }
        
        $data['get_research_data'] = $this->model->get_data([
            'table' => 'lites_research',
            'select' => 'lites_research.*, lites_research_image.filename as image,
                        lites_research_platforms.platform_id, lites_research_repositories.repositories_id, 
                        lites_research_repositories.link',
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
                ]
            ],
            'group' => 'lites_research.id'
        ]);

        if(empty($data['get_research_data'])) {
            $flashdata = [
                'route_visited' => request()->uri->getPath(),
                'position' => session()->get('session_token')['position'],
            ];
            session()->setFlashData('notify', $flashdata);
            return redirect()->to('/admin/notify?id=2');
        }

        $render = [
            'title' => 'Delete Research | LITES',
            'active' => 'pages',
            'data' => $data,
        ];

        return $this->renderView('Admin/sub-pages/'.$page.'', $render);
    }

    public function manage_contact($page = 'manage-contacts') {

        $view = [
            'page' => $page,
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $data['get_contacts'] = $this->model->get_data(['table' => 'lites_contacts']);

        $render = [
            'title' => 'Manage Contact | LITES',
            'active' => 'pages',
            'data' => $data,
        ];

        return $this->renderView('Admin/'.$page.'', $render);
    }

    public function manage_testimonials($page = 'manage-testimonials') {

        $view = [
            'page' => $page,
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $data['get_testimonials'] = $this->model->get_data([
            'table' => 'lites_testimonials'
        ]);

        
        $render = [
            'title' => 'Manage Testimonials | LITES',
            'active' => 'pages',
            'data' => $data,
        ];

        return $this->renderView('Admin/'.$page.'', $render);
    }

    public function add_testimonials($page = 'add-testimonials') {

        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $render = [
            'title' => 'Add Testimonial | LITES',
            'active' => 'pages',
        ];

        return $this->renderView('Admin/sub-pages/'.$page.'', $render);
    }

    public function update_testimonials($id, $page = 'update-testimonials') {

        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }
        
        $data['get_testimonial'] = $this->model->get_data([
            'table' => 'lites_testimonials',
            'condition' => [
                'column' => 'lites_testimonials.id',
                'value' => $id
            ],
        ]);

        if(empty($data['get_testimonial'])) {
            $flashdata = [
                'route_visited' => request()->uri->getPath(),
                'position' => session()->get('session_token')['position'],
            ];
            session()->setFlashData('notify', $flashdata);
            return redirect()->to('/admin/notify?id=2');
        }

        $render = [
            'title' => 'Update Testimonial | LITES',
            'active' => 'pages',
            'data' => $data,
        ];

        return $this->renderView('Admin/sub-pages/'.$page.'', $render);
    }

    public function delete_testimonials($id, $page = 'delete-testimonials') {

        $view = [
            'page' => $page,
            'isSubPage' => 'true',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }
        
        $data['get_testimonial'] = $this->model->get_data([
            'table' => 'lites_testimonials',
            'condition' => [
                'column' => 'lites_testimonials.id',
                'value' => $id
            ],
        ]);

        if(empty($data['get_testimonial'])) {
            $flashdata = [
                'route_visited' => request()->uri->getPath(),
                'position' => session()->get('session_token')['position'],
            ];
            session()->setFlashData('notify', $flashdata);
            return redirect()->to('/admin/notify?id=2');
        }

        $render = [
            'title' => 'Delete testimonial | LITES',
            'active' => 'pages',
            'data' => $data,
        ];

        return $this->renderView('Admin/sub-pages/'.$page.'', $render);
    }

    public function manage_me($page = 'manage-me') {
        $view = [
            'page' => $page,
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $data['get_user_data'] = $this->model->get_data([
            'table' => 'lites_users',
            'condition' => [
                'column' => 'lites_users.id',
                'value' => session()->get('session_token')['id']
            ]
        ]);

        
        $render = [
            'title' => 'Manage Account | LITES',
            'active' => 'settings',
            'data' => $data,
        ];

        return $this->renderView('Admin/'.$page.'', $render);
    }

    public function manage_passwords($page = 'manage-passwords') {
        $view = [
            'page' => $page,
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $data['get_user_data'] = $this->model->get_data([
            'table' => 'lites_users',
            'condition' => [
                'column' => 'lites_users.id',
                'value' => session()->get('session_token')['id']
            ]
        ]);

        
        $render = [
            'title' => 'Manage Passwords | LITES',
            'active' => 'settings',
            'data' => $data,
        ];

        return $this->renderView('Admin/'.$page.'', $render);
    }

    public function manage_reports($page = 'manage-reports') {
        $view = [
            'page' => $page,
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }
        
        $render = [
            'title' => 'Manage Reports | LITES',
            'active' => 'reports',
        ];

        if(!empty($this->request->getGet())) {
            $this->reports->init();
        }

        return $this->renderView('Admin/'.$page.'', $render);
    }

    public function manage_logs($page = 'manage-logs') {
        $view = [
            'page' => $page,
            'isSubPage' => 'false',
        ];

        if($this->isPageNotExists($view)) {
            throw PageNotFoundException::forPageNotFound();    
        }

        $data['get_logs'] = $this->model->get_data([
            'table' => 'lites_logs',
            'select' => 'lites_logs.id, lites_users.username, lites_users.first_name, lites_users.last_name, 
                        lites_users.position, lites_logs.activity, 
                        lites_logs.ip_address, lites_logs.date_updated',
            'join' => [
                'table' => 'lites_users',
                'on' => 'lites_logs.user_id = lites_users.id',
                'type' => 'inner'
            ],
            'order' => 'lites_logs.id DESC'
        ]);

        $render = [
            'title' => 'Manage Logs | LITES',
            'active' => 'logs',
            'data' => $data,
        ];

        return $this->renderView('Admin/'.$page.'', $render);
    }

}