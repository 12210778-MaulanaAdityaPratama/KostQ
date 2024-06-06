<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Promosi extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Promosi_model');
    $this->load->model('Kategori_model');

    $this->data['module'] = 'Promosi';

    if(!$this->ion_auth->logged_in()){redirect('admin/auth/login', 'refresh');}
    elseif(!$this->ion_auth->is_AdminKost() && !$this->ion_auth->is_admin()){redirect(base_url());}
  }

  public function index()
  {
    $this->data['title']    = 'Data '.$this->data['module'];
    $this->data['get_all']  = $this->Promosi_model->get_all();

    $this->load->view('back/promosi/promosi_list', $this->data);
  }

  public function create()
  {
    $this->data['title']          = 'Tambah '.$this->data['module'].' Baru';
    $this->data['action']         = site_url('admin/promosi/create_action');
    $this->data['button_submit']  = 'Simpan';
    $this->data['button_reset']   = 'Reset';

    $this->data['nama_promosi'] = array(
      'name'  => 'nama_promosi',
      'id'    => 'nama_promosi',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('nama_promosi'),
    );
    $this->data['harga'] = array(
      'name'  => 'harga',
      'id'    => 'harga',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('harga'),
    );
    $this->data['link'] = array(
      'name'  => 'link',
      'id'    => 'link',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('link'),
    );

    $this->data['deskripsi'] = array(
      'name'  => 'deskripsi',
      'id'    => 'deskripsi',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('deskripsi'),
    );

    $this->data['kat_id'] = array(
      'name'  => 'kat_id',
      'id'    => 'kat_id',
      'class' => 'form-control',
      'required'    => '',
    );

    $this->data['ambil_kategori'] = $this->Kategori_model->ambil_kategori();

    $this->load->view('back/promosi/promosi_add', $this->data);
  }

  public function create_action()
  {
    $this->_rules();

    if ($this->form_validation->run() == FALSE)
    {
      $this->create();
    }
    else
    {
      /* 4 adalah menyatakan tidak ada file yang diupload*/
      if ($_FILES['foto']['error'] <> 4)
      {
        $nmfile = strtolower(url_title($this->input->post('nama_promosi'))).date('YmdHis');

        /* memanggil library upload ci */
        $config['upload_path']      = './assets/images/promosi/';
        $config['allowed_types']    = 'jpg|jpeg|png|gif';
        $config['max_size']         = '2048'; // 2 MB
        $config['file_name']        = $nmfile; //nama yang terupload nantinya

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('foto'))
        {
          //file gagal diupload -> kembali ke form tambah
          $error = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('message', '<div class="alert alert-danger alert">'.$error['error'].'</div>');

          $this->create();
        }
          //file berhasil diupload -> lanjutkan ke query INSERT
          else
          {
            $foto = $this->upload->data();
            $thumbnail                = $config['file_name'];
            // library yang disediakan codeigniter
            $config['image_library']  = 'gd2';
            // gambar yang akan disimpan thumbnail
            $config['source_image']   = './assets/images/promosi/'.$foto['file_name'].'';
            // membuat thumbnail
            $config['create_thumb']   = TRUE;
            // rasio resolusi
            $config['maintain_ratio'] = FALSE;
            // lebar
            $config['width']          = 800;
            // tinggi
            $config['height']         = 400;

            $this->load->library('image_lib', $config);
            $this->image_lib->resize();

            $data = array(
              'nama_promosi'    => $this->input->post('nama_promosi'),
              'slug_promosi'     => strtolower(url_title($this->input->post('nama_promosi'))),
              'deskripsi'      => $this->input->post('deskripsi'),
              'harga'      => $this->input->post('harga'),
              'link'      => $this->input->post('link'),
              'kategori'      => $this->input->post('kat_id'),
              'foto'          => $nmfile,
              'foto_type'     => $foto['file_ext'],
              'created_by'    => $this->session->userdata('username')
            );

            // eksekusi query INSERT
            $this->Promosi_model->insert($data);
            // set pesan data berhasil disimpan
            $this->session->set_flashdata('message', '
            <div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
              <i class="ace-icon fa fa-bullhorn green"></i> Data berhasil disimpan
            </div>');
            redirect(site_url('admin/promosi'));
          }
      }
      else // Jika file upload kosong
      {
        $data = array(
          'nama_promosi'  => $this->input->post('nama_promosi'),
          'slug_promosi'     => strtolower(url_title($this->input->post('nama_promosi'))),
          'deskripsi'      => $this->input->post('deskripsi'),
          'harga'      => $this->input->post('harga'),
          'link'      => $this->input->post('link'),
          'kategori'      => $this->input->post('kat_id'),
          'created_by'      => $this->session->userdata('username')
        );

        // eksekusi query INSERT
        $this->Promosi_model->insert($data);
        // set pesan data berhasil disimpan
        $this->session->set_flashdata('message', '
        <div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
          <i class="ace-icon fa fa-bullhorn green"></i> Data berhasil disimpan
        </div>');
        redirect(site_url('admin/promosi'));
      }
    }
  }

  public function update($id)
  {
    $row = $this->Promosi_model->get_by_id($id);
    $this->data['promosi'] = $this->Promosi_model->get_by_id($id);

    if ($row)
    {
      $this->data['title']          = 'Ubah Data '.$this->data['module'];
      $this->data['action']         = site_url('admin/promosi/update_action');
      $this->data['button_submit']  = 'Simpan';
      $this->data['button_reset']   = 'Reset';

      $this->data['id_promosi'] = array(
        'name'  => 'id_promosi',
        'id'    => 'id_promosi',
        'type'  => 'hidden',
      );
      $this->data['nama_promosi'] = array(
        'name'  => 'nama_promosi',
        'id'    => 'nama_promosi',
        'class' => 'form-control',
      );
      $this->data['link'] = array(
        'name'  => 'link',
        'id'    => 'link',
        'class' => 'form-control',
      );
      $this->data['harga'] = array(
        'name'  => 'harga',
        'id'    => 'harga',
        'class' => 'form-control',
      );
      $this->data['deskripsi'] = array(
        'name'  => 'deskripsi',
        'id'    => 'deskripsi',
        'class' => 'form-control',
      );
      $this->data['kat_id'] = array(
        'name'  => 'kat_id',
        'id'    => 'kat_id',
        'class' => 'form-control',
        'required'    => '',
      );

      $this->data['ambil_kategori'] = $this->Kategori_model->ambil_kategori();

      $this->load->view('back/promosi/promosi_edit', $this->data);
    }
      else
      {
        $this->session->set_flashdata('message', '
        <div class="alert alert-block alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
          <i class="ace-icon fa fa-bullhorn green"></i> Data tidak ditemukan
        </div>');
        redirect(site_url('admin/promosi'));
      }
  }

  public function update_action()
  {
    $this->_rules();

    if ($this->form_validation->run() == FALSE)
    {
      $this->update($this->input->post('id_promosi'));
    }
      else
      {
        $nmfile = strtolower(url_title($this->input->post('nama_promosi'))).date('YmdHis');
        $id['id_promosi'] = $this->input->post('id_promosi');

        /* Jika file upload diisi */
        if ($_FILES['foto']['error'] <> 4)
        {
          $nmfile = strtolower(url_title($this->input->post('nama_promosi'))).date('YmdHis');

          //load uploading file library
          $config['upload_path']      = './assets/images/promosi/';
          $config['allowed_types']    = 'jpg|jpeg|png|gif';
          $config['max_size']         = '2048'; // 2 MB
          $config['file_name']        = $nmfile; //nama yang terupload nantinya

          $this->load->library('upload', $config);

          // Jika file gagal diupload -> kembali ke form update
          if (!$this->upload->do_upload('foto'))
          {
            //file gagal diupload -> kembali ke form update
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert">'.$error['error'].'</div>');

            $this->update($this->input->post('id_promosi'));
          }
            // Jika file berhasil diupload -> lanjutkan ke query INSERT
            else
            {
              $delete = $this->Promosi_model->del_by_id($this->input->post('id_promosi'));

              $dir        = "assets/images/promosi/".$delete->foto.$delete->foto_type;
              $dir_thumb  = "assets/images/promosi/".$delete->foto.'_thumb'.$delete->foto_type;

              if(file_exists($dir))
              {
                // Hapus foto dan thumbnail
                unlink($dir);
                unlink($dir_thumb);
              }

              $foto = $this->upload->data();
              // library yang disediakan codeigniter
              $thumbnail                = $config['file_name'];
              //nama yang terupload nantinya
              $config['image_library']  = 'gd2';
              // gambar yang akan disimpan thumbnail
              $config['source_image']   = './assets/images/promosi/'.$foto['file_name'].'';
              // membuat thumbnail
              $config['create_thumb']   = TRUE;
              // rasio resolusi
              $config['maintain_ratio'] = FALSE;
              // lebar
              $config['width']          = 800;
              // tinggi
              $config['height']         = 400;

              $this->load->library('image_lib', $config);
              $this->image_lib->resize();

              $data = array(
                'nama_promosi'  => $this->input->post('nama_promosi'),
                'slug_promosi'   => strtolower(url_title($this->input->post('nama_promosi'))),
                'link'    => $this->input->post('link'),
                'deskripsi'    => $this->input->post('deskripsi'),
                'harga'    => $this->input->post('harga'),
                'kategori'    => $this->input->post('kat_id'),
                'foto'        => $nmfile,
                'foto_type'   => $foto['file_ext'],
                'modified_by' => $this->session->userdata('username')
              );

              $this->Promosi_model->update($this->input->post('id_promosi'), $data);
              $this->session->set_flashdata('message', '
              <div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
                <i class="ace-icon fa fa-bullhorn green"></i> Data berhasil disimpan
              </div>');
              redirect(site_url('admin/promosi'));
            }
        }
          // Jika file upload kosong
          else
          {
            $data = array(
              'nama_promosi'  => $this->input->post('nama_promosi'),
              'slug_promosi'   => strtolower(url_title($this->input->post('nama_promosi'))),
              'deskripsi'    => $this->input->post('deskripsi'),
              'harga'    => $this->input->post('harga'),
              'link'    => $this->input->post('link'),
              'kategori'    => $this->input->post('kat_id'),
              'modified_by' => $this->session->userdata('username')
            );

            $this->Promosi_model->update($this->input->post('id_promosi'), $data);
            $this->session->set_flashdata('message', '
            <div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
              <i class="ace-icon fa fa-bullhorn green"></i> Data berhasil disimpan
            </div>');
            redirect(site_url('admin/promosi'));
          }
      }
  }

  public function delete($id)
  {
    $delete = $this->Promosi_model->del_by_id($id);

    // menyimpan lokasi gambar dalam variable
    $dir = "assets/images/promosi/".$delete->foto.$delete->foto_type;
    $dir_thumb = "assets/images/promosi/".$delete->foto.'_thumb'.$delete->foto_type;

    // Hapus foto
    unlink($dir);
    unlink($dir_thumb);

    // Jika data ditemukan, maka hapus foto dan record nya
    if($delete)
    {
      $this->Promosi_model->delete($id);

      $this->session->set_flashdata('message', '
      <div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
        <i class="ace-icon fa fa-bullhorn green"></i> Data berhasil dihapus
      </div>');
      redirect(site_url('admin/promosi'));
    }
      // Jika data tidak ada
      else
      {
        $this->session->set_flashdata('message', '
        <div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
					<i class="ace-icon fa fa-bullhorn green"></i> Data tidak ditemukan
        </div>');
        redirect(site_url('admin/promosi'));
      }
  }

  public function _rules()
  {
    $this->form_validation->set_rules('nama_promosi', 'nama promosi', 'trim|required');

    // set pesan form validasi error
    $this->form_validation->set_message('required', '{field} wajib diisi');

    $this->form_validation->set_rules('id_promosi', 'id_promosi', 'trim');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert">', '</div>');
  }

}
