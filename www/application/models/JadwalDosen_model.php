<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class JadwalDosen_model extends CI_Model {

	
	public $NAMA_HARI = ['Senin','Selasa','Rabu','Kamis','Jumat'];
    /**
     * Mendapatkan seluruh request dari email tertentu
     * @param type $email email yang melakukan request atau NULL untuk semua
     * @return array hasil dari $query->result()
     */
    public function requestsBy($email, $rows = NULL, $start = NULL) {
        if ($email !== NULL) {
            $this->db->where('requestByEmail', $email);
        }
        if ($start !== NULL && $rows !== NULL) {
            $this->db->limit($rows, $start);
        }
        $this->db->from('jadwal');
        $this->db->order_by('requestDateTime', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Memeriksa jenis request apa saja yang diperbolehkan.
     * @param $requests array hasil dari requestsBy($email)
     * @return mixed array daftar requestType yang tidak diperbolehkan,
     * atau string berisi alasan kenapa tidak diperbolehkan jika semuanya tidak
     * diperbolehkan.
     */
    public function addJadwal($data) {
		$this->user = $data['user'];
		$this->hari = $data['hari'];
		$this->jam_mulai = $data['jam_mulai'];
		$this->durasi = $data['durasi'];
		$this->jenis = $data['jenis_jadwal'];
		$this->label = $data['label_jadwal'];
		
		$this->db->insert('jadwal', $this);
    }
	
	/* public function getAllJadwal(){
		$query = $this->db->get('jadwal');
                return $query->result();
	} */
	 public function getAllJadwal(){
		 $query = $this->db->query('SELECT jadwal.*, bluetape_userinfo.name
			FROM jadwal
			INNER JOIN bluetape_userinfo ON jadwal.user=bluetape_userinfo.email');
			return $query->result();
	}
	
	public function getJadwalByUsername($user){
		$query = $this->db->get_where('jadwal',array('user'=>$user));
                return $query->result();
	}
	
	
	public function updateJadwal($id_jadwal,$data){
		$query = $this->db
				->where('id',$id_jadwal)
				->update('jadwal', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		return false;
	}
	
	public function getNamaHari(){
		return $this->NAMA_HARI;
	}
	
	public function kolomKeHari($namaHari){
			switch ($namaHari) {
				case "B":
				return 0;
				case "C":
				return 1;
				case "D":
				return 2;
				case "E":
				return 3;
				case "F":
				return 4;
			}
		}
		
		public function hariKeKolom($col){
			switch ($col) {
				case 0:
				return "B";
				case 1:
				return "C";
				case 2:
				return "D";
				case 3:
				return "E";
				case 4:
				return "F";
			}
		}
}