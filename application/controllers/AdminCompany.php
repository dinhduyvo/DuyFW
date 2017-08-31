<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminCompany extends MY_Controller {

	var $form_data;

	function __construct()
	{
		parent::__construct();
		$this->data["current"] = "";
	}

	public function index()
	{
		$this->data["title"] = "Quản lý Nhà tuyển dụng";
		$this->data['view'] = array("admin/AdminCompany");

		$datas = R::getAll( "SELECT id as code, name as name
												FROM dcompanies Order By name asc" );
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
				redirect("AdminCompany/index/id/".$this->input->post('datas')[0]);
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
		$item = R::findOne('dcompanies','id=?',[$id]);
		$this->form_data = $item;
	}

	private function doAdd()
	{
		$item = R::dispense('dcompanies');
		$item->name = $this->input->post('name');
		$item->link_name = $this->input->post('link_name');
		$item->description = $this->input->post('description');
		$item->display = $this->input->post('display');

		$filenameAvatar = "";
		if(isset($_FILES['avatar']) && $_FILES['avatar']['size'] > 0) {
				$output = $this->mu->do_upload_image ( 'avatar', 'av', FILE_IMAGE_PATH_COMPANIES );
				$filenameAvatar = $output["data"];
		}
		$item->avatar = $filenameAvatar;

		$id = R::store($item);

		redirect($this->uri->uri_string());

	}

	private function doUpdate()
	{
		$item = R::load( 'dcompanies', $this->input->post('id'));
		$item->name = $this->input->post('name');
		$item->link_name = $this->input->post('link_name');
		$item->description = $this->input->post('description');
		$item->display = $this->input->post('display');

		$filenameAvatar = "";
		if(isset($_FILES['avatar']) && $_FILES['avatar']['size'] > 0) {
				$output = $this->mu->do_upload_image ( 'avatar', 'av', FILE_IMAGE_PATH_COMPANIES );
				$filenameAvatar = $output["data"];
		}
		else {
			$filenameAvatar = $item->avatar;
		}
		$item->avatar = $filenameAvatar;

		$id = R::store($item);

		redirect($this->uri->uri_string());

	}

	private function doDelete($id)
	{
		$item = R::load('dcompanies', $id);
		R::trash($item);

	}

}
