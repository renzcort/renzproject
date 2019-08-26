<?php 
	defined('BASEPATH') OR exit('No direct script allowed');

	/*function for merger array values*/
	function array_merge_value($key, $data) {
    $CI =& get_instance();
		$result = array();
		foreach ($data as $val) {
			if (array_key_exists($key, $val)) {
				$result[$val[$key]][] = $val;
			} else {
				$result[""][] = $val;
			}
		}
		return $result;
	} 
?>