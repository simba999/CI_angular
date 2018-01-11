<?php
ob_start();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
ini_set('display_errors', 0);
//defined('BASEPATH') OR exit('No direct script access allowed');
class GetLeadCountForLeadCreator_model extends MY_Model {
	
	public $table_name = "leads";
	public function getNumberOFLeadCountForLeadCreator($leadCretor){
		// Below code is written to get number of leads for the particular lead Creator
		$responseData = array();
		$query = "SELECT count(*) as TotalLeads from `".$this->table_name."` where `IsDeleted` = 1 AND (`AssignedUserId` = ".$leadCretor." OR `CreatedBy` = ".$leadCretor.")";
		$returnquery = $this->db->query($query);
		if($returnquery->result()[0]->TotalLeads>0)
		{
			return array("status"=>1,"TotalLeads"=>$returnquery->result()[0]->TotalLeads);
		}
		else {
			return array("status"=>0,"TotalLeads"=>0);	
		}
		// End Code - // Below code is written to get number of leads for the particular lead Creator
	}
}
?>