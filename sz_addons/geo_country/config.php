<?php
defined('BASEPATH') OR exit('No direct script access allowed');

return [
	'ADDONS_NAME'				=> ['id_ID'=> 'Geo negara', 'en_US' => 'Geo Country'],
	'ADDONS_DESCRIPTION'		=> 'Geo Country',
	'ADDONS_VERSION_NAME'		=> '1.0',
	'ADDONS_VERSION_CODE'		=> 1,
	'ADDONS_AUTHOR'				=> 'Shiza Digital',
	'ADDONS_AUTHOR_URL'			=> 'https://shiza.id/',
	'ADDONS_DOCUMENTATION_URL'	=> 'https://shiza.id/',

	'ADDONS_MENU_NUMBER'		=> 7,
	'ADDONS_MENU_ICON'			=> NULL,

	'ADDONS_MENU_CHILD_IN'		=> 'Pengaturan',

	/**
	 *  privilage addons
	 */
	'ADDONS_PRIVILEGE' 			=> ['view'=> 'y', 'add' => 'y', 'edit' => 'y', 'delete' => 'y']
];
