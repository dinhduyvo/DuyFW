<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$noibats = R::getAll("(SELECT id, title, avatar as avatar2, 'NEWS' as vtype, content as description FROM dnews where display = 2 limit 0,2)
							UNION ALL
							(SELECT id, title, avatar as avatar2, 'JOBS' as vtype, description FROM djobs where display = 2 limit 0,2)
							UNION ALL
							(SELECT id, title, avatar as avatar2, 'LANDS' as vtype, description FROM dlands where display = 2 limit 0,2);");
		$this->data['noibats'] = $noibats;
		$news = R::find('dnews',' display = ? order by  public_date desc limit 0,8', [2]);
		$this->data['news'] = $news;
		$jobs = R::getAll( "SELECT djobs.*, dcompanies.name as comname, dcompanies.avatar as avatar2, dlocations.name as locationname FROM djobs
												LEFT JOIN dcompanies ON djobs.company_id = dcompanies.id
												LEFT JOIN dlocations ON djobs.location_id = dlocations.id
												order by public_date desc limit 0,8 ");
		$this->data['jobs'] = $jobs;
		$lands = R::getAll( "SELECT dlands.*, dlandcategories.name, dlocations.name as locationname FROM dlands
													LEFT JOIN dlandcategories ON dlands.type = dlandcategories.id
													LEFT JOIN dlocations ON dlands.location_id = dlocations.id
													order by public_from desc limit 0,8 ");
		$this->data['lands'] = $lands;
		$this->data['view'] = array('home/top');
		$this->load->view('.layout', $this->data);
	}
}
