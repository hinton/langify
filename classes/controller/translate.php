<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Translate Controller
 *
 * @package    Translate
 * @author     Copy112
 */
class Controller_Translate extends Controller_Template {
	
	public $template = 'translate/template';
	
	public $title = 'Undefined';
	
	function before()
	{
		parent::before();
		
		$this->template->bind('title', $this->title);
		
	}
	
	
	function action_index()
	{
		
		$this->title = 'Index';
		$this->template->content = View::factory('translate/index')
			->bind('languages', $languages);
		
		$languages = Sprig::factory('translate_language')->load(NULL, NULL);
		
		
		// Uncomment this line if you want to import a language file.
		// $this->import('en', FALSE);
		
	}
	
	function action_view($lang, $id = FALSE)
	{
		
		// Check if someone submited a form
		/*if ( isset ( $_POST['id'] ) ) {
			
			$post = Sprig::factory('translate_string', array('id' => security::xss_clean($_POST['id']) ))
				->load();
			
			$post->values( array(
				'string' => security::xss_clean($_POST['string']),
			));
			
			/*$post = Sprig::factory('translate_string', array(
				//'id' => security::xss_clean($_POST['id']),
				'string' => security::xss_clean($_POST['string']),
			));
			
			try
			{
				$post->update();
			}
			catch (Validate_Exception $e)
			{
				// print_r( $e->array );
			}
			
		} */
		
		print_r($_POST);
		
		$this->title = 'View';
		$this->template->content = View::factory('translate/view')
			->bind('language', $language)
			->bind('strings', $string_return)
			->bind('keys', $keys);
		
		// Load the language and strings from the database
		$language = Sprig::factory('translate_language', array('file' => $lang))->load();
		$strings = Sprig::factory('translate_string', array('language_id' => $language->id))->load(NULL, NULL);
		$keys = Sprig::factory('translate_key')->load(NULL, NULL);
		
		
		$string_return = array();
		
		// Assign all language strings to an array with the key_id as key.
		foreach ($strings as $string)
		{
			$string_return[$string->translate_key_id] = array( 
				'string' => $string->string,
				'id' => $string->id,
			);
		}
		
	}
	
	function action_import($password = '')
	{
		if ($password != Kohana::config('translate.password')) {
			die('Wrong Login info');
		}
		
		
	}
	
	function action_export($password = '')
	{
		if ($password != Kohana::config('translate.password')) {
			die('Wrong Login info');
		}
		
		
	}
	
	/**
	 * Imports a language file into the db to allow translations
	 * @return 
	 */
	private function import($file = 'en', $import_keys = TRUE)
	{
		
		// Retrive the id of the wanted language
		$language_id = Sprig::factory('translate_language', array('file' => $file))->load();
		
		// Load the translation file
		$lang = I18n::load($file);
		
		// Import the key's into the key table
		if ($import_keys) {
			
			foreach ($lang as $key => $value)
			{
				
				$keys = Sprig::factory('translate_key', array(
					'key' => $key,
				));
				
				$keys->create();
				
			}
			
		}
		
		// Import the lang strings into string table
		foreach ($lang as $key => $value)
		{
			
			$key_id = Sprig::factory('translate_key', array( 'key' => $key ))->load();
			
			$strings = Sprig::factory('translate_string', array(
				'language_id' => $language_id->id,
				'key_id'      => $key_id->id,
				'string'      => $value,
			));

			$strings->create();
			
		}
		
		
	}
	
	/**
	 * Perse strings for a language into a download able language file
	 * @return 
	 */
	private function export()
	{
		
	}
	
}