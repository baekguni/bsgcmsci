<?PHP
    /* 이런 뷰를 만들 필요는 없다. 컨틀롤러에서 그냥 리턴하면 됨. */
    
    /*
    $data_tmo['user'] = array('cnt' => 1, 'cnt2' => 20 );
    $data_tmo['name'] = array('name' => 'sung kyun');
    $json_output = json_encode($data_tmo, JSON_UNESCAPED_UNICODE);
    */

    // echo json_encode(array("pup" => 'gunter', 'name' => 'hong'));
    //$data = '{"Peter":35,"Ben":37,"Joe":43}';

    $data = $this->input->post('data', true);
    //$json_object = json_decode( $data, false );
    $json_output = json_encode($data, JSON_UNESCAPED_UNICODE);

    echo $json_output;
    
?>