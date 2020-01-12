<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {

	public function index()
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			$data['barang'] = $this->db->select('*')
							->from('gudang')
							->get()->result();
		    $data['main'] = 'table';
			$this->load->view('template', $data);
		} else {
			redirect(base_url('data/login'));
		}
	}

	public function cari()
	{
		if ($this->session->userdata('logged_in') == TRUE) {
		    $cari = $this->input->post('search');
			$data['barang'] = $this->db->select('*')
							->from('gudang')
							->like('nomor', $cari)
							->get()->result();
			$this->load->view('table', $data);
		} else {
			redirect(base_url('data/login'));
		}
	}

	public function login()
	{
		$this->load->view('login');		
	}

	public function masuk()
	{
	    $username = $this->input->post('username');
	    $password = $this->input->post('password');

	    $query = $this->db->where('username',$username)
	                      ->where('password',md5($password))
	                      ->get('login');

	    if ($query->num_rows() > 0) {
	    	$login = array_shift($query->result_array());
	      	$data = array(
	        	'username' => $login['username'],
	        	'role' => $login['role'],
	        	'logged_in' => TRUE,
	      	);
	      	$this->session->set_userdata($data);
			redirect(base_url('data'));
	      	return TRUE;
	      	} else {
			redirect(base_url('data'));
	      	return FALSE;
	    }
	}

  	public function logout()
  	{
    	$this->session->sess_destroy();
    	redirect();
  	}

	public function get_barang_by_id($id_barang)
	{
        $data_barang_by_id = $this->db->where('id_barang', $id_barang)
						->get('gudang')
						->row();

		echo json_encode($data_barang_by_id);die();
	}

	public function get_detilout_by_id($id_detil)
	{
        $data_detilout_by_id = $this->db->where('id_detil', $id_detil)
						->get('detil_keluar')
						->row();

		echo json_encode($data_detilout_by_id);die();
	}

	public function insertdata()
	{
		if ($this->session->userdata('role') != 'Admin Keluar') {
		    $data['main'] = 'form';
    		$this->load->view('template', $data);
		} else {
			redirect(base_url('data'));
		}
	}

	public function insertdataout($id_barang)
	{
	    $data['main'] = 'formout';
		$data['id_barang'] = $id_barang;
		$this->load->view('template', $data);
	}

	public function insert()
	{
	    $harga = $this->input->post('harga');
	    $masuk = $this->input->post('jumlah_masuk');
	    $totalharga = $harga * $masuk;
		$id_barang = $this->db->select('MAX(id_barang) AS id')
						->from('gudang')
						->get();

		$id = $id_barang->row()->id;
		$id++;

		$data = array(
			'id_barang' => $id,
			'nomor' => $this->input->post('nomor'),
			'tgl_masuk' => $this->input->post('tgl_masuk'),
			'deskripsi' => $this->input->post('deskripsi'),
			'unit' => $this->input->post('unit'),
			'harga' => $this->input->post('harga'),
			'jumlah_masuk' => $this->input->post('jumlah_masuk'),
			'total_harga' => $totalharga,
			'sisa' => $this->input->post('jumlah_masuk'));

			$this->db->insert('gudang', $data);

			if ($this->db->affected_rows() > 0) {
				redirect(base_url('data'));
				return TRUE;
			} else {
				return FALSE;
			}
	}

	public function insertout($id_barang)
	{
		$data = array(
			'id_detil' => NULL,
			'id_barang' => $id_barang,
			'jumlah' => $this->input->post('jumlah'),
			'tgl_keluar' => $this->input->post('tgl_keluar'),
			'keterangan' => $this->input->post('ket'));

		$masuk = $this->db->select('jumlah_masuk')->from('gudang')->where('id_barang', $id_barang)->get()->result();
		$keluar = $this->db->select('total_keluar')->from('gudang')->where('id_barang', $id_barang)->get()->result();
		$sisasbl = $this->db->select('sisa')->from('gudang')->where('id_barang', $id_barang)->get()->result();
		$harga = $this->db->select('harga')->from('gudang')->where('id_barang', $id_barang)->get()->result();

        foreach ($masuk as $dataa) {
        	$jumlah_masuk = $dataa->jumlah_masuk;
        }

        foreach ($sisasbl as $sisa) {
        	$sisakm = $sisa->sisa;
        }

        foreach ($keluar as $keluar) {
        	$jml_keluar = $keluar->total_keluar;
        }

        foreach ($harga as $harga) {
        	$harga = $harga->harga;
        }

		$inputkeluar = $this->input->post('jumlah');

        $jumlah_keluar = $jml_keluar + $inputkeluar;

		$sisa = $jumlah_masuk -  $jumlah_keluar;
		
		$total_harga = $harga * $sisa;

		if ($sisa < 0) {
			echo "<script>alert('Stok Kosong');window.location.href = '".base_url('data')."'</script>";die();
			redirect(base_url('data'));
		}

		$this->db->insert('detil_keluar', $data);

		$data2 = array(
			'total_keluar' => $jumlah_keluar,
			'sisa' => $sisa,
			'total_harga' => $total_harga
		);

		$this->db->where('id_barang', $id_barang)
				 ->update('gudang', $data2);

		if ($this->db->affected_rows() > 0) {
			redirect(base_url('data'));
			return TRUE;
		} else {
			return FALSE;
		}
	}


	public function delete($id_barang)
	{
		$this->db->where('id_barang', $id_barang)
				 ->delete('gudang');

		if($this->db->affected_rows() > 0){
			redirect(base_url('data'));
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function deleteout($id_detil, $id_barang)
	{
		$keluarsbl = $this->db->select('total_keluar')->from('gudang')->where('id_barang', $id_barang)->get()->result();
		$keluar = $this->db->select('jumlah')->from('detil_keluar')->where('id_detil', $id_detil)->get()->result();
		$sisasbl = $this->db->select('sisa')->from('gudang')->where('id_barang', $id_barang)->get()->result();
		$harga = $this->db->select('harga')->from('gudang')->where('id_barang', $id_barang)->get()->result();

        foreach ($keluarsbl as $data) {
        	$keluarsbl = $data->total_keluar;
        }

        foreach ($keluar as $keluar) {
        	$jml_keluar = $keluar->jumlah;
        }

        foreach ($sisasbl as $sisa) {
        	$sisakm = $sisa->sisa;
        }

        foreach ($harga as $harga) {
        	$harga = $harga->harga;
        }

        $jumlah_keluar = $keluarsbl - $jml_keluar;

		$sisa = $sisakm +  $jml_keluar;
		
		$totalharga = $harga * $sisa;

		$data2 = array(
			'total_keluar' => $jumlah_keluar,
			'sisa' => $sisa,
			'total_harga' => $totalharga
		);

		$this->db->where('id_barang', $id_barang)
				 ->update('gudang', $data2);

		$this->db->where('id_detil', $id_detil)
				 ->delete('detil_keluar');

		if($this->db->affected_rows() > 0){
			redirect(base_url('data'));
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function edit()
	{
		$inputmasuk = $this->input->post('edit_jumlah_masuk');
		$harga = $this->input->post('edit_harga');
		$keluar = $this->db->select('total_keluar')->from('gudang')->where('id_barang', $this->input->post('edit_id_barang'))->get()->result();

        foreach ($keluar as $keluar) {
        	$jml_keluar = $keluar->total_keluar;
        }

        $sisa = $inputmasuk - $jml_keluar;

        $totalharga = $harga * $sisa;

		$data = array(
				'nomor' => $this->input->post('edit_nomor'),
				'tgl_masuk' => $this->input->post('edit_tgl_masuk'),
				'deskripsi' => $this->input->post('edit_deskripsi'),
				'unit' => $this->input->post('edit_unit'),
				'harga' => $this->input->post('edit_harga'),
				'jumlah_masuk' => $this->input->post('edit_jumlah_masuk'),
				'sisa' => $sisa,
				'total_harga' => $totalharga
			);

		$this->db->where('id_barang', $this->input->post('edit_id_barang'))
				 ->update('gudang', $data);

		if($this->db->affected_rows() > 0){
			redirect(base_url('data'));
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function editout()
	{
		$inputkeluar = $this->input->post('edit_jumlah');
		$masuk = $this->db->select('jumlah_masuk')->from('gudang')->where('id_barang', $this->input->post('edit_id_barang'))->get()->result();
		$harga = $this->db->select('harga')->from('gudang')->where('id_barang', $this->input->post('edit_id_barang'))->get()->result();

        foreach ($masuk as $masuk) {
        	$jml_masuk = $masuk->jumlah_masuk;
        }

        foreach ($harga as $harga) {
        	$harga = $harga->harga;
        }

        $sisa = $jml_masuk - $inputkeluar;
        $totalharga = $harga * $sisa;

		$data = array(
				'jumlah' => $this->input->post('edit_jumlah'),
				'tgl_keluar' => $this->input->post('edit_tgl_keluar'),
				'keterangan' => $this->input->post('edit_ket')
			);

		$this->db->where('id_detil', $this->input->post('edit_id_detil'))
				 ->update('detil_keluar', $data);

		$data2 = array(
				'total_keluar' => $inputkeluar,
				'sisa' => $sisa,
				'total_harga' => $totalharga
			);

		$this->db->where('id_barang', $this->input->post('edit_id_barang'))
				 ->update('gudang', $data2);
				 
		if($this->db->affected_rows() > 0){
			redirect(base_url('data'));
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function out($id_barang)
	{
		$masuk = $this->db->select('jumlah_masuk')->from('gudang')->where('id_barang', $id_barang)->get()->result();
		$keluar = $this->db->select('total_keluar')->from('gudang')->where('id_barang', $id_barang)->get()->result();
		$sisasbl = $this->db->select('sisa')->from('gudang')->where('id_barang', $id_barang)->get()->result();

        foreach ($masuk as $data) {
        	$jumlah_masuk = $data->jumlah_masuk;
        }

        foreach ($sisasbl as $sisa) {
        	$sisakm = $sisa->sisa;
        }

        foreach ($keluar as $keluar) {
        	$jml_keluar = $keluar->jumlah_keluar;
        }

		$inputkeluar = $this->input->post('jumlah');

        $jumlah_keluar = $jml_keluar + $inputkeluar;

		$sisa = $jumlah_masuk -  $jumlah_keluar;

		if ($sisa < 0) {
			echo "<script>alert('Stok Kosong');window.location.href = '".base_url('data')."'</script>";die();
			redirect(base_url('data'));
		}

		$data = array(
			'jumlah_keluar' => $jumlah_keluar,
			'sisa' => $sisa
		);

		$this->db->where('id_barang', $id_barang)
				 ->update('gudang', $data);

		if($this->db->affected_rows() > 0){
			redirect(base_url('data'));
			return TRUE;
		} else {
			return FALSE;
		}		
	}	

	public function detilout($id_barang)
	{
		if ($this->session->userdata('role') != 'Admin Entry') {
    		$data['out'] = $this->db->select('*')
    							->from('detil_keluar')
    							->where('id_barang', $id_barang)
    							->get()->result();
    		$data['out2'] = $id_barang;
    		$data['main'] = 'tableout';
    		$this->load->view('template', $data);
		} else {
			redirect(base_url('data'));
		}
	}	

}