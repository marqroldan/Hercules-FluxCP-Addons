<?php
return array(
	'MenuItems' => array(
		'Addons' => array(
			'Avatar and Signature Generator' => array('module' => 'chargen')
		)
	),
	'ChargenCacheTime' => 0.1,  ///// In minutes
	'default_avaBG' => "background00.jpg", //Default Avatar Background BG
	'default_avaBD' => "border.png", //Default Avatar Border
	'default_sigBG' => "background01.jpg",
	'Data_INI' => "DATA.INI",
	'AutoExtract' => true,
	'supported_filetypes' => array('gif','jpg','jpeg','png'), //List of supported filetypes for background and border.
	
	/** Directories */
	'avatar_background' => "/data/avatar/background/",
	'avatar_border' => "/data/avatar/border/",
	'signature_background' => "/data/signature/background/",
	
/* Character Details Default Value */
	'char_detail' => array(
	        'name' 				=> "Unknown",
            'class'				=> 0,
            'clothes_color' 	=> 0,
            'hair' 				=> 2,
            'hair_color' 		=> 0,
            'head_top' 			=> 0,
            'head_mid' 			=> 0,
            'head_bottom' 		=> 0,
            'robe' 				=> 0,
            'weapon' 			=> 0,
            'shield' 			=> 0,
            'online' 			=> 0,
            'base_level' 		=> 0,
            'job_level' 		=> 0,
            'sex' 				=> "M",
            //'emblem_data' 		=> null,
			
			//Fixed Data
			'direction'	 		=> 0,
			'action_'			=> 'ACTION_READYFIGHT',
			'doridori'			=> 0,
			'body_animation'	=> 0,
			
			//Border
			'no_border'			=> true, // If you don't want borders by default, set this to true.
	),
)
?>