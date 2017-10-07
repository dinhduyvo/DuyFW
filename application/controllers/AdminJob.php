<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminJob extends MY_Controller {

	var $form_data;

	function __construct()
	{
		parent::__construct();
		$this->data["current"] = "";
	}

	public function index()
	{
		$this->data["title"] = "Quản lý Tuyển dụng";
		$this->data['view'] = array("admin/AdminJob");
		$datas = R::getAll( "SELECT djobs.*, dcompanies.name FROM djobs LEFT JOIN dcompanies ON djobs.company_id = dcompanies.id order by public_date desc ");


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
              $tmp [0] = $row["title"];
              $tmp [1] = $row["name"];
              $tmp [2] = $row["position"];
              $tmp [3] = $this->mu->showVNDate($row["public_date"]);
              $tmp [4] = $row["display"];
              $tmp [5] = $row["id"];
              $output [$i] = $tmp;
              $i ++;
          }
      }

      return $output;
	}

	public function doAdd()
	{
		if($this->input->post('title') != null){
			$item = R::dispense('djobs');

			$filenameAvatar = "";
      if(isset($_FILES['avatar']) && $_FILES['avatar']['size'] > 0) {
          $output = $this->mu->do_upload_image ( 'avatar', 'av', FILE_IMAGE_PATH_JOBS );
          $filenameAvatar = $output["data"];
      }

			$item->avatar = $filenameAvatar;

			$item->title = $this->input->post('title');
			$item->link_name = $this->input->post('link_name');
			$item->start_date = $this->mu->changeDateTimeFormat($this->input->post('start_date'));
			$item->end_date = $this->mu->changeDateTimeFormat($this->input->post('end_date'));
			$item->salary_from = str_replace('.','', $this->input->post('salary_from'));
			$item->salary_to = str_replace('.','', $this->input->post('salary_to'));
			$item->description = $this->input->post('description');
			$item->requirement = $this->input->post('requirement');
			$item->benefit = $this->input->post('benefit');
			$item->position = $this->input->post('position');
			$item->education = $this->input->post('education');
			$item->language = $this->mu->arrayToString($this->input->post('language'),"|");
			$item->company_id = $this->input->post('company_id');
			$item->career_id = $this->input->post('career_id');
			$item->location_id = $this->input->post('location_id');
			if($this->input->post('display') == "1"){
				$item->public_date = date('Y-m-d G:i:s');
			}
			$item->display = $this->input->post('display');
			$id = R::store($item);

			redirect('AdminJob');
		}
		else {
			$careers = R::getAll( "SELECT id as code, name as name
														FROM dcareers Order By disorder asc" );
			$this->data["careers"] = $careers;

			$companies = R::getAll( "SELECT id as code, name as name
														FROM dcompanies Order By name asc" );
			$this->data["companies"] = $companies;

			$locations = R::getAll( "SELECT id as code, name as name
														FROM dlocations Order By name asc" );
			$this->data["locations"] = $locations;
			$this->data["view"] = array('admin/AdminJob_Add');
			$this->load->view('.layout', $this->data);
		}


	}

	public function update($id)
	{
		if($this->input->post('title') != null){
			$item = R::load( 'djobs', $id);

			$filenameAvatar = "";
			if(isset($_FILES['avatar']) && $_FILES['avatar']['size'] > 0) {
				$output = $this->mu->do_upload_image ( 'avatar', 'av', FILE_IMAGE_PATH_JOBS );
				$filenameAvatar = $output["data"];
			}
			else {
				$filenameAvatar = $item->avatar;
			}

			$item->avatar = $filenameAvatar;

			$item->title = $this->input->post('title');
			$item->link_name = $this->input->post('link_name');
			$item->start_date = $this->mu->changeDateTimeFormat($this->input->post('start_date'));
			$item->end_date = $this->mu->changeDateTimeFormat($this->input->post('end_date'));
			$item->salary_from = str_replace('.','', $this->input->post('salary_from'));
			$item->salary_to = str_replace('.','', $this->input->post('salary_to'));
			$item->description = $this->input->post('description');
			$item->requirement = $this->input->post('requirement');
			$item->benefit = $this->input->post('benefit');
			$item->position = $this->input->post('position');
			$item->education = $this->input->post('education');
			$item->language = $this->mu->arrayToString($this->input->post('language'),"|");
			$item->company_id = $this->input->post('company_id');
			$item->career_id = $this->input->post('career_id');
			$item->location_id = $this->input->post('location_id');
			if($this->input->post('display') == "1"){
				$item->public_date = date('Y-m-d G:i:s');
			}
			$item->display = $this->input->post('display');
			$id = R::store($item);

			redirect("AdminJob");
		}
		else{
			$careers = R::getAll( "SELECT id as code, name as name
														FROM dcareers Order By disorder asc" );
			$this->data["careers"] = $careers;
			$companies = R::getAll( "SELECT id as code, name as name
														FROM dcompanies Order By name asc" );
			$this->data["companies"] = $companies;

			$locations = R::getAll( "SELECT id as code, name as name FROM dlocations Order By name asc" );
			$this->data["locations"] = $locations;

			$item = R::findOne('djobs','id=?',[$id]);
			$this->form_data = $item;
			$this->data['data'] = $this->form_data;
			$this->data['view'] = array("admin/AdminJob_Add");
			$this->load->view('.layout', $this->data);
		}

	}

	public function delete($id)
	{
		$item = R::load('dnews', $id);
		R::trash($item);
		redirect('AdminJob');
	}

}
