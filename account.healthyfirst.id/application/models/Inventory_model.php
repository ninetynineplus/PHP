<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed.');

/* ----------------------------------------------------------------------------
 * Easy!Appointments - Open Source Web Scheduler
 *
 * @package     EasyAppointments
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) 2013 - 2016, Alex Tselegidis
 * @license     http://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        http://easyappointments.org
 * @since       v1.0.0
 * ---------------------------------------------------------------------------- */

/**
 * Services Model
 *
 * @package Models
 */
class Inventory_Model extends CI_Model {
    
    /**
     * Get all service category records from database.
     *
     * @return array Returns an array that contains all the service category records.
     */
    public function get_all_items($where = '') {
        if ($where !== '') $this->db->where($where);
        return $this->db->get('ea_items')->result_array();
    }
	
    public function get_all_usage($key = '') {
		$sql = "select a.id, c.id as appid, d.first_name as emfirstname, d.last_name as emlastname, 
				e.first_name as custfirstname, e.last_name as custlastname,
				b.name, a.stock, c.start_datetime
				from ea_item_usage a
				left join ea_items b
				on a.itemid = b.id
				left join ea_appointments c
				on a.appid = c.id
				left join ea_users d
				on c.id_users_provider = d.id
				left join ea_users e
				on c.id_users_customer = e.id ";
				
		if ($key != '')
		{
			$where = "where b.name like '%".$key."%'
						or d.first_name like '%".$key."%'
						or d.last_name like '%".$key."%'
						or e.first_name like '%".$key."%'
						or e.last_name like '%".$key."%'";
						
			$sql .= $where;
		}
		return $this->db->query($sql)->result_array();
    }	
	
    public function save_item(&$item) {
        if (!$this->validate_item($item)) {
            throw new Exception('Inventory item are invalid.');
        }

        if (!isset($item['id'])) {
            $this->db->insert('ea_items', $item);
            $item['id'] = $this->db->insert_id();
        } else {
            $this->db->where('id', $item['id']);
            $this->db->update('ea_items', $item);
        }
    }
	
    public function save_item_usage(&$item) {
		$edit = false;
		
		if(isset($item['id'])) $edit = true;
		
        if (!$this->validate_item_usage($item, $edit)) {
            return false;
        }

        if (!$edit) {
			$data = array();
			$data['itemid'] = $item['items'];
			$data['appid'] = $item['appid'];
			$data['stock'] = $item['stock'];
			
            $this->db->insert('ea_item_usage', $data);
            $item['id'] = $this->db->insert_id();
			
			$sql = "UPDATE ea_items set stock = stock - ".(int)$data['stock']." where id = ".(int)$data['itemid'];
			$this->db->query($sql);
        } else {
			$data["id"] = $item["id"];
			$data['stock'] = $item['stock'];
            $sql = "UPDATE ea_item_usage set stock = ".(int)$data['stock']." where id = ".(int)$data['id'];
            $this->db->query($sql);
			
            $sql = "UPDATE ea_items set stock = ".(int)$item['newstock']." where id = ".(int)$item['itemid'];
            $this->db->query($sql);		
        }
		
		return true;
    }	
	
    public function validate_item_usage(&$data, $edit) {
		$item = (object)$data;
		
		if(!$edit)
		{
			if(!isset($item->appid)) return false;
			if(!isset($item->stock)) return false;
			if(!isset($item->items)) return false;	
			
			if((int)$item->stock < 1) return false;

			$sql = "select * from ea_appointments where id = ".(int)$item->appid;
			$result = $this->db->query($sql)->result_array();
			if(count($result) < 1)
			{
				throw new Exception('Input Appointment id is not valid.');
				return false;
			}	

			$sql = "select * from ea_items where id = ".(int)$item->items;
			$result = $this->db->query($sql)->result_array();
			if(count($result) < 1)
			{
				throw new Exception('Input Item id is not valid.');
				return false;
			}else{
				foreach($result as $k => $v)
				{
					if($v["stock"] < $item->stock) 
					{
						throw new Exception('Stock is not available');
						return false;
					}
				}
			}
		}else{
			if(!isset($item->stock)) return false;		
			if((int)$item->stock < 1) return false;
			
			$sql = "select * from ea_item_usage where id = ".(int)$item->id;
			$result = $this->db->query($sql)->result_array();
			if(count($result) < 1)
			{
				throw new Exception('Input Item Usage ID is not valid');
				return false;
			}else{
				foreach($result as $k => $v)
				{
					$oldstock = $v['stock'];
					$calcstock = $item->stock - $oldstock;
					
					$sql = "select * from ea_items where id = ".(int)$v['itemid'];
					$res = $this->db->query($sql)->result_array();
					if(count($res) < 1)
					{
						throw new Exception('Item is not exist anymore you cant edit this item usage');
						return false;	
					}else{
						foreach($res as $i => $j)
						{
							if($j['stock'] < $calcstock)
							{
								throw new Exception('Stock is not available');
								return false;
							}
							
							$data['itemid'] = $v['itemid'];
							$data['newstock'] = $j['stock'] - $calcstock;
						}
					}					
				}				
			}
		}
		
		return true;
    }	
	
    public function validate_item($item) {
		$item = (object)$item;
		if(!isset($item->name)) return false;
		
		if(!isset($item->stock)) return false;
		
        if(strlen($item->name) < 2)	return false;
		
		return true;
    }

    /**
     * Delete a service category record from the database.
     *
     * @param numeric $category_id Record id to be deleted.
     *
     * @return bool Returns the delete operation result.
     */
    public function delete_item($itemid) {
        if (!is_numeric($itemid)) {
            throw new Exception('Invalid argument given for itemid: ' . $itemid);
        }

        $num_rows = $this->db->get_where('ea_items', array('id' => $itemid))
                ->num_rows();
        if ($num_rows == 0) {
            throw new Exception('Service item record not found in database.');
        }

        $this->db->where('id', $itemid);
        return $this->db->delete('ea_items');
    }
	
    /**
     * Delete a service category record from the database.
     *
     * @param numeric $category_id Record id to be deleted.
     *
     * @return bool Returns the delete operation result.
     */
    public function delete_item_usage($itemid) {
        if (!is_numeric($itemid)) {
            throw new Exception('Invalid argument given for usageid: ' . $itemid);
        }

        $num_rows = $this->db->get_where('ea_item_usage', array('id' => $itemid))
                ->num_rows();
        if ($num_rows == 0) {
            throw new Exception('Item usage record not found in database.');
        }

        $this->db->where('id', $itemid);
        return $this->db->delete('ea_item_usage');
    }	
}

/* End of file services_model.php */
/* Location: ./application/models/services_model.php */
