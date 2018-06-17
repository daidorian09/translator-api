<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* CSRFTokenGenerator Class
* This class generates csrf token and stores it as an session data in order to be hidden input value
*/

class CSRFToken_Generator
{
	function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->library('session');
	}

	/**
	 * It generates csrf token
	 *
	 *
	 * @return void
	 **/
	public function generate_csrf()
	{
		$config = [
    	 "cost" => 10,
    	 "salt" => mcrypt_create_iv(64, MCRYPT_DEV_URANDOM),
		];
		
		$bcrypt  = password_hash("rasmuslerdorf", PASSWORD_BCRYPT, $config);
		$my_csrf_token = hash("sha512",$bcrypt.date("c:A"));

		$csrf_token_session_array = array(
									'smt_csrf_token' => "smt_csrf_token",
									'smt_csrf_hash' => $my_csrf_token
									);

		$this->ci->session->set_userdata($csrf_token_session_array);
	}

	/**
	 * Validate generated csrf token whether it is sent from form page or not.
	 *
	 * @param string csrf token
	 *
	 * @return bool 
	 **/
	public function validate_csrf_token($csrf_token)
	{
			$session_token = $this->ci->session->userdata("smt_csrf_hash");
			if(isset($session_token) && $csrf_token == $this->ci->session->userdata("smt_csrf_hash"))
				return $this->reset_token();
			else
				return false;
	}


	public function reset_token()
	{
				$csrf_token_session_array = array(
									'smt_csrf_token' => "",
									'smt_csrf_hash' => "" );
				$this->ci->session->unset_userdata($csrf_token_session_array);
				return true;
	}
}