<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';
//Google Translate API
require 'vendor/autoload.php';


// Rest Library
use Restserver\Libraries\REST_Controller;
// API library
use Stichoza\GoogleTranslate\TranslateClient;


/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * This class is required to operate all rest-related actions that are  going to
 *  be requested by users. 
 *
 *
 */
class MemoryService extends REST_Controller 
{
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Language');
        $this->load->model('Translated_Sentence');
        $this->load->model('Word');
        $this->load->library("CSRFToken_Generator");

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        /*$this->methods['users_get']['limit'] = 500; 
        $this->methods['users_post']['limit'] = 100; 
        $this->methods['users_delete']['limit'] = 50;*/
    }

    /**
     * Display waited words to be translated
     *
     *
     * @return void
     **/
    public function waited_get()
    {
        $language_source = (int) $this->input->get("language_from",true);
        $language_target = (int) $this->input->get("language_to",true);
        $csrf = $this->input->get("smt_csrf_token",true);

        if($this->validate_csrf($csrf))
        {
             if($this->validate_language($language_source, $language_target))
             {
                 $data[] = null;
                 $data = $this->Word->get_waited_words($language_source,$language_target);
                 $this->display_word(array_filter($data));
             }
        }
    }

    /**
     * Search translated definitons of sentence
     *
     * @return void
     **/
    public function value_get()
    {
        $language_source = (int) $this->input->get("sentence_from",true);
        $language_target = (int) $this->input->get("sentence_to",true);
        $sentence = $this->input->get("sentence",true);
        $csrf = $this->input->get("smt_csrf_token",true);

         if($this->validate_csrf($csrf))
         {
            if($this->validate_language($language_source, $language_target))
             {
                $parsed_sentence = preg_split('/[.?!\s]+/',$sentence, -1, PREG_SPLIT_NO_EMPTY);
                $data[] = null;
                foreach ($parsed_sentence as $key => $value) 
                {
                    if($this->Word->search_words_for_translation($value, $language_source, $language_target) != null)
                    $data[] = $this->Word->search_words_for_translation($value, $language_source, $language_target);
                }
                $this->display_word(array_filter($data));
            }
        }
    }

    /**
    * Display retrieved word data from database
    *
    * @param data object word model array
    *
    * @return void
    **/
    public function display_word($data)
    {
        if(empty($data))
             $this->response([
            'status' => FALSE,
            'message' => 'No words are found'
            ], REST_Controller::HTTP_NOT_FOUND);
        else
         $this->response($data,REST_Controller::HTTP_OK);
    }


    /**
     * Validate whether sentence is already translated or not
     *
     *
     * @return void
     **/
    public function value_post()
    {

         $language_source= (int) $this->input->post("sentence_from",true);
         $language_target = (int) $this->input->post("sentence_to",true);
         $sentence = $this->input->post("sentence",true);
         $csrf = $this->input->post("smt_csrf_token",true);

         if($this->validate_csrf($csrf))
         {
             if($this->validate_language($language_source, $language_target))
             {
                $data = array(
                'source_id' => $language_source,
                'target_id' => $language_target,
                'sentence' => $sentence);
                $this->display_translation_result($data);
             }
             else
             {
                    $this->response([
                    'status' => FALSE,
                    'message' => 'No languages are found.'
                ], REST_Controller::HTTP_BAD_REQUEST);
             }
        }
    }

    /**
     * Obtain sentence and prepare for translation
     *
     *
     * @return void
     **/

    public function translate_post()
    {
         $language_source = (int) $this->input->post("sentence_from",true);
         $language_target = (int) $this->input->post("sentence_to",true);
         $sentence = $this->input->post("sentence",true);
         $csrf = $this->input->post("smt_csrf_token",true);



         if($this->validate_csrf($csrf))
         {
            if($this->validate_language($language_source, $language_target))
             {
                $language_array = array(
                'source' => $language_source,
                'target' => $language_target);
                foreach ($language_array as $key => $value) 
                {
                    $language_array[] = $this->Language->get_language_abbr($value);
                }

                $sentence_translation_data = array(
                'sentence' => $sentence,
                'source' => $language_array[0],
                'target'=> $language_array[1],
                'source_id' => $language_source,
                'target_id' => $language_target
                );

                $this->display_translation_result($sentence_translation_data);
                $this->set_translation_process($sentence_translation_data);

            }   
        }
    }


    /**
     * Attempt to sentence translation
     *
     * @return  void
     **/

    public function set_translation_process($sentence_data)
    {
        if($this->Translated_Sentence->validate_translated_sentence($sentence_data))
        $this->response([
        'status' => false,
        'message' => 'Sentence is already translated'
        ], REST_Controller::HTTP_CONFLICT);
        else
         $this->complete_translation($sentence_data);

    }

    /**
     * Attemp to insert sentence into database
     *
     * @return void
     **/

    public function complete_translation($data)
    {
        
         //Google API Class
         $google_api = new TranslateClient(); 
         $google_api->setSource($data["source"]); 
         $google_api->setTarget($data["target"]);

         $translated_sentence = $google_api->translate($data["sentence"]);

         $translated_sentence_array = array(
        'sentence' => $data["sentence"],
        'source'  => $data["source_id"],
        'target' => $data["target_id"],
        'sentence_translated' => $translated_sentence);
        
         $this->Translated_Sentence->translate_sentence($translated_sentence_array);
         $this->response([
                    'status' => true,
                    'message' => 'Sentence is translated',
                    'translation' => $translated_sentence
                    ], REST_Controller::HTTP_CREATED);
    }



    /**
    * Validate languages sent by user
    *
    * @param source int native language
    * @param target int language that is used for translation
    *
    * @return void
    **/
    public function validate_language($source, $target)
    {
        $language_count = 0;

        $language_array = array(
        'source' => $source,
        'target' => $target);
        foreach ($language_array as $key => $value) 
        {
            $language_count += $this->Language->validate_language_existence($value);
        }

         return $language_count == 2 ? true : false;
    }

    /**
     * Validate generated CSRF Token
    *
    * @param csrf string sha512 encoded csrf token
    *
    * @return void
     **/
    public function validate_csrf($csrf)
    {
        if(!$this->csrftoken_generator->validate_csrf_token($csrf))
              $this->response([
                    'status' => FALSE,
                    'message' => 'Request is not permitted'
                ], REST_Controller::HTTP_FORBIDDEN);
          else
            return true;

    }

    /**
     * Display whether sentence is already translated or required to be translated
     *
     * @param data object sentence data array
     *
     * @return void
     **/
    public function display_translation_result($data)
    {
        if($this->Translated_Sentence->validate_translated_sentence($data))
         $this->response([
                    'status' => false,
                    'message' => 'Sentence is already translated'
                ], REST_Controller::HTTP_CONFLICT);
         else
          $this->response([
                    'status' => true,
                    'message' => 'Sentence is required to be translated'
                ], REST_Controller::HTTP_OK);
    }

}
