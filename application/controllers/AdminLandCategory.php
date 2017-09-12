<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminLandCategory extends MY_Controller {

	var $form_data;

	function __construct()
	{
		parent::__construct();
		$this->data["current"] = "";
	}

	public function index()
	{
		$this->data["title"] = "Quản lý Danh mục Bất động sản";
		$this->data['view'] = array("admin/AdminLandCategory");

		$parents = R::getAll( "SELECT id as code, name as name
													FROM dlandcategories Where parent is null Order By disorder asc" );
		$this->data["parents"] = $parents;
		$datas = R::getAll( "SELECT id as code, CASE
																								WHEN parent is null THEN concat('【',display,'】', name)
																								ELSE concat('　ᗒ ',concat('【',display,'】', name))
																						END as name
												FROM dlandcategories Order By disorder asc" );
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
			elseif ($this->input->post('pageaction') == "up") {
				$this->doUp();
			}
			elseif ($this->input->post('pageaction') == "down") {
				$this->doDown();
			}
			else {
				redirect("AdminLandCategory/index/id/".$this->input->post('datas')[0]);
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
		$item = R::findOne('dlandcategories','id=?',[$id]);
		$this->form_data = $item;
	}

	private function doAdd()
	{
		$item = R::dispense('dlandcategories');
		$item->name = $this->input->post('name');
		$item->link_name = $this->input->post('link_name');
		$item->type = $this->input->post('type');
		if ($this->input->post('parent')>0) {
			$item->parent = $this->input->post('parent');
			$maxorder = R::getCell('SELECT max(disorder) FROM dlandcategories WHERE parent = ?',[$this->input->post('parent')]);
			if($maxorder > 0){
				$item->disorder = $maxorder + 1;
			}
			else{
				$maxorder = R::getCell('SELECT max(disorder) FROM dlandcategories WHERE id = ?',[$this->input->post('parent')]);
				$item->disorder = $maxorder + 1;
			}
		}
		else{
			$maxorder = R::getCell('SELECT max(disorder) FROM dlandcategories WHERE parent is null');
			$item->disorder = $maxorder + 10000;
		}
		$item->link = $this->input->post('description');
		$item->display = $this->input->post('display');
		$id = R::store($item);

		redirect($this->uri->uri_string());

	}

	private function doUpdate()
	{
		$item = R::load( 'dlandcategories', $this->input->post('id'));
		$item->name = $this->input->post('name');
		$item->link_name = $this->input->post('link_name');
		$item->type = $this->input->post('type');
		if ($this->input->post('parent')>0) {
			if($this->input->post('parent') != $item->parent){
				$maxorder = R::getCell('SELECT max(disorder) FROM dlandcategories WHERE parent = ?',[$this->input->post('parent')]);
				if($maxorder > 0){
					$item->disorder = $maxorder + 1;
				}
				else{
					$maxorder = R::getCell('SELECT max(disorder) FROM dlandcategories WHERE id = ?',[$this->input->post('parent')]);
					$item->disorder = $maxorder + 1;
				}
			}
			$item->parent = $this->input->post('parent');
		}
		$item->description = $this->input->post('description');
		$item->display = $this->input->post('display');
		$id = R::store($item);

		redirect($this->uri->uri_string());

	}

	private function doDelete($id)
	{
		$item = R::load('dlandcategories', $id);
		R::trash($item);

	}

	private function doUp()
	{
		$datas = $this->input->post('datas');
		foreach ($datas as $itemid) {
			$item = R::load("dlandcategories", $itemid);
			if($item->parent == ""){
				$upTmp = R::findOne("dlandcategories", " parent is null and disorder < ? order by disorder desc ",[$item->disorder]);
			}
			else {
				$upTmp = R::findOne("dlandcategories", " parent = ? and disorder < ? order by disorder desc ",[$item->parent, $item->disorder]);
			}

			if($upTmp != null){
				$up = R::load("dlandcategories", $upTmp->id);
				$backupPage = $item->disorder;
				$backupUp = $up->disorder;
				$item->disorder = $up->disorder;
				$up->disorder = $backupPage;

				R::store($item);
				R::store($up);
				if($item->parent == ""){
					R::exec("UPDATE dlandcategories SET disorder = concat(?,RIGHT(disorder,4)) WHERE parent = ?",[substr($backupUp,0,4), $item->id]);
					R::exec("UPDATE dlandcategories SET disorder = concat(?,RIGHT(disorder,4)) WHERE parent = ?",[substr($backupPage,0,4), $up->id]);
				}

			}
		}
		redirect($this->uri->uri_string());
	}

	private function doDown()
	{
		$datas = $this->input->post('datas');
		for ($i=count($datas) - 1; $i >= 0; $i--) {
			$itemid = $datas[$i];
			$item = R::load("dlandcategories", $itemid);
			if($item->parent == ""){
				$downTmp = R::findOne("dlandcategories", " parent is null and disorder > ? order by disorder asc ",[$item->disorder]);
			}
			else {
				$downTmp = R::findOne("dlandcategories", " parent = ? and disorder > ? order by disorder asc ",[$item->parent, $item->disorder]);
			}

			if($downTmp != null){
				$down = R::load("dlandcategories", $downTmp->id);
				$backupPage = $item->disorder;
				$backupDown = $down->disorder;
				$item->disorder = $down->disorder;
				$down->disorder = $backupPage;

				R::store($item);
				R::store($down);
				if($item->parent == ""){
					R::exec("UPDATE dlandcategories SET disorder = concat(?,RIGHT(disorder,4)) WHERE parent = ?",[substr($backupDown,0,4), $item->id]);
					R::exec("UPDATE dlandcategories SET disorder = concat(?,RIGHT(disorder,4)) WHERE parent = ?",[substr($backupPage,0,4), $down->id]);
				}

			}
		}
		redirect($this->uri->uri_string());
	}

}
