<?php
class GetInformation extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('Information_Model');

		$this->load->helper('form');
		$this->load->helper('url');
	    $this->load->library('form_validation');
	}
	public function index(){
		$data['allTables']=$this->Information_Model->getAllTables();
		$data['title']='Select Information:';
		$this->load->view('header',$data);
		$this->load->view('information/index',$data);
		$this->load->view('footer');		
	}
	public function selectedTableInfo($selectedTable=NULL){
		$data['infos']=$this->Information_Model->getTableInfo($selectedTable);
		$data['columns']=$this->Information_Model->getTableColumns($selectedTable);
		if(empty($data['infos'])){
			show_error('No data in '.$selectedTable);
		}
		$data['title']=$selectedTable;
		if($selectedTable==='Machine_Profile'){
			$this->load->view('header',$data);
			$this->load->view('information/searchButton',$data);
			$this->load->view('information/addButton',$data);
			$this->load->view('information/modifyButton',$data);
			$this->load->view('information/deleteButton',$data);
			$this->load->view('information/tableInfo',$data);
			$this->load->view('footer');
		}else{
			$this->load->view('header',$data);
			$this->load->view('information/searchButton',$data);
			$this->load->view('information/modifyButton',$data);
			$this->load->view('information/tableInfo',$data);
			$this->load->view('footer');
		}
		
	}
	public function clickAdd($selectedTable=NULL){
		$data['infos']=$this->Information_Model->getTableInfo($selectedTable);
		$data['columns']=$this->Information_Model->getTableColumns($selectedTable);
		if(empty($data['infos'])){
			show_error('No found in '.$selectedTable);
		}
		$data['title']=$selectedTable;
		$this->load->view('header',$data);
		$this->load->view('information/createInfo',$data);
		$this->load->view('information/tableInfo',$data);
		$this->load->view('footer');
	}
	public function clickModify($selectedTable=NULL,$mode=NULL){
		$data['columns']=$this->Information_Model->getTableColumns($selectedTable);
		$data['infos']=$this->Information_Model->getTableInfo($selectedTable);
		$data['title']=$selectedTable;
		$this->load->view('header',$data);
		if($mode=='modify'){
			$this->load->view('information/modifyInfo',$data);
		}else{
			$this->load->view('information/deleteInfo',$data);
		}
		$this->load->view('information/tableInfo',$data);
		$this->load->view('footer');
	}
	public function clickSearch($selectedTable=NULL){
		$dataForSearch['table']=$selectedTable;
		$this->form_validation->set_rules('text','text','required');
		$this->form_validation->set_rules('column','column','required');
		$dataForSearch['column']=$this->input->post('column');
		$dataForSearch['text']=$this->input->post('text');
		if($this->form_validation->run()===FALSE){
			$this->selectedTableInfo($selectedTable);
		}
		else{
			$searchResult['title']='Search Result';
			$searchResult['columns']=$this->Information_Model->getTableColumns($selectedTable);
			$searchResult['infos']=$this->Information_Model->search_Info($dataForSearch);
			$this->load->view('header',$searchResult);
			$this->load->view('information/tableInfo',$searchResult);
			$this->load->view('footer');
		}
		
	}
	
	
	public function addInfo($selectedTable=NULL){
		$data['title']=$selectedTable;
		$data['infos']=$this->Information_Model->getTableInfo($selectedTable);
		$data['columns']=$this->Information_Model->getTableColumns($selectedTable);
	
		foreach ($data['columns'] as $column){
			$this->form_validation->set_rules($column['Field'],$column['Field'],'required');
		}
		
		if($this->form_validation->run()===FALSE){
			$this->load->view('header',$data);
			$this->load->view('information/createInfo',$data);
			$this->load->view('information/tableInfo',$data);
			$this->load->view('footer');
		}
		else 
		{
			$this->Information_Model->set_Info($selectedTable,$data);
			$this->load->view('information/addInfoSuccess');
		}
	}
	public function modifyInfo($selectedTable=NULL){
		$data['title']=$selectedTable;
		$data['infos']=$this->Information_Model->getTableInfo($selectedTable);
		$data['columns']=$this->Information_Model->getTableColumns($selectedTable);
		
		$this->form_validation->set_rules('mName','mName','required');
		$this->form_validation->set_rules('column','column','required');
		$this->form_validation->set_rules('text','text','required');
		$dataForUpdate['table']=$selectedTable;
		$dataForUpdate['mName']=$this->input->post('mName');
		$dataForUpdate['column']=$this->input->post('column');
		$dataForUpdate['text']=$this->input->post('text');
		
		if($this->form_validation->run()===FALSE){
			$this->load->view('header',$data);
			$this->load->view('information/modifyInfo',$data);
			$this->load->view('information/tableInfo',$data);
			$this->load->view('footer');
		}
		else{
			$this->Information_Model->update_Info($dataForUpdate);
			$this->load->view('information/addInfoSuccess');
		}
		
	}
	public function deleteInfo($selectedTable=NULL){
		$this->form_validation->set_rules('column','column','required');
		$this->form_validation->set_rules('text','text','required');
		$dataForDelete['title']=$selectedTable;
		$dataForDelete['column']=$this->input->post('column');
		$dataForDelete['text']=$this->input->post('text');
		if($this->form_validation->run()===FALSE){
			$this->selectedTableInfo($selectedTable);
		}else{
			$this->Information_Model->delete_Info($dataForDelete);
			$this->load->view('information/addInfoSuccess');
		}
	}
	public function getInfo($table=NULL,$mName=NULL,$key=NULL,$value=NULL){
		$data['table']=$table;
		$data['mName']=$mName;
		$data['key']=$key;
		$data['value']=$value;
		if($value===NULL){
			$feeback['feeback']=$this->Information_Model->getData($data);
			$this->load->view('check',$feeback);
		}else{
			$this->Information_Model->setData($data);
		}
	}
	
}