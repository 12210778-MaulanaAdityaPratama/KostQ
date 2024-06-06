<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaksi_detail_model extends CI_Model{

	function get_jam_mulai_terpakai($tanggal, $kost_id){
		$this->db->select('jam_mulai, durasi, jam_selesai');
		$this->db->where('tanggal', $tanggal);
		$this->db->where('kost_id', $kost_id);
		return $query = $this->db->get('transaksi_detail')->result();

		// $sql = "
		// 		SELECT
		// 			jam_mulai, durasi, jam_selesai
		// 		FROM futsal_transaksi_detail
		// 		where
		// 			tanggal = ? and kost_id = ?
		// 		";
		// $query = $this->db->query($sql, array($tanggal, $kost_id));
		//
		// return $query->result();
	}
}
