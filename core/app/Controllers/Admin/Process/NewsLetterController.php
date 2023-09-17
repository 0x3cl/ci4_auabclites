<?php

namespace App\Controllers\Admin\Process;

use App\Controllers\BaseController;
use App\Models\CustomModel;

class NewsLetterController extends BaseController {

    protected $model;

    public function __construct() {
        $this->model = new CustomModel;
    }

    public function delete_data($id) {
       try {
            if($this->model->delete_data('lites_newsletter', [
                'id' => $id
            ])) {
                $flashdata = [
                    'status' => 'success',
                    'message' => 'email successfully unsubscribed'
                ];
            }
        } catch(\Exception $e) {
            $flashdata = [
                'status' => 'error',
                'message' => 'error: ' . $e->getMessage()
            ];
        }

        session()->setFlashdata('flashdata', $flashdata);
        return redirect()->back();
    }

}