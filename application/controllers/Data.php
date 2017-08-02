<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		auth_force();
		$this->load->database();
		$this->load->helper('url');
	}

	public function _example_output($output = null)
	{
		$this->load->view('crud.php',(array)$output);
	}

	public function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	public function stockGroups()
	{
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			$crud->set_table('stock_groups');
			// $crud->columns('name');
			$crud->display_as('account_id','account_name');
			$crud->set_relation('account_id','accounts','name');
			$crud->set_relation('sales_account_id','accounts','name');
			$crud->set_relation('purchase_account_id','accounts','name');
			$crud->set_relation_n_n('category', 'stock_group_categories_relation', 'stock_group_categories', 'stock_group_id', 'stock_group_categories_id', 'name');
			// $crud->field_type('type','dropdown',array('IN' => 'IN', 'OUT' => 'OUT'));
			$output = $crud->render();
			$this->_example_output($output);
	}


	public function bagWeights()
	{ 	
		  $stGrps = Models\StockGroups::whereCategory('BAGS')->with('bagWeights')->get();
		 
		  $weightUnits = Models\WeightUnits::get();				
	
	  	  $this->load->view('data/bag-weights', [
				'stGrps' => $stGrps,
				'wtUnits' => $weightUnits
			]);
	}

	public function savebagWeights()
	{ 	
		  if(empty($_POST))	
		  	return 404;
		  $postData = $_POST['data'];
		 
		  foreach($postData as $stockItemId => $val){
		  
		  	$count = Models\BagWeights::where('stock_item_id', $stockItemId)->count();

		    if(!$count){
		    	Models\BagWeights::create([
		    			'stock_item_id' => $stockItemId,
		    			'weight' => $val['weight'],
		    		]);
		    }
		    else{
		    	Models\BagWeights::where('stock_item_id', $stockItemId)->update([
		    			'weight' => $val['weight'],
		    		]);
		    }
		  }  

		  success('Weights Updated Successfully');  
		  redirect('data/bagWeights');  

	}


	public function otherLabourJob($party_id){
		
		
		$godowns = Models\FCIGodowns::get();
		$labour_job_types = Models\LabourJobTypes::get();
		$weight_units = Models\WeightUnits::get();
		
		$this->load->view('data/add-other-labour-jobs',[
			'party_id' => $party_id,
			'godowns' => $godowns,
			'weight_units' => $weight_units,
			'labour_job_types' => $labour_job_types,
			'css_files' => [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.css')],
			'js_files' => [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.js')],

		]);

	}

	public function customLabourJobs($party_id){
		
		
		$godowns = Models\FCIGodowns::get();
		$labour_job_types = Models\LabourJobTypes::get();
		$weight_units = Models\WeightUnits::get();
		
		$this->load->view('data/custom-labour-jobs',[
			'party_id' => $party_id,
			'godowns' => $godowns,
			'weight_units' => $weight_units,
			'labour_job_types' => $labour_job_types,
			'css_files' => [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.css')],
			'js_files' => [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.js')],

		]);

	}


	public function saveOtherLabourJob(){
		if(empty($_POST))		
			return 404;

		$data = $_POST;
		$dat = Models\OtherLabourJobs::create($data);
		if($dat)
			success('Labour Job Added Successfully');
		else
			failure('Unable to Add Labour Job. Please Try Again');

		redirect('data/dailyLabourAccounts');

	}

	public function saveCustomLabourJob(){
		if(empty($_POST))		
			return 404;

		$data = $_POST;

		$dat = Models\CustomLabourJobs::create($data);
		if($dat)
			success('Custom Labour Job Added Successfully');
		else
			failure('Unable to Add Custom Labour Job. Please Try Again');

		redirect('data/dailyLabourAccounts');

	}

	public function dailyLabourAccounts()
	{     
		  $resultsFlag = false;
		  $data = [];
		  $otherJobsData = [];
		  $customJobsData = [];

		  $stub = [
		  	'start_date' => date('Y-m-d'),
		  	'end_date' => date('Y-m-d')
		  ];

		  $accounts = Models\Accounts::whereLabourParty('Labour Party')->get();

		 	if(!empty($_POST)){
		 
		 			$postData = $_POST;

		 			if(!isset($postData['party_id'])){
		 				failure("Select party id from drop down to add job");
		 				redirect('data/dailyLabourAccounts');
		 				// $postData['party_id'] = 0;
		 			}
		 			
		 			if(!empty($postData['start_date']))
		 				$stub['start_date'] = $postData['start_date'];
		 			
		 			if(!empty($postData['end_date']))
		 				$stub['end_date'] = $postData['end_date'];
				
                  $geGodQcLabAll = Models\GEGodownQcLaborAllocation::where('labour_party_id', $postData['party_id'])
												->where('created_at', '>=', $stub['start_date'].' 00:00:00')	
												->where('created_at', '<=', $stub['end_date'].' 23:59:59')	
												->get();
					
				  //Read Other Jobs

				  $otherJobs = Models\OtherLabourJobs::where('party_id', $postData['party_id'])
												->where('created_at', '>=', $stub['start_date'].' 00:00:00')	
												->where('created_at', '<=', $stub['end_date'].' 23:59:59')	
												->get();
 			      
 			      // Read Custom Jobs
			     

				  $customJobs = Models\CustomLabourJobs::where('party_id', $postData['party_id'])
												->where('created_at', '>=', $stub['start_date'].' 00:00:00')	
												->where('created_at', '<=', $stub['end_date'].' 23:59:59')	
												->get();									
						
											
				  foreach ($geGodQcLabAll as $key => $detail) {

				  	$party_name = getPartyName($detail->labour_party_id);
				  	$data[$key]['labour_party_name'] = getPartyName($detail->labour_party_id);
				  	$data[$key]['bags'] = $detail->bags;
				   	$data[$key]['godown_name'] = getGodownName($detail->godown_id);
				  	$data[$key]['labour_job_type_name'] = getLaboutJobTypeName($detail->labour_job_type_id);
   		
				  	$labPartJobTypes = Models\LabourPartyJobTypes::select('rate')	
				  										 ->where('account_id', $detail->labour_party_id)
				  										 ->where('labour_job_type_id', $detail->labour_job_type_id)
				  										 ->first();

	                $data[$key]['rate'] = !empty($labPartJobTypes) ? $labPartJobTypes->rate : 0.00;

			    }
			  
			  // Filtering other jobs

			  foreach ($otherJobs as $key => $ojob) {
			  	
				  	$party_name = getPartyName($ojob->party_id);
				  	$otherJobsData[$key]['labour_party_name'] = getPartyName($ojob->party_id);
				  	$otherJobsData[$key]['bags'] = intVal($ojob->weight);
				  	$otherJobsData[$key]['party_id'] = $ojob->party_id;
				  	$otherJobsData[$key]['date'] = $ojob->date;
				  	$otherJobsData[$key]['godown_name'] = getGodownName($ojob->godown_id);
				  	$otherJobsData[$key]['labour_job_type_name'] = getLaboutJobTypeName($ojob->job_type_id);
   		
				  	$labPartJobTypes = Models\LabourPartyJobTypes::select('rate')	
				  										 ->where('account_id', $ojob->labour_party_id)
				  										 ->where('labour_job_type_id', $ojob->labour_job_type_id)
				  										 ->first();

	                $otherJobsData[$key]['rate'] = !empty($labPartJobTypes) ? $labPartJobTypes->rate : 0.00;

			  }


			  // Filtering Custom jobs

			  foreach ($customJobs as $key => $ojob) {
				  	$party_name = getPartyName($ojob->party_id);
				  	$customJobsData[$key]['labour_party_name'] = getPartyName($ojob->party_id);
				  	// $customJobsData[$key]['bags'] = intVal($ojob->weight);
				  	$customJobsData[$key]['party_id'] = $ojob->party_id;
				  	$customJobsData[$key]['date'] = $ojob->date;
				  	$customJobsData[$key]['godown_name'] = getGodownName($ojob->godown_id);
				  	$customJobsData[$key]['job_name'] = $ojob->job_name;
				  	$customJobsData[$key]['amount'] = $ojob->amount;
				  
			  }

			  if(count($data) || count($customJobsData) || count($otherJobsData))	
			  	$resultsFlag = true;

			
		 	} //Post Data block
			
			$this->load->view('data/daily-labour-accounts', [
				'data' => $data,
				'stub' => $stub,
				'accounts' => $accounts,
				'other_jobs_data' => $otherJobsData,
				'custom_jobs_data' => $customJobsData,
				'resultsFlag' => $resultsFlag,
				'css_files' => [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.css')],
			    'js_files' => [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.js')],
  		    ]);
	}

	public function accounts()
	{
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('accounts');
		$crud->columns('name','accounts_category','accounts_group_id');
		$crud->display_as('accounts_group_id','Account Group');
		$crud->set_relation('accounts_group_id','accounts_group','{name}');
		$crud->set_relation_n_n('accounts_category','accounts_categories_relation','account_categories','account_id', 'account_category_id', 'name');	
		$crud->field_type('created_at','hidden',date('Y-m-d H:i:s'));
		$crud->field_type('updated_at','hidden');
		$output = $crud->render();
		$this->_example_output($output);
	}

	public function manageUsers()
	{
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			$crud->set_table('users');
			$crud->columns('username');
			$crud->fields('username','password','role');
			$crud->field_type('role','dropdown', array('admin' => 'Admin', 'operator' => 'Operator','manager' => 'Manager'));
			$crud->callback_field('password', array($this,'edit_password_callback'));
			$crud->callback_before_update(array($this,'on_update_encrypt_password_callback'));
            $crud->callback_before_insert(array($this,'on_update_encrypt_password_callback'));
			$crud->field_type('created_at','hidden', date('Y-m-d H:i:s'));
			$crud->field_type('updated_at','hidden');
			$output = $crud->render();
			$this->_example_output($output);
	}

	public function userAccess()
	{
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			$crud->field_type('role','dropdown', array('operator' => 'Operator','manager' => 'Manager'));
			$crud->set_table('user_access');
			$crud->callback_field('feature',array($this,'get_menu_keys'));
			$crud->field_type('created_at','hidden', date('Y-m-d H:i:s'));
			$crud->field_type('updated_at','hidden');
			$output = $crud->render();
			$this->_example_output($output);
	}

	function get_menu_keys($value = '', $primary_key = null)
	{  

		$menuItems = [];

		foreach($this->config->item('menu_access') as $key => $val):
			foreach($val as $feature => $url):
				$menuItems[] = $feature;
			endforeach;	
		endforeach;
		$dropDown = "<select class='form-control' name='feature'>";
		foreach($menuItems as $v):
		 $dropDown .= "<option value=".$v.">".ucwords(str_replace('_', ' ', $v))."</option>";
		endforeach;		

		$dropDown .= "</select>";
		
		return $dropDown;
		
	}

	public function bagTypes()
	{
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			$crud->set_table('bag_types');
			$crud->columns('name','weight');
			$crud->field_type('stock_group_id','hidden');
			// $crud->set_relation('stock_group_id','stock_groups','{name}');
			$output = $crud->render();
			$this->_example_output($output);
	}

	public function stockItems()
	{
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			$crud->set_table('stock_items');
			$crud->columns('name','stock_group_id');
			$crud->display_as('stock_group_id', 'Stock Group');
			$crud->set_relation('stock_group_id','stock_groups','{name}');
			$crud->field_type('created_at','hidden',date('Y-m-d H:i:s'));
			$crud->field_type('updated_at','hidden');
			$output = $crud->render();
			$this->_example_output($output);
	}


	public function qualityCutTypes()
	{
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			$crud->set_table('quality_cut_types');
			$crud->display_as('stock_group_id', 'Stock Group');
			$crud->set_relation('stock_group_id','stock_groups','{name}');
			$output = $crud->render();
			$this->_example_output($output);
	}

	public function labourAccounts()
	{
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('labour_accounts');
		
		$crud->field_type('created_at','hidden', date('Y-m-d H:i:s'));
		$crud->field_type('updated_at','hidden');

		$crud->set_relation('labour_job_category_id', 'labour_job_categories','{name}');
		$crud->callback_before_update(array($this,'add_updated_at_value'));

		$output = $crud->render();
		$output->title = 'Labour Accounts';
		$this->_example_output($output);
	}

	public function rateEntry()
	{ 
		 $stub = [
		 	'start_date' => date('Y-m-d'),
		 	'end_date' => date('Y-m-d'),
		 	'_rate' => ''
		 ];
		
		 $query = new Models\GEGodownQcLaborAllocation;
		 
		 $query = $query->with('stockItems')->orderBy('ge_id', 'asc');

		 	
		 if(!empty($_GET)){
		 	
  				 	if($_GET['_rate'] == 'NO'){
					 		$query = $query->where('rate_per_unit', 0);
					 		$stub['_rate'] = 'NO';
					 	}
					 	else if($_GET['_rate'] == 'YES'){
					 		$query = $query->where('rate_per_unit','>', 0);
					 		$stub['_rate'] = 'YES';
					 	}
					 	else
					 		$stub['_rate'] = 'ALL';
		 	}

		if(!empty($_GET['start_date']) && !empty($_GET['end_date'])){
			  $stub['start_date'] = $_GET['start_date'] ? $_GET['start_date'] : '';
			 	$stub['end_date'] = $_GET['end_date'] ? $_GET['end_date'] : '';
			 	$query = $query->where('created_at','>=', $stub['start_date'].' 00:00:00');
			 	$query = $query->where('created_at','<=', $stub['end_date'].' 23:59:59');
		 }else{
		 		$start_date = $stub['start_date'];
			 	$end_date = $stub['end_date'];
			 	$query = $query->where('created_at','>=', $start_date.' 00:00:00');
			 	$query = $query->where('created_at','<=', $end_date.' 23:59:59');
		 }
		 
		
		 $qcMaterialForms = $query->get();
		
		 $wtUnits = Models\WeightUnits::get();

		 $this->load->view('data/rate-entry',[
		 		'forms' => $qcMaterialForms,
		 		'wtUnits' => $wtUnits,
		 		'stub' => $stub,
		 		'css_files' 	 => [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.css')],
		 		'js_files' => [
						base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.js'),
					],
		 	]);
	}

	public function rateEntryUpdate()
	{ 
		if(empty($_POST))
			return 404;

		 $data = $_POST['data'];
		 foreach ($data as $key => $record) {
		 	$qcMaterialForms = Models\GEGodownQcLaborAllocation::find($key);
		 	$qcMaterialForms->update($record);	
		 }
		 
		 redirect('data/rateEntry');
		 
	}

	public function forms()
	{
		$crud = new grocery_CRUD();
		if($crud->getState() == 'add')
			redirect('manager/formCreate/');

		$crud->set_theme('datatables');
		$crud->set_table('forms');
		$crud->unset_edit();
		$crud->unset_read();
		// $crud->callback_delete(array($this,'delete_form_relationship_tables_data'));
		$crud->field_type('created_at','hidden', date('Y-m-d H:i:s'));
		$crud->field_type('updated_at','hidden');
		$crud->add_action('Edit', '', '','ui-icon-pencil',array($this,'editFormRedirect'));
		$crud->field_type('type','dropdown', ['IN' => 'IN', 'OUT' => 'OUT']);
		$crud->callback_edit_field('phone',array($this,'edit_field_callback_1'));
		$crud->callback_before_update(array($this,'add_updated_at_value'));
		$output = $crud->render();

		$output->title = 'Labour Accounts';
		$this->_example_output($output);
	}
	
	function delete_form_relationship_tables_data($primary_key){
		echo "<pre>";
		print_r($primary_key);
		exit;
	}

	function editFormRedirect($primary_key , $row){
		return site_url('manager/formEdit/'.$primary_key);
	}

	public function add_updated_at_value($post)
	{
		$post['updated_at'] = date('Y-m-d H:i:s');
		return $post;
	}

	public function gateEntryConfig()
	{
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('gate_entry_config');
		$crud->set_relation('form_id', 'forms','{name}');
		$crud->field_type('created_at','hidden', date('Y-m-d H:i:s'));
		$crud->field_type('updated_at','hidden');
		$crud->callback_before_update(array($this,'add_updated_at_value'));

		$crud->unset_columns(array('created_at','updated_at'));

		
		$output = $crud->render();

		$output->title = 'Labour Accounts';
		$this->_example_output($output);
	}

	function on_update_encrypt_password_callback($post_array){
		if($post_array['password'] != '__DEFAULT_PASSWORD_'){
      $password=$post_array['password'];
			$hasher = new PasswordHash(
	    		$this->config->item('phpass_hash_strength', 'tank_auth'),
		    	$this->config->item('phpass_hash_portable', 'tank_auth')
			);

			$post_array['password'] = $hasher->HashPassword($password);
			$post_array['activated'] = 1;
			return $post_array;
		}

		unset($post_array['password']);
		return $post_array;
	}

	  function edit_password_callback($post_array){
		return '<input type="password" class="form-control" value="__DEFAULT_PASSWORD_" name="password" style="width:462px">';
	}

	public function labour_job_categories()
	{
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('labour_job_categories');
		$crud->set_relation_n_n('Accounts', 'labour_job_category_accounts_relation', 'accounts', 'labour_job_category_id', 'account_id', 'name');
		$crud->field_type('created_at','hidden', date('Y-m-d H:i:s'));
		$crud->field_type('updated_at','hidden');
		$crud->callback_before_update(array($this,'add_updated_at_value'));

		$crud->unset_columns(array('created_at','updated_at'));
		
		$output = $crud->render();

		$output->title = 'Labour Job Categories';
		$this->_example_output($output);
	}

	public function labour_job_types()
	{
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('labour_job_types');
		$crud->set_relation('labour_job_category_id', 'labour_job_categories','{name}');
		$crud->display_as('labour_job_category_id','Job category');
		$crud->field_type('created_at','hidden', date('Y-m-d H:i:s'));
		$crud->field_type('updated_at','hidden');
		$crud->callback_before_update(array($this,'add_updated_at_value'));
		$crud->unset_columns(array('created_at','updated_at'));
		$crud->order_by('created_at','desc');
		$output = $crud->render();
		$output->title = 'Labour Job Categories';
		$this->_example_output($output);
	}


	public function labour_job_rates()
	{

		$category = Models\AccountCategories::where('name', 'Labour Party')->first();
		$accounts = Models\AccountsCategoriesRelation::where('account_category_id', $category->id)
													 ->with('accounts')
													 ->get();
		$accounts = array_column($accounts->toArray(), 'accounts');
		$selectAccount = isset($_GET['account_id']) ? intval($_GET['account_id']) : 0;
		$jobTypes  = [];
		$rates  = [];


		usort($accounts, function($a, $b) {
		  return strcmp($a["name"], $b["name"]);
		});

		if ($selectAccount > 0)
		{
			$categories = Models\LabourJobCategoryAccountsRelation::where('account_id',$selectAccount)->get();
			$categoriesIds = array_column($categories->toArray(), 'labour_job_category_id');


			$jobTypes = Models\LabourJobTypes::whereIn('labour_job_category_id', $categoriesIds)->get()->toArray();
			$priceList =  Models\LabourPartyJobTypes::where('account_id', $selectAccount)
													  ->whereIn('labour_job_type_id', array_column($jobTypes, 'id'))
													  ->get();
			foreach ($priceList as $price)
				$rates[$price->labour_job_type_id]  = $price->rate;
		}

		$this->load->view('data/labour_job_rates', [ 
			'accounts' => $accounts,
			'jobTypes' => $jobTypes,
			'rates' => $rates,
			'account_id' => $selectAccount,
		]);
	}

	public function store_labour_job_rates()
	{
		$data = $_POST;
		$account_id = $data['account_id'];    

	    foreach ($data['labour_job_type'] as $labour_job_type_id => $rate) 
	    {
	    	if (empty($rate))
	    		continue;

			$record = Models\LabourPartyJobTypes::where('account_id', $account_id)
												->where('labour_job_type_id', $labour_job_type_id);
			
			if ($record->count() > 0)
			{
				$record->update(['rate' => $rate]);
			}
			else
			{
				Models\LabourPartyJobTypes::create([
					'labour_job_type_id' => $labour_job_type_id,
					'account_id' 		 => $account_id,
					'rate' 				 => $rate,
				]);
			}
	    }

	    $this->session->set_flashdata('success_msg', 'Price Updated successfully.');
	    redirect('data/labour_job_rates/?'. http_build_query(['account_id' => $account_id]));
	}
}
