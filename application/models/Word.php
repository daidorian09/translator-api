<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Word Model Class
 *
 * This  model is responsible for words-table related operations
 *
 * @author Yiğit At 
 *
 **/
class Word extends CI_Model
{
	/**
	 * Retrieves the list of translations of a value
	 *
	 *
	 * @return array object Word
	 **/
	public function search_words_for_translation($word,$from,$to)
	{
		$words_array[] = null;
		$this->db->cache_on() ;
		$sql = $this->db->query("select count(*) as word_found, w.translated_name as translated_word from words w where substring(w.name,1) = ? and w.language_source = ? and w.language_target = ? limit 1", array($word,$from,$to));
		foreach($sql->result() as $rows)
        {
        	$words_array = $rows->word_found == 1  ?  array('word' => $word, 'translated_word' => $rows->translated_word) : array("word_untranslated" => true, "word" => $word);
        }
        return $words_array;
	}
	/**
	 * Get list of untranslated words from language to another
	 * 
	 * @return array object Word
	 **/
	public function get_waited_words($from,$to)
	{
		$untranslated_words_array[] = null;
		$sql = $this->db->query("select w.name as untranslated from words w where w.language_source= ? and w.language_target = ? and w.translated_name is null", array($from,$to));
		foreach($sql->result() as $rows)
        {
         	$untranslated_words_array[] = array('message' => 'Undefined word','untranslated' => $rows->untranslated);
        }
        return $untranslated_words_array;
	}

}




?>

