<?php

namespace App\Models;

use CodeIgniter\Model;

class SignupModel extends Model
{
    // protected $table = 'crm_user';
    // protected $allowedFields = ['cid', 'cemail', 'cname','cpasswd','cnic'];

    public function adduser($c_name, $c_Email, $c_id, $c_pw, $c_nic)
    {
        $db = \Config\Database::connect();
        $sql = "insert into crm_user(cid,cemail,cname,cpasswd,cnic) values('".$c_id."', '".$c_Email."', '". $c_name."', Password('". $c_pw."'), '". $c_nic."')";
        $result = $db->query($sql);
        
        //$sql = "INSERT INTO crm_user (cid, cemail, cname, cpasswd, cnic) VALUES (?, ?, ?, PASSWORD(?), ?)";
        // 쿼리 실행 및 결과 확인
        //$result = $db->query($sql, [$c_id, $c_Email, $c_name, $c_pw, $c_nic]) ? 1 : 0;
        return $result;
    }

    public function checkid($c_id)
    {
        $db = \Config\Database::connect();
        $sql = "select count(*) as cnt from crm_user where cid='".$c_id."' group by cid";
        return $db->query($sql);
    }

}