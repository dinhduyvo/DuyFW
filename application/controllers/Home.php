<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$noibats = R::find('dnews',' display = ? order by  public_date desc limit 0,8', [2]);
		$this->data['noibats'] = $noibats;
		$this->data['view'] = array('home/top');
		$this->load->view('.layout', $this->data);
	}
}
