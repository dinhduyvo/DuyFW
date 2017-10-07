<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TuyenDung extends MY_Controller {
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$noibats = R::getAll("SELECT djobs.*, dcompanies.name as comname,dcompanies.avatar as avatar2,
																	dlocations.name as locationname
													FROM djobs
													LEFT JOIN dcompanies ON djobs.company_id = dcompanies.id
													LEFT JOIN dlocations ON djobs.location_id = dlocations.id
													where djobs.display > 0 and dcompanies.display > 0 order by public_date limit 0,8");
		$this->data['noibats'] = $noibats;

		$careers = R::getAll("SELECT dc.*, (select count(id) from djobs where career_id = dc.id) as countnew FROM dcareers dc where dc.display = 1 order by dc.name desc");
		$this->data['careers'] = $careers;

		$locations = R::getAll("SELECT dc.*, (select count(id) from djobs where location_id = dc.id) as countnew FROM dlocations dc where dc.display = 1 and dc.parent is not null order by dc.name desc");
		$this->data['locations'] = $locations;

		$companies = R::getAll("SELECT dc.* FROM dcompanies dc where dc.display = 2 order by dc.name desc");
		$this->data['companies'] = $companies;

		$jobs = R::getAll( "SELECT djobs.*, dcompanies.name FROM djobs LEFT JOIN dcompanies ON djobs.company_id = dcompanies.id order by public_date desc limit 0,8 ");
		$this->data['jobs'] = $jobs;

		$this->data['view'] = array('home/tuyendung_list');
		$this->load->view('.layout', $this->data);
	}

	public function chitiet($id)
	{
		$item = R::getRow("SELECT djobs.*, dcompanies.name as comname,dcompanies.avatar as avatar2,
																	dlocations.name as locationname, dcareers.name as careername
													FROM djobs
													LEFT JOIN dcompanies ON djobs.company_id = dcompanies.id
													LEFT JOIN dlocations ON djobs.location_id = dlocations.id
													LEFT JOIN dcareers ON djobs.career_id = dcareers.id
													where djobs.display > 0 and dcompanies.display > 0 and djobs.id = ? ", [$id]);

		if (empty($item)) {
			redirect("");
		}
		$this->data['item'] = $item;

		$careers = R::getAll("SELECT dc.*, (select count(id) from djobs where career_id = dc.id) as countnew FROM dcareers dc where dc.display = 1 order by dc.name desc");
		$this->data['careers'] = $careers;

		$locations = R::getAll("SELECT dc.*, (select count(id) from djobs where location_id = dc.id) as countnew FROM dlocations dc where dc.display = 1 and dc.parent is not null order by dc.name desc");
		$this->data['locations'] = $locations;

		$jobs = R::getAll( "SELECT djobs.*, dcompanies.name FROM djobs LEFT JOIN dcompanies ON djobs.company_id = dcompanies.id order by public_date desc limit 0,8 ");
		$this->data['jobs'] = $jobs;

		$cungchuyenmuc = R::getAll("SELECT djobs.*, dcompanies.name as comname,dcompanies.avatar as avatar2,
										dlocations.name as locationname
								FROM djobs
								LEFT JOIN dcompanies ON djobs.company_id = dcompanies.id
								LEFT JOIN dlocations ON djobs.location_id = dlocations.id
								where djobs.display > 0 and dcompanies.display > 0
											and djobs.career_id = ? and djobs.id <> ?
								order by public_date limit 0,8", [$item['career_id'], $id]);
		$this->data['cungchuyenmuc'] = $cungchuyenmuc;

		$this->data['view'] = array('home/tuyendung_chitiet');
		$this->load->view('.layout', $this->data);
	}
}
