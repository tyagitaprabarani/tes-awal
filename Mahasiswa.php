<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends CI_Controller {

    public function __construct(){
            parent::__construct();
			$this->load->model('m_mahasiswa');
			$this->load->helper('url');
			$this->load->library('session');
    }
	
	public function cek_login() {
		if(!$this->session->has_userdata('uid')){
			$this->session->set_flashdata('message', 
			                     'sesi anda berakhir silahkan login kembali');			
			redirect('login/form_login');
			exit;
		}
	}	
	public function lihat_daftar(){
		//$this->cek_login();
		$data['title'] = 'Daftar Mahasiswa';
		$data['mhs']['entries'] = $this->m_mahasiswa->get_mahasiswa();
		$this->load->view('v_daftar_mahasiswa',$data);
	}
	public function logout(){
		$array_items = array('uid');
		$this->session->unset_userdata($array_items);
		$this->load->view('v_logout');
	}

	public function lihat_detail($nim=0){
		$this->cek_login();
		$data['mhs'] = $this->m_mahasiswa->get_mahasiswa_bynim($nim);		
		$data['title'] = 'Detail Mahasiswa';
		$this->load->view('v_detail_mahasiswa',$data);
	}
	
	public function proses_hapus($nim=0){
		$this->cek_login();
		$this->m_mahasiswa->delete_mahasiswa($nim);
        redirect('mahasiswa/lihat_daftar');
	}
	public function form_ubah($nim=0){
		$this->cek_login();
		$data['nim'] = $nim;
		$data['mhs'] = $this->m_mahasiswa->get_mahasiswa_bynim($nim);		
		$data['title'] = 'Edit Admin';
		$this->load->view('v_ubah_mahasiswa',$data);
	}
	public function proses_ubah($nim){
        $mhs = array(
            'nim' => $this->input->post('nim'),
            'nama' => $this->input->post('nama'),
        );
		$this->m_mahasiswa->update_mahasiswa($nim,$mhs);
        redirect('mahasiswa/lihat_daftar');
	}
	public function form_tambah(){
		$this->cek_login();
		$data['title'] = 'Tambah Mahasiswa';
		$this->load->view('v_tambah_mahasiswa',$data);
	}
	public function proses_tambah(){
        $mhs = array(
            'nim' => $this->input->post('nim'),
            'nama' => $this->input->post('nama'),
        );
		$this->m_mahasiswa->insert_mahasiswa($mhs);
        redirect('mahasiswa/lihat_daftar');
	}
}
