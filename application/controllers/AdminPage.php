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
		$this->data['view'] = array("admin/AdminPage");

		$parents = R::getAll( "SELECT id as code, title as name
													FROM DPages Where parent is null Order By disorder asc" );
		$this->data["parents"] = $parents;
		$pages = R::getAll( "SELECT id as code, CASE
																								WHEN parent is null THEN concat('【',display,'】', title)
																								ELSE concat('　ᗒ ',concat('【',display,'】', title))
																						END as name
												FROM DPages Order By disorder asc" );
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
			elseif ($this->input->post('pageaction') == "up") {
				$this->doUp();
			}
			elseif ($this->input->post('pageaction') == "down") {
				$this->doDown();
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
		$content = R::findOne('dcontents','pageid=?',[$id]);
		$this->form_data = $page;
		$this->data["datacontent"] = $content;
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

		if($this->input->post('type') == "static") {
			$content = R::dispense("dcontents");
			$content->title = $this->input->post('contenttitle');
			$content->content = $this->input->post('content');
			$content->pageid = $id;
			R::store($content);
		}

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

	private function doUp()
	{
		$pages = $this->input->post('pages');
		foreach ($pages as $pageid) {
			$page = R::load("dpages", $pageid);
			if($page->parent == ""){
				$upTmp = R::findOne("dpages", " parent is null and disorder < ? order by disorder desc ",[$page->disorder]);
			}
			else {
				$upTmp = R::findOne("dpages", " parent = ? and disorder < ? order by disorder desc ",[$page->parent, $page->disorder]);
			}

			if($upTmp != null){
				$up = R::load("dpages", $upTmp->id);
				$backupPage = $page->disorder;
				$backupUp = $up->disorder;
				$page->disorder = $up->disorder;
				$up->disorder = $backupPage;

				R::store($page);
				R::store($up);
				if($page->parent == ""){
					R::exec("UPDATE dpages SET disorder = concat(?,RIGHT(disorder,4)) WHERE parent = ?",[substr($backupUp,0,4), $page->id]);
					R::exec("UPDATE dpages SET disorder = concat(?,RIGHT(disorder,4)) WHERE parent = ?",[substr($backupPage,0,4), $up->id]);
				}

			}
		}
		redirect($this->uri->uri_string());
	}

	private function doDown()
	{
		$pages = $this->input->post('pages');
		for ($i=count($pages) - 1; $i >= 0; $i--) {
			$pageid = $pages[$i];
			$page = R::load("dpages", $pageid);
			if($page->parent == ""){
				$downTmp = R::findOne("dpages", " parent is null and disorder > ? order by disorder asc ",[$page->disorder]);
			}
			else {
				$downTmp = R::findOne("dpages", " parent = ? and disorder > ? order by disorder asc ",[$page->parent, $page->disorder]);
			}

			if($downTmp != null){
				$down = R::load("dpages", $downTmp->id);
				$backupPage = $page->disorder;
				$backupDown = $down->disorder;
				$page->disorder = $down->disorder;
				$down->disorder = $backupPage;

				R::store($page);
				R::store($down);
				if($page->parent == ""){
					R::exec("UPDATE dpages SET disorder = concat(?,RIGHT(disorder,4)) WHERE parent = ?",[substr($backupDown,0,4), $page->id]);
					R::exec("UPDATE dpages SET disorder = concat(?,RIGHT(disorder,4)) WHERE parent = ?",[substr($backupPage,0,4), $down->id]);
				}

			}
		}
		redirect($this->uri->uri_string());
	}

}
