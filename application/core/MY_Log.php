<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class MY_Log extends CI_Log {
     
    protected $_enabled = TRUE;
    protected $_date_fmt = 'Y-m-d H:i:s';
    protected $_levels = array(
        'ERROR' => 1,
        'DEBUG' => 2,
        'APP_USER'  => 3,
        'APP_ADMIN'  => 4,
        'COMMON'  => 5,
        'INFO'  => 6,
        'ALL'   => 7,
    );
	
	public $_date_utc;
	public $_utcDate;
	public $_utcTime;
	public $_seoulTime;
     
    public function __construct()
    {
        parent::__construct();
		
		##########################################
		##		UTC & Asia/Seoul Time SET		##
		##########################################
		$this->_date_utc = new \DateTime("now", new \DateTimeZone("UTC"));
		$this->_utcDate = $this->_date_utc->format('Y-m-d');
		$this->_utcTime = $this->_date_utc->format('Y-m-d H:i:s');
		$this->_seoulTime = date("Y-m-d H:i:s" , strtotime($this->_utcTime."+9 hours"));
    }
	
	public function write_log($level, $msg)
	{
		if ($this->_enabled === FALSE)
		{
			return FALSE;
		}

		$level = strtoupper($level);
		
		if($this->_levels[$level] == '3') { 
			$this->_log_path = APPPATH.'logs/app_user/';
		} else if($this->_levels[$level] == '4') { 
			$this->_log_path = APPPATH.'logs/app_adm/';
		} else if($this->_levels[$level] == '5') { 
			$this->_log_path = APPPATH.'logs/common/';
		}

		if (( ! isset($this->_levels[$level]) OR ($this->_levels[$level] > $this->_threshold))
			&& ! isset($this->_threshold_array[$this->_levels[$level]]))
		{
			return FALSE;
		}

		$filepath = $this->_log_path.'log-'.$this->_utcDate.'.'.$this->_file_ext;
		$message = chr(13).chr(10);

		if ( ! file_exists($filepath))
		{
			$newfile = TRUE;
			// Only add protection to php files
			if ($this->_file_ext === 'php')
			{
				$message .= "<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>\n\n";
			}
		}

		if ( ! $fp = @fopen($filepath, 'ab'))
		{
			return FALSE;
		}

		flock($fp, LOCK_EX);

		// Instantiating DateTime with microseconds appended to initial date is needed for proper support of this format
		if (strpos($this->_date_fmt, 'u') !== FALSE)
		{
			$microtime_full = microtime(TRUE);
			$microtime_short = sprintf("%06d", ($microtime_full - floor($microtime_full)) * 1000000);
			$date = new DateTime(date('Y-m-d H:i:s.'.$microtime_short, $microtime_full));
			$date = $date->format($this->_date_fmt);
		}
		else
		{
			$date = date($this->_date_fmt);
		}

		$message .= $this->_format_line2($level, $msg);

		for ($written = 0, $length = self::strlen($message); $written < $length; $written += $result)
		{
			if (($result = fwrite($fp, self::substr($message, $written))) === FALSE)
			{
				break;
			}
		}

		flock($fp, LOCK_UN);
		fclose($fp);

		if (isset($newfile) && $newfile === TRUE)
		{
			chmod($filepath, $this->_file_permissions);
		}

		return is_int($result);
	}
	
	public function _format_line2($level, $message)
	{

		$msg = '------------------------------------------------------------------------------'.chr(13).chr(10);
		$msg .= '['.$level.'] (UTC)'.$this->_utcTime.' (KRT) '.$this->_seoulTime.chr(13).chr(10);
		$msg .= '-----------------------------------------------------------------------------'.chr(13).chr(10);
		$msg .= $message.PHP_EOL.chr(13).chr(10);
		
		return $msg;
		
		//return $level.' - '.$date.' --> '.$message.PHP_EOL;
	}
}
// END MY_Log Class