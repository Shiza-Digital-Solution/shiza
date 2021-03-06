<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Addons extends CI_Controller{ 

	private $moduleName = '';
	private $extensi_allowed = array();

	public function __construct(){
		parent::__construct();
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// define module name variable
		$this->moduleName = t('addons');

		// file extention allowed
		$this->extensi_allowed = array('zip');

		// load model
		$this->load->model('addons_model');
	}

	public function index(){
		if( is_view() ){

			if(!empty($this->input->get('kw'))){
				$datapage = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

				$table = 'addons';

				$excClause = '';

				$kw = $this->security->xss_clean( $this->input->get('kw') );

				$queryserach = "addonsName LIKE '%{$kw}%'";
				$excClause = " ( $queryserach )";	

				$perPage = 30;

				$where = $excClause;
				$params = [
					'where' => $where,
					'order' => ['addonsId'=>'DESC'],
					'limit' => [$perPage, $datapage]
				];
				$datauser = $this->sm->viewData('*', $table, $params);
				$rows = countdata($table, $where);

				$pagingURI = admin_url( $this->uri->segment(2) );

				$this->load->library('paging');
				$pagination = $this->paging->PaginationAdmin( $pagingURI, $rows, $perPage );
			} else {
				$datauser = $this->add_ons->getAllAddonsInfo();
				$pagination = '';
				$rows = count($datauser);
			}

			$data = array( 
						'title' => $this->moduleName . ' - '.get_option('sitename'),
						'page_header_on' => true,
						'title_page' =>  $this->moduleName,
						'title_page_icon' => '',
						'title_page_secondary' => '',
						'breadcrumb' => false,
						'header_button_action' => array(
											array(
												'title' => t('addnew'),
												'icon'	=> 'fe fe-plus',
												'access' => admin_url('addons/addnew'),
												'permission' => 'add'
											)
										),					
						'data' => $datauser,
						'pagination' => $pagination,
						'totaldata' => $rows			
					);
			
			$this->load->view( admin_root('addons_view'), $data );
		}
	}

	public function uploadaddon(){
		if( is_add() ){
			$error = false;

			if( empty($_FILES['addons']['tmp_name']) ){
				$error = t('emptyrequiredfield');
			}

			$dirname_addon = '';

			// check addon upload
			if(!empty($_FILES['addons']['tmp_name'])){
				$ext_file = strtolower(pathinfo($_FILES['addons']['name'], PATHINFO_EXTENSION));

				if(!in_array($ext_file,$this->extensi_allowed)) {

					$error = "<strong>".t('error')."!!</strong> " . t('wrongextentionfile');

				} else {

					$addonFile = $_FILES['addons']['tmp_name'];

					// check config file in zip
					$zip = zip_open($addonFile);

					if ($zip) {

						$availability_config = false; 

						while ($zip_entry = zip_read($zip)) {

							$z_entryname = zip_entry_name($zip_entry);
							$expname = explode('/',$z_entryname );

							if( $expname[1]!='config.php' ){ continue; }

							$availability_config = true; 
							$dirname_addon = $expname[0];

						}
						zip_close($zip);
						
						if(!$availability_config ){
							$error = "<strong>".t('error')."!!</strong> " . t('addonnotfoundconfig');
						}

					} else {

						$error = "<strong>".t('error')."!!</strong> " . t('zipcannotopen');
					}

				}
			}


			if(!$error){

				$targetzip = FCPATH . $_FILES["addons"]["name"];

				if(move_uploaded_file($_FILES['addons']['tmp_name'], FCPATH.$_FILES["addons"]["name"])) {

					$zip = new ZipArchive();
					$x = $zip->open($targetzip);  // open the zip file to extract
					
					if ($x === true) {

						$zip->extractTo(ADDONS_PATH); 
						$zip->close();
			
						unlink($targetzip);

						$this->session->set_flashdata( 'succeed', t('successfullyadd'));
						echo '<script>window.location.href = "'.admin_url('addons').'";</script>';

					} else {

						echo 'danger|'.t('error').'|'.t('addonextractfailed');

					}

				} else {

					// error condition
					// format: type|title|description
					echo 'danger|'.t('error').'|'.t('addonuploadfailed');

				}

			} else {
				// error condition
				// format: type|title|description
				echo 'danger|'.t('error').'|'.$error;
			}

		}
	}

	public function addnew(){
		if( is_add() ){
			$data = array( 
							'title' => $this->moduleName . ' - '.get_option('sitename'),
							'page_header_on' => true,
							'title_page' => $this->moduleName . ' - ' . t('addnew'),
							'title_page_icon' => '',
							'title_page_secondary' => '',
							'breadcrumb' => false,
							'header_button_action' => array(
												array(
													'title' => t('back'),
													'icon'	=> 'fe fe-corner-up-left',
													'access' => admin_url('addons'),
													'permission' => 'view'
												)
											),
						);

			$this->load->view( admin_root('addons_add'), $data );
		}
	}

	public function active($data){
		$data = esc_sql(filter_txt($data));

		$query = false;

		// check availability in database
		if( countdata('addons', ['addonsDirName'=>$data]) > 0 ){
			
			$sql = [
				'addonsActive' => 1
			];

			$query = $this->Env_model->update( 'addons', $sql, ['addonsDirName'=>$data]);

			if($query){

				if( countdata('users_menu', ['menuAccess' => $data]) > 0 ){
					$querymenu = array(
						'menuActive' => 'y'
					);
					// update to inactive menu
					$this->Env_model->update('users_menu',$querymenu, ['menuAccess' => $data]);
				}
				
			}
		} else {
			$addonsdata = $this->add_ons->getAddonsInfo( $data );

			if( count($addonsdata) > 0 ){

				$now = time2timestamp();

				// get default lang for multi language
				$getDefaultLang = $this->config->item('language');

				$menuname = $addonsdata['ADDONS_NAME'];
				if( is_array($addonsdata['ADDONS_NAME'])){
					$menuname = $addonsdata['ADDONS_NAME'][$getDefaultLang];
				}

				// get next ID
				$nextId = getNextId('addonsId', 'addons');

				$sql = [
					'addonsId' => $nextId,
					'addonsName' => $menuname,
					'addonsDirName' => $data,
					'addonsDesc' => $addonsdata['ADDONS_DESCRIPTION'],
					'addonsVersion' => $addonsdata['ADDONS_VERSION_NAME'],
					'addonsAdded' => $now,
					'addonsActive' => 1
				];

				$query = $this->sm->insert('addons',$sql);

				if($query){

					// icon 
					$menuicon = ($addonsdata['ADDONS_MENU_ICON']!=null)?$addonsdata['ADDONS_MENU_ICON']:'';

					// check parent menu in config
					$parentMenu = 0;
					if($addonsdata['ADDONS_MENU_CHILD_IN']!=NULL){

						if( countdata('users_menu', ['menuName' => $addonsdata['ADDONS_MENU_CHILD_IN']]) > 0){

							$parentMenu = getval('menuId', 'users_menu', ['menuName' => $addonsdata['ADDONS_MENU_CHILD_IN']]);

						} else {
							// get next ID
							$nextIdParentMenu = getNextId('menuId', 'users_menu');

							// insert new parent
							$dataquery = array(
								'menuId' => $nextIdParentMenu,
								'menuParentId' => 0,
								'menuName' => $addonsdata['ADDONS_MENU_CHILD_IN'],
								'menuType'=> 'noaccess',
								'menuAccess' => (string)'',
								'menuAddedDate' => $now,
								'menuSort' => (int) $addonsdata['ADDONS_MENU_NUMBER'],
								'menuIcon' => (string) $menuicon,
								'menuAttrClass' => (string) '',
								'menuActive' => 'y',
								'menuView' => 'y',
								'menuAdd' => 'n',
								'menuEdit' => 'n',
								'menuDelete' => 'n'
							);
		
							// insert data menu here
							$query = $this->sm->insert('users_menu',$dataquery);
							$parentMenu = $this->sm->insert_id();

							if($query){
								// update user privilege
								$nextIdmenupriv1 = getNextId('menuId', 'users_menu');

								$dataquerypriv = array(
									'lmnId' => $nextIdmenupriv1,
									'levelId' => 1,
									'menuId' => $parentMenu,
									'lmnView'=> 'y',
									'lmnAdd' => 'n',
									'lmnEdit' => 'n',
									'lmnDelete' => 'n'
								);
			
								// insert data menu here
								$query = $this->sm->insert('users_menu_access',$dataquerypriv);
							}
							
							// reset data
							$menuicon = '';
							$addonsdata['ADDONS_MENU_NUMBER']=1;

						}

					}

					// privilege
					$m_view 	= ($addonsdata['ADDONS_PRIVILEGE']['view']=='y')?'y':'n';
					$m_add 		= ($addonsdata['ADDONS_PRIVILEGE']['add']=='y')?'y':'n';
					$m_edit 	= ($addonsdata['ADDONS_PRIVILEGE']['edit']=='y')?'y':'n';
					$m_delete 	= ($addonsdata['ADDONS_PRIVILEGE']['delete']=='y')?'y':'n';

					// get next ID
					$nextIdmenu = getNextId('menuId', 'users_menu');

					$dataquery = array(
						'menuId' => $nextIdmenu,
						'menuParentId' => (int) $parentMenu,
						'menuName' => $menuname,
						'menuType'=> 'addons',
						'menuAccess' => $data,
						'menuAddedDate' => $now,
						'menuSort' => (int) $addonsdata['ADDONS_MENU_NUMBER'],
						'menuIcon' => (string) $menuicon,
						'menuAttrClass' => (string) '',
						'menuActive' => 'y',
						'menuView' => $m_view,
						'menuAdd' => $m_add,
						'menuEdit' => $m_edit,
						'menuDelete' => $m_delete
					);

					// insert data menu here
					$query = $this->sm->insert('users_menu',$dataquery);

					if($query){
						// insert if multilang first
						if( is_array($addonsdata['ADDONS_NAME'])){

							if( count($addonsdata['ADDONS_NAME']) > 0 ){

								foreach($addonsdata['ADDONS_NAME'] as $lang => $val){

									if($lang == $getDefaultLang){ continue; }

									$langnextId= getNextId('dtId', 'dynamic_translations');

									$insertlang = [
										'dtId' => $langnextId,
										'dtRelatedTable' => 'users_menu',
										'dtRelatedField' => 'menuName',
										'dtRelatedId' => $nextIdmenu,
										'dtLang' => $lang,
										'dtTranslation' => $val,
										'dtInputType' => 'text',
										'dtCreateDate' => $now,
										'dtUpdateDate' => $now
									];
									$this->sm->insert('dynamic_translations', $insertlang);
								}

							}
						}

						// get next ID
						$nextIdmenupriv = getNextId('lmnId', 'users_menu_access');

						// update user privilege
						$dataquerypriv = array(
							'lmnId' => $nextIdmenupriv,
							'levelId' => 1,
							'menuId' => $nextIdmenu,
							'lmnView'=> $m_view,
							'lmnAdd' => $m_add,
							'lmnEdit' => $m_edit,
							'lmnDelete' => $m_delete
						);
	
						// insert data menu here
						$query = $this->sm->insert('users_menu_access',$dataquerypriv);
					}
				}
			}
		}

		if($query){
			$this->session->set_flashdata( 'succeed', t('successfullyadd'));
		} else {
			$this->session->set_flashdata( 'failed', t('cannotprocessdata'));
		}

		redirect( admin_url('addons/') );

	}

	public function inactive($data){
		$data = esc_sql(filter_txt($data));

		$query = false;

		// check availability in database
		if( countdata('addons', ['addonsDirName'=>$data]) > 0 ){
			
			$sql = [
				'addonsActive' => 0
			];

			$query = $this->sm->update( 'addons', $sql, ['addonsDirName'=>$data]);

			if($query){
				if( countdata('users_menu', ['menuAccess' => $data]) > 0 ){
					$querymenu = array(
						'menuActive' => 'n'
					);

					// update to inactive menu
					$this->sm->update('users_menu',$querymenu, ['menuAccess' => $data]);
				}
			}
		}

		if($query){
			$this->session->set_flashdata( 'succeed', t('successfullyupdated'));
		} else {
			$this->session->set_flashdata( 'failed', t('cannotprocessdata'));
		}

		redirect( admin_url('addons/') );

	}

	protected function deleteAction($id){
		if( is_delete() ){
			$id = esc_sql( filter_txt( $id ) );

			$where = array('addonsDirName' => $id);
			$query = $this->Env_model->delete('addons', $where);

			removeDirectory( ADDONS_PATH . DIRECTORY_SEPARATOR .$id);

			// remove related
			$getmenuid = getval('menuId', 'users_menu', ['menuAccess' => $id]);
			$this->sm->delete('dynamic_translations', ['dtRelatedTable'=> 'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId' => $getmenuid]);
			$this->sm->delete('users_menu_access', ['menuId' => $getmenuid]);
			
			// remove main table
			$this->sm->delete('users_menu', ['menuAccess' => $id]);
			
			return true;
		}
	}
	public function delete($id){
		if( is_delete() ){
			$query = $this->deleteAction($id);
			if($query){

				$this->session->set_flashdata( 'succeed', t('successfullydeleted') );

			} else {

				$this->session->set_flashdata( 'failed', t('cannotprocessdata') );

			}

			redirect( admin_url('addons') );
		}
	}

	public function bulk_action(){
		$error = false;
		if(empty($this->input->post('bulktype'))){
			$error = "<strong>".t('error')."!!</strong> ". t('bulkactionnotselectedyet');
		}

		if(!$error){
			if( $this->input->post('bulktype')=='bulk_delete' AND is_delete() ){
				$theitem = (!empty($this->input->post('item'))) ? array_filter($this->input->post('item')):array();

				if( count($theitem) > 0 ){
					$stat_hapus = FALSE;

					foreach ($theitem as $key => $value) {
						if($value == 'y'){
							$id = filter_int($this->input->post('item_val')[$key]);

							$queryact = $this->deleteAction($id);

							if($queryact){

								$stat_hapus = TRUE;

							} else {

								$stat_hapus = FALSE; break;

							}
						}
					}

					if($stat_hapus){
						$this->session->set_flashdata( 'succeed', t('successfullydeleted') );
					} else {
					  	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
					}

					redirect( admin_url('addons') );
					exit;

				} else {
					$error = "<strong>".t('error')."</strong>".t('bulkactionnotselecteditemyet');
				}

			}
			redirect( admin_url('addons') );
		}

		if($error){
			show_error($error, 503,t('actionfailed'));
			exit;
		}
	}

}
