<?php
ob_start();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
ini_set('display_errors', 0);
//defined('BASEPATH') OR exit('No direct script access allowed');
class CheckTasksStatus_model extends MY_Model {
	
	public $table_name = "tasks";
	public function checkAndUpdateTasksStatus(){
		// Below code is written to get tasks list which are having in statis (Not Completed)
		$todayDate = date("Y-m-d");
		$yesterdayDate = date('Y-m-d',strtotime("-1 days"));
		$this->db->select("*");
		$this->db->from($this->table_name);
		$this->db->where(array("IsDeleted" => 0, "DueDate" => $yesterdayDate, "Status" => TASK_STATUS_OPEN));
		$overDueTasks = $this->db->get();
		// End code - Below code is written to get tasks list which are having in statis (Not Completed)
		// Below code is written to iterate Tasks List which are not completed on yesterday from Today tade and to make their status as "OverDue"
		if($overDueTasks->num_rows()>0)
		{
			foreach($overDueTasks->result_array() as $taskKey => $taskVal)
			{
				$updateData = array("Status" => TASK_STATUS_OVER_DUE);
				$this->db->where(array("DueDate" => $yesterdayDate, "Status" => TASK_STATUS_OPEN));
				$status = $this->db->update($this->table_name,$updateData);
			}
			return true;
		}
		// End Code - Below code is written to iterate Tasks List which are not completed on yesterday from Today tade and to make their status as "OverDue"
	}
}
?>