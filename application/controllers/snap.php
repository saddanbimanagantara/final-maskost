<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Snap extends CI_Controller
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
		$this->load->library('midtrans');
		$this->load->model('kamar_m');
		$this->load->model('keuangan_m');
		$this->load->model('transaksi_m');
		$this->midtrans->config($params);
		$this->load->helper('url');
	}

	public function index()
	{
		$this->load->view('checkout_snap');
	}

	public function token()
	{
		// all uid
		$uid_kamar = $this->input->post('uid_kamar');
		$uid_member = $this->input->post('uid_member');
		// data pembayaran sewa
		$nama_kost = $this->input->post('nama_kost');
		$durasi = $this->input->post('durasi');
		$tanggal_masuk = $this->input->post('tanggal_masuk');
		$jumlah_pembayaran = preg_replace('/\D/', '', $this->input->post('jumlah_pembayaran'));

		// Required
		$transaction_details = array(
			'order_id' => "TX-" . rand(),
			'gross_amount' => $jumlah_pembayaran, // no decimal allowed for creditcard
		);

		// Optional
		$item1_details = array(
			'id' 			=> $uid_kamar,
			'price' 		=> $jumlah_pembayaran,
			'quantity' 		=> 1,
			'name' 			=> $nama_kost,
			'durasi'		=> $durasi,
			'tanggal masuk' => $tanggal_masuk
		);

		// Optional
		$item_details = array($item1_details);

		// data identitas
		$fnama = $this->input->post('fnama');
		$lnama = $this->input->post('lnama');
		$email = $this->input->post('email');
		$no_hp = $this->input->post('no_hp');
		$alamat = $this->input->post('alamat');

		// Optional
		$customer_details = array(
			'first_name'    => $fnama,
			'last_name'     => $lnama,
			'email'         => $email,
			'phone'         => $no_hp,
			'address'		=> $alamat
		);

		// Data yang akan dikirim untuk request redirect_url.
		$credit_card['secure'] = true;
		//ser save_card true to enable oneclick or 2click
		//$credit_card['save_card'] = true;

		$time = time();
		$custom_expiry = array(
			'start_time' => date("Y-m-d H:i:s O", $time),
			'unit' => 'minute',
			'duration'  => 500
		);

		$transaction_data = array(
			'transaction_details' => $transaction_details,
			'item_details'       => $item_details,
			'customer_details'   => $customer_details,
			'credit_card'        => $credit_card,
			'expiry'             => $custom_expiry
		);

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
	}

	public function finish()
	{
		// payment type code {QRIS, cstore(alfa group), cstpre(indomaret), GO-PAY, bank_transfer}
		$result = json_decode($this->input->post('result_data'), TRUE);
		$snapToken = $this->input->post('token');
		$uid_kamar = $this->input->post('uid_kamar');
		$uid_member = $this->input->post('uid_member');
		$durasi = $this->input->post('durasi');
		$jenis = $this->input->post('jenis');
		$tanggal_masuk = $this->input->post('tanggal_masuk');
		$tanggal_keluar = '';
		if ($jenis === "baru") {
			$tanggal_keluar = date('Y-m-d', strtotime('+' . $durasi . ' month', strtotime($tanggal_masuk)));
		} else if ($jenis === "perpanjang") {
			$tanggal_keluar = date('Y-m-d', strtotime('+' . $durasi . ' month', strtotime($this->input->post('tanggal_keluar'))));
		}
		// get uid pemilik kamar
		$kamar = $this->db->get_where('kamar_kost', array('uid_kamar' => $uid_kamar))->row_array();
		// set profit perusahaan
		$profit = $this->db->get('profit_set')->row_array();
		$profit = $profit['gross_amount'];
		switch ($result['status_code']) {
			case 201:
				$datapembayaran = $this->_datapembayaran($result, $snapToken, $jenis);
				$datasewa = array(
					'uid_transaksi'		=> $result['order_id'],
					'uid_member'		=> $uid_member,
					'uid_kamar'			=> $uid_kamar,
					'uid_durasi'		=> $durasi,
					'tanggal_masuk'		=> $tanggal_masuk,
					'tanggal_keluar'	=> $tanggal_keluar,
					'status'			=> 'booking'
				);
				$data = array(
					'kamar'		=> $kamar,
					'datasewa'	=> $datasewa
				);
				// section transaksi
				$this->db->insert('transaksi', $datapembayaran);
				$this->db->insert('transaksi_detail', $datasewa);
				// section kamar
				$this->kamar_m->updateKamarBookingOrHuni($uid_kamar, $jenis);
				// section keuangan juragan
				$this->keuangan_m->insertKeuangan($kamar['uid_member'], $result['order_id'], ($result['gross_amount'] - $profit), "PENDING", "SALDO_MASUK", "Pembayaran Kost", "");
				$viewData = array(
					'title'				=> "Pembayaran " . $result['order_id'],
					'status'			=> 201,
					'status_message'	=> "Pembayaran pending, Anda belum melakukan pembayaran atau sistem sedang gangguan, silahkan cek di dashboard pembayaran dibawah."
				);
				$this->load->view('_templatepublic/header', $viewData);
				$this->load->view('finish', $viewData);
				$this->load->view('_templatepublic/footer', $viewData);
				break;
			case 200:
				$datapembayaran = $this->_datapembayaran($result, $snapToken, $jenis);
				$datasewa = array(
					'uid_transaksi'		=> $result['order_id'],
					'uid_member'		=> $uid_member,
					'uid_kamar'			=> $uid_kamar,
					'uid_durasi'		=> $durasi,
					'tanggal_masuk'		=> $tanggal_masuk,
					'tanggal_keluar'	=> $tanggal_keluar,
					'status'			=> 'huni'
				);
				// section transaksi
				$this->db->insert('transaksi', $datapembayaran);
				$this->db->insert('transaksi_detail', $datasewa);
				// section kamar
				$this->kamar_m->updateKamarBookingOrHuni($uid_kamar, $jenis);
				// section keuangan juragan
				$this->keuangan_m->insertKeuangan($kamar['uid_member'], $result['order_id'], ($result['gross_amount'] - $profit), "SETTLEMENT", "SALDO_MASUK", "Pembayaran Kost", "");
				$this->keuangan_m->updateSaldoMember($result['gross_amount'], $kamar['uid_member'], "masuk");
				// section profit perusahaan
				$this->keuangan_m->profit($profit);
				$viewData = array(
					'title'				=> "Pembayaran " . $result['order_id'],
					'status'			=> 200,
					'status_message'	=> "Pembayaran berhasil, silahkan cek di dashboard pembayaran dibawah."
				);
				$this->load->view('_templatepublic/header', $viewData);
				$this->load->view('finish', $viewData);
				$this->load->view('_templatepublic/footer', $viewData);
				break;
			default:
		}
	}

	public function pembayaran()
	{
		date_default_timezone_set('Asia/jakarta');
		$uid_transaksi = $this->input->post('uid_transaksi');
		$params = $this->input->post('params');
		$date = date('Y-m-d H:i:s');
		// set profit perusahaan
		$profit = $this->db->get('profit_set')->row_array();
		$profit = $profit['gross_amount'];
		if ($params == 200) {
			// data keuangan
			$keuangan = array(
				'status'		=> "SETTLEMENT",
				'date_updated'	=> $date
			);
			$keuangan = $this->keuangan_m->updatePembayaran($keuangan, $uid_transaksi);
			// data transaksi
			$transaksi = array(
				'status_pembayaran'	=> "SETTLEMENT",
				'waktu_transaksi'	=> $date,
				'status_code'		=> 200
			);
			$transaksi = $this->transaksi_m->updateTransaksi($transaksi, $uid_transaksi);
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
		}
		echo json_encode("error");
	}

	private function _datapembayaran($result, $snapToken, $jenis)
	{
		$minute = 500;
		$time = new DateTime($result['transaction_time']);
		$time->add(new DateInterval('PT' . $minute . 'M'));
		$stamp = $time->format('Y-m-d H:i');
		$data = array();
		if ($result['payment_type'] === "bank_transfer") {
			$data = array(
				'uid_transaksi' 	=> $result['order_id'],
				'id_pembayaran'		=> $result['transaction_id'],
				'jumlah_pembayaran'	=> $result['gross_amount'],
				'jenis'				=> $jenis,
				'status_pembayaran'	=> ($result['status_code'] == 200) ? "SETTLEMENT" : "PENDING",
				'jenis_pembayaran'	=> $result['payment_type'],
				'bank'				=> $result['va_numbers'][0]['bank'],
				'va_number'			=> $result['va_numbers'][0]['va_number'],
				'payment_code'		=> null,
				'reference_number'	=> null,
				'pdf_url'			=> null,
				'waktu_transaksi'	=> $result['transaction_time'],
				'tenggat_pembayaran' => $stamp,
				'status_code'		=> $result['status_code'],
				'snapToken'			=> $snapToken
			);
		} else if ($result['payment_type'] === "gopay") {
			$data = array(
				'uid_transaksi' 	=> $result['order_id'],
				'id_pembayaran'		=> $result['transaction_id'],
				'jenis'				=> $jenis,
				'jumlah_pembayaran'	=> $result['gross_amount'],
				'status_pembayaran'	=> ($result['status_code'] == 200) ? "SETTLEMENT" : "PENDING",
				'jenis_pembayaran'	=> $result['payment_type'],
				'bank'				=> null,
				'va_number'			=> null,
				'payment_code'		=> null,
				'reference_number'	=> null,
				'pdf_url'			=> "https://api.sandbox.midtrans.com/v2/gopay/" . $result['transaction_id'] . "/qr-code",
				'waktu_transaksi'	=> $result['transaction_time'],
				'tenggat_pembayaran' => $stamp,
				'status_code'		=> $result['status_code'],
				'snapToken'			=> $snapToken
			);
		} else if ($result['payment_type'] === "qris") {
			$data = array(
				'uid_transaksi' 	=> $result['order_id'],
				'id_pembayaran'		=> $result['transaction_id'],
				'jenis'				=> $jenis,
				'jumlah_pembayaran'	=> $result['gross_amount'],
				'status_pembayaran'	=> ($result['status_code'] == 200) ? "SETTLEMENT" : "PENDING",
				'jenis_pembayaran'	=> $result['payment_type'],
				'bank'				=> null,
				'va_number'			=> null,
				'payment_code'		=> null,
				'reference_number'	=> null,
				'pdf_url'			=> "https://api.sandbox.midtrans.com/v2/gopay/" . $result['transaction_id'] . "/qr-code",
				'waktu_transaksi'	=> $result['transaction_time'],
				'tenggat_pembayaran' => $stamp,
				'status_code'		=> $result['status_code'],
				'snapToken'			=> $snapToken
			);
		} else if ($result['payment_type'] === "cstore") {
			$data = array(
				'uid_transaksi' 	=> $result['order_id'],
				'id_pembayaran'		=> $result['transaction_id'],
				'jenis'				=> $jenis,
				'jumlah_pembayaran'	=> $result['gross_amount'],
				'status_pembayaran'	=> $result['status_message'],
				'jenis_pembayaran'	=> ($result['status_code'] == 200) ? "SETTLEMENT" : "PENDING",
				'bank'				=> null,
				'va_number'			=> null,
				'payment_code'		=> $result['payment_code'],
				'reference_number'	=> null,
				'pdf_url'			=> $result['pdf_url'],
				'waktu_transaksi'	=> $result['transaction_time'],
				'tenggat_pembayaran' => $stamp,
				'status_code'		=> $result['status_code'],
				'snapToken'			=> $snapToken
			);
		} else if ($result['payment_type'] === "cstpre") {
			$data = array(
				'uid_transaksi' 	=> $result['order_id'],
				'id_pembayaran'		=> $result['transaction_id'],
				'jenis'				=> $jenis,
				'jumlah_pembayaran'	=> $result['gross_amount'],
				'status_pembayaran'	=> ($result['status_code'] == 200) ? "SETTLEMENT" : "PENDING",
				'jenis_pembayaran'	=> $result['payment_type'],
				'bank'				=> null,
				'va_number'			=> null,
				'payment_code'		=> $result['payment_code'],
				'reference_number'	=> null,
				'pdf_url'			=> $result['pdf_url'],
				'waktu_transaksi'	=> $result['transaction_time'],
				'tenggat_pembayaran' => $stamp,
				'status_code'		=> $result['status_code'],
				'snapToken'			=> $snapToken
			);
		}
		return $data;
	}
}
