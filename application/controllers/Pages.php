<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Pages Class
 *
 * This class responsible for front-end operations
 *
 * @author Yiğit At
 **/


class Pages extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("Language");
        $this->load->model('Translated_Sentence');
        $this->load->model('Word');	
        $this->load->library("CSRFToken_Generator");
	}


	public function Index()
	{
		$data["count_languages"] = $this->Language->count_languages();
		$data["count_translated_sentences"] = $this->Translated_Sentence->count_translated_sentences();
		$data["translated_sentences"] = $this->Translated_Sentence->display_translated_sentences();
		$this->load->view("includes/Header");
		$this->load->view("Index",$data);
		$this->load->view("includes/Footer");
	}


	public function WordSearch()
	{
		$data["language_content"] = $this->Language->get_languages();
		$this->csrftoken_generator->generate_csrf();
		$this->load->view("includes/Header");
		$this->load->view("WordSearch",$data);
		$this->load->view("includes/Footer");
	}

	public function WaitedWords()
	{
		$data["language_content"] = $this->Language->get_languages();
		$this->csrftoken_generator->generate_csrf();
		$this->load->view("includes/Header");
		$this->load->view("WaitedWords",$data);
		$this->load->view("includes/Footer");
	}

	public function ValidateSentence()
	{
		$data["language_content"] = $this->Language->get_languages();
		$this->csrftoken_generator->generate_csrf();
		$this->load->view("includes/Header");
		$this->load->view("ValidateSentence",$data);
		$this->load->view("includes/Footer");
	}


	public function TranslateSentence()
	{
		$data["language_content"] = $this->Language->get_languages();
		$this->csrftoken_generator->generate_csrf();
		$this->load->view("includes/Header");
		$this->load->view("TranslateSentence",$data);
		$this->load->view("includes/Footer");
	}

	public function Error()
	{
		$this->load->view("includes/Header");
		$this->load->view("errors/Error");
		$this->load->view("includes/Footer");
	}



	public function search()
	{
		$data = $this->Word->tests();
		var_dump($data);

	}


	public function sentence_parser()
	{

		$tr = new TranslateClient('en', 'tr');
	$tr = new TranslateClient(); // Default is from 'auto' to 'en'
	$tr->setSource('en'); // Translate from English
	$tr->setTarget('tr');
	echo $tr->translate('I know you and you know me Tell me what is you want it to be');
		/*$form_sentence = "Bülent nerdeydin sen honey aint showed up";
		$parsed_sentenced = preg_split('/\s+/', $form_sentence);
		$eng = 2;
		$tr = 1;

		foreach ($parsed_sentenced as $key => $value) 
		{
			if($this->Memory_Translator->search_words_for_translation($value,$eng,$tr) != null)
			{
				$data = $this->Memory_Translator->search_words_for_translation($value,$eng,$tr);
				var_dump($data);
			}
			
		}*/


		

		
		/*foreach ($data as $key => $value) 
		{
			var_dump($key." ".$value);
		}*/

		



	}
	public function x()
	{
		var_dump($this->input->post());
	}
}