<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Listing_model extends MY_Model {
	
	public $_table_name = 'Property';
	public $_table_property_images_name = 'PropertyImages';
	public $_table_agent_name = 'Agent';
    protected $_order_by;
    public $_primary_key;
	public $collection;
    public $rules = array(
    );
	
	function getAllListing($start,$limit,$data){
		$propertydb = $this->load->database('property_db', TRUE);
		$propertydb->select('*');
		$propertydb->from($this->_table_name);
		if(isset($data)){
			if(isset($data['filter']) && !empty($data['filter'])){
					if($data['filter']['city']!=''){
						$propertydb->like('AddressCity', $data['filter']['city'], 'both');
					}
					if($data['filter']['min_price']!=''){
						$propertydb->where('ListPrice > ',$data['filter']['min_price']);
					}
					if($data['filter']['max_price']!=''){
						$propertydb->where('ListPrice < ',$data['filter']['max_price']);
					}
					if($data['filter']['bedrooms']!=''){
						$propertydb->where('PropertyBedRooms',$data['filter']['bedrooms']);
					}
					if($data['filter']['bathrooms']!=''){
						$propertydb->where('PropertyBathrooms',$data['filter']['bathrooms']);
					}
					if($data['filter']['status']!=''){
						$propertydb->like('MlsStatusText', $data['filter']['status'], 'both');
					}
			}
			if(isset($data['search']) && !empty($data['search'])){
					if($data['search']['search']!=''){
						$propertydb->or_where('AddressCity LIKE "%'.$data['search']['search'].'%"');
						$propertydb->or_where('MlsStatus LIKE "%'.$data['search']['search'].'%"');
						$propertydb->or_where('MlsId',$data['search']['search']);
						$propertydb->or_where('ListPrice LIKE "%'.$data['search']['search'].'%"');
						$propertydb->or_where('PropertyBedRooms',$data['search']['search']);
						$propertydb->or_where('PropertyBathrooms',$data['search']['search']);
						$propertydb->or_where('PropertyArea LIKE "%'.$data['search']['search'].'%"');
						$propertydb->or_where('AddressFull LIKE "%'.$data['search']['search'].'%"');
				}
			}
		}
		$propertydb->where('IsDeleted','0');
		$propertydb->limit($start, $limit);
		$query = $propertydb->get();
		$listing_array = $query->result();
		$i= 0;
		if(!empty($listing_array)){
			foreach ($listing_array as $row) {
				$MlsId = $row->MlsId;
				$image_query = $propertydb->select('ImageUrl')
				->from($this->_table_property_images_name)
				->where('MlsId',$MlsId)
				->limit('1')
				->get();
				$result = $image_query->row_array();
				$ImageUrl = $result['ImageUrl'];
				$row->ImageUrl = $ImageUrl;
				$i++;
			}
		}
		return $listing_array;
	}

	function getListingCount($data){

		$propertydb = $this->load->database('property_db', TRUE);
		$propertydb->select('COUNT(*)');
		$propertydb->from($this->_table_name);
		if(isset($data)){
			if(isset($data['filter']) && !empty($data['filter'])){
					if($data['filter']['city']!=''){
						$propertydb->like('AddressCity', $data['filter']['city'], 'both');
					}
					if($data['filter']['min_price']!=''){
						$propertydb->where('ListPrice > ',$data['filter']['min_price']);
					}
					if($data['filter']['max_price']!=''){
						$propertydb->where('ListPrice < ',$data['filter']['max_price']);
					}
					if($data['filter']['bedrooms']!=''){
						$propertydb->where('PropertyBedRooms',$data['filter']['bedrooms']);
					}
					if($data['filter']['bathrooms']!=''){
						$propertydb->where('PropertyBathrooms',$data['filter']['bathrooms']);
					}
					if($data['filter']['status']!=''){
						$propertydb->like('MlsStatusText', $data['filter']['status'], 'both');
					}
			}
			if(isset($data['search']) && !empty($data['search'])){
					if($data['search']['search']!=''){
						$propertydb->or_where('AddressCity LIKE "%'.$data['search']['search'].'%"');
						$propertydb->or_where('MlsStatus LIKE "%'.$data['search']['search'].'%"');
						$propertydb->or_where('MlsId',$data['search']['search']);
						$propertydb->or_where('ListPrice LIKE "%'.$data['search']['search'].'%"');
						$propertydb->or_where('PropertyBedRooms',$data['search']['search']);
						$propertydb->or_where('PropertyBathrooms',$data['search']['search']);
						$propertydb->or_where('PropertyArea LIKE "%'.$data['search']['search'].'%"');
						$propertydb->or_where('AddressFull LIKE "%'.$data['search']['search'].'%"');
				}
			}
		}
		$propertydb->where('IsDeleted','0');
		$query = $propertydb->get();
		$result = $query->row_array();
		$count = $result['COUNT(*)'];
		return $count;
	}

	function getPropertyDetailById($data){
		$propertydb = $this->load->database('property_db', TRUE);
		$propertydb->select('*');
		$propertydb->from($this->_table_name);
		$propertydb->where('Id',$data);
		$query = $propertydb->get();
		$detail_array = $query->result();
		$i=0;
		if(!empty($detail_array)){
			foreach ($detail_array as $row) {
				$MlsId = $row->MlsId;
				$image_query = $propertydb->select('ImageUrl')
				->from($this->_table_property_images_name)
				->where('MlsId',$MlsId)
				->get();
				$image_data = $image_query->result();
				if(!empty($image_data)){
					$row->ImageUrl = $image_data;
				}
				$AgentId = $row->AgentId;
				$agent_query = $propertydb->select('AgentFirstName,AgentLastName')
				->from($this->_table_agent_name)
				->where('AgentId',$AgentId)
				->get();
				$agent_data = $agent_query->result();
				if(!empty($agent_data)){
					$row->Agent = $agent_data;
				}
				$i++;
			}
		}
		return $detail_array[0];

	}
	
}
?>