<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminPage extends MY_Controller {

	var $form_data;

	function __construct()
	{
		parent::__construct();
		$this->data["current"] = "";
	}

	public function index()
	{
		$this->data["title"] = "Quản lý trang";
		$this->data['view'] = "admin/AdminPage";

		$parents = R::getAll( "SELECT id as code, title as name FROM DPages Where parent is null Order By disorder asc" );
		$this->data["parents"] = $parents;
		$pages = R::getAll( "SELECT id as code, CASE WHEN parent is null THEN title ELSE concat('........ ',title) END as name FROM DPages Order By disorder asc" );
		$this->data["pages"] = $pages;



		if($this->input->post('title') != null && $this->input->post('id') > 0){
			$this->doUpdate();
		}
		else if($this->input->post('title') != null){
			$this->doAdd();
		}

		if ($this->input->post('pages') != null) {
			if($this->input->post('pageaction') == "delete"){
				foreach ($this->input->post('pages') as $id) {
					$this->doDelete($id);
				}
				redirect($this->uri->uri_string());
			}
			else {
				redirect("AdminPage/index/id/".$this->input->post('pages')[0]);
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
		$page = R::findOne('dpages','id=?',[$id]);
		$this->form_data = $page;
	}

	private function doAdd()
	{
		$page = R::dispense('dpages');
		$page->title = $this->input->post('title');
		$page->link_name = $this->input->post('link_name');
		$page->type = $this->input->post('type');
		if ($this->input->post('parent')>0) {
			$page->parent = $this->input->post('parent');
			$maxorder = R::getCell('SELECT max(disorder) FROM dpages WHERE parent = ?',[$this->input->post('parent')]);
			if($maxorder > 0){
				$page->disorder = $maxorder + 1;
			}
			else{
				$maxorder = R::getCell('SELECT max(disorder) FROM dpages WHERE id = ?',[$this->input->post('parent')]);
				$page->disorder = $maxorder + 1;
			}
		}
		else{
			$maxorder = R::getCell('SELECT max(disorder) FROM dpages WHERE parent is null');
			$page->disorder = $maxorder + 10000;
		}
		$page->link = $this->input->post('link');
		$page->display = $this->input->post('display');
		$id = R::store($page);

		redirect($this->uri->uri_string());

	}

	private function doUpdate()
	{
		$page = R::load( 'dpages', $this->input->post('id'));
		$page->title = $this->input->post('title');
		$page->link_name = $this->input->post('link_name');
		$page->type = $this->input->post('type');
		if ($this->input->post('parent')>0) {
			if($this->input->post('parent') != $page->parent){
				$maxorder = R::getCell('SELECT max(disorder) FROM dpages WHERE parent = ?',[$this->input->post('parent')]);
				if($maxorder > 0){
					$page->disorder = $maxorder + 1;
				}
				else{
					$maxorder = R::getCell('SELECT max(disorder) FROM dpages WHERE id = ?',[$this->input->post('parent')]);
					$page->disorder = $maxorder + 1;
				}
			}
			$page->parent = $this->input->post('parent');
		}
		$page->link = $this->input->post('link');
		$page->display = $this->input->post('display');
		$id = R::store($page);

		redirect($this->uri->uri_string());

	}

	private function doDelete($id)
	{
		$page = R::load('dpages', $id);
		R::trash($page);

	}
}
