<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Languages Model Class
 *
 * This  model is responsible for languages-table related operations
 *
 * @author Yiğit At 
 *
 **/
class Language extends CI_Model
{

	/**
	 * Get number of avaliable languages
	 * 
	 * @return int number of languages
	 **/
	public function count_languages()
	{	
		$count = 0;
		$sql = $this->db->query("select * from languages l");
		$count = $sql->num_rows();
		return $count;
	}

	/**
	 * Get all avaliable languages within defined database
	 * 
	 * @return object language array
	 **/
	public function get_languages()
	{
		$sql = $this->db->query("select * from languages l");
        foreach($sql->result() as $rows)
        {
         	$language_data[] = $rows;
        }
        return $language_data;
	}

	/**
	 * Get all avaliable languages within defined database
	 * 
	 * @return object language array
	 **/
	public function get_language_abbr($language_id)
	{
		$language_data = null;
		$sql = $this->db->query("select l.abbr from languages l where l.id = ?",array($language_id));
        foreach($sql->result() as $rows)
        {
         	$language_data = $rows->abbr;
        }
        return $language_data;
	}

	/**
	 * Validate language for translation
	 * 
	 * @return object language array
	 **/
	public function validate_language_existence($language_id)
	{
		$language_data = 0;
		$sql = $this->db->query("select count(*) as language_found from languages l where l.id = ?",array($language_id));
        foreach($sql->result() as $rows)
        {
         	$language_data += (int) $rows->language_found;
        }
        return $language_data;
	}


}



?>

