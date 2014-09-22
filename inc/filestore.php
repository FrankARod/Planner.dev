<?php

class Filestore {

		public $filename = '';

		function __construct($filename = '')
		{
				$this->filename = $filename;
		}

		/**
			* Returns array of lines in $this->filename
		*/
		function read_lines()
		{
			$handle = fopen($this->filename, 'r');
			$list = fread($handle, filesize($this->filename));
			fclose($handle);
			return explode(PHP_EOL, $list);
		}

		/**
			* Writes each element in $array to a new line in $this->filename
		*/
		function write_lines($array)
		{
		 	$handle = fopen($this->filename, 'w');
			$list = implode(PHP_EOL, $array);
			fwrite($handle, $list);
			fclose($handle);
		}

		/**
			* Reads contents of csv $this->filename, returns an array
			*/
		function read_csv()
		{
			if (filesize($this->filename) == 0) {
				$address_book = [];
			} else {
				$handle = fopen($this->filename, 'r');
				while(!feof($handle)) {
					$row = fgetcsv($handle);
					if (!empty($row)) {
						$address_book[] = $row;
					}
				}
				fclose($handle);
			}
			return $address_book;
		}

		/**
			* Writes contents of $array to csv $this->filename
			*/
		function write_csv($array)
		{
			$handle = fopen($this->filename, 'w');
			foreach ($array as $key => $value) {
				fputcsv($handle, $value);
			}
			fclose($handle);
		}

}