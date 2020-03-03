<?php
class Model_sms extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	//=================================================================
	// SEND SMS
	//=================================================================
	function sendMessage($dest, $date, $message) {
		$data = array (
				'InsertIntoDB' => date('Y-m-d H:i:s'),
				'SendingDateTime' => $date,
				'DestinationNumber' => $dest,
				'Coding' => 'Default_No_Compression',
				'TextDecoded' => $message,
				'CreatorId' => 'gilar'
					);
		$this->db->insert('outbox',$data);		
	}
	function insertOutbox($dest, $date, $message,$jumlah) {	
		$data = array (
				'InsertIntoDB' => date('Y-m-d H:i:s'),
				'SendingDateTime' => $date,
				'DestinationNumber' => $dest,
				'MultiPart' => 'true',
				'UDH' => '050003D3'.$jumlah.'01',
				'Coding' => 'Default_No_Compression',
				'TextDecoded' => $message,
				'CreatorId' => 'gilar'
					);
		$this->db->insert('outbox',$data);		
	}
	function getLastOutboxID() {
		$sql = "select max(ID) as value from outbox";
		return $this->db->query($sql);	
	}
	function insertOutboxMultipart($outboxid, $message, $pos,$jumlah) {
		$code = $pos+1;
		$data = array (
				'ID' => $outboxid,
				'UDH' => '050003D3'.$jumlah.'0'.$code,
				'SequencePosition' => $code,
				'Coding' => 'Default_No_Compression',
				'TextDecoded' => $message,
					);	
		$this->db->insert('outbox_multipart',$data);						
	}

}