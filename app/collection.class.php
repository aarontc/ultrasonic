<?php

	require_once('./app/database.class.php');
	require_once('./app/config.class.php');

	class Collection {
		public $path;
		public $id;

		function __construct($id = null) {
			if($id != null) {
				$this->id = $id;
				$db = new Database();
				$s = $db->ado->Prepare('SELECT path FROM collection WHERE id=' . $db->ado->Param('id'));
				$result = $db->ado->GetOne($s, $id);
				if($result === false)
					throw new Exception("Requested collection does not exist");
				else
					$this->path = $result;
			} else {
				$this->id = null;
			}
		}

		// Responsible for validating that the path is readable
		// Maybe in the future, look for at least one readable file too
		function validate_path() {
			return is_dir($this->path);
		}

		function save() {
			$db = new Database();
			if($this->id == null) {
				$s = $db->ado->Prepare('INSERT INTO collection (path) VALUES(' . $db->ado->Param('p') . ')');
				return $db->ado->Execute($s, $this->path);
			} else {
				$s = $db->ado->Prepare('UPDATE collection SET path=' . $db->ado->Param('path') . ' WHERE id=' . $db->ado->Param('id'));
				return $db->ado->Execute($s, $this->path, $this->id);
			}
		}

		function scan() {
			$dirs = array();
			$dirs[] = $this->path;

			while(count($dirs) > 0) {
				$dir = $dirs[0];
				$d = opendir($dir);
				while(false !== ($entity = readdir($d))) {
					if($entity != '.' && $entity != '..') {
						if(is_dir($dir . '/' . $entity)) {
							$dirs[] = $dir . '/' . $entity;
						} else {
							////////// file processing
							//Prepare('INSERT INTO song(
							print_r($entity);
						}
					}
				}
				closedir($d);
				array_splice($dirs, 0, 1);
			}
		}

		function dirTree($dir) {
			$arDir = array();
			$d = dir($dir);
			while (false !== ($entry = $d->read())) {
				if($entry != '.' && $entry != '..' && is_dir($dir.'/'.$entry))
					$arDir[$entry] = self::dirTree($dir.'/'.$entry);
			}

			$d->close();
			return $arDir;
		}

		function printTree($array, $level=0) {
			foreach($array as $key => $value) {
				echo "<div class='dir' style='width: ".($level*20)."px;'>&nbsp;</div>".$key."<br/>\n";
				if(is_array($value))
					self::printTree($value, $level+1);
			}
		}

	}

?>