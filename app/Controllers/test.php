<?php

namespace App\Controllers;

use App\Models\NewsModel;
use Config\Services;

class test extends BaseController
{
    protected $helpers = ['form'];

    public function index()
    {
        if (strtolower($this->request->getMethod()) !== 'post') {
            return view('testfiles/form_vali', [
                'validation' => Services::validation(),
            ]);
        }

        //$rules = [];
        $rules = [
            'username' => 'required',
            'password' => 'required|min_length[10]',
            'passconf' => 'required|matches[password]',
            'email'    => 'required|valid_email',
        ];

        if (! $this->validate($rules)) {
            return view('testfiles/form_vali', [
                'validation' => $this->validator,
            ]);
        }

        return view('testfiles/form_succ');
    }

    public function popup()
    {
        return view('testfiles/bsg_popup');
    }

}

