<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends MY_Controller {

    public $_table_templates = 'templates';
    public $_table_tasks = 'tasks';
    public $_table_leadtodo = 'lead_todos';
    public $_table_template_tasks = 'template_tasks';
    public $_table_users = 'users';
    public $_table_leads = 'leads';

    public function __construct() {
        parent::__construct();
        $base_url = base_url();
        $this->load->model('task_model');
    }

    public function index() {
        if (!$this->session->userdata('loggedin')) {
            redirect(base_url('login'), 'refresh');
        }
        $this->load->view('components/htmlheader');
        $this->load->view('components/header');
        $this->load->view('components/sidebar');
		$this->load->model('lead_model');
		$response = $this->lead_model->getLatestAnalytics();
		$created_date = array();
        $created_date_count = array();
        $graph_data = array();
        foreach($response as $analyticsdata)
        {
            $created_date[] = $analyticsdata->created;
            $created_date_count[] = $analyticsdata->total;
        }
        $implode_created_date = implode("','", $created_date);
        $implode_created_date_count = implode(",", $created_date_count);
       
        $graph_data['graph_labels'] = "'".$implode_created_date."'";
        $graph_data['graph_data'] = $implode_created_date_count;
        $this->load->view('todolist/list',$graph_data);
    }

    public function createTemplate() {
        if (!$this->session->userdata('loggedin')) {
            redirect(base_url('login'), 'refresh');
        }
        $this->load->view('components/htmlheader');
        $this->load->view('components/header');
        $this->load->view('components/sidebar');
        $this->load->view('todolist/createTemplate');
    }

    public function getAllTasks() {
        $response = $this->task_model->getAllTasks();
        echo json_encode($response);
    }

    public function store() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $insert = $this->input->post();
		$data = array();
        if (isset($insert['taskId']) && $insert['taskId'] != "") {
            $taskId = $insert['taskId'];
            unset($insert['taskId']);
            $data = array();
            $data['Title'] = $insert['taskTitle'];
            $data['Description'] = $insert['taskDescription'];
			$data['AssignTo'] = $this->session->userdata('id');
			if(!empty($insert['assignUser']))
			{
				$data['AssignTo'] = $insert['assignUser'];
			}
			$data['DueDate'] = DateTime::createFromFormat("m-d-Y" ,$insert['taskDueDate'])->format('Y-m-d');
            $response = $this->task_model->updateTask($data, $taskId);
        } else {
			
			$assignUser = $this->session->userdata('id');
			if(!empty($insert['assignUser']))
			{
				$assignUser = $insert['assignUser'];
			}
            $data = array(
                'Title' => $insert['taskTitle'],
                'Description' => $insert['taskDescription'],
                'LeadId' => $insert['taskLeadId'],
                'DueDate' => DateTime::createFromFormat("m-d-Y" ,$insert['taskDueDate'])->format('Y-m-d'),
                'AssignTo' => $assignUser,
                'CreatedBy' => $this->session->userdata('id'),
                'UpdatedBy' => $this->session->userdata('id'),
            );
            $response = $this->task_model->saveTask($data);
        }
        echo json_encode($response);
    }

    public function getDailyTask() {
        $response = $this->task_model->getDailyTask();
        echo json_encode($response);
    }

    public function getTaskById() {
        $taskId = $this->input->get('taskId');
        $response = $this->task_model->getTaskById($taskId);
        echo json_encode($response);
    }

    public function setReminderForTask() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $insert = $this->input->post();
        $reminderDate = $insert['reminderDate'];
        //$reminderTime = $insert['reminderTime'];
        //$reminderCombineDateTime = date('Y-m-d H:i', strtotime("$reminderDate $reminderTime"));
        unset($insert['reminderDate']);
        //unset($insert['reminderTime']);
        $editTaskId = $insert['Id'];
        unset($insert['Id']);
        $insert['ReminderDate'] = $reminderDate;
        $response = $this->task_model->setReminderForTask($insert, $editTaskId);
        echo json_encode($response);
    }

    public function getOverDueTaskList() {
        $response = $this->task_model->getOverDueTaskList();
        echo json_encode($response);
    }

    public function destroy() {
        $taskId = $this->input->get('taskId');
        $data = array();
        $data['IsDeleted'] = 1;
        $response = $this->task_model->updateTask($data, $taskId);
        echo json_encode($response);
    }

    public function taskStatusUpdate() {
        $taskId = $this->input->get('taskId');
        $data = array();
        $data['Status'] = 'Completed';
        $response = $this->task_model->updateTask($data, $taskId);
        echo json_encode($response);
    }

    public function getCalanderTasks() {
        $response = $this->task_model->getCalanderTasks();
        echo json_encode($response);
    }

    public function getFilterdTask() {
        $filterOption = $this->input->get('filterOption');
        $response = $this->task_model->getFilterdTaskData($filterOption);
        echo json_encode($response);
    }

    public function saveTemplateTask() {
        $data = json_decode(file_get_contents('php://input'), true);


        $templateTitle = $data['templateTitle'];
        $addTemplate = array(
            'Title' => $templateTitle,
            'IsDeleted' => 0,
            'CreatedBy' => $this->session->userdata('id'),
            'UpdatedBy' => $this->session->userdata('id'),
        );

        $tempalteId = $this->crud->insert($this->_table_templates, $addTemplate);

        $taskData = $data['taskTitle'];
        $taskDays = $data['day'];
        $day = 0;
        foreach ($taskData as $task) {
            $addTask = array(
                'Title' => $task,
                'TaskDays' => $taskDays[$day],
                'TemplateId' => $tempalteId,
                'CreatedBy' => $this->session->userdata('id'),
                'UpdatedBy' => $this->session->userdata('id'),
            );
            $taskId[] = $this->crud->insert($this->_table_template_tasks, $addTask);

            $day++;
        }
        echo json_encode(array("status" => 1, "data" => "", "message" => 'Congratulations your task is created successfully!'));
    }

    public function getAllUnassignedTemplate() {
        $response = $this->task_model->getAllUnassignedTemplate();
        echo json_encode($response);
    }

    public function getAllTemplate() {
        $conditions = array('IsDeleted' => 0,'CreatedBy'=>$this->session->userdata('id'));
        $tempalteList = $this->crud->select($this->_table_templates, $conditions);

        echo json_encode($tempalteList);
    }

    public function saveAssignTemplateTask() {
        $post_data = json_decode(file_get_contents('php://input'), true);
        $templates = $post_data['selectTemplate'];
        foreach ($templates as $template) {	
			$getTemplateTasks = $this->crud->select($this->_table_template_tasks, array('TemplateId' => $template), array('Title', 'TaskDays'));
			$todo = array();

            foreach ($getTemplateTasks as $tempalteTask) {
                $todoData = array(
                    'LeadId' => $post_data['selectLead'],
                    'Title' => $tempalteTask['Title'],
                    //'TaskDays' => $tempalteTask['TaskDays'],
                    'TemplateId' => $template,
                    'AssignTo' => $post_data['selectAssign'],
                    'DueDate' => date('Y-m-d', strtotime($post_data['taskdeadline'] . " + " . $tempalteTask['TaskDays'] . ' days')),
                    'CreatedBy' => $this->session->userdata('id'),
                    'UpdatedBy' => $this->session->userdata('id'),
                    'CreatedAt' => date('Y-m-d H:i:s'),
                    'UpdatedAt' => date('Y-m-d H:i:s')
                );

                $todo[] = $this->crud->insert($this->_table_tasks, $todoData);
            }
        }

        echo json_encode(array('status' => 1, 'data' => $todo));
    }

    public function leadTasks() {
        $para = array('tp.Title AS Template', 'task.*',
            ' leadstable.Title AS leadname', 'leadstable.FirstName AS leadfname', 'leadstable.LastName AS leadlname', 'leadstable.LeadImage AS leadimage',
            ' memberuser.UserName AS memberuser', 'memberuser.FirstName AS memberfname', 'memberuser.LastName AS memberlname', 'memberuser.ProfileImage AS memberimage');
        $tempCondition = array('task.IsDeleted' => 0,'task.AssignTo'=> $this->session->userdata('id'));
        $tempjoin [] = array(
            'jointable' => "$this->_table_tasks AS task",
            'joinon' => 'task.TemplateId = tp.Id',
            'jointype' => 'right'
        );
        /* $tempjoin [] = array(
            "jointable" => "$this->_table_users  AS leaduser",
            "joinon" => "task.LeadId = leaduser.Id",
            "jointype" => "left"
        ); */
        $tempjoin [] = array(
            "jointable" => "$this->_table_users  AS memberuser",
            "joinon" => "task.AssignTo = memberuser.Id",
            "jointype" => "inner"
        );
		$tempjoin [] = array(
            "jointable" => "$this->_table_leads  AS leadstable",
            "joinon" => "leadstable.Id = task.LeadId",
            "jointype" => "inner"
        );

        $templateTasks = $this->crud->selectJoin($this->_table_templates . ' AS tp', $tempCondition, $tempjoin, $para, '', 'task.DueDate');
		
        $i = 0;
        $data = array();
        foreach ($templateTasks as $task) {
            if ($task['TemplateId'] != 0) {
                $templateId = $task['TemplateId'];
                $templateName = $task['Template'];
				$templateName = str_replace(' ', '', $templateName);
                $tmplateKey = "$templateName-$templateId";
				$data[$tmplateKey]['leadfname'] = $task['leadfname'];
				$data[$tmplateKey]['leadlname'] = $task['leadlname'];
				$data[$tmplateKey]['leadname'] = $task['leadname'];
				$data[$tmplateKey]['templateName'] = $task['Template'];
				$data[$tmplateKey]['leadimage'] = $task['leadimage'];
				//$data[$tmplateKey]['DueDate'] = $task['DueDate'];
                $data[$tmplateKey]['allTask'][] = $task;
            } else {
                $data["notemplate-".$i] = $task;
            }
            $i++;
        }
		echo json_encode($data);
    }
	public function leadCompletedTasks() {
        $para = array('tp.Title AS Template', 'task.*',
            ' leadstable.Title AS leadname', 'leadstable.FirstName AS leadfname', 'leadstable.LastName AS leadlname', 'leadstable.LeadImage AS leadimage',
            ' memberuser.UserName AS memberuser', 'memberuser.FirstName AS memberfname', 'memberuser.LastName AS memberlname', 'memberuser.ProfileImage AS memberimage');
        $tempCondition = array('task.IsDeleted' => 0,'task.Status = '=>'Completed','task.AssignTo'=> $this->session->userdata('id'));
        $tempjoin [] = array(
            'jointable' => "$this->_table_tasks AS task",
            'joinon' => 'task.TemplateId = tp.Id',
            'jointype' => 'right'
        );
        /* $tempjoin [] = array(
            "jointable" => "$this->_table_users  AS leaduser",
            "joinon" => "task.LeadId = leaduser.Id",
            "jointype" => "left"
        ); */
        $tempjoin [] = array(
            "jointable" => "$this->_table_users  AS memberuser",
            "joinon" => "task.AssignTo = memberuser.Id",
            "jointype" => "inner"
        );
		$tempjoin [] = array(
            "jointable" => "$this->_table_leads  AS leadstable",
            "joinon" => "leadstable.Id = task.LeadId",
            "jointype" => "inner"
        );

        $templateTasks = $this->crud->selectJoin($this->_table_templates . ' AS tp', $tempCondition, $tempjoin, $para, '', 'task.DueDate');
        $i = 0;
        $data = array();
        foreach ($templateTasks as $task) {
            if ($task['TemplateId'] != 0) {
                $templateId = $task['TemplateId'];
                $templateName = $task['Template'];
				$templateName = str_replace(' ', '', $templateName);
                $tmplateKey = "$templateName-$templateId";
				$data[$tmplateKey]['leadfname'] = $task['leadfname'];
				$data[$tmplateKey]['leadlname'] = $task['leadlname'];
				$data[$tmplateKey]['leadname'] = $task['leadname'];
				$data[$tmplateKey]['templateName'] = $task['Template'];
				$data[$tmplateKey]['leadimage'] = $task['leadimage'];
				//$data[$tmplateKey]['DueDate'] = $task['DueDate'];
                $data[$tmplateKey]['allTask'][] = $task;
            } else {
                $data["notemplate-".$i] = $task;
            }
            $i++;
        }
        echo json_encode($data);
    }
    function createTodoTask() {
        $insert = json_decode(file_get_contents('php://input'), true);

        
        $taskId = $insert['taskId'];
        $data = array(
            'Title' => $insert['taskTitle'],
            'Description' => $insert['taskDescription'],
            'LeadId' => $insert['assignLead'],
            'DueDate' => DateTime::createFromFormat("m-d-Y" ,$insert['taskDueDate'])->format('Y-m-d'),
            'AssignTo' => $insert['assignUser'],
            'CreatedBy' => $this->session->userdata('id'),
            'UpdatedBy' => $this->session->userdata('id'),
        );
        
        if($taskId !=''){
            $condition = array('Id'=>$taskId);
            $taskId = $this->crud->update($this->_table_tasks, $data,$condition);
            echo json_encode(array("status" => 1, "data" => $taskId, "message" => 'Congratulations your task is updated successfully!'));
        }else{
            $taskId = $this->crud->insert($this->_table_tasks, $data);
            echo json_encode(array("status" => 1, "data" => $taskId, "message" => 'Congratulations your task is created successfully!'));
        }

        

        
    }

}
