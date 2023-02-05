<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Transaction extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


	public function __construct()
	{
		parent::__construct();
		$params = array('server_key' => 'SB-Mid-server-CDvL9h0h6rDvdlxWG7WAp88s', 'production' => false);
		$this->load->library('veritrans');
		$this->veritrans->config($params);
		$this->load->helper('url');
		$this->load->model('kamar_m');
		$this->load->model('keuangan_m');
		$this->load->model('transaksi_m');
	}

	public function index()
	{
		$this->load->view('transaction');
	}

	public function process()
	{
		$uid_transaksi = $this->input->post('order_id');
		$action = $this->input->post('action');
		switch ($action) {
			case 'status':
				$this->status($uid_transaksi);
				break;
			case 'approve':
				$this->approve($uid_transaksi);
				break;
			case 'expire':
				$this->expire($uid_transaksi);
				break;
			case 'cancel':
				$this->cancel($uid_transaksi);
				$keuangan = array(
					'status'		=> "CANCEL",
					'date_updated'	=> date("Y-m-d H:i:s")
				);
				$keuangan = $this->keuangan_m->updatePembayaran($keuangan, $uid_transaksi);
				// data transaksi
				$transaksi = array(
					'status_pembayaran'	=> "cancel",
					'waktu_transaksi'	=> date("Y-m-d H:i:s"),
					'status_code'		=> 202
				);
				$transaksi = $this->transaksi_m->updateTransaksiV2($transaksi, $uid_transaksi);
				// data transaksi detail
				$transaksi_detail = array(
					'status'			=> 'cancel'
				);
				$transaksi_detail = $this->transaksi_m->updateTransaksiDetail($transaksi_detail, $uid_transaksi);
				break;
		}
	}

	public function status($order_id)
	{
		echo json_encode($this->veritrans->status($order_id));
	}

	public function cancel($order_id)
	{
		print_r($this->veritrans->cancel($order_id));
	}

	public function approve($order_id)
	{
		print_r($this->veritrans->approve($order_id));
	}

	public function expire($order_id)
	{
		print_r($this->veritrans->expire($order_id));
	}
}
