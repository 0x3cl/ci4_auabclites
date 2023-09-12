<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CustomModel;

class ApiController extends BaseController {

    use ResponseTrait;

    public function get_overview() {

        $model = new CustomModel;
        
        $tables = [
            'total_visitors' => 'lites_site_visitors',
            'total_users' => 'lites_users',
            'total_bulletin' => 'lites_bulletin',
            'total_faculty' => 'lites_faculty',
            'total_officers' => 'lites_officers',
            'total_research' => 'lites_research'
        ];

        $data = [];

        try {
            foreach ($tables as $key => $table) {
                $result = $model->get_data([
                    'table' => $table
                ]);
                $data[$key] = count($result);
            }
        } catch (\Exception $e) {
            $response = [
                'status' => 500,
                'message' => 'error :' . $e->getMessage(),
            ];
        }

        $response = [
            'status' => 200,
            'message' => 'ok',
            'data' => $data
        ];

        return $this->respondCreated($response);
    }

    public function get_visitors() {
        $model = new CustomModel;
        $builder = $model->db->table('lites_site_visitors') 
        ->select('YEAR(date_visited) as year, MONTHNAME(date_visited) as month, COUNT(*) as count')
        ->groupBy('year, month')
        ->orderBy('year, month')
        ->get();

        $result = $builder->getResult(); 

        $data = [];

        // Create an array to store month names
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        foreach ($result as $row) {
            $year = $row->year;
            $month = strtoupper($row->month);
            $count = $row->count;

            if (!isset($data[$year])) {
                $months = array_map('strtoupper', $months);
                $data[$year] = array_fill_keys($months, '0');
            }

            // Set the count for the specific month
            $data[$year][$month] = $count;
        }

        $response = [
            'status' => 200,
            'message' => 'ok',
            'total_data' => count($data),
            'data' => $data
        ];


            return $this->respondCreated($response);
    }

    public function get_referrers() {
        $model = new CustomModel;
        $builder = $model->db->table('lites_site_referrers') 
            ->select('COUNT(*) as count, referrer')
            ->groupBy('referrer')
            ->orderBy('referrer')
            ->get();

        $result = $builder->getResult(); 

        $data = [];

        foreach ($result as $row) {
            $referrer = $row->referrer;

            $key = convertReferrer($referrer);            
            $data[$key] = [
                'referrer' => $referrer,
                'count' => $row->count
            ];
        }

        $response = [
            'status' => 200,
            'message' => 'ok',
            'total_data' => count($data),
            'data' => $data
        ];

        return $this->respondCreated($response);
    }

    public function newsletter() {

        if($this->validate([
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|is_unique[lites_newsletter.email]',
                'errors' => [
                    'required' => '{field} is required',
                    'valid_email' => '{field} is not a valid email',
                    'is_unique' => '{field} is already receiving email updates'
                ]
            ]])) {
            $email = $this->request->getPost('email');

            $model = new CustomModel();

            if($model->insertData('lites_newsletter', [
                'email' => $email
            ])) {
                $response = [
                    'status' => 200,
                    'message' => 'email successfully subscribed',
                ];   
            }
        } else {
            $response = [
                'status' => 200,
                'message' => $this->validator->getErrors(),
            ];
        }   

        return $this->respondCreated($response); 
    }

}