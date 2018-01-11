<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Filter_model extends MY_Model {

    public $_table_header = 'message_header';
    public $_table_message = 'message';

    function __construct() {
        parent::__construct();
    }

    public function getAllCircles() {
        $this->db->select(array("Id", "Name", "Goal", "Color", "ReminderDay"));
        $this->db->from('circles');
        $this->db->where('Status', 1);
        $this->db->where('Deleted', 0);
        $this->db->where('CreatedBy',$this->session->userdata('id'));
        $CircleList = $this->db->get();
        if ($CircleList->num_rows() > 0) {
            return $CircleList->result();
        }
        return false;
    }

    public function getAllStatus() {
        $this->db->select(array("Id", "LeadStatus"));
        $this->db->from('lead_status');
        $StatusList = $this->db->get();
        if ($StatusList->num_rows() > 0) {
            return $StatusList->result();
        }
        return false;
    }

    public function getAllTags() {
        $this->db->distinct();
        $this->db->select(array("TagTitle"));
		 $this->db->where('CreatedBy',$this->session->userdata('id'));
        $this->db->from('lead_tags');
        $TagList = $this->db->get();
        if ($TagList->num_rows() > 0) {
            return $TagList->result();
        }
        return false;
    }

    public function getAllTaskProgressByLogginId() {
        $loggedInUser = $this->session->userdata('id');
        $todayDate = date("Y-m-d");
        if (isset($loggedInUser) && !empty($loggedInUser)) {
            $this->db->select("count(*) as totalTasks");
            $this->db->from("tasks");
            $this->db->where(array("LeadId" => $loggedInUser, "DueDate" => $todayDate, "IsDeleted" => 0));
            $todayTasks = $this->db->get();
            if ($todayTasks->num_rows() > 0) {
                $totalTodayTasks = $todayTasks->result()[0]->totalTasks;
            } else {
                $totalTodayTasks = 0;
            }
            $this->db->select("count(*) as totalCompletedTasks");
            $this->db->from("tasks");
            $this->db->where(array("LeadId" => $loggedInUser, "DueDate" => $todayDate, "Status" => TASK_STATUS_COMPLETED, "IsDeleted" => 0));
            $completedTasks = $this->db->get();
            if ($completedTasks->num_rows() > 0) {
                $totalTodayCompletedTasks = $completedTasks->result()[0]->totalCompletedTasks;
            } else {
                $totalTodayCompletedTasks = 0;
            }
            if (isset($taskCompletedTaskInPercentage) && !empty($taskCompletedTaskInPercentage) && $taskCompletedTaskInPercentage != 0) {
                $taskCompletedTaskInPercentage = ($totalTodayCompletedTasks * 100) / $totalTodayTasks;
                $taskCompletedTaskInPercentage = number_format((float) $taskCompletedTaskInPercentage, 2);
            } else {
                $taskCompletedTaskInPercentage = '';
            }
            return $taskCompletedTaskInPercentage;
        }
    }

}

?>