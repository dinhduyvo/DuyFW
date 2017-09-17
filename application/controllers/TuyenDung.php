<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TuyenDung extends MY_Controller {
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$noibats = R::getAll("SELECT id, title, avatar as avatar2, 'JOBS' as vtype, description FROM djobs where display = 2 order by public_date limit 0,3");
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
}
