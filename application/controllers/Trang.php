<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trang extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		$this->data['view'] = array('Trang');
	}

	public function index()
	{
		$id=$this->params['i'];
		$beans = R::findMulti('dpages,dcontents',
									'SELECT dpages.*, dcontents.* FROM dpages LEFT JOIN dcontents ON dpages.id = dcontents.pageid
									WHERE dpages.link_name = ?',[$id]);
		$this->data['dcontents'] = $beans['dcontents'];
		$this->load->view('.layout', $this->data);
	}
}
