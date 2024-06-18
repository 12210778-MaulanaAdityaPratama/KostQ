<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Gambarkost extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_gambarkost');
        $this->load->model('kost_model');
    }

    public function index()
    {
        $data = array(
            'title' => 'Gambar Kost',
            'gambarkost' => $this->m_gambarkost->get_user_data(),
            //'isi' => 'gambarbarang/v_index',
        );
        $this->load->view('back/gambarkost/v_index', $data, FALSE);
    }
    public function tambah($id)
    {
        $this->form_validation->set_rules(
            'ket',
            'Ket Gambar',
            'required',
            array('required' => '%s keterangan Harus diisi !!')
        );

        if ($this->form_validation->run() == TRUE or FALSE) {
            $config['upload_path'] = './assets/images/kost/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
            $config['max_size'] = '2000'; //'2000' = '2MB'
            $this->upload->initialize($config);
            $field_name = "gambar";
            if (!$this->upload->do_upload($field_name)) {
                $data = array(
                    'title' => 'Tambah gambar',
                    'tambah' => $this->kost_model->get_user_data(),
                    'error_upload' => $this->upload->display_errors(),
                    'gambar' => $this->m_gambarkost->get_gambar($id),
                    //'isi' => 'gambarbarang/v_tambah',
                    'kost' => $this->m_gambarkost->get_user_data(),
                );
                $this->load->view('back/gambarkost/v_tambah', $data);
            } else {
                $upload_data = array('uploads' => $this->upload->data());
                $config['image_library'] = 'gd2';
                $config['source_image'] = './assets/images/kost/' . $upload_data['uploads']['file_name'];
                $this->load->library('image_lib', $config);
                $data = array(
                    'id_kost' => $id,
                    'ket' => $this->input->post('ket'),
                    'gambar' => $upload_data['uploads']['file_name'],
                );
                $this->m_gambarkost->tambah($data);
                $this->session->set_flashdata('pesan', 'Gambar Berhasil ditambahkan');
                redirect('gambarkost/tambah/' . $id);
            }
        }

        $data = array(
            'title' => 'tambah gambar',
            'gambar' => $this->m_gambarkost->get_gambar($id),
            //'isi' => 'gambarbarang/v_tambah',
            'kost' => $this->m_gambarkost->get_user_data(),
        );
        $this->load->view('back/gambarkost/v_tambah', $data);
    }
    public function delete($id_kost, $id_gambar)
    {
        //hapus gambar
        $gambar = $this->m_gambarkost->get_data($id_gambar);
        if ($gambar->gambar != "") {
            unlink('./assets/images/kost/' . $gambar->gambar);
        }
        //hapus gambar
        $data = array('id_gambar' => $id_gambar);
        $this->m_gambarkost->delete($data);
        $this->session->set_flashdata('pesan', 'gambar Berhasil dihapus');
        redirect('gambarkost/tambah/' . $id_kost);
    }

}
