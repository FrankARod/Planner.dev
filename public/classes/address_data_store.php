<?php
require('../inc/filestore.php');
class AddressDataStore extends Filestore {
	public function save_file($address_book) {	
		$this->write($address_book);
	}
	public function read_file() {
		return $this->read();
	}
}