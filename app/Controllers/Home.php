<?php

namespace App\Controllers;

use App\Models\SignupModel;
use Config\Services;

class Home extends BaseController
{
    protected $helpers = ['form'];

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

            ## Validation
            $validation = \Config\Services::validation();
    
            $rules = [
                'c_id' => 'required|min_length[5]',
                'c_name' => 'required|min_length[3]',
                'c_nick' => 'required|min_length[3]',
                'c_pw' => 'required|min_length[6]',
                'c_pwconf' => 'required|matches[c_pw]',
                'c_Email'    => 'required|valid_email',
            ];
    
            if (! $this->validate($rules)) {
    
                return view('gelib/gheader')
                . view('gelib/gtopmenu')
                .view('signup', ['validation' => $this->validator,])
                . view('gelib/gfooter');
            }else{
            /* $this->request->getPost('title') */
                $c_id = $this->request->getPost('c_id');
                $c_name = $this->request->getPost('c_name');
                $c_Email = $this->request->getPost('c_Email');
                $c_pw = $this->request->getPost('c_pw');
                $c_nick = $this->request->getPost('c_nick');

                $model->adduser($c_name, $c_Email, $c_id, $c_pw, $c_nick);
                
                return view('gelib/gheader')
                . view('gelib/gtopmenu')
                . view('login')
                . view('gelib/gfooter');               
            }
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
        $validation = \Config\Services::validation();
        $data = array();
          
        // Read new token and assign in $data['token']
        //$data['token'] = csrf_token();
        $data['chash'] = csrf_hash();
        $data['cnt'] = 2;
        $data['success'] = 0;
        
        // http://localhost/signupchk?cid=cardoc
        $c_id = $this->request->getPost('custid');
        $data['custidr'] = $c_id;
  
        $rules = [
            'custid' => [
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => '아이디를 입력해주세요.',
                    'min_length' => '아이디가 너무 짧습니다. 다른 아이디를 입력해주세요.'
                ],
            ],
        ];

        //if ($this->validation->run() == FALSE){
        if(! $this->validate($rules)){
           $data['success'] = 0;
           $data['error'] = $validation->getError('custid');// Error response
           $data['cnt'] = 3;
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
        //header("content-type:application/json");
        $data = array();
  
        // Read new token and assign in $data['token']
        $data['chash'] = csrf_hash();
  
        ## Validation
        $validation = \Config\Services::validation();
        $rules = [
            'c_id' => [
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => '아이디를 입력해주세요.',
                    'min_length' => '아이디가 너무 짧습니다. 다른 아이디를 입력해주세요.'
                ],
            ],
            'c_name' => [
                'rules' => 'required|min_length[2]',
                'errors' => [
                    'required' => '이름을 입력해주세요.',
                    'min_length' => '이름이 너무 짧습니다. 두글자 이상 입력해주세요.'
                ],
            ],
            'c_email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => '이메일 주소를 입력해주세요.',
                    'valid_email' => '이메일 형식이 잘 못 되었습니다.'
                ],
            ],
            'c_pw' => [
                'rules' => 'required|min_length[8]|alpha_numeric_punct',
                'errors' => [
                    'required' => '패스워드를 입력해주세요.',
                    'min_length' => '패스워드는 8자 이상이어야 합니다.',
                    'alpha_numeric_punct' => '패스워드는 영문, 숫자 그리고 특수문자로만 이루어져야 합니다.'
                ],
            ],
            'c_pwconf' => [
                'rules' => 'required|matches[c_pw]',
                'errors' => [
                    'required' => '확인용 패스워드를 입력해주세요.',
                    'matches' => '확인용 패스워드가 다르게 입력 되었습니다.'
                ],
            ],

        ];


        //if ($validation->withRequest($this->request)->run() == FALSE){
        if(! $this->validate($rules)){
           $data['success'] = 0;
           $data['error'] = '입력형식이 맞지 않습니다.';
           $data['result'] = false;
           
           if ($validation->hasError('c_id')) {
                $data['error'] = $data['error'] . '\n' . $validation->getError('c_id');
                $data['errorele'] = 'c_id';
           }
           if ($validation->hasError('c_name')) {
                $data['error'] = $data['error'] . '\n' . $validation->getError('c_name');
                $data['errorele'] = 'c_name';
           }
           if ($validation->hasError('c_email')) {
                $data['error'] = $data['error'] . '\n' . $validation->getError('c_email');
                $data['errorele'] = 'c_email';
           }
           if ($validation->hasError('c_pw')) {
                $data['error'] = $data['error'] . '<br>' . $validation->getError('c_pw');
                $data['errorele'] = 'c_pw';
           }
           if ($validation->hasError('c_pwconf')) {
                $data['error'] = $data['error'] . '<br>' . $validation->getError('c_pwconf');
                $data['errorele'] = 'c_pwconf';
           }
  
        }else{
  
            $data['success'] = 1;
            $c_id = $this->request->getPost('c_id');
            $c_name = $this->request->getPost('c_name');
            $c_email = $this->request->getPost('c_email');
            $c_pw = $this->request->getPost('c_pw');
            $c_nic = $this->request->getPost('c_nick');
      
            $model = model(SignupModel::class);
            $data['result'] = $model->adduser($c_name, $c_email, $c_id, $c_pw, $c_nic);
            // result value is true or false
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
