<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kost_model extends CI_Model
{
  public $table = 'kost';
  public $id    = 'id_kost';
  public $nama    = 'nama_kost';
  public $order = 'DESC';

	function count_all()
	{
    $this->db->join('provinsi', 'provinsi.id_provinsi = kost.provinsi');
		$this->db->join('kota', 'kota.id_kota = kost.kota');
    $this->db->join('kategori', 'kost.kategori = kategori.id_kategori', 'LEFT');
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

  function get_by_id_front1($id)
  {
    $this->db->where('nama_kost', $id);
    return $this->db->get($this->table)->row();
  }

  function get_all_random()
  {
    $this->db->limit(3);
    $this->db->order_by($this->id_kost, 'random');
    return $this->db->get($this->table)->result();
  }

  function get_all()
  {
    $this->db->order_by('nama_kost','ASC');
    return $this->db->get($this->table)->result();
  }

  function get_all_home()
  {
    $this->db->order_by('nama_kost', 'ASC');
    return $this->db->get($this->table)->result();
  }
  public function get_data($id)
    {
        $this->db->select("*");
        $this->db->from('kost');
        $this->db->join('kategori', 'kategori.id_kategori = kost.id_kategori', 'left');
        $this->db->where('id_kost', $id);
        return $this->db->get()->row();
    }

  public function detail_kost($id)
    {
        $this->db->select("*");
        $this->db->from('kost');
        //$this->db->join('tb_kategori', 'tb_kategori.id_kategori = tb_barang.id_kategori', 'left');
        $this->db->where('id_kost', $id);
        return $this->db->get()->row();
    }

  function ambil_kost()
  {
    $this->db->order_by('nama_kost', 'ASC');
  	$data=$this->db->get('kost');
  	if($data->num_rows()>0)
    {
  		foreach ($data->result_array() as $row)
			{
				$result['']= '- Pilih kost -';
				$result[$row['id_kost']]= ucwords(strtolower($row['nama_kost']));
			}
			return $result;
		}
	}

  function ambil_subkat($kat)
  {
    $this->db->where('id_kat',$kat);
  	// $this->db->order_by('judul_subkat','asc');
  	$sql_subkat=$this->db->get('subkost');
  	if($sql_subkat->num_rows()>0)
    {
  		foreach ($sql_subkat->result_array() as $row)
      {
        $result[$row['id_subkost']]= ucwords(strtolower($row['judul_subkost']));
      }
      return $result;
    }
    // else
    // {
		//   $result['-']= '- Belum Ada Sub kost -';
		// }
    // return $result;
	}

  function ambil_subkost($kat_id)
  {
  	$this->db->where('id_kat',$kat_id);
  	$this->db->order_by('judul_subkost','asc');
  	$sql=$this->db->get('subkost');
  	if($sql->num_rows()>0)
    {
  		foreach ($sql->result_array() as $row)
      {
        $result[$row['id_subkost']]= ucwords(strtolower($row['judul_subkost']));
      }
    }
    else
    {
		  $result['-']= '- Belum Ada Subkost -';
		}
    return $result;
	}

  function ambil_supersubkat($subkat_id)
  {
  	$this->db->where('id_subkat',$subkat_id);

  	$sql=$this->db->get('supersubkost');
  	if($sql->num_rows()>0)
    {
  		foreach ($sql->result_array() as $row)
      {
        $result[$row['id_supersubkost']]= ucwords(strtolower($row['judul_supersubkost']));
      }
    }
    else
    {
		  $result['-']= '- Belum Ada SuperSubkost -';
		}
    return $result;
	}

  function ambil_supersubkost($subkat_id)
  {
  	$this->db->where('id_subkat',$subkat_id);

  	$sql=$this->db->get('supersubkost');
  	if($sql->num_rows()>0)
    {
  		foreach ($sql->result_array() as $row)
      {
        $result[$row['id_supersubkost']]= ucwords(strtolower($row['judul_supersubkost']));
      }
    }
    else
    {
		  $result['-']= '- Belum Ada SuperSubkost -';
		}
    return $result;
	}

  function get_list_by_kost($slug, $limit=null, $offset=null)
  {
    $this->db->join('kost', 'produk.kat_id=kost.id_kost');
    $this->db->where('kost.slug_kat', $slug);
    $this->db->limit($limit, $offset);

    return $this->db->get('produk');
  }

  function get_by_kost_nr($slug)
  {
    $this->db->join('kost', 'produk.kat_id=kost.id_kost');
    $this->db->where('kost.slug_kat', $slug);

    return $this->db->get('produk')->num_rows();
  }

  function get_list_by_subkost($slug, $limit=null, $offset=null)
  {
    $this->db->join('subkost', 'produk.subkat_id=subkost.id_subkost');
    $this->db->where('subkost.slug_subkat', $slug);
    $this->db->limit($limit, $offset);

    return $this->db->get('produk');
  }

  function get_by_subkost_nr($slug)
  {
    $this->db->join('subkost', 'produk.subkat_id=subkost.id_subkost');
    $this->db->where('subkost.slug_subkat', $slug);

    return $this->db->get('produk')->num_rows();
  }

  function get_list_by_superskost($slug, $limit=null, $offset=null)
  {
    $this->db->join('supersubkost', 'produk.supersubkat_id=supersubkost.id_supersubkost');
    $this->db->where('supersubkost.slug_supersubkat', $slug);
    $this->db->limit($limit, $offset);

    return $this->db->get('produk');
  }

  function get_by_superskost_nr($slug)
  {
    $this->db->join('supersubkost', 'produk.supersubkat_id=supersubkost.id_supersubkost');
    $this->db->where('supersubkost.slug_supersubkat', $slug);

    return $this->db->get('produk')->num_rows();
  }

  function get_all_new_home()
  {
    $this->db->limit(4);
    $this->db->order_by($this->id, $this->order);
    return $this->db->get($this->table)->result();
  }

  function get_all_kost_sidebar()
  {
    $this->db->order_by('judul_kost', 'asc');
    return $this->db->get($this->table)->result();
  }

  function get_total_row_kost()
  {
    return $this->db->get($this->table)->count_all_results();
  }

  function get_by_id($id)
  {
    $this->db->where($this->id, $id);
    return $this->db->get($this->table)->row();
  }

  function get_by_id_front($id)
  {
    $this->db->from('produk');
    $this->db->where('slug_subkat', $id);
    $this->db->join('subkost', 'produk.subkat_id = subkost.id_subkost');
    $this->db->order_by('id_produk','desc');
    return $this->db->get();
  }

  // get total rows
  function total_rows()
  {
    return $this->db->get($this->table)->num_rows();
  }

  function insert($data)
  {
    $this->db->insert($this->table, $data);
  }

  function update($id, $data)
  {
    $this->db->where($this->id,$id);
    $this->db->update($this->table, $data);
  }

  function delete($id)
  {
    $this->db->where($this->id, $id);
    $this->db->delete($this->table);
  }

  function del_by_id($id)
  {
    $this->db->select("foto");
    $this->db->where($this->id,$id);
    return $this->db->get($this->table)->row();
  }

  public function search($nama)
    {
        $this->db->group_start();
        $this->db->like('nama_kost', $nama, 'both');
        $this->db->or_like('nama_perusahaan', $nama, 'both');
        $this->db->or_like('lokasi', $nama, 'both');
        $this->db->or_like('provinsi', $nama, 'both');
        $this->db->or_like('kota', $nama, 'both');
        $this->db->or_like('kategori', $nama, 'both');
        $this->db->group_end();

        $this->db->order_by('id_kost', 'ASC');
        $this->db->limit(100);

        return $this->db->get('kost')->result();
    }
    public function get_items($search = '')
    {
        // Query untuk mengambil data dari database (contoh: tabel 'items') dengan filter pencarian
        $this->db->like('nama_kost', $search); // Gantilah 'field_name' dengan nama kolom yang sesuai
        $query = $this->db->get('kost');
        return $query->result();
    }

}
