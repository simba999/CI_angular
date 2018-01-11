<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login';
$route['CheckTasksStatus'] = "CheckTasksStatus";
$route['leadCreate']['post'] = "leads/store";
$route['userCreate']['post'] = "users/store";
$route['hotLeads']['get'] = "leads/getHotLeads";
$route['leadSource']['get'] = "leadSources/getLeadSource";
$route['recentLeads']['get'] = "leads/getRecenetLeads";
$route['leadStatus']['get'] = "leadStatus/getLeadStatus";
$route['leadStatusChange']['get'] = "leads/updateLeadStatus";
$route['leadDelete']['get'] = "leads/destroy";
//$route['leadDetails']['post'] = "leads/view";
$route['taskCreate']['post'] = "tasks/store";
$route['dailyTask']['get'] = "tasks/getDailyTask";
$route['overDueTask']['get'] = "tasks/getOverDueTaskList";
/*$route['assignUsers']['get'] = "users/getAssignUsers";*/
$route['assignUsers']['get'] = "users/getAssignUsersForEmailMsg";             //Added by NM.
$route['getTask']['get'] = "tasks/getTaskById";
$route['setTaskReminder']['post'] = "tasks/setReminderForTask";
$route['deleteTask']['get'] = "tasks/destroy";
$route['taskStatusChange']['get'] = "tasks/taskStatusUpdate";
$route['getCalanderTaskData']['get'] = "tasks/getCalanderTasks";
$route['getleadInteractionTypes']['get'] = "leadInteractionTypes/getAllLeadInteractionTypes";
$route['interactionCreate']['post'] = "interactions/store";
$route['getAllInteractions']['get'] = "interactions/getAllInteractions";
$route['searchInteractions']['post'] = "interactions/searchInteractions";
$route['getRelatedLeadDropdown']['get'] = "leads/getRelatedLeadDropdown";
$route['saveRelatedContact']['post'] = "leads/saveRelatedContact";
$route['getRelatedContacts']['get'] = "leads/getRelatedContacts";
$route['deleteRelation']['get'] = "leads/deleteRelatedContact";
$route['getRelatedContactById']['get'] = "leads/getRelatedContactById";
$route['getEditRelatedLeadDropdown']['get'] = "leads/getEditRelatedLeadDropdown";
$route['updateRelatedContact']['post'] = "leads/updateRelatedContact";
$route['getFilterdTask']['get'] = "tasks/getFilterdTask";
$route['getLeadData']['get'] = "leads/getCurrentLeadDetails";
$route['updateLeadData']['post'] = "leads/updateLeadData";
$route['saveHouseHoldContacts']['post'] = "leads/saveHouseHoldContact";
$route['getHouseHoldContacts']['get'] = "leads/getHouseHoldContacts";
$route['getAllTaskData']['get'] = "tasks/getAllTasks";
$route['template']['get'] = "tasks/createTemplate";
$route['saveTemplateTask']['post'] = "tasks/saveTemplateTask";
$route['getLeadListDropdown']['get'] = "leads/getLeadListDropdown";
$route['unassignedTemplate']['get'] = "tasks/getAllUnassignedTemplate";
$route['deleteHouseHoldContact']['get'] = "leads/deleteHouseHoldContact";
$route['getAllTags']['get'] = "leadTags/getAllTags";
$route['addTags']['post'] = "leadTags/store";
$route['getTagsById']['get'] = "leadTags/getTagByLeadId";
$route['deleteTag']['get'] = "leadTags/deleteTag";
$route['addLeadDocuments']['post'] = "leadDocuments/store";
$route['getLeadDocuments']['get'] = "leadDocuments/getDocuments";
$route['deleteLeadDocument']['get'] = "leadDocuments/deleteDocument";
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
