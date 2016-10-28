<?php
class Information_Model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	public function getAllTables(){
		$query=$this->db->query('SHOW TABLES');//資料庫的所有表格
		return $query->result_array();
	}
	public function getTableInfo($tableName=NULL){
		if($tableName===NULL){
			
		}
		$query=$this->db->get($tableName);//取的某table資料
		return $query->result_array();
	}
	public function getTableColumns($tableName=NULL){
		if($tableName===NULL){
		}
		$query=$this->db->query('SHOW COLUMNS FROM '.$tableName);//取得某table欄位
		return $query->result_array();
	}
	public function set_Info($selectedTable,$data){
		$dataToAdd=array();
		$dataForDynamic=array();
		$dataForMaintain=array();
		foreach($data['columns'] as $column){
			$dataToAdd[$column['Field']]=$this->input->post($column['Field']);
		}
		$dataForDynamic['mName']=$dataToAdd['mName'];
		$dataForMaintain['mName']=$dataToAdd['mName'];
		$dataForMaintain['fDate']=date('Y-m-d');
		$this->set_relatedTable('Machine_Dynamic_Info',$dataForDynamic);
		$this->set_relatedTable('Maintain_Record',$dataForMaintain);
		return $this->db->insert($selectedTable,$dataToAdd);
	}
	public function set_relatedTable($table,$data){
		return $this->db->insert($table,$data);
	}
	public function update_Info($data){
		$dataForUpdate=array(
				$data['column']=>$data['text']
		);
		$this->db->where('mName',$data['mName']);
		return $this->db->update($data['table'],$dataForUpdate);
	}
	public function search_Info($data){
		$query=$this->db->get_where($data['table'],array($data['column']=>$data['text']));
		return $query->result_array();
	}
	public function delete_Info($data){
		$dataForDelete=array(
				$data['column']=>$data['text']
		);
		$deleteRelatedTable=array();
		$request=$this->db->get_where($data['title'],$dataForDelete)->result_array();
		foreach($request as $row){
			$deleteRelatedTable['mName']=$row['mName'];
			$this->db->delete('Machine_Dynamic_Info',array('mName'=>$deleteRelatedTable['mName']));
			$this->db->delete('Maintain_Record',array('mName'=>$deleteRelatedTable['mName']));
		}
		return $this->db->delete($data['title'],$dataForDelete);
	}
	public function getData($data=NULL){
		$request=$this->db->get_where($data['table'],array('mName'=>$data['mName']))->result_array();
		foreach($request as $row){
			return $row[$data['key']];
		}
	}
	public function setData($data=NULL){
		$dataForSet=array(
				$data['key']=>$data['value']
		);
		$this->db->where('mName',$data['mName']);
		$this->db->update($data['table'],$dataForSet);
		
	}
	
}
	
