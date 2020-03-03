<?php
class Model_sms extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	//=================================================================
	// SEND SMS
	//=================================================================
	function sendMessage($dest, $date, $message) {
		$self = $this->load->database('lokal',TRUE);
		$data = array (
				'InsertIntoDB' => date('Y-m-d H:i:s'),
				'SendingDateTime' => $date,
				'DestinationNumber' => $dest,
				'Coding' => 'Default_No_Compression',
				'TextDecoded' => $message,
				'CreatorId' => 'gilar'
					);
		$self->insert('outbox',$data);		
	}
	function insertOutbox($dest, $date, $message,$jumlah) {
		$self = $this->load->database('lokal',TRUE);
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
		$self->insert('outbox',$data);		
	}
	function getLastOutboxID() {
		$self = $this->load->database('lokal',TRUE);
		$sql = "select max(ID) as value from outbox";
		return $self->query($sql);	
	}
	function insertOutboxMultipart($outboxid, $message, $pos,$jumlah) {
		$self = $this->load->database('lokal',TRUE);
		$code = $pos+1;
		$data = array (
				'ID' => $outboxid,
				'UDH' => '050003D3'.$jumlah.'0'.$code,
				'SequencePosition' => $code,
				'Coding' => 'Default_No_Compression',
				'TextDecoded' => $message,
					);	
		$self->insert('outbox_multipart',$data);						
	}

}