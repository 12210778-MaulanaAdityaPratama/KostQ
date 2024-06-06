<?php
class Laporan_model extends CI_Model {

    public function get_all_transactions() {
        $this->db->select('transaksi.*, users.name as user_name');
        $this->db->from('transaksi');
        $this->db->join('users', 'transaksi.user_id = users.id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_totals() {
        $this->db->select_sum('subtotal');
        $this->db->select_sum('diskon');
        $this->db->select_sum('grand_total');
        $query = $this->db->get('transaksi');
        return $query->row_array();
    }

    public function get_transactions_by_month($month, $year) {
        $this->db->select('transaksi.*, users.name as user_name');
        $this->db->from('transaksi');
        $this->db->join('users', 'transaksi.user_id = users.id');
        $this->db->where('MONTH(transaksi.created_date)', $month);
        $this->db->where('YEAR(transaksi.created_date)', $year);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_totals_by_month($month, $year) {
        $this->db->select_sum('subtotal');
        $this->db->select_sum('diskon');
        $this->db->select_sum('grand_total');
        $this->db->where('MONTH(created_date)', $month);
        $this->db->where('YEAR(created_date)', $year);
        $query = $this->db->get('transaksi');
        return $query->row_array();
    }

    public function get_unpaid_transactions_by_month($month, $year) {
        $this->db->select('transaksi.*, users.name as user_name');
        $this->db->from('transaksi');
        $this->db->join('users', 'transaksi.user_id = users.id');
        $this->db->where('MONTH(transaksi.created_date)', $month);
        $this->db->where('YEAR(transaksi.created_date)', $year);
        $this->db->where_in('transaksi.status', [0, 1]); // Status 0 dan 1 adalah belum lunas
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_paid_transactions_by_month($month, $year) {
        $this->db->select('transaksi.*, users.name as user_name');
        $this->db->from('transaksi');
        $this->db->join('users', 'transaksi.user_id = users.id');
        $this->db->where('MONTH(transaksi.created_date)', $month);
        $this->db->where('YEAR(transaksi.created_date)', $year);
        $this->db->where('transaksi.status', 2); // Status 2 adalah lunas
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_unpaid_totals_by_month($month, $year) {
        $this->db->select_sum('subtotal');
        $this->db->select_sum('diskon');
        $this->db->select_sum('grand_total');
        $this->db->where('MONTH(created_date)', $month);
        $this->db->where('YEAR(created_date)', $year);
        $this->db->where_in('status', [0, 1]); // Status 0 dan 1 adalah belum lunas
        $query = $this->db->get('transaksi');
        return $query->row_array();
    }

    public function get_all_unpaid_transactions() {
        $this->db->select('transaksi.*, users.name as user_name');
        $this->db->from('transaksi');
        $this->db->join('users', 'transaksi.user_id = users.id');
        $this->db->where_in('transaksi.status', [0, 1]); // Status 0 dan 1 adalah belum lunas
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_paid_transactions() {
        $this->db->select('transaksi.*, users.name as user_name');
        $this->db->from('transaksi');
        $this->db->join('users', 'transaksi.user_id = users.id');
        $this->db->where('transaksi.status', 2); // Status 2 adalah lunas
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_paid_totals_by_month($month, $year) {
        $this->db->select_sum('subtotal');
        $this->db->select_sum('diskon');
        $this->db->select_sum('grand_total');
        $this->db->where('MONTH(created_date)', $month);
        $this->db->where('YEAR(created_date)', $year);
        $this->db->where('status', 2); // Status 2 adalah lunas
        $query = $this->db->get('transaksi');
        return $query->row_array();
    }
    public function get_all_paid_totals() {
        $this->db->select_sum('subtotal');
        $this->db->select_sum('diskon');
        $this->db->select_sum('grand_total');
        $this->db->where('status', 2); // Status 2 adalah lunas
        $query = $this->db->get('transaksi');
        return $query->row_array();
    }
    public function get_all_unpaid_totals() {
        $this->db->select_sum('subtotal');
        $this->db->select_sum('diskon');
        $this->db->select_sum('grand_total');
        $this->db->where_in('status', [0, 1]); // Status 0 dan 1 adalah belum lunas
        $query = $this->db->get('transaksi');
        return $query->row_array();
    }
    
    
}

?>
