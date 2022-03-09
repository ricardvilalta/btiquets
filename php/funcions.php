<?php  

	function translate($phrase, $lang) {
 
		$translation = null;
        global $dicc;
 
		switch ($lang) {
 
			case 'es':
 
                if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/lang/es.php'))
                    include_once $_SERVER['DOCUMENT_ROOT'].'/lang/es.php';    
 
				$translation = $dicc[$phrase];
				
				if($translation=="")
				{
					$translation = $phrase;
				}
				break;
 
			case 'ca':
                $translation = $phrase;
				break;
 
			case 'de':

				if(file_exists($_SERVER['DOCUMENT_ROOT'].'/lang/de.php'))
                    include_once $_SERVER['DOCUMENT_ROOT'].'/lang/de.php';
 
				$translation = $dicc[$phrase];
				
				if($translation=="")
				{
					$translation = $phrase;
				}
				break;
            
            case 'en':

				if(file_exists($_SERVER['DOCUMENT_ROOT'].'/lang/en.php'))
                    include_once $_SERVER['DOCUMENT_ROOT'].'/lang/en.php';
 
				$translation = $dicc[$phrase];
				
				if($translation=="")
				{
					$translation = $phrase;
				}
				break;
 
			case 'fr':
				$translation = $phrase;
				break;
				
			default:
				$translation = $phrase;
				break;
		}
 
		return $translation;
	}

	/*
	* File: SimpleImage.php
	* Author: Simon Jarvis
	* Copyright: 2006 Simon Jarvis
	* Date: 08/11/06
	* Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
	*
	* This program is free software; you can redistribute it and/or
	* modify it under the terms of the GNU General Public License
	* as published by the Free Software Foundation; either version 2
	* of the License, or (at your option) any later version.
	*
	* This program is distributed in the hope that it will be useful,
	* but WITHOUT ANY WARRANTY; without even the implied warranty of
	* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	* GNU General Public License for more details:
	* http://www.gnu.org/licenses/gpl.html
	*
	*/
 
	class SimpleImage {
 
	   var $image;
	   var $image_type;
 
	   function load($filename) {
 
		  $image_info = getimagesize($filename);
		  $this->image_type = $image_info[2];
		  if( $this->image_type == IMAGETYPE_JPEG ) {
 
			 $this->image = imagecreatefromjpeg($filename);
		  } elseif( $this->image_type == IMAGETYPE_GIF ) {
 
			 $this->image = imagecreatefromgif($filename);
		  } elseif( $this->image_type == IMAGETYPE_PNG ) {
 
			 $this->image = imagecreatefrompng($filename);
		  }
	   }
	   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
 
		  if( $image_type == IMAGETYPE_JPEG ) {
			 imagejpeg($this->image,$filename,$compression);
		  } elseif( $image_type == IMAGETYPE_GIF ) {
 
			 imagegif($this->image,$filename);
		  } elseif( $image_type == IMAGETYPE_PNG ) {
 
			 imagepng($this->image,$filename);
		  }
		  if( $permissions != null) {
 
			 chmod($filename,$permissions);
		  }
	   }
	   function output($image_type=IMAGETYPE_JPEG) {
 
		  if( $image_type == IMAGETYPE_JPEG ) {
			 imagejpeg($this->image);
		  } elseif( $image_type == IMAGETYPE_GIF ) {
 
			 imagegif($this->image);
		  } elseif( $image_type == IMAGETYPE_PNG ) {
 
			 imagepng($this->image);
		  }
	   }
       function clear() {
 
		  imagedestroy($this->image);
	   }
	   function getWidth() {
 
		  return imagesx($this->image);
	   }
	   function getHeight() {
 
		  return imagesy($this->image);
	   }
	   function resizeToHeight($height) {
 
		  $ratio = $height / $this->getHeight();
		  $width = $this->getWidth() * $ratio;
		  $this->resize($width,$height);
	   }
 
	   function resizeToWidth($width) {
		  $ratio = $width / $this->getWidth();
		  $height = $this->getheight() * $ratio;
		  $this->resize($width,$height);
	   }
 
	   function scale($scale) {
		  $width = $this->getWidth() * $scale/100;
		  $height = $this->getheight() * $scale/100;
		  $this->resize($width,$height);
	   }
 
	   function resize($width,$height) {
		 $new_image = imagecreatetruecolor($width, $height);
		 if( $this->image_type == IMAGETYPE_GIF || $this->image_type == IMAGETYPE_PNG ) {
			 $current_transparent = imagecolortransparent($this->image);
			 if($current_transparent != -1) {
				 $transparent_color = imagecolorsforindex($this->image, $current_transparent);
				 $current_transparent = imagecolorallocate($new_image, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
				 imagefill($new_image, 0, 0, $current_transparent);
				 imagecolortransparent($new_image, $current_transparent);
			 } elseif( $this->image_type == IMAGETYPE_PNG) {
				 imagealphablending($new_image, false);
				 $color = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
				 imagefill($new_image, 0, 0, $color);
				 imagesavealpha($new_image, true);
			 }
		 }
		 imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
         imagedestroy($this->image);
		 $this->image = $new_image;
	   }
        
        function rotate($orientation) {
            
            $mirror = false;
            $deg    = 0;
            
            switch ($orientation) {
              case 2:
                $mirror = true;
                break;
              case 3:
                $deg = 180;
                break;
              case 4:
                $deg = 180;
                $mirror = true;  
                break;
              case 5:
                $deg = 270;
                $mirror = true; 
                break;
              case 6:
                $deg = 270;
                break;
              case 7:
                $deg = 90;
                $mirror = true; 
                break;
              case 8:
                $deg = 90;
                break;
            }
            if ($deg) $this->image = imagerotate($this->image, $deg, 0); 
            if ($mirror) $this->image = _mirrorImage($this->image);
        }
	}


    function get_ext($filename)
    {
        return substr(strrchr($filename, '.'), 1);
    }

    function file_in_array($name,$myarray)
    {
        $count = count($myarray);
        for ($i = 0; $i < $count; $i++)
        {
            if($myarray[$i]==$name)
            {
                return true;
            }
        }
        
        return false;
    }


    function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    
    function base64url_decode($data) {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    } 

    function generarCodi($longitud) 
    {
        $key = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
        $max = strlen($pattern)-1;
        for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
        return $key;
    }

    function RandomString($length=10,$uc=TRUE,$n=TRUE,$sc=FALSE)
    {
        $source = 'abcdefghijklmnopqrstuvwxyz';
        if($uc==1) $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if($n==1) $source .= '1234567890';
        if($sc==1) $source .= '|@#~$%()=^*+[]{}-_';
        if($length>0){
            $rstr = "";
            $source = str_split($source,1);
            for($i=1; $i<=$length; $i++){
                mt_srand((double)microtime() * 1000000);
                $num = mt_rand(1,count($source));
                $rstr .= $source[$num-1];
            }   
        }
        return $rstr;
    }

    function Zip($source, $destination)
    {
        if (!extension_loaded('zip') || !file_exists($source)) {
            return false;
        }
    
        $zip = new ZipArchive();
        if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
            return false;
        }
    
        $source = str_replace('\\', '/', realpath($source));
    
        if (is_dir($source) === true)
        {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
    
            foreach ($files as $file)
            {
                $file = str_replace('\\', '/', $file);
    
                // Ignore "." and ".." folders
                if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
                    continue;
    
                $file = realpath($file);
    
                if (is_dir($file) === true)
                {
                    $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                }
                else if (is_file($file) === true)
                {
                    $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                }
            }
        }
        else if (is_file($source) === true)
        {
            $zip->addFromString(basename($source), file_get_contents($source));
        }
    
        return $zip->close();
    }

    /**
     * Unzip the source_file in the destination dir
     *
     * @param   string      The path to the ZIP-file.
     * @param   string      The path where the zipfile should be unpacked, if false the directory of the zip-file is used
     * @param   boolean     Indicates if the files will be unpacked in a directory with the name of the zip-file (true) or not (false) (only if the destination directory is set to false!)
     * @param   boolean     Overwrite existing files (true) or not (false)
     * 
     * @return  boolean     Succesful or not
     */
    function UnZip($src_file, $dest_dir=false, $create_zip_name_dir=true, $overwrite=true)
    {
      if ($zip = zip_open($src_file))
      {
        if ($zip)
        {
          $splitter = ($create_zip_name_dir === true) ? "." : "/";
          if ($dest_dir === false) $dest_dir = substr($src_file, 0, strrpos($src_file, $splitter))."/";
         
          // Create the directories to the destination dir if they don't already exist
          create_dirs($dest_dir);
    
          // For every file in the zip-packet
          while ($zip_entry = zip_read($zip))
          {
              echo "read: ".zip_entry_name($zip_entry);
            // Now we're going to create the directories in the destination directories
           
            // If the file is not in the root dir
            $pos_last_slash = strrpos(zip_entry_name($zip_entry), "/");
            if ($pos_last_slash !== false)
            {
              // Create the directory where the zip-entry should be saved (with a "/" at the end)
              create_dirs($dest_dir.substr(zip_entry_name($zip_entry), 0, $pos_last_slash+1));
            }
    
            // Open the entry
            if (zip_entry_open($zip,$zip_entry,"r"))
            {
             
              // The name of the file to save on the disk
              $file_name = $dest_dir.zip_entry_name($zip_entry);
             
              // Check if the files should be overwritten or not
              if ($overwrite === true || $overwrite === false && !is_file($file_name))
              {
                // Get the content of the zip entry
                $fstream = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
    
                file_put_contents($file_name, $fstream );
                // Set the rights
                chmod($file_name, 0777);
              }
             
              // Close the entry
              zip_entry_close($zip_entry);
            }      
          }
          // Close the zip-file
          zip_close($zip);
        }
      }
      else
      {
        return false;
      }
     
      return true;
    }

    function is_image($path)
    {
        $a = getimagesize($path);
        if($a)
        {
            $image_type = $a[2];

            if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
            {
                return true;
            }
        }
        return false;
    }

    function GetFolderImages($dir)
    {
        if (is_dir($dir))
        {
            if(!$dh = opendir($dir)) return;
            $data = array();
            while (false !== ($obj = readdir($dh))) 
            {
                if($obj=='.' || $obj=='..' || !is_image($dir.'/'.$obj)) continue;            
                if(!is_dir($dir.'/'.$obj))                
                {
                    $data[]=$obj;
                }
            }
            closedir($dh);
            return $data;
        }
    }

    /**
     * This function creates recursive directories if it doesn't already exist
     *
     * @param String  The path that should be created
     * 
     * @return  void
     */
    function create_dirs($path)
    {
      if (!is_dir($path))
      {
        $directory_path = "";
        $directories = explode("/",$path);
        array_pop($directories);
       
        foreach($directories as $directory)
        {
          $directory_path .= $directory."/";
          if (!is_dir($directory_path))
          {
            mkdir($directory_path);
            chmod($directory_path, 0777);
          }
        }
      }
    }

    function delete_dir($dir, $del_dir)
    {
        if (is_dir($dir))
        {
            if(!$dh = opendir($dir)) return;
            while (false !== ($obj = readdir($dh))) 
            {
                if($obj=='.' || $obj=='..') continue;            
                if(is_dir($dir.'/'.$obj))
                {
                    delete_dir($dir.'/'.$obj, true);
                }
                else
                {
                    unlink($dir.'/'.$obj);
                }
            }
            closedir($dh);
            if ($del_dir)
            {
                rmdir($dir);
            }
        }
    }

    function copyDirToDir($src,$dst)
    {
        $dir = opendir($src);
        
        if(!file_exists( $dst ))
        {
            mkdir($dst);
        }
        
        while(false !== ( $file =  readdir($dir)) ) 
        {        
            if (( $file  != '.' ) && ( $file != '..' )) 
            {            
                if (  is_dir($src . '/' . $file) ) 
                {                
                    copyDirToDir($src . '/' . $file,$dst .  '/' . $file);                
                }                
                else 
                {
                    copy($src . '/' . $file,$dst . '/' .  $file);
                }
            }
        }
        
        closedir($dir);
    }


    function dirsize($dir)
    {
        @$dh = opendir($dir);
        $size = 0;
        while ($file = @readdir($dh))
        {
            if ($file != "." and $file != "..") 
            {
                $path = $dir."/".$file;
                if (is_dir($path))
                {
                    $size += dirsize($path); // recursive in sub-folders
                }
                elseif (is_file($path))
                {
                    $size += filesize($path); // add file
                }
            }
        }
        @closedir($dh);
        return $size;
    }



    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // noves funcions
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function sec_session_start($session_name) 
    {
            $session_name = $session_name; // Set a custom session name
            $secure = true; // Set to true if using https.
            $httponly = true; // This stops javascript being able to access the session id. 
     
            ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies. 
            $cookieParams = session_get_cookie_params(); // Gets current cookies params.
            session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
            session_name($session_name); // Sets the session name to the one set above.
            session_start(); // Start the php session
            session_regenerate_id(); // regenerated the session, delete the old one.  
    }

    function login($name, $password, $mysqli, $login_key_str) 
    {
        global $zone;
        $found=false;
        
        // Using prepared Statements means that SQL injection is not possible. 
        if ($stmt = $mysqli->prepare("SELECT id, username, password, salt FROM members WHERE email = ? AND confirmed = 1 AND deleted = 0 LIMIT 1")) 
        { 
            $email = $name;
            $stmt->bind_param('s', $name); // Bind "$email" to parameter.
            $stmt->execute(); // Execute the prepared query.
            $stmt->store_result();
            $stmt->bind_result($user_id, $username, $db_password, $salt); // get variables from result.
            $stmt->fetch();
            $password_salt = hash('sha512', $password.$salt); // hash the password with the unique salt.
            
            if($stmt->num_rows == 1)
            {
                $found=true;
            }
                
                
            if($found) 
            { 
                // If the user exists
                // We check if the account is locked from too many login attempts
                //if(checkbrute($user_id, $mysqli) == true) 
                if(true==false)
                { 
                    // Account is locked
                    // Send an email to user saying their account is locked
                    return false;
                } 
                else 
                {
                    if($db_password == $password_salt) 
                    { 
                        // Check if the password in the database matches the password the user submitted. 
                        // Password is correct!
                        
                        
                        $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
                        
                        $user_id = preg_replace("/[^0-9]+/", "", $user_id); // XSS protection as we might print this value
                        $_SESSION['user_id'] = $user_id; 
                        $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // XSS protection as we might print this value
                        $_SESSION['username'] = $username;
                        $_SESSION[$login_key_str] = hash('sha512', $password_salt.$user_browser);
                        // Login successful.
                        
                        date_default_timezone_set($zone);
                        $now = date('Y-m-d H:i:s');
                        $mysqli->query("UPDATE members SET `last_visit`='$now' WHERE id = $user_id");                        
                        
                        return true;    
                    } 
                    else 
                    {
                        // Password is not correct
                        error_log("Contrasenya errònia");
                        // We record this attempt in the database
                        $now = time();
                        $mysqli->query("INSERT INTO login_attempts (user_id, time) VALUES ('$user_id', '$now')");
                        return false;
                    }
                }
            } 
            else 
            {
                // No user exists. 
                error_log("No existeix l'usuari o la contrasenya és errònia");
                return false;
            }
        }
    }

    function login_id($id, $password, $mysqli, $login_key_str) 
    {        
        global $zone;
        $found=false;
        
        // Using prepared Statements means that SQL injection is not possible. 
        if ($stmt = $mysqli->prepare("SELECT id, username, password, salt FROM members WHERE id = ? AND confirmed = 1 AND deleted = 0 LIMIT 1"))
        { 
            $stmt->bind_param('i', $id); // Bind "$email" to parameter.
            $stmt->execute(); // Execute the prepared query.
            $stmt->store_result();
            $stmt->bind_result($user_id, $username, $db_password, $salt); // get variables from result.
            $stmt->fetch();
            $password_salt = hash('sha512', $password.$salt); // hash the password with the unique salt.
            
            if($stmt->num_rows == 1)
            {
                $found=true;
            }

            if($found) 
            { 
                // If the user exists
                // We check if the account is locked from too many login attempts
                //if(checkbrute($user_id, $mysqli) == true) 
                if(true==false)
                { 
                    // Account is locked
                    // Send an email to user saying their account is locked
                    return false;
                } 
                else 
                {
                    if($db_password == $password_salt) 
                    { 
                        // Check if the password in the database matches the password the user submitted. 
                        // Password is correct!
                        
                        
                        $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
                        
                        $user_id = preg_replace("/[^0-9]+/", "", $user_id); // XSS protection as we might print this value
                        $_SESSION['user_id'] = $user_id; 
                        $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // XSS protection as we might print this value
                        $_SESSION['username'] = $username;
                        $_SESSION[$login_key_str] = hash('sha512', $password_salt.$user_browser);
                        // Login successful.
                        
                        date_default_timezone_set($zone);
                        $now = date('Y-m-d H:i:s');
                        $mysqli->query("UPDATE members SET `last_visit`='$now' WHERE id = $user_id");
                        
                        return true;    
                    } 
                    else 
                    {
                        // Password is not correct
                        // We record this attempt in the database
                        $now = time();
                        $mysqli->query("INSERT INTO login_attempts (user_id, time) VALUES ('$user_id', '$now')");
                        return false;
                    }
                }
            } 
            else 
            {
                // No user exists. 
                return false;
            }
        }
    }

    function login_code($usermail, $code, $login_key_str) 
    {
        if(file_exists('php/common.php'))
            include_once 'php/common.php';
        
        if(file_exists('../php/common.php'))
            include_once '../php/common.php';
        
        global $mysqli;
        global $zone;
        $found=false;
        
        // Using prepared Statements means that SQL injection is not possible. 
        if ($stmt = $mysqli->prepare("SELECT id, username, password, confirmation_code FROM members WHERE email = ? AND confirmed = 1 AND deleted = 0 LIMIT 1"))
        { 
            $stmt->bind_param('s', $usermail); // Bind "$email" to parameter.
            $stmt->execute(); // Execute the prepared query.
            $stmt->store_result();
            $stmt->bind_result($user_id, $username, $password, $db_code); // get variables from result.
            $stmt->fetch();            
            
            if($stmt->num_rows == 1)
            {
                $found=true;
            }
            else
            {
                $found=false;
            }
   

            if($found)
            { 
                if($code == $db_code) 
                { 
                    $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
                    
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id); // XSS protection as we might print this value
                    $_SESSION['user_id'] = $user_id; 
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // XSS protection as we might print this value
                    $_SESSION['username'] = $username;
                    $login_str = hash('sha512', $password.$user_browser);
                    $_SESSION[$login_key_str] = $login_str;
                    // Login successful.
                    
                    date_default_timezone_set($zone);
                    $now = date('Y-m-d H:i:s');
                    $mysqli->query("UPDATE members SET `last_visit`='$now' WHERE id = $user_id");
 
                    return true;    
                } 
                else 
                {
                    // Password is not correct
                    // We record this attempt in the database
                    $now = time();
                    $mysqli->query("INSERT INTO login_attempts (user_id, time) VALUES ('$user_id', '$now')");
                    return false;
                }
            } 
            else 
            {
                // No user exists. 
                return false;
            }
        }
    }


    function login_update($user_id, $username)
    {
        $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
                    
        $user_id = preg_replace("/[^0-9]+/", "", $user_id); // XSS protection as we might print this value
        $_SESSION['user_id'] = $user_id; 
        $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // XSS protection as we might print this value
        $_SESSION['username'] = $username;
        // Login successful.
        
        return true;
    }


    function register($username, $surnames, $countrycode, $tel, $email, $city, $password, $mysqli, $generate_code, &$codi, $newsletter=0) 
    {
        if(file_exists('php/common.php'))
            include_once 'php/common.php';
        
        if(file_exists('../php/common.php'))
            include_once '../php/common.php';
        
        global $zone;
        
        // Primer he de mirar si ja existeix algun usuari amb aquest nom o aquest correu
        if ($stmt = $mysqli->prepare("SELECT COUNT(*) FROM members WHERE email = ? AND deleted=0")) 
        { 
            $stmt->bind_param('s', $email); // Bind "$email" to parameter.
            $stmt->execute(); // Execute the prepared query.
            $stmt->store_result();
            $stmt->bind_result($count);
            $stmt->fetch();
            
            if($count >= 1) 
            { 
                // Això vol dir que ja existeix algun usuari amb aquest nom o email
                return false;
            }
            else
            {
                // Create a random salt
                $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
                // Create salted password (Careful not to over season)
                $password = hash('sha512', $password.$random_salt);
                
                if($generate_code)
                {
                    // Ara genero un codi de confirmació
                    $codi = RandomString(20,false,true,false);
                    
                    date_default_timezone_set($zone);
                    $now = date('Y-m-d H:i:s');
                    
                    // Make sure you use prepared statements!
                    if ($insert_stmt = $mysqli->prepare("INSERT INTO members (username, surnames, email, city, password, salt, creation, confirmation_code, country_code, tel, newsletter) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) 
                    {                        
                        $insert_stmt->bind_param('ssssssssssi', $username, $surnames, $email, $city, $password, $random_salt, $now, $codi, $countrycode, $tel, $newsletter); 
                        // Execute the prepared query.
                        $insert_stmt->execute();
                        
                        return $mysqli->insert_id;
                    }
                    else
                    {
                        return false;
                    }
                }
                else
                {
                    date_default_timezone_set($zone);
                    $now = date('Y-m-d H:i:s');
                    
                    // Make sure you use prepared statements!
                    if ($insert_stmt = $mysqli->prepare("INSERT INTO members (username, surnames, email, city, password, salt, creation, confirmed, country_code, tel, newsletter) VALUES (?, ?, ?, ?, ?, ?, ?, 1, ?, ?, ?)")) 
                    {                        
                        $insert_stmt->bind_param('sssssssssi', $username, $surnames, $email, $city, $password, $random_salt, $now, $countrycode, $tel, $newsletter); 
                        // Execute the prepared query.
                        $insert_stmt->execute();
                        
                        return $mysqli->insert_id;
                    }
                    else
                    {
                        return false;
                    }
                }
            }
        }
        else
        {
            return false;
        }
    }

    function getUserInfo($userid,$mysqli) 
    {
        if(file_exists('php/common.php'))
            include_once 'php/common.php';
        
        if(file_exists('../php/common.php'))
            include_once '../php/common.php';
        
        // Primer he de mirar si ja existeix algun usuari amb aquest nom o aquest correu
        if ($stmt = $mysqli->prepare("SELECT username,surnames,email,city,password,salt,country_code,tel,newsletter FROM members WHERE id = ? AND confirmed=1")) 
        { 
            $stmt->bind_param('i', $userid);
            $stmt->execute(); // Execute the prepared query.
            $stmt->store_result();
            $stmt->bind_result($uname,$snames,$email,$city,$password,$salt,$countrycode,$tel,$newsletter);
            $stmt->fetch();
            
            return array('id'=>$userid,'name'=>$uname,'surnames'=>$snames,'email'=>$email,'city'=>$city,'countrycode'=>$countrycode,'tel'=>$tel,'newsletter'=>$newsletter);
        }
        else
        {
            return null;
        }
    }

    function editUser($mysqli,$zone,$userid,$username,$surnames,$email,$city,$countrycode,$tel,$confirmed,$newsletter=0) 
    {        
        // Primer he de mirar si ja existeix algun usuari amb aquest nom o aquest correu
        if ($stmt = $mysqli->prepare("SELECT COUNT(*) FROM members WHERE email = ? AND id != ?")) 
        { 
            $stmt->bind_param('si', $email,$userid); // Bind "$email" to parameter.
            $stmt->execute(); // Execute the prepared query.
            $stmt->store_result();
            $stmt->bind_result($count);
            $stmt->fetch();
            
            if($count >= 1) 
            { 
                // Això vol dir que ja existeix algun usuari amb aquest nom o email
                return false;
            }
            else
            {
                if($userid!=-1)
                {
                    // Make sure you use prepared statements!
                    if ($insert_stmt = $mysqli->prepare("UPDATE members SET username=?,surnames=?,email=?,city=?,country_code=?,tel=?,newsletter=? WHERE id = ?")) 
                    {                        
                        $insert_stmt->bind_param('ssssssii', $username, $surnames, $email, $city, $countrycode, $tel, $newsletter, $userid); 
                        // Execute the prepared query.
                        $insert_stmt->execute();
                        
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                }
                else
                {
                    // Codifiquem el password per defecte "1234"
                    $default_password = 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db';
                    // Create a random salt
                    $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
                    // Create salted password (Careful not to over season)
                    $password = hash('sha512', $default_password.$random_salt);
                    
                    date_default_timezone_set($zone);
                    $now = date('Y-m-d H:i:s');
                    
                    // Make sure you use prepared statements!
                    if ($insert_stmt = $mysqli->prepare("INSERT INTO members (username, surnames, email, city, password, salt, creation, country_code, tel, confirmed, newsletter) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) 
                    {                        
                        $insert_stmt->bind_param('sssssssssii', $username, $surnames, $email, $city, $password, $random_salt, $now, $countrycode, $tel,$confirmed,$newsletter); 
                        // Execute the prepared query.
                        $insert_stmt->execute();
                        
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                }
            }
        }
        else
        {
            return false;
        }
    }
        
        
    function editPassword($userid,$password,$mysqli) 
    {
        if(file_exists('php/common.php'))
            include_once 'php/common.php';
        
        if(file_exists('../php/common.php'))
            include_once '../php/common.php';
        
       // Create a random salt
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        // Create salted password (Careful not to over season)
        $password = hash('sha512', $password.$random_salt);
        
        // Make sure you use prepared statements!
        if ($insert_stmt = $mysqli->prepare("UPDATE members SET password=?,salt=? WHERE id = ?"))         
        {                        
            $insert_stmt->bind_param('ssi', $password, $random_salt, $userid); 
            // Execute the prepared query.
            $insert_stmt->execute();
            
            return true;
        }
        else
        {
            return false;
        }
    }


    function checkbrute($user_id, $mysqli) 
    {
        if(file_exists('php/common.php'))
            include_once 'php/common.php';
        
        if(file_exists('../php/common.php'))
            include_once '../php/common.php';
        // Get timestamp of current time
        $now = time();
        // All login attempts are counted from the past 2 hours. 
        $valid_attempts = $now - (2 * 60 * 60); 
        
        if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time > '$valid_attempts'")) 
        { 
            $stmt->bind_param('i', $user_id); 
            // Execute the prepared query.
            $stmt->execute();
            $stmt->store_result();
            // If there has been more than 5 failed logins
            if($stmt->num_rows > 5) 
            {
                return true;
            } 
            else 
            {
                return false;
            }
        }
    }


    function login_check($mysqli,$login_key_str) 
    {
//        error_log("USER ID: " . $_SESSION['user_id'] . "\nUSERNAME: " . $_SESSION['username'] . "\nKEY STR: " . $_SESSION[$login_key_str]);
        // Check if all session variables are set        
        if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION[$login_key_str])) 
        {
            $user_id = $_SESSION['user_id'];
            $login_string = $_SESSION[$login_key_str];
            $username = $_SESSION['username'];
            
            $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.            
            
            if ($stmt = $mysqli->prepare("SELECT password FROM members WHERE id = ? LIMIT 1")) 
            {                 
                $stmt->bind_param('i', $user_id); // Bind "$user_id" to parameter.
                $stmt->execute(); // Execute the prepared query.
                $stmt->store_result();
                
                if($stmt->num_rows == 1) 
                {
                    // If the user exists
                    $stmt->bind_result($password); // get variables from result.
                    $stmt->fetch();
                    $login_check = hash('sha512', $password.$user_browser);                                        
                    
                    if($login_check == $login_string) 
                    {
                        // Logged In!!!!
                        return true;
                    } 
                    else 
                    {
                        // Not logged in
                        error_log("LOGIN STRING ERROR");
                        return false;
                    }
                } 
                else 
                {
                    // Not logged in
                    error_log("MEMBERS > 1");
                    return false;
                }
            } 
            else 
            {
                // Not logged in
                error_log("ERROR PREPARING DATABASE ACCESS");
                return false;
            }
        } 
        else 
        {
            // Not logged in
            error_log("Not logged in");
            return false;
        }
    }

    function ConfirmUser($id) 
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        if(file_exists('/../php/common.php'))
            include_once '/../php/common.php';
        
        global $mysqli;
        
        $mysqli->query("UPDATE members SET `confirmed`='1' WHERE id = $id");
        
        return 1;
    }

    function ConfirmUser_byCode($usermail,$code)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        if(file_exists('/../php/common.php'))
            include_once '/../php/common.php';
        
        global $mysqli;
        
        $result = $mysqli->query("UPDATE members SET `confirmed`='1' WHERE email = '$usermail' AND confirmation_code = '$code'");
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function DeleteUser($mysqli,$id,$permanent=false)
    {        
        //$sql="DELETE FROM members WHERE id='$id'";
        
        if($permanent==true)
        {
            $sql="DELETE FROM members WHERE id='$id'";
        }
        else
        {
            $sql="UPDATE members SET `deleted`='1' WHERE id='$id'";
        }
        $mysqli->query($sql);   
        
        return 1;
    }


    // Funció de validació de les variables POST
    function post_validation($required)
    {
        $missing = array();
        $error = false;
        foreach($required as $field)
        foreach($required as $field)
        {
            if (empty($_POST[$field])) 
            {
                $missing[] = $field;
                $error = true;
            }
        }
        
        return $missing;
    }

    function GetBackupList($path="CS")
    {
        $dir = $path;
        $data = array();
        $directori = opendir($dir);
        while ($subdir = readdir($directori))
        {            
            if(!is_file($subdir) && $subdir!='.' && $subdir!='..')
            {
                $data[] = $subdir;             
            }
        }
        sort($data);
        return $data;
    }


    function DeleteTempUserFolders()
    {
        $dir = "../UserInfo";
        $directori = opendir($dir);
        while ($subdir = readdir($directori))
        {            
            if(!is_file($subdir) && $subdir!='.' && $subdir!='..')
            {
                if(strstr($subdir,"userid_temp_"))
                {                 
                    delete_dir('../UserInfo/' . $subdir,true);
                }
            }
        }
    }


    function resizeMarkup($markup, $dimensions)
    {
        $w = $dimensions['width'];
        $h = $dimensions['height'];
        
        $patterns = array();
        $replacements = array();
        if( !empty($w) )
        {
            $patterns[] = '/width="([0-9]+)"/';
            $patterns[] = '/width:([0-9]+)/';
            
            $replacements[] = 'width="'.$w.'"';
            $replacements[] = 'width:'.$w;
        }
        
        if( !empty($h) )
        {
            $patterns[] = '/height="([0-9]+)"/';
            $patterns[] = '/height:([0-9]+)/';
            
            $replacements[] = 'height="'.$h.'"';
            $replacements[] = 'height:'.$h;
        }
        
        return preg_replace($patterns, $replacements, $markup);
    }

    function to_slug($str, $replace=array(), $delimiter='-') {
        if( !empty($replace) ) {
            $str = str_replace((array)$replace, ' ', $str);
        }
    
        //$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        //$clean = utf8_encode($str);
        $clean = str_replace(array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $str);
        $clean = str_replace(array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $clean);
        $clean = str_replace(array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $clean);
        $clean = str_replace(array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $clean);
        $clean = str_replace(array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $clean);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
    
        return $clean;
    }

    function DeleteImage($path)
    {
        if(file_exists($path))
        {
            unlink($path);
            return 1;
        }
        else
        {
            return $path;
        }
    }    

    function isInteger($input){
        return(ctype_digit(strval($input)));
    }

    function GetMonthDay($month,$language){
        switch ($language)
        {
            case 'es':
                switch ($month)
                {
                    case 1:
                        $ret = 'ene';
                        break;
                    case 2:
                        $ret = 'feb';
                        break;
                    case 3:
                        $ret = 'mar';
                        break;
                    case 4:
                        $ret = 'abr';
                        break;
                    case 5:
                        $ret = 'may';
                        break;
                    case 6:
                        $ret = 'jun';
                        break;
                    case 7:
                        $ret = 'jul';
                        break;
                    case 8:
                        $ret = 'ago';
                        break;
                    case 9:
                        $ret = 'sep';
                        break;
                    case 10:
                        $ret = 'oct';
                        break;
                    case 11:
                        $ret = 'nov';
                        break;
                    case 12:
                        $ret = 'dic';
                        break;
                    default:
                        $ret = 'ene';
                        break;
                }
                break;
            
            case 'ca':
                switch ($month)
                {
                    case 1:
                        $ret = 'gen';
                        break;
                    case 2:
                        $ret = 'feb';
                        break;
                    case 3:
                        $ret = 'mar';
                        break;
                    case 4:
                        $ret = 'abr';
                        break;
                    case 5:
                        $ret = 'mai';
                        break;
                    case 6:
                        $ret = 'jun';
                        break;
                    case 7:
                        $ret = 'jul';
                        break;
                    case 8:
                        $ret = 'ago';
                        break;
                    case 9:
                        $ret = 'set';
                        break;
                    case 10:
                        $ret = 'oct';
                        break;
                    case 11:
                        $ret = 'nov';
                        break;
                    case 12:
                        $ret = 'dec';
                        break;
                    default:
                        $ret = 'gen';
                        break;
                }
                break;
            
            case 'en':
                switch ($month)
                {
                    case 1:
                        $ret = 'jan';
                        break;
                    case 2:
                        $ret = 'feb';
                        break;
                    case 3:
                        $ret = 'mar';
                        break;
                    case 4:
                        $ret = 'apr';
                        break;
                    case 5:
                        $ret = 'may';
                        break;
                    case 6:
                        $ret = 'jun';
                        break;
                    case 7:
                        $ret = 'jul';
                        break;
                    case 8:
                        $ret = 'aug';
                        break;
                    case 9:
                        $ret = 'sep';
                        break;
                    case 10:
                        $ret = 'oct';
                        break;
                    case 11:
                        $ret = 'nov';
                        break;
                    case 12:
                        $ret = 'dec';
                        break;
                    default:
                        $ret = 'jan';
                        break;
                }
                break;
            
            default:
                switch ($month)
                {
                    case 1:
                        $ret = 'gen';
                        break;
                    case 2:
                        $ret = 'feb';
                        break;
                    case 3:
                        $ret = 'mar';
                        break;
                    case 4:
                        $ret = 'abr';
                        break;
                    case 5:
                        $ret = 'mai';
                        break;
                    case 6:
                        $ret = 'jun';
                        break;
                    case 7:
                        $ret = 'jul';
                        break;
                    case 8:
                        $ret = 'ago';
                        break;
                    case 9:
                        $ret = 'set';
                        break;
                    case 10:
                        $ret = 'oct';
                        break;
                    case 11:
                        $ret = 'nov';
                        break;
                    case 12:
                        $ret = 'dec';
                        break;
                    default:
                        $ret = 'gen';
                        break;
                }
                break;
        }
        
        return $ret;
    }
?>