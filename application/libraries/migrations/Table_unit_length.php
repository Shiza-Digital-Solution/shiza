<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_unit_length {
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
		$schema = $this->CI->schema->create_table('unit_length');
        $schema->increments('lengthId', ['length' => '11']);
        $schema->string('lengthTitle', ['length' => '35']);
        $schema->string('lengthUnit', ['length' => '5']);
        $schema->decimal('lengthValue', ['length' => '15,8']);
        $schema->enum('lengthDefault', ['y', 'n']);
        $schema->run();
	}

	public function seeder(){

	}

}

