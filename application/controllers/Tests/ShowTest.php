<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class ShowTest extends  CI_Controller{
    public function index(){
        $this->load->view('TestDocuments/test_library');
    }
}