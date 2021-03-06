<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AssetsLoc {
	protected $CI;

	protected $js_admin_files			= array();
	protected $js_admin_values_request 	= '';

	protected $css_admin_files			= array();
	protected $css_admin_values_request = '';

	protected $footer_element = '';

	public function __construct(){
        $this->CI =& get_instance();
	}

	/*
	* Load admin stylesheet
	*/
	public function reg_admin_style( $cssfiles = array(), $stylesheet='' ){
		if(count($cssfiles) > 0){
			foreach ($cssfiles as $valuecss) {
				$this->css_admin_files[] = $valuecss;
			}
		}

		if(!empty($stylesheet)){
			$this->css_admin_values_request .= $stylesheet;
		}
	}

	public function get_admin_style( $type = 'library' ){
		$view = '';

		if( $type=='library' AND count($this->css_admin_files) > 0){
			
			$libdatacss = array_unique($this->css_admin_files);

			foreach (array_filter($libdatacss) as $keyfiles => $valuefiles) {
				$view .= "<link href=\"".admin_assets()."/".$valuefiles."\" rel=\"stylesheet\" type=\"text/css\">\n";
			}
		}

		if($type == 'manually' AND !empty($this->css_admin_values_request)){
			$view .= "<style type=\"text/css\">\n";
			$view .= $this->css_admin_values_request;
			$view .= "\n</style>";
		}

		return $view;
	}

	/*
	* Load admin javascript
	*/
	public function reg_admin_script( $jsfiles = array(), $script='' ){
		if(count($jsfiles) > 0){
			foreach ($jsfiles as $value) {
				$this->js_admin_files[] = $value;
			}
		}

		if(!empty($script)){
			$this->js_admin_values_request .= $script;
		}
	}
	
	public function get_admin_script($type = 'library'){
		$view = '';

		if($type == 'library' AND count($this->js_admin_files) > 0){

			$libdatajs = array_unique($this->js_admin_files);

			foreach ( array_filter( $libdatajs ) as $keyfiles => $valuefiles) {
				$view .= "<script src=\"".admin_assets()."/".$valuefiles."\"></script>\n";
			}
		}

		if($type == 'manually' AND !empty($this->js_admin_values_request)){
			$view .= "<script type=\"text/javascript\">\n";
			$view .= $this->js_admin_values_request;
			$view .= "\n</script>";
		}

		return $view;
	}

	/*
	* place element to footer
	*/
	public function place_element_to_footer( $script='' ){
		if( is_array($script) ){
			$result = '';
			foreach ($script as $key => $value) {
				$result .= $value;
			}
			$this->footer_element .= $result;
		} else {
			$this->footer_element .= $script;
		}
	}

	public function get_footer_element(){
		return $this->footer_element;
	}
}
