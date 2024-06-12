<?php

namespace App\Controllers;

use App\Models\SignupModel;

class Home extends BaseController
{
    public function index(): string
    {
        return view('gelib/gheader_m')
        . view('gelib/gtopmenu')
        . view('spectral')
        . view('gelib/gfooter');
    }

    public function generic(): string
    {
        return view('gelib/gheader')
        . view('gelib/gtopmenu')
        . view('generic')
        . view('gelib/gfooter');
    }

    public function elements(): string
    {
        return view('gelib/gheader')
        . view('gelib/gtopmenu')
        . view('elements')
        . view('gelib/gfooter');
    }

    public function signup(): string
    {
        $model = model(SignupModel::class);

        if ( $_POST )
        {
            /* $this->request->getPost('title') */
            $c_id = $this->request->getPost('c_id');
            $c_name = $this->request->getPost('c_name');
            $c_Email = $this->input->post('c_Email', TRUE);
            $c_pw = $this->input->post('c_pw', TRUE);
            $c_nic = $this->input->post('c_nic', TRUE);
            /*
            $c_id = "baekguni";
            $c_name = "baekgun";
            $c_Email = "baekguni@naver.com";
            $c_pw = "100100";
            $c_nic = "baekgun nic";
            */

            $model->adduser($c_name, $c_Email, $c_id, $c_pw, $c_nic);
			//redirect('/');
			// exit;

            return view('gelib/gheader')
            . view('gelib/gtopmenu')
            . view('login')
            . view('gelib/gfooter');

        }
        else{
            return view('gelib/gheader')
            . view('gelib/gtopmenu')
            . view('signup')
            . view('gelib/gfooter');
        }
    }
    
    public function signupchk(): string
    {
        //header("content-type:application/json");
  
        $data = array();
        //$dbdata = array();
          
        // Read new token and assign in $data['token']
        $data['token'] = csrf_hash();
        $c_id = $this->request->getPost('cid');
        $data['cid'] = $c_id;

        // http://localhost/signupchk?cid=cardoc

        ## Validation
        $validation = \Config\Services::validation();
  
        $validation->setRules(['cid' => 'required|min_length[5]']);        
  
        if ($validation->withRequest($this->request)->run() == FALSE){
  
           $data['success'] = 0;
           $data['error'] = $validation->getError('cid');// Error response
  
        }else{
            $data['success'] = 1;
            $model = model(SignupModel::class);
            $dbdata = $model->checkid($c_id);
            // 결과를 배열로 가져오기
            $result = $dbdata->getRowArray();

            if (empty($result)) {
                // 레코드가 없는 경우
                $data['cnt'] = 0;
            } else {
                // 레코드가 있는 경우
                $data['cnt'] = $result['cnt'];
            }
            
        }
        $json_output = json_encode($data, JSON_UNESCAPED_UNICODE);
        return $json_output;
    }

    public function signup_ajax(): string
    {
        
        /* 회원가입처리 AJAX */
        header("content-type:application/json");
        $data = array();
  
        // Read new token and assign in $data['token']
        $data['token'] = csrf_hash();
  
        ## Validation
        $validation = \Config\Services::validation();
        $input = $validation->setRules([
          'cid' => 'required|min_length[3]'
        ]);
  
        if ($validation->withRequest($this->request)->run() == FALSE){
  
           $data['success'] = 0;
           $data['error'] = $validation->getError('cid');// Error response
  
        }else{
  
            $data['success'] = 1;
            $c_id = $this->request->getPost('cid');
            $c_name = $this->request->getPost('c_name');
            $c_Email = $this->input->post('c_Email', TRUE);
            $c_pw = $this->input->post('c_pw', TRUE);
            $c_nic = $this->input->post('c_nic', TRUE);
      
            $model = model(SignupModel::class);
            $data['result'] = $model->adduser($c_name, $c_Email, $c_id, $c_pw, $c_nic);
        }
        $json_output = json_encode($data, JSON_UNESCAPED_UNICODE);
        return $json_output;

    }
    public function login(): string
    {
        return view('gelib/gheader')
        . view('gelib/gtopmenu')
        . view('login')
        . view('gelib/gfooter');
    }


}
