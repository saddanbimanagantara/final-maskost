<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends CI_Controller
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
		$params = array('server_key' => 'Mid-server-6jGWqH0cBCeyvsyIMpcbnkuz', 'production' => true);
		$this->load->library('veritrans');
		$this->veritrans->config($params);
		$this->load->helper('url');
		$this->load->model('kamar_m');
		$this->load->model('keuangan_m');
		$this->load->model('transaksi_m');
	}

	public function index()
	{
		$json_result = file_get_contents('php://input');
		$result = json_decode($json_result);

		if ($result) {
			$notif = $this->veritrans->status($result->order_id);
		}

		error_log(print_r($result, TRUE));

		//notification handler sample


		$transaction = $notif->transaction_status;
		$type = $notif->payment_type;
		$order_id = $notif->order_id;
		$uid_transaksi = $notif->order_id;
		$fraud = $notif->fraud_status;
		$settlement_time = $notif->settlement_time;

		if ($transaction == 'capture') {
			if ($type == 'credit_card') {
				if ($fraud == 'challenge') {
					echo "Transaction order_id: " . $order_id . " is challenged by FDS";
				} else {
					echo "Transaction order_id: " . $order_id . " successfully captured using " . $type;
				}
			} else if ($type == 'gopay') {
				if ($fraud == 'challenge') {
					echo "Transaction order_id: " . $order_id . " is challenged by FDS";
				} else {
					echo "Transaction order_id: " . $order_id . " successfully captured using " . $type;
				}
			} else if ($type == 'qris') {
				if ($fraud == 'challenge') {
					echo "Transaction order_id: " . $order_id . " is challenged by FDS";
				} else {
					echo "Transaction order_id: " . $order_id . " successfully captured using " . $type;
				}
			} else if ($type == 'shopeepay') {
				if ($fraud == 'challenge') {
					echo "Transaction order_id: " . $order_id . " is challenged by FDS";
				} else {
					echo "Transaction order_id: " . $order_id . " successfully captured using " . $type;
				}
			} else if ($type == 'cstore') {
				if ($fraud == 'challenge') {
					echo "Transaction order_id: " . $order_id . " is challenged by FDS";
				} else {
					echo "Transaction order_id: " . $order_id . " successfully captured using " . $type;
				}
			}
		} else if ($transaction == 'settlement') {
			$profit = $this->db->get('profit_set')->row_array();
			$profit = $profit['gross_amount'];
			$keuangan = array(
				'status'		=> "SETTLEMENT",
				'date_updated'	=> $settlement_time
			);
			$keuangan = $this->keuangan_m->updatePembayaran($keuangan, $uid_transaksi);
			// data transaksi
			$transaksi = array(
				'status_pembayaran'	=> "SETTLEMENT",
				'bayar_transaksi'	=> $settlement_time,
				'status_code'		=> 200
			);
			$transaksi = $this->transaksi_m->updateTransaksiNotif($transaksi, $uid_transaksi);
			// data transaksi detail
			$transaksi_detail = array(
				'status'			=> 'huni'
			);
			$transaksi_detail = $this->transaksi_m->updateTransaksiDetail($transaksi_detail, $uid_transaksi);
			$result = array(
				'keuangan'		=> $keuangan,
				'transaksi'		=> $transaksi,
				'transaksi_detail'	=> $transaksi_detail,
			);
			// section profit
			$this->keuangan_m->profit($profit);
			echo json_encode($result);
		} else if ($transaction == 'pending') {
			echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
		} else if ($transaction == 'deny') {
			echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
		}
	}
}
