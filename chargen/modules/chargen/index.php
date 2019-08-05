<?php
if (!defined('FLUX_ROOT')) exit;    
$this->loginRequired();

//Character Details 
$col  = "ch.name, ch.guild_id,
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
$sql .= "WHERE ch.account_id='".$session->account->account_id."'";
$sth  = $server->connection->getStatement($sql);
$sth->execute();
$charnames = $sth->fetchAll();
$name_array = array();
foreach ($charnames as $chars => $arr) {
	$name_array[$chars] = array(
		        'name' => $arr->name,
                'class' => $arr->class,
                'clothes_color' => $arr->clothes_color,
                'hair' => $arr->hair,
                'hair_color' => $arr->hair_color,
                'head_top' => $arr->head_top,
                'head_mid' => $arr->head_mid,
                'head_bottom' => $arr->head_bottom,
                'robe' => $arr->robe,
                'weapon' => $arr->weapon,
                'shield' => $arr->shield,
                'online' => $arr->online,
                'base_level' => $arr->base_level,
                'job_level' => $arr->job_level,
                'sex' => $arr->sex,
                'emblem_data' => $arr->emblem_data,
                'guild_id' => $arr->guild_id,
	);
}
$supported_file = Flux::config('supported_filetypes')->toArray();

//Avatar Background List
$dir = FLUX_ADDON_DIR."/".$this->moduleName.Flux::config('avatar_background');
$files = glob($dir."*.*");
$avaBGList = array();
foreach ($files as $images) {
	$ext = strtolower(pathinfo($images, PATHINFO_EXTENSION));
	if (in_array($ext, $supported_file)) $avaBGList[] = str_replace($dir, "", $images);
}

//Avatar Border List
$dir = FLUX_ADDON_DIR."/".$this->moduleName.Flux::config('avatar_border');
$files = glob($dir."*.*");
$avaBDList = array();
foreach ($files as $images) {
	$ext = strtolower(pathinfo($images, PATHINFO_EXTENSION));
	if (in_array($ext, $supported_file)) $avaBDList[] = str_replace($dir, "", $images);
}

//Signature Backgrounds List
$dir = FLUX_ADDON_DIR."/".$this->moduleName.Flux::config('signature_background');
$files = glob($dir."*.*");
$sigBGList = array();
foreach ($files as $images) {
	$ext = strtolower(pathinfo($images, PATHINFO_EXTENSION));
	if (in_array($ext, $supported_file)) $sigBGList[] = str_replace($dir, "", $images);
}

$_viewName = $this->viewName.".php";
$_moduleName = $this->moduleName;
$_count = strlen($_viewName) + strlen($_moduleName) + 1;
$_newThemePath = substr($this->viewPath, 0, -$_count);

?>