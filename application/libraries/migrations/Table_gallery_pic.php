<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_gallery_pic {
	/**
	 * !!! CAUTION !!!
	 * 
	 * Don't change the table name and class name because to important to seeder system
	 * 
	 * if you want to change the table name, copy your script code in this file
	 * remove this file with this bash 
	 * 
	 * php index.php Migration remove {table name}
	 * 
	 * then create new database with migration bash and paste you code before
	 */

	private $CI;

	public function __construct(){
		$this->CI =& get_instance();

        $this->CI->load->model('mc');
        $this->CI->load->library('Schema');
	}

	public function migrate(){
		$schema = $this->CI->schema->create_table('gallery_pic');
        $schema->increments('galpicId', ['type' => 'BIGINT', 'length' => '25']);
        $schema->integer('contentId', ['length' => '11']);
        $schema->text('galpicText');
        $schema->text('galpicPicture');
        $schema->string('galpicDir', ['length' => '25']);
        $schema->string('galpicPhotographer', ['length' => '225']);
        $schema->run();

        // ADD index
        $schema->index('contentId');
	}

	public function seeder(){
		
	}

}

