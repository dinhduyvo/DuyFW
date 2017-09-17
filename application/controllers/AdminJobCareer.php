<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminJobCareer extends MY_Controller {

	var $form_data;

	function __construct()
	{
		parent::__construct();
		$this->data["current"] = "";
	}

	public function index()
	{
		$this->data["title"] = "Quản lý nghề nghiệp tuyển dụng";
		$this->data['view'] = array("admin/AdminJobCareer");

		$datas = R::getAll( "SELECT id as code, name as name
												FROM dcareers Order By name asc" );
		$this->data["datas"] = $datas;

		if($this->input->post('name') != null && $this->input->post('id') > 0){
			$this->doUpdate();
		}
		else if($this->input->post('name') != null){
			$this->doAdd();
		}

		if ($this->input->post('datas') != null) {
			if($this->input->post('pageaction') == "delete"){
				foreach ($this->input->post('datas') as $id) {
					$this->doDelete($id);
				}
				redirect($this->uri->uri_string());
			}
			else {
				redirect("AdminJobCareer/index/id/".$this->input->post('datas')[0]);
			}

		}
		if (isset($this->params['id'])) {
			$this->data["current"] = array($this->params['id']);
			$this->doGet();
		}

		$this->data['data'] = $this->form_data;

		$this->load->view('.layout', $this->data);
	}

	public function doGet()
	{
		$id = $this->params['id'];
		$item = R::findOne('dcareers','id=?',[$id]);
		$this->form_data = $item;
	}

	private function doAdd()
	{
		$item = R::dispense('dcareers');
		$item->name = $this->input->post('name');
		$item->link_name = $this->input->post('link_name');
		$item->icon = $this->input->post('icon');
		$item->display = $this->input->post('display');

		$id = R::store($item);

		redirect($this->uri->uri_string());

	}

	private function doUpdate()
	{
		$item = R::load( 'dcareers', $this->input->post('id'));
		$item->name = $this->input->post('name');
		$item->link_name = $this->input->post('link_name');
		$item->icon = $this->input->post('icon');
		$item->display = $this->input->post('display');

		$id = R::store($item);

		redirect($this->uri->uri_string());

	}

	private function doDelete($id)
	{
		$item = R::load('dcareers', $id);
		R::trash($item);

	}

}
