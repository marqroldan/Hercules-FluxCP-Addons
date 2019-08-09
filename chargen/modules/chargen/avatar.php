<?php
if (!defined('FLUX_ROOT')) exit;
define('__ROOT__', dirname(__FILE__) . '/'); 

$name_ = $params->get('name');
$request = -1;
if ($params->get('request')!='') {
	$name_ = $params->get('request');
	$request = 2;
}
elseif(count($_POST)) {
	$request = 1;
}
elseif(count($params->toArray())>2) {
	$request = 0;
}

function generateTemp($dir) {
	if(!is_dir($dir)) {
		if(!mkdir($dir)) {
		echo "Warning: cannot create temp folder.";
		}
	}
}

$ava_BGDir = FLUX_ADDON_DIR."/".$this->moduleName."/data/avatar/";
$avatarTMP_dir = FLUX_DATA_DIR.'/tmp/avatar/';

generateTemp($avatarTMP_dir);

//$account_ava = $avatarTMP_dir.md5($session->account->account_id).'.php';
$char_ava =  $avatarTMP_dir.$name_.'.png';
$char_details = $avatarTMP_dir.$name_.'.php';

/*** Character Generation ****/
// Default Values
$char_detail = Flux::config('char_detail')->toArray();
$char_detail['bg_loc'] = $ava_BGDir;
$char_detail['background'] = Flux::config('default_avaBG');
$char_detail['border'] = Flux::config('default_avaBD');
$char_detail_count = count ($char_detail);

// Replace Values 
foreach ($params->toArray() as $field_name => $field_value) {
	if ($params->get($field_name) != "") {
		$char_detail[$field_name] = $params->get($field_name);
	}
}

require_once( __ROOT__ . 'core/class.Controller.php');
require_once( __ROOT__ . 'core/class.Cache.php');
require_once( __ROOT__ . 'core/class.Client.php');
require_once( __ROOT__ . 'core/class.DB.php');
require_once( __ROOT__ . 'core/class.Debug.php');
 
 
DB::$path 			  =     __ROOT__ . "db/"     ;
Client::$path         =     FLUX_ADDON_DIR."/".$this->moduleName."/grf/" ;   // Define where your client path is (where you put your grfs, data, etc.)
Client::$data_ini     =     Flux::config("Data_INI")           ;   // The name of your DATA.INI (to locate your grfs, if not set: grfs will not be loaded)
Client::$AutoExtract  =     Flux::config('AutoExtract')                 ;   // If true, client will save extracted files from GRF into the data folder.
Client::init();

// Renderer for Avatar
require_once(  __ROOT__ . 'render/class.CharacterRender.php' );
require_once(  __ROOT__ . 'loaders/Bmp.php');
$chargen                 = new CharacterRender();
$char_detail['action_'] = constant('CharacterRender::'.$char_detail['action_']);

if ((count($char_detail)-4 == $char_detail_count) && array_key_exists('preview',$char_detail) && ($char_detail['preview'])) {
		$chargen->changeData($char_detail);
		header('Content-type:image/png');
		imagepng($chargen->render(0));
		exit();
}
elseif (file_exists($char_details)) {
	if (count($_POST)==0) $char_detail = unserialize(file_get_contents($char_details, null, null, 28));
	
	
	if((time() - filemtime($char_ava)) > (Flux::config('ChargenCacheTime') * 60)) {
		if (generateImage($name_, $_POST, $server, $char_detail, $char_details, $char_ava, $session, $chargen))
			$this->redirect($this->url('chargen'));
	}
	else {
		header('Content-type:image/png');
		imagepng(imagecreatefrompng($char_ava));
		exit();
	}
}
elseif (!file_exists($char_details) && (count($_POST) > 0)) {
		if (generateImage($name_, $_POST, $server, $char_detail, $char_details, $char_ava, $session, $chargen))
			$this->redirect($this->url('chargen'));
}
else {
	$session->setMessageData("Avatar not available.");
}
			
function generateImage($name_, $_post, $server, $char_detail, $char_details, $char_ava, $session, $chargen) {
	//Latest data of the character
	$col  = "ch.name, ch.guild_id, ch.account_id,
			ch.class, ch.clothes_color,
			ch.hair, ch.hair_color,
			ch.head_top, ch.head_mid, ch.head_bottom,
			ch.robe, ch.weapon, ch.shield,
			ch.online, ch.base_level, ch.job_level,
			login.sex,
			guild.emblem_data 
			";
	$sql  = "SELECT $col FROM {$server->charMapDatabase}.`char` AS ch ";
	$sql .= "LEFT OUTER JOIN {$server->loginDatabase}.login ON login.account_id = ch.account_id ";
	$sql .= "LEFT OUTER JOIN {$server->charMapDatabase}.`guild` ON guild.guild_id = ch.guild_id ";
	
	if (count($_POST)) {
		$sql .= "WHERE ch.name='".$name_."' AND ch.account_id = {$session->account->account_id} LIMIT 1";
	}
	else {
		$sql .= "WHERE ch.name='".$name_."' LIMIT 1";
	}
	
	$sth  = $server->connection->getStatement($sql);
	$sth->execute();
	$char = $sth->fetchAll();
	$char = $char[0];
	
	if($char) {
		$char_detail['name']			 = $char->name;
		$char_detail['guild_id'] 		 = $char->guild_id; 		
		$char_detail['class'] 			 = $char->class; 			
		$char_detail['clothes_color'] 	 = $char->clothes_color; 	
		$char_detail['hair'] 			 = $char->hair; 			
		$char_detail['hair_color'] 		 = $char->hair_color; 	
		$char_detail['head_top'] 		 = $char->head_top; 		
		$char_detail['head_mid'] 		 = $char->head_mid; 		
		$char_detail['head_bottom'] 	 = $char->head_bottom; 	
		$char_detail['robe'] 			 = $char->robe; 			
		$char_detail['weapon'] 			 = $char->weapon; 		
		$char_detail['shield'] 			 = $char->shield; 		
		$char_detail['online'] 			 = $char->online; 		
		$char_detail['base_level'] 		 = $char->base_level; 	
		$char_detail['job_level'] 		 = $char->job_level; 		
		$char_detail['sex'] 			 = $char->sex; 			
		$char_detail['emblem_data'] 	 = $char->emblem_data; 	
		
		
		$chargen->changeData($char_detail);
		
		if (count($_POST)) {
			$fp = fopen($char_details, 'w');
			if (is_resource($fp)) {
				fwrite($fp, '<?php exit("Forbidden."); ?>');
				fwrite($fp, serialize($char_detail));
				fclose($fp);
			}
			imagepng($chargen->render(0),$char_ava);
			$session->setMessageData("Successfully saved.");
			return true;
		}
		else {
			header('Content-type:image/png');
			imagepng($chargen->render(0));
			exit();
		}
	}
	else {
		$session->setMessageData("Character is not found in your account.");
		return true;
	}
}	
?>