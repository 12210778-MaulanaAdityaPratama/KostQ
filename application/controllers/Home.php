<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$this->data['title'] = 'Home';

		$this->load->model('Company_model');
		$this->load->model('Promosi_model');
		$this->load->model('Foto_model');
		$this->load->model('Kontak_model');
		$this->load->model('Kost_model');
		$this->load->model('Slider_model');

		$this->data['company_data'] 	= $this->Company_model->get_by_company();
		$this->data['promosi_new'] 			= $this->Promosi_model->get_all_new_home();
		$this->data['foto_data'] 			= $this->Foto_model->get_all_new_home();
		$this->data['slider_data'] 		= $this->Slider_model->get_all_home();
		$this->data['kontak'] 				= $this->Kontak_model->get_all();
		$this->data['kost_new'] 	= $this->Kost_model->get_all_home();

		$this->load->view('front/home/body', $this->data);
	}

    public function search()
    {
        $this->load->model('Kost_model');
        if (isset($_GET['fr'])) {
            $result = $this->Kost_model->search($_GET['fr']);
            if (count($result) > 0) {
                $kost_new = [];
                foreach ($result as $row) {
                    $kost_new[] = (object) [
                        'id_kost' => $row->id_kost,
                        'nama_kost' => $row->nama_kost,  
                        'nama_perusahaan' => $row->nama_perusahaan,
                        'provinsi' => $row->provinsi,
                        'kota' => $row->kota,
                        'lokasi' => $row->lokasi,
                        'harga' => $row->harga,
                        'foto' => $row->foto,
                        'deskripsi' => $row->deskripsi,
                        'kategori' => $row->kategori,
                        'created_at' => $row->created_at,
                    ];
                }
                $this->data['kost_new'] = $kost_new;

                $data['title'] = "KostQ | Search";
                $this->load->model('Company_model');
                $this->load->model('Promosi_model');
                $this->load->model('Foto_model');
                $this->load->model('Kontak_model');
                $this->load->model('Slider_model');

                $this->data['company_data']    = $this->Company_model->get_by_company();
                $this->data['promosi_new']         = $this->Promosi_model->get_all_new_home();
                $this->data['foto_data']           = $this->Foto_model->get_all_new_home();
                $this->data['slider_data']         = $this->Slider_model->get_all_home();
                $this->data['kontak']              = $this->Kontak_model->get_all();
                
                $this->load->view('front/home/body', $this->data);
            } else {
                $this->session->set_flashdata('error', '<div class="alert alert-success alert-pesan">Kost Yang kamu cari tidak ada</div>');
                redirect('');
            }
        }
    }

    public function get_data()
    {
        $search = $this->input->post('search');
        $data['items'] = $this->Beranda_model->get_items($search);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
