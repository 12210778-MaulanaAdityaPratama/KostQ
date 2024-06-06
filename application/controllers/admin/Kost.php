<?php if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Kost extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Kost_model');
    $this->load->model('Kategori_model');
    $this->load->model('Wilayah_model');

    $this->data['module'] = 'Kost';

    if (!$this->ion_auth->logged_in()) {
      redirect('admin/auth/login', 'refresh');
    } elseif (!$this->ion_auth->is_AdminKost() && !$this->ion_auth->is_admin()) {
      redirect(base_url());
    }
  }

  public function index()
  {
    $this->data['title'] = 'Data ' . $this->data['module'];
    $this->data['get_all'] = $this->Kost_model->get_all();

    $this->load->view('back/kost/kost_list', $this->data);
  }

  public function detail_kost($id)
	{
    /* mengambil data berdasarkan id */
		$row = $this->Kost_model->get_by_id_front1($id);

    /* melakukan pengecekan data, apabila ada maka akan ditampilkan */
		if ($row)
    {
      /* memanggil function dari masing2 model yang akan digunakan */
    	$this->data['kost_detail']     = $this->Kost_model->get_by_id_front1($id);
      $this->data['Kost_lainnya']    = $this->Kost_model->get_all_random();

      $this->data['title'] 						= $row->nama_kost;

      /* memanggil view yang telah disiapkan dan passing data dari model ke view*/
			$this->load->view('front/kost/detail_kost', $this->data);
		}
		else
    {
			$this->session->set_flashdata('message', '<div class="alert alert-dismissible alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>Promosi tidak ditemukan</b></div>');
      redirect(base_url());
    }
	}

  public function create()
  {
    $this->data['title'] = 'Tambah ' . $this->data['module'] . ' Baru';
    $this->data['action'] = site_url('admin/kost/create_action');
    $this->data['button_submit'] = 'Simpan';
    $this->data['button_reset'] = 'Reset';

    $this->data['nama_kost'] = array(
      'name' => 'nama_kost',
      'id' => 'nama_kost',
      'type' => 'text',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('nama_kost'),
      'required' => '',
    );
    $this->data['harga'] = array(
      'name' => 'harga',
      'id' => 'harga',
      'type' => 'number',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('harga'),
      'required' => '',
    );
    $this->data['nama_perusahaan'] = array(
      'name' => 'nama_perusahaan',
      'id' => 'nama_perusahaan',
      'type' => 'text',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('nama_perusahaan'),
      'required' => '',
    );
    $this->data['lokasi'] = array(
      'name' => 'lokasi',
      'id' => 'lokasi',
      'type' => 'text',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('nama_perusahaan'),
      'required' => '',
    );
    $this->data['kat_id'] = array(
      'name' => 'kat_id',
      'id' => 'kat_id',
      'type' => 'text',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('kat_id'),
      'required' => '',
    );
    $this->data['sisa_kost'] = array(
      'name' => 'sisa_kost',
      'id' => 'sisa_kost',
      'type' => 'text',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('sisa_kost'),
      'required' => '',
    );
    $this->data['deskripsi'] = array(
      'name' => 'deskripsi',
      'id' => 'deskripsi',
      'type' => 'text',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('deskripsi'),
      'required' => '',
    );
    $this->data['provinsi_id'] = array(
      'name' => 'provinsi_id',
      'id' => 'provinsi_id',
      'class' => 'form-control',
      'onChange' => 'tampilKota()',
      'required' => '',
    );
    $this->data['kota_id'] = array(
      'name' => 'kota_id',
      'id' => 'kota_id',
      'class' => 'form-control',
      'required' => '',
    );
    $this->data['no_hp'] = array(
      'name' => 'no_hp',
      'id' => 'no_hp',
      'class' => 'form-control',
      'required' => '',
    );



    $this->data['ambil_provinsi'] = $this->Wilayah_model->get_provinsi();
    $this->data['ambil_kategori'] = $this->Kategori_model->ambil_kategori();
    $this->load->view('back/kost/kost_add', $this->data);
  }

  public function pilih_kota()
  {
    $this->data['kota'] = $this->Wilayah_model->get_kota($this->uri->segment(3));
    $this->load->view('back/kost/kota', $this->data);
  }


  public function create_action()
  {
    $this->_rules();

    if ($this->form_validation->run() == FALSE) {
      $this->create();
    } else {
      /* 4 adalah menyatakan tidak ada file yang diupload*/
      if ($_FILES['foto']['error'] <> 4) {
        $nmfile = strtolower(url_title($this->input->post('nama_kost'))) . date('YmdHis');

        /* memanggil library upload ci */
        $config['upload_path'] = './assets/images/kost/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|mp4';
        $config['max_size'] = '30000'; // 2 MB
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('foto')) {
          //file gagal diupload -> kembali ke form tambah
          $error = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('message', '<div class="alert alert-danger alert">' . $error['error'] . '</div>');

          $this->create();
        }
        //file berhasil diupload -> lanjutkan ke query INSERT
        else {
          $foto = $this->upload->data();
          $thumbnail = $config['file_name'];
          // library yang disediakan codeigniter
          $config['image_library'] = 'gd2';
          // gambar yang akan disimpan thumbnail
          $config['source_image'] = './assets/images/kost/' . $foto['file_name'] . '';
          // rasio resolusi
          $config['maintain_ratio'] = FALSE;
          // lebar
          $config['width'] = 1280;
          // tinggi
          $config['height'] = 720;

          $this->load->library('image_lib', $config);
          $this->image_lib->resize();

          $data = array(
            'nama_kost' => $this->input->post('nama_kost'),
            'harga' => $this->input->post('harga'),
            'nama_perusahaan' => $this->input->post('nama_perusahaan'),
            'lokasi' => $this->input->post('lokasi'),
            'kategori' => $this->input->post('kat_id'),
            'sisa_kost' => $this->input->post('sisa_kost'),
            'no_hp' => $this->input->post('no_hp'),
            'deskripsi' => $this->input->post('deskripsi'),
            'provinsi' => $this->input->post('provinsi_id'),
            'kota' => $this->input->post('kota_id'),
            'foto' => $nmfile . $foto['file_ext'],
            'created_by' => $this->session->userdata('username')
          );

          // eksekusi query INSERT
          $this->Kost_model->insert($data);
          // set pesan data berhasil disimpan
          $this->session->set_flashdata('message', '
            <div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
              <i class="ace-icon fa fa-bullhorn green"></i> Data berhasil disimpan
            </div>');
          redirect(site_url('admin/kost'));
        }
      } else // Jika file upload kosong
      {
        $data = array(
          'nama_kost' => $this->input->post('nama_kost'),
          'harga' => $this->input->post('harga'),
          'nama_perusahaan' => $this->input->post('nama_perusahaan'),
          'lokasi' => $this->input->post('lokasi'),
          'no_hp' => $this->input->post('no_hp'),
          'deskripsi' => $this->input->post('deskripsi'),
          'kategori' => $this->input->post('kat_id'),
          'provinsi' => $this->input->post('provinsi_id'),
          'kota' => $this->input->post('kota_id'),
          'sisa_kost' => implode(' ', $this->input->post('sisa_kost')),
          'created_by' => $this->session->userdata('username')
        );

        // eksekusi query INSERT
        $this->Kost_model->insert($data);
        // set pesan data berhasil disimpan
        $this->session->set_flashdata('message', '
        <div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
          <i class="ace-icon fa fa-bullhorn green"></i> Data berhasil disimpan
        </div>');
        redirect(site_url('admin/kost'));
      }
    }
  }

  public function update($id)
  {
    $row = $this->Kost_model->get_by_id($id);
    $this->data['kost'] = $this->Kost_model->get_by_id($id);

    if ($row) {
      $this->data['title'] = 'Ubah Data ' . $this->data['module'];
      $this->data['action'] = site_url('admin/kost/update_action');
      $this->data['button_submit'] = 'Simpan';
      $this->data['button_reset'] = 'Reset';

      $this->data['id_kost'] = array(
        'name' => 'id_kost',
        'id' => 'id_kost',
        'type' => 'hidden',
      );
      $this->data['nama_kost'] = array(
        'name' => 'nama_kost',
        'id' => 'nama_kost',
        'type' => 'text',
        'class' => 'form-control',
        'required' => '',
      );
      $this->data['harga'] = array(
        'name' => 'harga',
        'id' => 'harga',
        'type' => 'number',
        'class' => 'form-control',
        'required' => '',
      );
      $this->data['provinsi_id'] = array(
        'name' => 'provinsi_id',
        'id' => 'provinsi_id',
        'class' => 'form-control',
        'onChange' => 'tampilKota()',
        'required' => '',
      );
      $this->data['kota_id'] = array(
        'name' => 'kota_id',
        'id' => 'kota_id',
        'class' => 'form-control',
        'required' => '',
      );
      $this->data['lokasi'] = array(
        'name' => 'lokasi',
        'id' => 'lokasi',
        'class' => 'form-control',
        'required' => '',
      );
      $this->data['sisa_kost'] = array(
        'name' => 'sisa_kost',
        'id' => 'sisa_kost',
        'class' => 'form-control',
        'required' => '',
      );
      $this->data['deskripsi'] = array(
        'name' => 'deskripsi',
        'id' => 'deskripsi',
        'class' => 'form-control',
        'required' => '',
      );
      $this->data['no_hp'] = array(
        'name' => 'no_hp',
        'id' => 'no_hp',
        'class' => 'form-control',
        'required' => '',
      );
      $this->data['kat_id'] = array(
        'name' => 'kat_id',
        'id' => 'kat_id',
        'type' => 'text',
        'class' => 'form-control',
        'value' => $this->form_validation->set_value('kat_id'),
        'required' => '',
      );
      $this->data['ambil_provinsi'] = $this->Wilayah_model->get_provinsi();
      $this->data['ambil_kategori'] = $this->Kategori_model->ambil_kategori();
      $this->load->view('back/kost/kost_edit', $this->data);
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-warning alert">Data tidak ditemukan</div>');
      redirect(site_url('admin/kost'));
    }
  }

  public function update_action()
  {
    $this->_rules();

    if ($this->form_validation->run() == FALSE) {
      $this->update($this->input->post('id_kost'));
    } else {
      $nmfile = strtolower(url_title($this->input->post('nama_kost'))) . date('YmdHis');

      /* Jika file upload diisi */
      if ($_FILES['foto']['error'] <> 4) {
        $nmfile = strtolower(url_title($this->input->post('nama_kost'))) . date('YmdHis');

        //load uploading file library
        $config['upload_path'] = './assets/images/kost/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|mp4';
        $config['max_size'] = '30000'; // 2 MB
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

        $this->load->library('upload', $config);

        // Jika file gagal diupload -> kembali ke form update
        if (!$this->upload->do_upload('foto')) {
          //file gagal diupload -> kembali ke form update
          $error = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('message', '<div class="alert alert-danger alert">' . $error['error'] . '</div>');

          $this->update($this->input->post('id_kost'));
        }
        // Jika file berhasil diupload -> lanjutkan ke query INSERT
        else {
          $delete = $this->Kost_model->del_by_id($this->input->post('id_kost'));

          $dir = "assets/images/kost/" . $delete->foto;

          if (file_exists($dir)) {
            // Hapus foto dan thumbnail
            unlink($dir);
          }

          $foto = $this->upload->data();
          // library yang disediakan codeigniter
          $thumbnail = $config['file_name'];
          //nama yang terupload nantinya
          $config['image_library'] = 'gd2';
          // gambar yang akan disimpan thumbnail
          $config['source_image'] = './assets/images/kost/' . $foto['file_name'] . '';
          // rasio resolusi
          $config['maintain_ratio'] = FALSE;
          // lebar
          $config['width'] = 1280;
          // tinggi
          $config['height'] = 720;

          $this->load->library('image_lib', $config);
          $this->image_lib->resize();

          $data = array(
            'nama_kost' => $this->input->post('nama_kost'),
            'harga' => $this->input->post('harga'),
            'provinsi' => $this->input->post('provinsi'),
            'kota' => $this->input->post('kota'),
            'lokasi' => $this->input->post('lokasi'),
            'no_hp' => $this->input->post('no_hp'),
            'sisa_kost' => $this->input->post('sisa_kost'),
            'kategori' => $this->input->post('kat_id'),
            'deskripsi' => $this->input->post('deskripsi'),
            'foto' => $nmfile . $foto['file_ext'],
            'modified_by' => $this->session->userdata('username')
          );

          $this->Kost_model->update($this->input->post('id_kost'), $data);
          $this->session->set_flashdata('message', '
              <div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
                <i class="ace-icon fa fa-bullhorn green"></i> Data berhasil disimpan
              </div>');
          redirect(site_url('admin/kost'));
        }
      }
      // Jika file upload kosong
      else {
        $data = array(
          'nama_kost' => $this->input->post('nama_kost'),
          'harga' => $this->input->post('harga'),
          'provinsi' => $this->input->post('provinsi'),
          'kota' => $this->input->post('kota'),
          'lokasi' => $this->input->post('lokasi'),
          'no_hp' => $this->input->post('no_hp'),
          'sisa_kost' => $this->input->post('sisa_kost'),
          'kategori' => $this->input->post('kat_id'),
          'deskripsi' => $this->input->post('deskripsi'),
          'modified_by' => $this->session->userdata('username')
        );

        $this->Kost_model->update($this->input->post('id_kost'), $data);
        $this->session->set_flashdata('message', '
            <div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
              <i class="ace-icon fa fa-bullhorn green"></i> Data berhasil disimpan
            </div>');
        redirect(site_url('admin/kost'));
      }
    }
  }

  public function delete($id)
  {
    $delete = $this->Kost_model->del_by_id($id);

    // menyimpan lokasi gambar dalam variable
    $dir = "assets/images/foto/" . $delete->foto . $delete->foto_type;

    // Hapus foto
    unlink($dir);

    // Jika data ditemukan, maka hapus foto dan record nya
    if ($delete) {
      $this->Kost_model->delete($id);

      $this->session->set_flashdata('message', '
      <div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
        <i class="ace-icon fa fa-bullhorn green"></i> Data berhasil dihapus
      </div>');
      redirect(site_url('admin/kost'));
    }
    // Jika data tidak ada
    else {
      $this->session->set_flashdata('message', '
        <div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
					<i class="ace-icon fa fa-bullhorn green"></i> Data tidak ditemukan
        </div>');
      redirect(site_url('admin/kost'));
    }
  }

  public function _rules()
  {
    $this->form_validation->set_rules('nama_kost', 'Judul Kost', 'trim|required');

    // set pesan form validasi error
    $this->form_validation->set_message('required', '{field} wajib diisi');

    $this->form_validation->set_rules('id_kost', 'id_kost', 'trim');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert">', '</div>');
  }

}