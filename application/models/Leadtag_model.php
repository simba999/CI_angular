<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Leadtag_model extends MY_Model {
	
	public $_table_name = 'lead_tags';
    protected $_order_by;
    public $_primary_key;
    public $rules = array(
    );
	
	public function saveTags($data)
	{
		$this->db->insert($this->_table_name, $data);
		$tagId = $this->db->insert_id();
		if($tagId)
		{
			return array("status"=>1,"data"=>$tagId,"message"=>'success','query'=>$this->db->last_query());
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry There is some error','query'=>$this->db->last_query());
		}
	}
	public function checkTagExists($data)
	{
		$this->db->select("TagTitle");
		$this->db->from($this->_table_name); 
		$this->db->where(array('LeadId'=>$data['LeadId'],'TagTitle'=>$data['TagTitle']));
		$query = $this->db->get();
		$row = $query->row();
		if(!empty($row))
		{
			return array("status"=>0,"data"=>$row,"message"=>'Tag is already exists for current lead');
		}
		else
		{
			return array("status"=>1,"data"=>$row,"message"=>'success','query'=>$this->db->last_query());
		}
	}
	public function getAllTags($leadId)
	{
		$leadTags = $this->getTagByLeadId($leadId);
		$oldTag = array();
		if(!empty($leadTags['data']))
		{
			foreach($leadTags['data'] as $tags)
			{
				$oldTag[] = $tags->TagTitle;
			}
		}
		$this->db->distinct();
		$this->db->select("TagTitle");
		$this->db->from($this->_table_name); 
		$this->db->where('LeadId !=', $leadId);
		if(!empty($leadTags['data']))
		{
			$this->db->where_not_in('TagTitle', $oldTag);
		}
		$this->db->order_by('TagTitle','asc');
		$query = $this->db->get();
		$tags = array();
		foreach ($query->result() as $row)
		{
				array_push($tags, $row);
		}
		if(!empty($tags))
		{
			return array("status"=>1,"data"=>$tags,"message"=>'success','query'=>$this->db->last_query());
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry no data found');
		}
	}
	public function getTagByLeadId($leadId)
	{
		$this->db->select("Id,TagTitle");
		$this->db->from($this->_table_name); 
		$this->db->where('LeadId', $leadId);
		$this->db->order_by('TagTitle','asc');
		$query = $this->db->get();
		$tags = array();
		foreach ($query->result() as $row)
		{
				array_push($tags, $row);
		}
		if(!empty($tags))
		{
			return array("status"=>1,"data"=>$tags,"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry no data found');
		}	
	}
	public function deleteAllTagById($leadId)
	{
		$this->db->where('LeadId', $leadId);
		$this->db->delete($this->_table_name); 
		if($this->db->affected_rows() > 0)
		{
			return array("status"=>1,"data"=>$this->db->affected_rows(),"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry there is some error');
		}
	}
	public function deleteTag($tagId)
	{
		$this->db->where('Id', $tagId);
		$this->db->delete($this->_table_name); 
		if($this->db->affected_rows() > 0)
		{
			return array("status"=>1,"data"=>$this->db->affected_rows(),"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry there is some error');
		}	
	}
    	
}
?>