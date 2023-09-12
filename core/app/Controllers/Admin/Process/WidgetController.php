<?php

namespace App\Controllers\Admin\Process;

use App\Controllers\BaseController;
use App\Models\CustomModel;

class WidgetController extends BaseController {

    protected $validation;

    public function __construct() {
        $this->validation = \Config\Services::validation();
    }

    public function index() {
        if($this->request->getMethod() === 'post') {
            $user_id = session()->get('session_token')['id'];
            $widget_id = $this->request->getPost('id');
            if(is_numeric($user_id) && is_numeric($widget_id)) {
                $model = new CustomModel;
                $result = $model->get_data([
                    'table' => 'lites_user_widgets',
                    'condition' => [
                        [
                            'column' => 'user_id',
                            'value' => $user_id
                        ],
                        [
                            'column' => 'widget_id',
                            'value' => $widget_id
                        ]
                    ]
                ]);

                $data = [
                    'user_id' => $user_id,
                    'widget_id' => $widget_id
                ];

                if(empty($result)) {
                    try {
                        $model->insertData('lites_user_widgets', $data);
                        $flashdata = [
                            'status' => 'success',
                            'message' => 'widget enabled successfully'
                        ];
                    } catch (\Exception $e) {
                        $flashdata = [
                            'status' => 'error',
                            'message' => 'error: ' . $e->getMessage()
                        ];
                    }
                } else {

                    $condition = [
                        'user_id' => $user_id,
                        'widget_id' => $widget_id
                    ];

                    try {
                        $model->deleteData('lites_user_widgets', $condition);
                        $flashdata = [
                            'status' => 'success',
                            'message' => 'widget disabled successfully'
                        ];
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

}