<?php

	require_once('./app/database.class.php');

	class Config {
		private $db;

		function __construct() {
			$this->db = new Database();
		}

		// Returns a string value by path. If string does not exist, false is returned
		function get_string($path) {
			$stmt = $this->db->ado->Prepare('SELECT value FROM strings WHERE path=' . $this->db->ado->Param('p') . '');
			$result = $this->db->ado->GetOne($stmt, $path);
			if($result == null)
				return false;
			return $result;
		}

		function set_string($path, $value) {
			$stmt = $this->db->ado->Prepare('REPLACE INTO strings (path, value) VALUES(' . $this->db->ado->Param('p') .
											', ' . $this->db->ado->Param('v') . ')');
			$result = $this->db->ado->Execute($stmt, array($path, $value));
			return $result;
		}

		function delete_string($path) {
			$stmt = $this->db->ado->Prepare('DELETE FROM strings WHERE path=' . $this->db->ado->Param('p'));
			$result = $this->db->ado->Execute($stmt, $path);
			return $result;
		}

		function get_array($path) {
			$stmt = $this->db->ado->Prepare('SELECT value FROM arrays WHERE path=' . $this->db->ado->Param('p'));
			$result = $this->db->ado->GetOne($stmt, $path);
			if($result !== false && $result != null) {
				return unserialize($result);
			} else {
				return false;
			}
		}

		public function delete_array_value($path, $value) {
			$this->db->ado->StartTrans();
			$old = $this->get_array($path);
			$new = array();
			foreach($old as $o) {
				if($o != $value) {
					$new[] = $o;
				}
			}
			$this->set_array($path, $new);
			$this->db->ado->CompleteTrans();
		}

		function set_array($path, $value) {
			$stmt = $this->db->ado->Prepare('REPLACE INTO arrays (path, value) VALUES(' . $this->db->ado->Param('p') .
											', ' . $this->db->ado->Param('v') . ')');
			$result = $this->db->ado->Execute($stmt, array($path, serialize($value)));
			return $result;
		}

		function delete_array($path) {
			$stmt = $this->db->ado->Prepare('DELETE FROM arrays WHERE path=' . $this->db->ado->Param('p'));
			$result = $this->db->ado->Execute($stmt, $path);
			return $result;
		}

	}

?>