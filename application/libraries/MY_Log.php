<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Logging Class with catalog and sub_directories supported
 *
 * Usage:  Change the catalogs config in application/config.php
 * $config['mylog_cats']= array('CAT1','CAT2','CAT3'); 
 * $config['mylog_sub_directories']= true;
 * Note: 1. Leaving this array blank will log ALL catalogs
 * 		 2. Without setting 'mylog_cats; will default to use standard
 * 		 log threshold config item
 * 		 3. The log file will be saved to different directories under
 * 		 log_path which will be named "pathname-catname-date('Y-m-d')-EXT"
 * 		 4.  mylog_sub_directories can works even "mylog_cats" is not set
 * 
 * Then you can use log_message("CAT1", "messages logged"); in you codes.
 * 
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Logging
 * @author		Allenji@Tencent
 * @link		Based on the version http://codeigniter.com/wiki/MY_Log/

 */
class MY_Log extends CI_Log {

	/**
	 * Constructor
	 */
	public function __construct()
	{
	    parent::__construct();
        $config =& get_config();
        
        if (isset ($config['mylog_cats']))
        {
            $mylog_cats=$config['mylog_cats'];
        }
        else
        {
            $mylog_cats="";
        }
        $this->_enable_sub_directory = isset ($config['mylog_sub_directories']) ? $config['mylog_sub_directories'] : false;
        $this->log_path = ($config['log_path'] != '') ? $config['log_path'] : APPPATH.'logs/';
        
        if ( ! is_dir($this->log_path) OR ! is_really_writable($this->log_path))
        {
            $this->_enabled = FALSE;
        }
        if (is_array($mylog_cats))
        {
            $this->_logging_array = $mylog_cats;            
        }
        if (is_numeric($config['log_threshold']))
        {
            $this->_threshold = $config['log_threshold'];
        }    
        if ($config['log_date_format'] != '')
        {
            $this->_date_fmt = $config['log_date_format'];
        }
	}

	// --------------------------------------------------------------------

	/**
	 * Write Log File
	 *
	 * Generally this function will be called using the global log_message() function
	 *
	 * @param	string	the error level
	 * @param	string	the error message
	 * @param	bool	whether the error is a native PHP error
	 * @return	bool
	 */
	public function write_log($level = 'error', $msg, $php_error = FALSE)
	{
        if ($this->_enabled === FALSE)
        {
            return FALSE;
        }
        $level = strtoupper($level);
        
        if (isset($this->_logging_array))
        {
            if ((! in_array($level, $this->_logging_array)) && (! empty($this->_logging_array)))
            {
                return FALSE;
            }
        }
        else 
        {
            if ( ! isset($this->_levels[$level]) OR ($this->_levels[$level] > $this->_threshold))
            {
                return FALSE;
            }
        }
		if ($this->_enable_sub_directory) {
			if (!@is_dir($this->log_path. $level)) {
				@mkdir($this->log_path. $level, 0777);
			}
			$filepath = $this->log_path. $level . '/log-'.date('Y-m-d').EXT;
		} else {
        	$filepath = $this->log_path.'log-'.date('Y-m-d').EXT;
		}
        $message  = '';
        //echo $filepath;echo "333";exit;
        
        if ( ! file_exists($filepath))
        {
            $message .= "<"."?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?".">\n\n";
        }
            
        if ( ! $fp = @fopen($filepath, FOPEN_WRITE_CREATE))
        {
            return FALSE;
        }

        $message .= date($this->_date_fmt). ' --> '.$msg."\n";
        
        flock($fp, LOCK_EX);    
        fwrite($fp, $message);
        flock($fp, LOCK_UN);
        fclose($fp);
    
        @chmod($filepath, FILE_WRITE_MODE);         
        return TRUE;
	}

}
// END Log Class

/* End of file MY_Log.php */
/* Location: ./application/libraries/MY_Log.php */