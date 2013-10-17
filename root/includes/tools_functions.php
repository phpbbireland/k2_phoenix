<?php
/**
*
* @package Tools (generic tool function)
* @version $Id$
* @copyright (c) 2013 phpbbireland
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*
* A collection of functions from existing code/mods that may prove useful...
* Where necessary they have been recoded to make them globally accesable...
*
* All functions name are preceeded by: tools_ ...
* All functions definitions are wrapped with: function_exists...
*
* To access functions use:
* include_once($phpbb_root_path . 'includes/tools_functions.'. $phpEx);
*
* @copyright (c) 2007 phpBB Group
* @copyright (c) 2005 phpBB Garage
* @copyright (c) 2006 phpBB Ireland
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

global $phpbb_root_path;


/**
* From: phpBB Garage
* Determine GD version if available else set to 0
* @param int $user_ver version to default
*
*/
if (!function_exists('tools_gd_version_check'))
{
	function tools_gd_version_check($user_ver = 0)
	{
		if (!extension_loaded('gd'))
		{
			return 0;
		}

		static $gd_ver = 0;
		//Just accept the specified setting if it's 1
		if ($user_ver == 1)
		{
			return 1;
		}
		//Use the static variable if function was called previously
		if ($user_ver !=2 && $gd_ver > 0)
		{
			return $gd_ver;
		}
		//Use The gd_info() function if possible
		if (function_exists('gd_info'))
		{
			$ver_info = gd_info();
			preg_match('/\d/', $ver_info['GD Version'], $match);
			$gd_ver = $match[0];
			return $match[0];
		}
		//If phpinfo() is disabled use a specified / fail-safe choice...
		if (preg_match('/phpinfo/', ini_get('disable_functions')))
		{
			$gd_ver = ($user_ver == 2) ? 2 : 1;

			return $gd_ver;
		}
		//Otherwise use phpinfo()
		ob_start();
		phpinfo(8);
		$info = ob_get_contents();
		ob_end_clean();
		$info = stristr($info, 'gd version');
		preg_match('/\d/', $info, $match);
		$gd_ver = $match[0];
		return $match[0];
	}
}


/**
* From: phpBB Garage
* Check if any image either uploaded or remote needs processing
* @return boolean
*
*/
if (!function_exists('tools_image_attached'))
{
	function tools_image_attached()
	{
		global $_FILES, $_POST;

		//Look for image to handle from either upload or remotely linked
		if (((isset($_FILES['FILE_UPLOAD'])) && ($_FILES['FILE_UPLOAD']['name'])) || ((!preg_match("/^http:\/\/$/i", $_POST['url_image'])) && (!empty($_POST['url_image']))))
		{
			return true;
		}
		return false;
	}
}



/**
* From: phpBB Garage
* Determine if image is remote
* @return boolean
*/
if (!function_exists('tools_image_is_remote'))
{
	function tools_image_is_remote()

	{
		global $_POST;

		//Lets make sure it's not just a default http://
		$url_image = str_replace("\'", "''", trim($_POST['url_image']));
		if (preg_match( "/^http:\/\/$/i", $url_image))
		{
			$url_image = "";
		}

		//Is image remote?
		if (!empty($url_image))
		{
			return true;
		}
		return false;
	}
}


/**
* From: phpBB Garage
* Determine if image is uploaded
* @return boolean
*/
if (!function_exists('tools_image_is_local'))
{
	function tools_image_is_local()
	{
		global $_FILES;

		//Is image local
		if ((isset($_FILES['FILE_UPLOAD'])) && (!empty($_FILES['FILE_UPLOAD']['name'])))
		{
			return true;
		}
		return false;
	}
}



/**
* From: phpBB Garage
* Handle image upload including thumbnail creation
* @param int $id id of parent item
*/
if (!function_exists('tools_process_image_attached'))
{
	function tools_process_image_attached($type, $id, $caller)
	{
		global $user, $images, $phpEx, $phpbb_root_path, $config, $_FILES, $_POST, $auth;

		$upload_path = $config['upload_path'];


		if (!$auth->acl_get('u_attach'))
		{
			return;
		}

		$gd_version = tools_gd_version_check();

		//Check directory exists...and if not let user know to contact administrator with helpful pointer
		if (!file_exists($phpbb_root_path. $upload_path))
		{
			redirect(append_sid("{$phpbb_root_path}{$caller}.$phpEx", "mode=error&amp;EID=24"));
		}
		//Check its writeable '16895' is octal for drwxrwxrwx.... let user know to contact admin with helpful pointer
		if (!fileperms($phpbb_root_path. $upload_path) == '16895')
		{
			redirect(append_sid("{$phpbb_root_path}{$caller}.$phpEx", "mode=error&amp;EID=25"));
		}

		//Check for both a remote image & image upload..not allowed
		if (($this->image_is_remote()) && ($this->image_is_local()))
		{
			redirect(append_sid("{$phpbb_root_path}{$caller}.$phpEx", "mode=error&amp;EID=11"));
		}
		//Process the remote image
		else if ($this->image_is_remote())
		{
			$data['location'] = str_replace("\'", "''", trim($_POST['url_image']));

			//Stop dynamic images and display correct error message
			if (preg_match( "/[?&;]/", $data['location']))
			{
				redirect(append_sid("{$phpbb_root_path}{$caller}.$phpEx", "mode=error&amp;EID=9"));
			}
			//Does Remote File Exist?
			if (!$this->remote_file_exists($data['location']))
			{
				redirect(append_sid("{$phpbb_root_path}{$caller}.$phpEx", "mode=error&amp;EID=10"));
			}

			$data['date']	= time();
			$data['ext']	= strtolower( preg_replace( "/^.*\.(\S+)$/", "\\1", $data['location'] ));
			$data['file']	= preg_replace( "/^.*\/(.*\.\S+)$/", "\\1", $data['location'] );

			switch ($data['ext'])
			{
				case 'jpeg':
				case 'jpg':
					$data['ext'] = '.jpg';
					$data['is_image'] = '1';
					break;
				case 'png':
					$data['ext'] = '.png';
					$data['image'] = '1';
					break;
				case 'gif':
					$data['ext'] = '.gif';
					$data['is_image'] = '1';
					break;
				default:
					redirect(append_sid("{$phpbb_root_path}{$caller}.$phpEx", "mode=error&amp;EID=12"));
			}

			//Build File Names
			$data['tmp_name']	 = 'garage_' . $type . '-' . $id . '-' . $data['date'] . $data['ext'];
			$data['thumb_location'] = 'garage_' . $type . '-' . $id . '-' . $data['date'] . '_thumb' . $data['ext'];
			//$data['vehicle_id']	 = ($type == 'vehicle') ? $id : $vid;

			//Download remote image to our temporary file
			$this->download_remote_image($data['location'], $data['tmp_name']);

			//Create the thumbnail if we have gd on the server
			if ($gd_version > 0)
			{
				//Create the thumbnail
				$this->create_thumbnail($data['tmp_name'], $data['thumb_location'], $data['ext']);

				//Get thumbnail width & height
				$data['thumb_width']	= $this->get_image_width($data['thumb_location']);
				$data['thumb_height']	= $this->get_image_height($data['thumb_location']);
				$data['thumb_filesize'] = $this->get_image_filesize($data['thumb_location']);
			}
			//No GD so use default image
			else
			{
				$data['thumb_location']	= $phpbb_root_path . $images['no_thumb'];
				$data['thumb_width']	= '145';
				$data['thumb_height']	= '35';
			}

			//Filesize is 0 as we have not used local storage for the many image.. only thumbnai
			$data['filesize'] = 0;

			//Remove our temporary file as we no longer need it..
			@unlink($phpbb_root_path . $upload_path . $data['tmp_name']);

			//Insert the image into the db now we are finished
			$image_id = $this->insert_image($data);

			return $image_id;
		}
		//Uploaded image not remote image
		else if ($this->image_is_local())
		{
			$data['filesize']	= $_FILES['FILE_UPLOAD']['size'];
			$data['tmp_name']	= $_FILES['FILE_UPLOAD']['tmp_name'];
			$data['file']		= trim(str_replace("\'", "''", trim(htmlspecialchars($_FILES['FILE_UPLOAD']['name']))));
			$data['date']		= time();
			$imagesize			= getimagesize($_FILES['FILE_UPLOAD']['tmp_name']);
			$data['filetype']	= $imagesize[2];

			if ($data['filesize'] == 0)
			{
				redirect(append_sid("{$phpbb_root_path}{$caller}.$phpEx?mode=error&EID=6", true));
			}

			//Check File Type
			switch ($data['filetype'])
			{
				case '1':
					$data['ext'] = '.gif';
					$data['is_image'] = '1';
					break;
				case '2':
					$data['ext'] = '.jpg';
					$data['is_image'] = '1';
					break;
				case '3':
					$data['ext'] = '.png';
					$data['is_image'] = '1';
					break;
				default:
					trigger_error($lang['Not_Allowed_File_Type_Vehicle_Created_No_Image'] . "<br />Your File Type Was " .$data['filetype'] . adm_back_link(append_sid("index.$phpEx", "i=garage_tool")));
			}

			//Generate Required Filename & Thumbname
			//$data['vehicle_id']	 = ($type == 'vehicle') ? $id : $vid;
			$data['location']	 = 'garage_' . $type . '-' . $id . '-' . $data['date'] . $data['ext'];
			$data['thumb_location'] = 'garage_' . $type . '-' . $id . '-' . $data['date'] . '_thumb' . $data['ext'];

			//Move file to upload directory...we know directory exists from earlier checks...
			$move_file = 'copy';
			$ini_val = (@phpversion() >= '4.0.0') ? 'ini_get' : 'get_cfg_var';
			if (@$ini_val('open_basedir') != '')
			{
				if (@phpversion() < '4.0.3')
				{
					trigger_error('open_basedir is set and your PHP version does not allow move_uploaded_file<br /><br />Please contact your server admin');
				}
				$move_file = 'move_uploaded_file';
			}

			$move_file($data['tmp_name'], $phpbb_root_path . $upload_path . $data['location']);
			@chmod($phpbb_root_path . $upload_path . $data['location'], 0777);

			//Lets Get Image Width & Height
			$data['width']	 = $this->get_image_width($data['location']);
			$data['height'] = $this->get_image_height($data['location']);

			//Check if image breaches site rules...if so just resize it to required size.
			if (($data['width'] > $config['img_max_width']) || ($data['height'] > $config['img_max_height']))
			{
				//Create temp filename to make compliant image
				$data['tmp_location'] = "temp_" . $data['location'];
				//Work out image resize deminisions to keep ratio
				if ($data['width'] > $data['height'])
				{
					$resize_width = 1024;
					$resize_height = (1024 / $data['width']) * $data['height'];
				}
				else
				{
					$resize_width =  (1024 / $data['height']) * $data['width'];
					$resize_height = 1024;
				}

				//Resize images thats too big to a compliant size & set its permission
				$this->resize_image($data['location'], $data['tmp_location'], $data['ext'], $data['width'], $data['height'], $resize_width, $resize_height);

				//Delete Original Too Large Image
				@unlink($phpbb_root_path . $upload_path . $data['location']);

				//Move compliant image back to original name & setup permissions
				rename($phpbb_root_path . $upload_path . $data['tmp_location'], $phpbb_root_path . $upload_path . $data['location']);

				//Reset Width & Height Values
				$data['width'] = $resize_width;
				$data['height'] = $resize_height;
			}

			//If after resize we are still too big guess we just need to error
			$data['filesize'] = filesize($phpbb_root_path . $upload_path . $data['location']);
			if ($data['filesize'] / 1024 > 1000)
			{
				redirect(append_sid("{$phpbb_root_path}{$caller}.$phpEx?mode=error&EID=7", true));
			}

			//Create the thumbnail for this image
			if ($gd_version > 0)
			{
				$this->create_thumbnail($data['location'], $data['thumb_location'], $data['ext']);

				//Get Thumbnail Width & Height
				$data['thumb_width']	= $this->get_image_width($data['thumb_location']);
				$data['thumb_height']	= $this->get_image_height($data['thumb_location']);
				$data['thumb_filesize'] = $this->get_image_filesize($data['thumb_location']);
			}
			else
			{
				$data['thumb_location'] = $phpbb_root_path . $images['garage_no_thumb'];
				$data['thumb_width'] = '145';
				$data['thumb_height'] = '35';
			}

			//Filesize is zero since its remote
			$data['filesize'] = '0';

			//Insert the image into the db now we are finished
			$image_id = $this->insert_image($data);

			return $image_id;
		}
	}
}
?>
