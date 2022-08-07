<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Main_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function fetch($table_name, $where = '', $order = '', $start = '', $length = '', $field='*')
	{
		if($start!='' && $length!='')
			$this->db->limit($length, $start);

		if($order)
			$this->db->order_by($order);

		$this->db->select($field);

		if($where)
			$query = $this->db->get_where($table_name, $where);
		else
			$query = $this->db->get($table_name);

		return $query->result_array();
	}

	public function fetch_in($table_name, $whereIn, $whereData, $order = '', $start = '', $length = '', $field='*')
	{
		if($start!='' && $length!='')
			$this->db->limit($length, $start);

		if($order)
			$this->db->order_by($order);

		$this->db->select($field);

		$this->db->where_in($whereIn, $whereData);
		$query = $this->db->get($table_name);

		return $query->result_array();
	}

	public function create($table_name, $data)
	{
		$this->db->insert($table_name, $data);
		$this->db->cache_delete_all();
		return $this->db->insert_id();
	}

	public function update($table_name, $data, $where, $set='')
	{
		if(is_array($data)){
			$this->db->update($table_name, $data, $where);
			$this->db->cache_delete_all();
		}
		else{
			$this->db->set($data,$set,FALSE);
			$this->db->where($where);
			$this->db->update($table_name);
			$this->db->cache_delete_all();
		}
	}

	public function delete($table_name, $where)
	{
		$this->db->delete($table_name, $where);
		$this->db->cache_delete_all();
	}

	public function count_rows($table,$where)
	{
		$query = $this->db->get_where($table, $where);
		return $query->num_rows();
	}

	public function isAdmin($username='',$password='')
	{
		if($username!='' || $password!=''){
			$query = $this->db->get_where('arg_admin', array('username'=>$username,'password'=>$password));
			return $query->result_array();
		}else{
			return false;
		}
	}

	public function get_anydata($table,$field,$id)
	{
		$query = $this->db->get_where($table, array('id' => $id));
		$res = $query->result_array();
		if($res)
			return $res[0][$field];
		else
			return '';
	}
}