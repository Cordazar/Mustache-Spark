<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
require_once '../vendor/Mustache.php';
*/

/**
 * Implementation of the Mustache template system for CodeIgniter
 */
class Mustache_spark
{

	private $master_template;
	private $template_collection;
	private $data_collection;
	private $template_file_extension;
	private $spark_path;
	
	/**
	 * Constructor
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
        $this->spark_path = dirname(__FILE__) . '/';
		// Setting standard file extension to 'tpl' to reinforce
		// that mustache templates doesn't need php code in them
		$this->template_file_extension = 'tpl';
		$this->data_collection = array();
		$this->template_collection = array();
		$this->CI =& get_instance();
		log_message('debug', "Mustache Class Initialized");
	}

	/**
	 * Get template file if it exists.
	 *
	 * @access private
	 * @param string $template
	 */
	private function get_include_contents($template)
	{
		// Build file path based on CI's structure
		$file_path = APPPATH.'views/'.$template.'.tpl';
		if ( is_file($file_path) )
		{
			ob_start();
			include($file_path);
			$contents = ob_get_contents();
			ob_end_clean();
			return $contents;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Render everything to CodeIgniters output, once is enough
	 *
	 * @access public
	 * @return void
	 */
	public function render()
	{
		$vendor_library_path = $this->spark_path . '../vendor/Mustache.php';
		if(file_exists($vendor_library_path))
		{
			require_once($vendor_library_path);
		}
		else
		{
			return false;
		}
		$mustache = new Mustache;
		$this->CI->output->append_output(
			$mustache->render(
				$this->master_template,
				$this->data_collection,
				$this->template_collection
			)
		);
	}

	/**
	 * Get data
	 *
	 * @access public
	 * @return array
	 */
	public function get_data()
	{
		return $this->data_collection;
	}

	/**
	 * Merge data into total data array
	 *
	 * @access public
	 * @param array $module_data
	 * @return void
	 */
	public function merge_data($module_data)
	{
		$this->data_collection = array_merge_recursive(
			$this->data_collection,
			$module_data
		);
	}
	
	/**
	 * Set master template
	 * 
	 * @access public
	 * @param string $template
	 * @return void
	 */
	public function set_master_template($template)
	{
		$this->master_template = self::get_include_contents($template);
	}
	
	/**
	 * Merge templates into the total template array
	 * 
	 * @access public
	 * @param array $mustache_templates
	 * @return boolean
	 */
	public function merge_template($mustache_templates)
	{
		foreach($mustache_templates as $partial => $template_file_name)
		{
			$template = self::get_include_contents($template_file_name);
			if ( $template )
			{
				if ( isset($this->template_collection[$partial]) )
				{
					$this->template_collection[$partial] .= $template;
				}
				else
				{
					$this->template_collection[$partial] = $template;
				}
			}
		}
	}

	/**
	 * Set template file extension
	 *
	 */
	 public function set_template_file_extension($file_extension) {
		 $this->template_file_extension = $file_extension;
	 }

}
