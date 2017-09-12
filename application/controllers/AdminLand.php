<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminLand extends MY_Controller {

	var $form_data;

	function __construct()
	{
		parent::__construct();
		$this->data["current"] = "";
	}

	public function index()
	{
		$this->data["title"] = "Quản lý Bất động sản";
		$this->data['view'] = array("admin/AdminLand");
		$datas = R::findAll( "dlands", ' order by public_from desc ' );


		$this->data["datas"] = $this->danhsach($datas);

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
				redirect("AdminCategory/index/id/".$this->input->post('datas')[0]);
			}

		}
		if (isset($this->params['id'])) {
			$this->data["current"] = array($this->params['id']);
			$this->doGet();
		}

		$this->data['data'] = $this->form_data;

		$this->load->view('.layout', $this->data);
	}

	private function danhsach($datas)
	{
		$output = array ();

      $tmp = array ();
      $i = 0;
      if ($datas != null) {
          foreach ( $datas as $row ) {
              // ***
              $tmp [0] = $row->title;
              $tmp [1] = $row->address;
              $tmp [2] = $row->phone;
              $tmp [3] = $this->mu->formatMoney($row->price);
              $tmp [4] = $this->mu->showVNDate($row->public_from);
              $tmp [5] = $this->mu->showVNDate($row->public_to);
              $tmp [6] = $row->id;
              $output [$i] = $tmp;
              $i ++;
          }
      }

      return $output;
	}

	public function doAdd()
	{
		if($this->input->post('title') != null){
			$item = R::dispense('dlands');

			$filenameAvatar = "";
      if(isset($_FILES['avatar']) && $_FILES['avatar']['size'] > 0) {
          $output = $this->mu->do_upload_image ( 'avatar', 'av', FILE_IMAGE_PATH_LANDS );
          $filenameAvatar = $output["data"];
      }

			$item->avatar = $filenameAvatar;

			$item->title = $this->input->post('title');
			$item->link_name = $this->input->post('link_name');
			$item->description = $this->input->post('description');
			$item->price = $this->mu->getDataMoney($this->input->post('price'));
			$item->address = $this->input->post('address');
			$item->contacter = $this->input->post('contacter');
			$item->phone = $this->input->post('phone');
			$item->public_from = $this->mu->changeDateTimeFormat($this->input->post('public_from'));
			$item->public_to = $this->mu->changeDateTimeFormat($this->input->post('public_to'));
			$item->width = $this->input->post('width');
			$item->long = $this->input->post('long');
			$item->livesize = $this->input->post('livesize');
			$item->mapx = $this->input->post('mapx');
			$item->mapy = $this->input->post('mapy');
			$item->type = $this->input->post('type');
			$item->display = $this->input->post('display');
			$id = R::store($item);

			redirect('AdminLand');
		}
		else {
			$categories = R::getAll( "SELECT id as code, name as name, parent
														FROM dlandcategories Order By disorder asc" );
			$this->data["categories"] = $categories;
			$this->data["view"] = array('admin/AdminLand_Add');
			$this->load->view('.layout', $this->data);
		}


	}

	public function update($id)
	{
		if($this->input->post('title') != null){
			$item = R::load( 'dlands', $id);

			$filenameAvatar = $item->avatar;
      if(isset($_FILES['avatar']) && $_FILES['avatar']['size'] > 0) {
          $output = $this->mu->do_upload_image ( 'avatar', 'av', FILE_IMAGE_PATH_LANDS );
          $filenameAvatar = $output["data"];
      }

			$item->avatar = $filenameAvatar;

			$item->title = $this->input->post('title');
			$item->link_name = $this->input->post('link_name');
			$item->description = $this->input->post('description');
			$item->price = $this->mu->getDataMoney($this->input->post('price'));
			$item->address = $this->input->post('address');
			$item->contacter = $this->input->post('contacter');
			$item->phone = $this->input->post('phone');
			$item->public_from = $this->mu->changeDateTimeFormat($this->input->post('public_from'));
			$item->public_to = $this->mu->changeDateTimeFormat($this->input->post('public_to'));
			$item->width = $this->input->post('width');
			$item->long = $this->input->post('long');
			$item->livesize = $this->input->post('livesize');
			$item->mapx = $this->input->post('mapx');
			$item->mapy = $this->input->post('mapy');
			$item->type = $this->input->post('type');
			$item->display = $this->input->post('display');
			$id = R::store($item);

			redirect("AdminLand");
		}
		else{
			$categories = R::getAll( "SELECT id as code, name as name, parent
														FROM dlandcategories Order By disorder asc" );
			$this->data["categories"] = $categories;

			$item = R::findOne('dlands','id=?',[$id]);
			$this->form_data = $item;
			$this->data['data'] = $this->form_data;
			$this->data['view'] = array("admin/AdminLand_Add");
			$this->load->view('.layout', $this->data);
		}

	}

	public function delete($id)
	{
		$item = R::load('dlands', $id);
		R::trash($item);
		redirect('AdminLand');
	}

}
