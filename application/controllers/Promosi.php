<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promosi extends CI_Controller {

	function __construct()
  {
    parent::__construct();
    /* memanggil model untuk ditampilkan pada masing2 modul */
		$this->load->model('Company_model');
		$this->load->model('Promosi_model');
		$this->load->model('Foto_model');
		$this->load->model('Kategori_model');
		$this->load->model('Kontak_model');

		/* memanggil function dari masing2 model yang akan digunakan */
		$this->data['company_data'] 			= $this->Company_model->get_by_company();
		$this->data['promosi_sidebar'] 			= $this->Promosi_model->get_all_sidebar();
		$this->data['foto_data'] 					= $this->Foto_model->get_all_new_home();
		$this->data['kategori_sidebar'] 	= $this->Kategori_model->get_all();
		$this->data['kontak_sidebar'] 		= $this->Kontak_model->get_all();
  }

	public function read($id)
	{
    /* mengambil data berdasarkan id */
		$row = $this->Promosi_model->get_by_id_front($id);

    /* melakukan pengecekan data, apabila ada maka akan ditampilkan */
		if ($row)
    {
      /* memanggil function dari masing2 model yang akan digunakan */
    	$this->data['promosi_detail']     = $this->Promosi_model->get_by_id_front($id);
      $this->data['promosi_lainnya']    = $this->Promosi_model->get_all_random();

      $this->data['title'] 						= $row->nama_promosi;

      /* memanggil view yang telah disiapkan dan passing data dari model ke view*/
			$this->load->view('front/promosi/body', $this->data);
		}
		else
    {
			$this->session->set_flashdata('message', '<div class="alert alert-dismissible alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>promosi tidak ditemukan</b></div>');
      redirect(base_url());
    }
	}

	public function kategori($id)
	{
    /* mengambil data berdasarkan id */
		$row = $this->Promosi_model->cek_kategori($id)->row();

    /* melakukan pengecekan data, apabila ada maka akan ditampilkan */
		if ($row)
    {
			$this->data['title'] 				= 'Kategori: '.$row->nama_kategori.' - '.$this->data['company_data']->company_name;

			/* memanggil library pagination (membuat halaman) */
	    $this->load->library('pagination');

	    /* menghitung jumlah total data */
	    $jumlah = $this->Promosi_model->total_rows_kategori($id);

	    // Mengatur base_url
	    $config['base_url'] = base_url().'promosi/kategori/'.$id.'/page/';
	    //menghitung total baris
	    $config['total_rows'] = $jumlah;
	    //mengatur total data yang tampil per halamannya
	    $config['per_page'] = 5;
	    // tag pagination bootstrap
	    $config['full_tag_open']    = "<ul class='pagination'>";
	    $config['full_tag_close']   = "</ul>";
	    $config['num_tag_open']     = "<li>";
	    $config['num_tag_close']    = "</li>";
	    $config['cur_tag_open']     = "<li class='disabled'><li class='active'><a href='#'>";
	    $config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
	    $config['next_link']        = "Selanjutnya";
	    $config['next_tag_open']    = "<li>";
	    $config['next_tagl_close']  = "</li>";
	    $config['prev_link']        = "Sebelumnya";
	    $config['prev_tag_open']    = "<li>";
	    $config['prev_tagl_close']  = "</li>";
	    $config['first_link']       = "Awal";
	    $config['first_tag_open']   = "<li>";
	    $config['first_tagl_close'] = "</li>";
	    $config['last_link']        = 'Terakhir';
	    $config['last_tag_open']    = "<li>";
	    $config['last_tagl_close']  = "</li>";

	    // mengambil uri segment ke-4
	    $dari = $this->uri->segment('5');

	    /* eksekusi library pagination ke model penampilan data */
	    $this->data['kategori_data'] = $this->Promosi_model->get_by_kategori($id,$config['per_page'],$dari)->result();
	    $this->pagination->initialize($config);

      /* memanggil view yang telah disiapkan dan passing data dari model ke view*/
			$this->load->view('front/promosi/kategori', $this->data);
		}
		else
    {
			$this->session->set_flashdata('message', '<div class="alert alert-dismissible alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>Kategori tidak ditemukan</b></div>');
      redirect(base_url());
    }
	}

	public function cari_promosi()
  {
    /* menyiapkan data yang akan disertakan/ ditampilkan pada view */
  	$this->data['page'] = 'Hasil Pencarian Anda';

  	$this->data['title'] = 'Portal promosi';

    /* memanggil function dari model yang akan digunakan */
    $this->data['hasil_pencarian'] = $this->Promosi_model->get_cari_promosi();

    /* memanggil view yang telah disiapkan dan passing data dari model ke view*/
    $this->load->view('front/home/hasil_pencarian', $this->data);
  }

  public function archive()
  {
    /* menyiapkan data yang akan disertakan/ ditampilkan pada view */
    $this->data['title'] = "Semua Promosi";

    /* memanggil library pagination (membuat halaman) */
    $this->load->library('pagination');

    /* menghitung jumlah total data */
    $jumlah = $this->Promosi_model->total_rows();

    // Mengatur base_url
    $config['base_url'] = base_url().'promosi/archive/page/';
    //menghitung total baris
    $config['total_rows'] = $jumlah;
    //mengatur total data yang tampil per halamannya
    $config['per_page'] = 5;
    // tag pagination bootstrap
    $config['full_tag_open']    = "<ul class='pagination'>";
    $config['full_tag_close']   = "</ul>";
    $config['num_tag_open']     = "<li>";
    $config['num_tag_close']    = "</li>";
    $config['cur_tag_open']     = "<li class='disabled'><li class='active'><a href='#'>";
    $config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
    $config['next_link']        = "Selanjutnya";
    $config['next_tag_open']    = "<li>";
    $config['next_tagl_close']  = "</li>";
    $config['prev_link']        = "Sebelumnya";
    $config['prev_tag_open']    = "<li>";
    $config['prev_tagl_close']  = "</li>";
    $config['first_link']       = "Awal";
    $config['first_tag_open']   = "<li>";
    $config['first_tagl_close'] = "</li>";
    $config['last_link']        = 'Terakhir';
    $config['last_tag_open']    = "<li>";
    $config['last_tagl_close']  = "</li>";

    // mengambil uri segment ke-4
    $dari = $this->uri->segment('4');

    /* eksekusi library pagination ke model penampilan data */
    $this->data['promosi_all'] = $this->Promosi_model->get_all_arsip($config['per_page'],$dari);
    $this->pagination->initialize($config);

    /* memanggil view yang telah disiapkan dan passing data dari model ke view*/
    $this->load->view('front/promosi/arsip', $this->data);
  }

}
