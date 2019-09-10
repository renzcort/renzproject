<?php 
  defined('BASEPATH') OR exit('No dirext script access allowed');

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

	  /*This is function to tabs layout */
  function tabs_layout($data) {
    $CI =& get_instance();
    $tabs_id = [];
    $elm = [];
    foreach ($data as $key) {
      $tabs_settings = json_decode($key->tabs_settings);
      if ($tabs_settings) {
	      if (in_array($tabs_settings->id, array_unique($tabs_id))) {
	        $fields[$tabs_settings->id][]   = $key->fields_id;
	        $tabs_title[$tabs_settings->id] = $tabs_settings->title;  
	        $tabs_count[$tabs_settings->id] = $tabs_settings->count;  
	      } else {
	        $fields[$tabs_settings->id][]   = $key->fields_id;
	        $tabs_title[$tabs_settings->id] = $tabs_settings->title;  
	        $tabs_count[$tabs_settings->id] = $tabs_settings->count;  
	      }
	      $tabs_id[]  = $tabs_settings->id;
	    }
    }

    if ($tabs_id) {
	    foreach ($fields as $key => $value) {
	      if (in_array($key, array_unique($tabs_id))) {
	        $elm[] = array(
	          'id'     => $key,
	          'title'  => $tabs_title[$key],
	          'count'  => $tabs_count[$key],
	          'fields' => $value,
	        );
	      }
	    }
    }
    return $elm;
  }

  /**
   * This Is Fuction To Send Email
   */
  function email_send($data, $register=FALSE) {
    $CI =& get_instance();
  	$config_email = $CI->config->item('setting_email');
  	$CI->email->initialize($config_email);
  	$CI->email->from($config_email['smtp_user'], 'Rendi');
  	$CI->email->to($data['email']);

    if ($register == TRUE) {
      $CI->email->subject('Activation Code');
      $msg = '
				<!DOCTYPE html>
				<html>
				<meta charset="utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<head>
					<title>Activation code</title>
				</head>
				<body>
						<div>
							hi, <strong>'.$data['username'].'</strong>
							<p>Welocme to the renzproject, please click link, 
								<a href="'.base_url("admin/activated/?username={$data['username']}&token={$data['token']}").'">
									<i>'.base_url("admin/activated/?username={$data['username']}&token={$data['token']}").'</i>
								</a>
							</p>
						</div>
						<div>
							<p>Enter your activation code '.$data['activation_code'].'</p>
						</div>
				</body>
					</html>
      ';
    } else {
      $CI->email->subject('Reset Password');
      $msg = '
				<!DOCTYPE html>
				<html>
				<meta charset="utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<head>
				  <title>Activation code</title>
				</head>
				<body>
				    <div>
				      hi, <strong>'.$data['username'].'</strong>
				      <p>Welcome to the renzproject, please click link, 
				        <a href="'.prep_url(base_url("admin/reset-password/?email={$data['email']}&forgotten_password_code={$data['forgotten_password_code']}")).'">
				          <i>'.base_url("admin/reset-password/?email={$data['email']}&forgotten_password_code={$data['forgotten_password_code']}").'</i>
				        </a>
				      </p>
				    </div>
				    <div>
				      <p>Enter your activation code '.$data['activation_code'].'</p>
				    </div>
				</body>
				</html>
      ';
    }
    $CI->email->message($msg);  
    if ($CI->email->send()) {
      helper_log('email', "Send Email {$data['email']} successfully");
      log_message('info', 'Send Email OK');
      return TRUE;
    } else {
      echo $CI->email->print_debugger();
    } 
  }

?>