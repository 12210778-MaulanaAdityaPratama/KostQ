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

        // Data to be inserted into the 'kost' table
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
            'created_by' => $this->session->userdata('username')
        );

        // Insert the kost data first
        $this->Kost_model->insert($data);

        // Get the new kost's ID
        $id_kost = $this->db->insert_id();

        // Check if a file was uploaded
        if ($_FILES['foto']['error'][0] != 4) { // Check the first file's error code

            // File Upload Configuration
            $config['upload_path'] = './assets/images/kost/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|mp4';
            $config['max_size'] = '30000';
            $config['image_library'] = 'gd2';
            $config['maintain_ratio'] = FALSE;
            $config['width'] = 1280;
            $config['height'] = 720;

            // Load the upload library
            $this->load->library('upload');

            // File Upload Handling (Multiple)
            $count = count($_FILES['foto']['name']);
            for ($i = 0; $i < $count; $i++) {
                // Prepare file information for CodeIgniter's Upload library
                $_FILES['file']['name'] = $_FILES['foto']['name'][$i];
                $_FILES['file']['type'] = $_FILES['foto']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['foto']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['foto']['error'][$i];
                $_FILES['file']['size'] = $_FILES['foto']['size'][$i];

                // Generate a unique filename
                $originalFileName = pathinfo($_FILES['foto']['name'][$i], PATHINFO_FILENAME);
                $nmfile = $originalFileName . date('YmdHis') . '_' . str_pad($i, 3, '0', STR_PAD_LEFT);
                $config['file_name'] = $nmfile;

                // Initialize upload library with current file configuration
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) { // Use 'file' as the upload field
                    $foto = $this->upload->data();

                    // Prepare data for the 'kost_images' table
                    $imageData = array(
                        'id_kost' => $id_kost,
                        'foto' => $nmfile . $foto['file_ext'],
                    );
                    $this->Kost_model->insert_image($imageData);

                    // Initialize the Image_lib library for resizing
                    $resizeConfig = array(
                        'source_image' => $foto['full_path'],
                        'maintain_ratio' => FALSE,
                        'width' => 1280,
                        'height' => 720,
                    );
                    $this->load->library('image_lib', $resizeConfig);
                    $this->image_lib->resize();
                    $this->image_lib->clear(); // Clear configuration for the next file
                }
            }
        }

        // Set flash message and redirect
        $this->session->set_flashdata('message', '<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="ace-icon fa fa-bullhorn green"></i> Data berhasil disimpan</div>');
        redirect(site_url('admin/kost'));
    }
}


  

  public function update($id)
  {
    $row = $this->Kost_model->get_by_id($id);
    $this->data['kost'] = $this->Kost_model->get_by_id($id);
    $this->data['id_kost'] = $id; 
    $this->data['kost_images'] = $this->Kost_model->get_kost_images($id); // Fetch images

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
        $id_kost = $this->input->post('id_kost');
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

        $this->Kost_model->update($id_kost, $data);

        // Check if a new file is uploaded
        if (!empty($_FILES['foto']['name'][0])) {
            $config['upload_path'] = './assets/images/kost/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|mp4';
            $config['max_size'] = '30000';

            // Load upload library
            $this->load->library('upload');

            // File Upload Handling (Multiple)
            $count = count($_FILES['foto']['name']);
            for ($i = 0; $i < $count; $i++) {
                $originalFileName = pathinfo($_FILES['foto']['name'][$i], PATHINFO_FILENAME);
                $nmfile = $originalFileName . date('YmdHis') . '_' . str_pad($i, 3, '0', STR_PAD_LEFT);
                $config['file_name'] = $nmfile;

                // Initialize upload library with current file configuration
                $this->upload->initialize($config);

                // Prepare file information for CodeIgniter's Upload library
                $_FILES['file']['name'] = $_FILES['foto']['name'][$i];
                $_FILES['file']['type'] = $_FILES['foto']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['foto']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['foto']['error'][$i];
                $_FILES['file']['size'] = $_FILES['foto']['size'][$i];

                if ($this->upload->do_upload('file')) {
                    // Delete old image
                    $existing_image = $this->Kost_model->get_image_by_id_kost($id_kost);
                    if ($existing_image) {
                        $dir = "assets/images/kost/" . $existing_image->foto;
                        if (file_exists($dir)) {
                            unlink($dir);
                        }
                        $this->Kost_model->delete_image($existing_image->id);
                    }

                    $foto = $this->upload->data();

                    // Image resizing (if needed)
                    $resizeConfig = array(
                        'source_image' => $foto['full_path'],
                        'maintain_ratio' => FALSE,
                        'width' => 1280,
                        'height' => 720,
                    );
                    $this->load->library('image_lib', $resizeConfig);
                    $this->image_lib->resize();
                    $this->image_lib->clear();

                    // Insert new image data
                    $imageData = array(
                        'id_kost' => $id_kost,
                        'foto' => $nmfile . $foto['file_ext'],
                    );
                    $this->Kost_model->insert_image($imageData);
                }
            }
        }

        $this->session->set_flashdata('message', '
            <div class="alert alert-block alert-success">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times"></i>
                </button>
                <i class="ace-icon fa fa-bullhorn green"></i> Data berhasil disimpan
            </div>');
        redirect(site_url('admin/kost'));
    }
}

public function delete($id_kost)
{
    // Get the kost and associated images
    $kost = $this->Kost_model->get_by_id($id_kost);
    $kost_images = $this->Kost_model->get_kost_images($id_kost);

    // Delete the images
    if (!empty($kost_images)) {
        foreach ($kost_images as $image) {
            $dir = "assets/images/kost/" . $image->foto;
            if (file_exists($dir)) {
                unlink($dir); // Delete image file
            }
            $this->Kost_model->delete_image($image->id); // Delete image record
        }
    }
    
    // Delete the kost data
    $this->Kost_model->delete($id_kost);

    $this->session->set_flashdata('message', '
        <div class="alert alert-block alert-success">
            <button type="button" class="close" data-dismiss="alert">
                <i class="ace-icon fa fa-times"></i>
            </button>
            <i class="ace-icon fa fa-bullhorn green"></i> Data berhasil dihapus
        </div>');

    redirect(site_url('admin/kost')); 
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