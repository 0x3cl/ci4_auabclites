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
            $model = new CustomModel;

            if(is_numeric($user_id) && is_numeric($widget_id)) {

                try {
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
    
                    if(empty($result)
                        && $model->insert_data('lites_user_widgets', $data)) {
                        $flashdata = [
                            'status' => 'success',
                            'message' => 'widget enabled successfully'
                        ];
                    } else {
                        $condition = [
                            'user_id' => $user_id,
                            'widget_id' => $widget_id
                        ];
    
                        if($model->delete_data('lites_user_widgets', $condition)) {
                            $flashdata = [
                                'status' => 'success',
                                'message' => 'widget disabled successfully'
                            ];
                        }
                    }
                } catch (\Exception $e) {
                    $message = array_values($this->validator->getErrors());
                    $flashdata = [
                        'status' => 'error',
                        'message' => $message,
                    ];
                }

                session()->setFlashdata('flashdata', $flashdata);
                return redirect()->back();
            }
        }
    }

}