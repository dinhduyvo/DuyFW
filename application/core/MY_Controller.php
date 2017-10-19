<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
  var $data;
  var $params;
	function __construct()
	{
		parent::__construct();
    //RedbeanPHP load
		$this->load->database();
    if(!R::testConnection()){
      R::setup("mysql:host=".$this->db->hostname.";dbname=".$this->db->database,$this->db->username,$this->db->password);
    }

    if ($this->input->server ( 'REQUEST_METHOD' ) == 'POST') {
        $this->data["isposted"] = true;
    } else {
        $this->data["isposted"] = false;
    }

    $this->params = $this->uri->uri_to_assoc ();

    $this->data["userlogin"] = $this->ion_auth->user()->row();

    if ($this->ion_auth->logged_in()){
      $pages2 = R::getAll( "SELECT t1.*, (select count(*) from DPages where parent = t1.id) as childnum
                            FROM DPages t1
                            Where t1.deleteflag = 0 and t1.display = 1

                            Order By disorder asc" );
    }
    else{
      $pages2 = R::getAll( "SELECT t1.*, (select count(*) from DPages where parent = t1.id) as childnum
                            FROM DPages t1
                            LEFT JOIN Dpages t2 ON t1.parent = t2.id
                            Where t1.deleteflag = 0 and t1.display = 1
                            And ((t1.parent is null AND t1.permission = 'ALL') OR (t1.parent is not null And t2.permission = 'ALL' And t1.permission = 'ALL'))
                            Order By disorder asc" );
    }

    $this->data['menus'] = $pages2;
	}
}
