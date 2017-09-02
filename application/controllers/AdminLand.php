<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminNew extends MY_Controller {

	var $form_data;

	function __construct()
	{
		parent::__construct();
		$this->data["current"] = "";
	}

	public function index()
	{
		$this->data["title"] = "Quản lý Tin tức";
		$this->data['view'] = array("admin/AdminNew");
		$datas = R::findAll( "dnews", ' order by public_date desc ' );


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
              $tmp [1] = $this->mu->showVNDate($row->public_date);
              $tmp [2] = $row->author;
              $tmp [3] = $row->id;
              $output [$i] = $tmp;
              $i ++;
          }
      }

      return $output;
	}

	public function doAdd()
	{
		if($this->input->post('title') != null){
			$item = R::dispense('dnews');

			$filenameAvatar = "";
      if(isset($_FILES['avatar']) && $_FILES['avatar']['size'] > 0) {
          $output = $this->mu->do_upload_image ( 'avatar', 'av', FILE_IMAGE_PATH_NEWS );
          $filenameAvatar = $output["data"];
      }

			$item->avatar = $filenameAvatar;

			$item->title = $this->input->post('title');
			$item->link_name = $this->input->post('link_name');
			$item->author = $this->input->post('author');
			$item->source = $this->input->post('source');
			$item->cat_id = $this->input->post('cat_id');
			$item->content = $this->input->post('content');
			$item->display = $this->input->post('display');
			$id = R::store($item);

			redirect('AdminNew');
		}
		else {
			$categories = R::getAll( "SELECT id as code, title as name
														FROM dcategories Order By disorder asc" );
			$this->data["categories"] = $categories;
			$this->data["view"] = array('admin/AdminNew_Add');
			$this->load->view('.layout', $this->data);
		}


	}

	public function update($id)
	{
		if($this->input->post('title') != null){
			$item = R::load( 'dnews', $id);

			$filenameAvatar = $item->avatar;
      if(isset($_FILES['avatar']) && $_FILES['avatar']['size'] > 0) {
          $output = $this->mu->do_upload_image ( 'avatar', 'av', FILE_IMAGE_PATH_NEWS );
          $filenameAvatar = $output["data"];
      }

			$item->avatar = $filenameAvatar;
			$item->title = $this->input->post('title');
			$item->link_name = $this->input->post('link_name');
			$item->source = $this->input->post('source');
			$item->author = $this->input->post('author');
			$item->display = $this->input->post('display');
			$item->cat_id = $this->input->post('cat_id');
			$item->content = $this->input->post('content');
			$id = R::store($item);

			redirect("AdminNew");
		}
		else{
			$categories = R::getAll( "SELECT id as code, title as name
														FROM dcategories Order By disorder asc" );
			$this->data["categories"] = $categories;

			$item = R::findOne('dnews','id=?',[$id]);
			$this->form_data = $item;
			$this->data['data'] = $this->form_data;
			$this->data['view'] = array("admin/AdminNew_Add");
			$this->load->view('.layout', $this->data);
		}

	}

	public function delete($id)
	{
		$item = R::load('dnews', $id);
		R::trash($item);
		redirect('AdminNew');
	}

}
