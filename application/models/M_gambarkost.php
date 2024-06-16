<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_gambarkost extends CI_Model
{

    public function get_user_data()
    {
        $this->db->select('kost.*,COUNT(kost.id_kost) as total_gambar');
        $this->db->from('kost');
        $this->db->join('tb_gambar', 'tb_gambar.id_kost = kost.id_kost', 'left');

        $this->db->group_by('kost.id_kost');
        $this->db->order_by('kost.id_kost', 'desc');


        return $this->db->get()->result();
    }
    public function get_data($id_gambar)
    {
        $this->db->select('*');
        $this->db->from('tb_gambar');
        $this->db->where('id_gambar', $id_gambar);
        return $this->db->get()->row();


    }
    public function get_gambar($id_kost)
    {
        $this->db->select('*');
        $this->db->from('tb_gambar');
        $this->db->where('id_kost', $id_kost);
        return $this->db->get()->result();
    }
    public function tambah($data)
    {
        $this->db->insert('tb_gambar', $data);
    }

    public function delete($data)
    {
        $this->db->where('id_gambar', $data['id_gambar']);
        $this->db->delete('tb_gambar');
    }
}