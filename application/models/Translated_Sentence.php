<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Translatedsentence Model Class
 *
 * This model is responsible for translatedsentences-table related operations
 *
 * @author Yiğit At 
 **/
class Translated_Sentence extends CI_Model
{
	/**
	* FullTEXT search for sentence verification
	*
	* @return bool
	*/
	public function validate_translated_sentence($sentence)
	{
		$sql = $this->db->query("select * from translatedsentences ts where binary ts.sentence = ? and ts.source = ? and ts.target= ?", array($sentence["sentence"], $sentence["source_id"], $sentence["target_id"]));

		$is_translated = $sql->num_rows() == 1 ? true : false;

		return $is_translated;
	}

	/**
	 * Display translated  sentences for users' interest
	 * 
	 * @return array
	 **/
	public function display_translated_sentences()
	{
		$this->db->cache_on();
		$sql = $this->db->query("select ts.sentence,ts.sentence_translated from translatedsentences ts order by rand() limit 15");
        foreach($sql->result() as $rows)
        {
         	$translated_array[] = $rows;
        }
        return $translated_array;
	}

	/**
	 * Get number of translated sentences
	 * 
	 * @return int number of languages
	 **/
	public function count_translated_sentences()
	{
		$count = 0;
		$sql = $this->db->query("select * from translatedsentences ts");
		$count = $sql->num_rows();
		return $count;
	}

	/**
	 * Insert translated sentence into table
	 * 
	 * @return bool 
	 **/
	public function translate_sentence($translated_sentence_array)
	{
		 $this->db->insert("translatedsentences",$translated_sentence_array);
	}
}



?>

