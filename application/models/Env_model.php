<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Env_model extends CI_model{

	// primitive  query
	public function query( $query ){
        $query = $this->db->query( $query );
		return $query->result_array();
	}

    // insert data
    public function insert($table, $data){
		$insert = $this->db->insert( $this->db->dbprefix($table), $data);
		if( $insert ) {
			return $this->db->insert_id();
		} else {
			return false;
		}
    }
    
    // update data
    public function update($table, $data, $where){
        $this->db->where( $where );
        return $this->db->update( $this->db->dbprefix($table), $data ); 
    }

    // delete data
    public function delete($table, $where){
        $this->db->where( $where );
        return $this->db->delete( $this->db->dbprefix($table));
    }

    // view data with "where" syntax
    public function view_where($fieldToDisplay='*', $table, $fieldReference){

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
        }

        $this->db->select( $fieldToDisplay );
        $this->db->where($fieldReference);
        return $this->db->get( $theTable )->result_array();
    }

    // view data with "where and limit" syntax
    public function view_where_limit($fieldToDisplay='*', $table, $fieldReference, $limit, $offset=null){

        $this->db->select( $fieldToDisplay );
        $this->db->where($fieldReference);
        if($offset != null){
            $this->db->limit($limit, $offset);
        } else {
            $this->db->limit($limit);            
        }

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
        }

        return $this->db->get( $theTable )->result_array();
    }

    // view data with "order and limit" syntax
    public function view_order_limit($fieldToDisplay='*', $table, $order, $ordering, $limit, $offset=null){

        $this->db->select( $fieldToDisplay );
        $this->db->order_by($order,$ordering);

        if($offset != null){
            $this->db->limit($limit, $offset);
        } else {
            $this->db->limit($limit);            
        }

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
        }

        return $this->db->get( $theTable )->result_array();
    }

    // view data with "where, order and limit" syntax
    public function view_where_order_limit($fieldToDisplay='*', $table, $fieldReference, $order, $ordering, $limit, $offset=null){

        $this->db->select( $fieldToDisplay );
        $this->db->where($fieldReference);
        $this->db->order_by($order,$ordering);

        if($offset != null){
            $this->db->limit($limit, $offset);
        } else {
            $this->db->limit($limit);            
        }

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
        }

        return $this->db->get( $theTable )->result_array();
    }
    
    // view data with "order" syntax
    public function view_order($fieldToDisplay='*', $table, $order, $ordering){

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
        }

        $this->db->select( $fieldToDisplay );
        $this->db->from( $theTable );
        $this->db->order_by($order,$ordering);
        return $this->db->get()->result_array();
    }

    // view data with "where and order" syntax
    public function view_where_order($fieldToDisplay='*', $table, $fieldReference, $order, $ordering){

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
        }

        $this->db->select( $fieldToDisplay );
        $this->db->where($fieldReference);
        $this->db->order_by($order,$ordering);
        $query = $this->db->get( $theTable );
        return $query->result_array();
	}
	
	/**
	 * 
	 * 
	 *  VIEW WITH JOIN TABLE
	 * 
	 * 
	 */

	// view data with "where" syntax
    public function view_join_where($fieldToDisplay='*', $table, $join, $joincond, $jointype = '', $fieldReference){

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
		}

        $this->db->select( $fieldToDisplay );
        $this->db->from( $theTable );
		$this->db->join($this->db->dbprefix($join), $joincond, $jointype);
        $this->db->where($fieldReference);
		return $this->db->get()->result_array();
    }

    // view data with "where and limit" syntax
    public function view_join_where_limit($fieldToDisplay='*', $table, $join, $joincond, $jointype = '', $fieldReference, $limit, $offset=null){

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
		}
		

        $this->db->select( $fieldToDisplay );
        $this->db->from( $theTable );
		$this->db->join($this->db->dbprefix($join), $joincond, $jointype);
        $this->db->where($fieldReference);
        if($offset != null){
            $this->db->limit($limit, $offset);
        } else {
            $this->db->limit($limit);            
        }

        return $this->db->get()->result_array();
    }

    // view data with "order and limit" syntax
    public function view_join_order_limit($fieldToDisplay='*', $table, $join, $joincond, $jointype = '', $order, $ordering, $limit, $offset=null){

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
		}
		
        $this->db->select( $fieldToDisplay );
        $this->db->from( $theTable );
		$this->db->join($this->db->dbprefix($join), $joincond, $jointype);
        $this->db->order_by($order,$ordering);

        if($offset != null){
            $this->db->limit($limit, $offset);
        } else {
            $this->db->limit($limit);            
        }

        return $this->db->get()->result_array();
    }

    // view data with "where, order and limit" syntax
    public function view_join_where_order_limit($fieldToDisplay='*', $table, $join, $joincond, $jointype = '', $fieldReference, $order, $ordering, $limit, $offset=null){

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
		}
		
        $this->db->select( $fieldToDisplay );
        $this->db->from( $theTable );
		$this->db->join($this->db->dbprefix($join), $joincond, $jointype);
        $this->db->where($fieldReference);
        $this->db->order_by($order,$ordering);

        if($offset != null){
            $this->db->limit($limit, $offset);
        } else {
            $this->db->limit($limit);            
        }

        return $this->db->get()->result_array();
    }
    
    // view data with "order" syntax
    public function view_join_order($fieldToDisplay='*', $table, $join, $joincond, $jointype = '', $order, $ordering){

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
        }

        $this->db->select( $fieldToDisplay );
        $this->db->from( $theTable );
		$this->db->join($this->db->dbprefix($join), $joincond, $jointype);
        $this->db->order_by($order,$ordering);
        return $this->db->get()->result_array();
    }

    // view data with "where and order" syntax
    public function view_join_where_order($fieldToDisplay='*', $table, $join, $joincond, $jointype = '', $fieldReference, $order, $ordering){

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
        }

        $this->db->select( $fieldToDisplay );
        $this->db->from( $theTable );
		$this->db->join($this->db->dbprefix($join), $joincond, $jointype);
        $this->db->where($fieldReference);
        $this->db->order_by($order,$ordering);
        $query = $this->db->get();
        return $query->result_array();
	}

    // baca ID berikutnya yang akan dibuat, patokan adalah ID pada data terakhir +1
    public function getNextId($idfield,$tablename){
        if( is_array($tablename) ){
            $dttable = array();
            foreach ($tablename as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($tablename);
        }

        $this->db->select_max($idfield, 'latestId');
        $latestId = $this->db->get( $theTable )->row()->latestId;
        $nowId=1;
        if (!empty($latestId)){
            $nowId = $latestId+1;
        }
        return $nowId;
    }

    public function nextSort($table, $sortfieldname, $where=null) {
        $this->db->select_max($sortfieldname, 'maksimalsort');
        if(!empty($where)){
            $this->db->where($where);
        }

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
        }

        $maksimalsort = $this->db->get( $theTable )->row()->maksimalsort;
        $nextSort = $maksimalsort + 1;
        return $nextSort;
    }


    // hitung total baris data
    public function countdata($table,$whereClause=null){
        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
        }

        $this->db->select("count(*) AS total");
        $this->db->from( $theTable );
        if($whereClause!==null){ $this->db->where($whereClause); }
        $query = $this->db->get();
        return $query->row()->total;
    }

    // getval hanya mengambil 1 baris data dari tabel
    public function getval($fieldToDisplay,$table,$fieldReference=null,$method_data = 'array'){
        $error=false;

        $result_ = '';
        if( $this->countdata($table, $fieldReference) > 0 ){

            if( is_array($table) ){
                $dttable = array();
                foreach ($table as $key => $val) {
                    $dttable[] = $this->db->dbprefix( $val );
                }
                $theTable = implode(',', $dttable);
            } else {
                $theTable = $this->db->dbprefix($table);
            }

            $this->db->select( $fieldToDisplay );
            $this->db->from( $theTable );

            if( !is_null($fieldReference) ){
                $this->db->where($fieldReference);
            }

            $this->db->limit(1);

            $query = $this->db->get();

            if(!$query){
                if(!$error){
                    $error = 'Server sedang sibuk. Data tidak dapat diproses';
                }else{
                    $error .= 'Server sedang sibuk. Data tidak dapat diproses';
                }

                show_error($error,503,'Server sibuk');
                exit;
            }

            $data = $query->result_array()[0];

            $result = array();
            $countdata = count($data);
            if($countdata > 0){
                foreach($data as $key => $value){
                    if($countdata > 1){
                        $result[$key] = $value;
                    } else {
                        $result = $value; break;
                    }
                }
            }

            if($method_data == 'object'){
                $result_ = (object) $result;
            } elseif($method_data == 'array'){
                $result_ = $result;
            }
        }
        return $result_;
    }

    public function getMax($field, $table, $where = null, $fieldview = null){
        if(!empty($fieldview)){
            $this->db->select_max($field, $fieldview);
            $fieldview = $fieldview;
        } else {
            $this->db->select_max($field);
            $fieldview = $field;
        }

        if(!empty($where)){
            $this->db->where($where);
        }

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
        }
        
        $latest = $this->db->get( $theTable )->row_array()[$fieldview];
        return $latest;
    }



    public function getMin($field, $table, $where = null, $fieldview = null){
        if(!empty($fieldview)){
            $this->db->select_min($field, $fieldview);
            $fieldview = $fieldview;
        } else {
            $this->db->select_min($field);
            $fieldview = $field;
        }

        if(!empty($where)){
            $this->db->where($where);
        }

        if( is_array($table) ){
            $dttable = array();
            foreach ($table as $key => $value) {
                $dttable[] = $this->db->dbprefix( $value );
            }
            $theTable = implode(',', $dttable);
        } else {
            $theTable = $this->db->dbprefix($table);
        }
        
        $latest = $this->db->get( $theTable )->row_array()[$fieldview];
        return $latest;
    }

    // truncate
    public function truncate($tablename = null){

        if( !empty($tablename) ){
            $this->db->truncate($this->db->dbprefix($tablename));
        }

    }

    public function enum_values( $table, $field ){
        $table = $this->db->dbprefix($table);
        $query = $this->db->query( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" );
        $dataresult = $query->result_array();

		if( count($dataresult[0]) >0 ){
			$type = $dataresult[0]['Type'];
		    preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
		    $enum = explode("','", $matches[1]);
		    $return = $enum;
		}

		return $return;
	}
}
