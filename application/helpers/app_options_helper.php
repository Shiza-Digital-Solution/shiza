<?php 
/**************** CHECKMIGRATION ********************/
function isNotMigration() {
    $ci =& get_instance();
    $segment = trim( strtolower( $ci->uri->segment(1) ) );
    if( $segment != 'migration') return true;
    else return false;
}

/**************** MULTILANG OPTION ********************/
/**
 *
 * get locales name
 *
 * @param string $locales
 * @param bool $country
 * 
 * @return string
 */
function locales($locales=null, $country=FALSE){
    $ci =& get_instance();

    if( $locales == null ){ $locales = $ci->config->item('language'); }

    $locale = $ci->config->load('locales')[$locales];
    
    if( $country === TRUE ) { $result = $locale; }
    else { $result = preg_replace('# \((.*?)\)#', '', $locale); }
    
    return $result;
}

/**
 *
 * get language directory code
 *
 * @return array 
 */
function langlist(){
    $ci =& get_instance();

    // get language directory
    $filedir = scandir(APPPATH . 'language');

    $result = array();

    if( is_dir(APPPATH . 'language') ){
        
        foreach ($filedir as $key => $thefile) {
            if ($thefile != "." && $thefile != ".." && $thefile != 'index.html'){
                $filename = pathinfo($thefile, PATHINFO_FILENAME );

                // check lang array availability here
                if( !array_key_exists( $filename, $ci->config->load('locales') ) ){
                    show_error('Terdapat nama direktori bahasa yang tidak valid', 503, 'Bahasa tidak valid'); exit;
                }

                $result[]  = $filename;
            }
        }        

    }
    
    return $result;
}

/**
 *
 * Check if this site is multilanguage
 *
 * @return bool 
 */
function is_multilang(){

	$result = FALSE;
	if( count( langlist() ) > 1 ) $result = TRUE;

	return $result;
}

/**
 *
 * Fetching a line of text in multilanguage
 *
 * @param string|array
 * @param bool
 * 
 * @return string
 */
function t($line, $log_errors=FALSE){
    $ci =& get_instance();
    $result = '';

    if( is_array( $line ) ){
        $db_table   = $line['table'];
        $db_field   = $line['field'];
        $relid      = $line['id'];

        $ci->load->helper('cookie');        

        if( is_multilang() AND (get_cookie('admin_lang')!==null OR get_cookie('lang')!==null ) ){
            $lang = '';
            if( strpos(current_url(), $ci->config->item('admin_slug') ) ){
                $lang = empty(get_cookie('admin_lang')) ? t('locale'):get_cookie('admin_lang');
            } else {
                $lang = empty(get_cookie('lang')) ? t('locale'):get_cookie('lang');
            }

            $sqlclause = "dtRelatedField='{$db_field}' AND dtRelatedTable='{$db_table}' AND dtRelatedId='{$relid}' AND dtLang='{$lang}'";
            $countdata = countdata("dynamic_translations",$sqlclause);

            if($countdata > 0){
                $data = getval("dtLang,dtTranslation,dtInputType","dynamic_translations",$sqlclause);
                $result = $data['dtTranslation'];
            } else {
                // get ID field on table
                $querymysql = $ci->db->query("SHOW KEYS FROM ".$ci->db->dbprefix($db_table)." WHERE Key_name = 'PRIMARY'");
                $theDB = $querymysql->result_array()[0];
                
                $data = getval($db_field, $db_table, "{$theDB['Column_name']}='{$relid}'");
                $result = $data;
            }
            
        } else {
            // get ID field on table
            $querymysql = $ci->db->query("SHOW KEYS FROM ".$ci->db->dbprefix($db_table)." WHERE Key_name = 'PRIMARY'");
            $theDB = $querymysql->result_array()[0];

            $data = getval($db_field, $db_table, "{$theDB['Column_name']}='{$relid}'");
            $result = $data;
        }

    } else {
        $result = $ci->lang->line($line, $log_errors);
    }
        
    return $result;
}

/**************** Encription ********************/
function encoder($str){
    $iv = substr(hash('sha256', AUTH_SALT), 0, 16); 
    $encrypted = openssl_encrypt($str, 'aes-128-cbc', AUTH_SALT, 0, $iv);

    $encrypted = base64_encode($encrypted);
    return urlencode(trim($encrypted));
}

function decoder($str){
    if(preg_match('/%/', $str)){
        $str = urldecode(trim($str));
    }
    $str = base64_decode($str);

    $iv = substr(hash('sha256', AUTH_SALT), 0, 16);
    $decrypted = openssl_decrypt($str, 'aes-128-cbc', AUTH_SALT, 0, $iv);

    return trim($decrypted);
}

/**************** Options from DB ********************/
function get_option($optname){
    $ci =& get_instance();
    if(isNotMigration()) {

        if( check_option($optname) > 0){
            $ci->db->select('optionValue');
            $ci->db->from( $ci->db->dbprefix('options') );
            $ci->db->where('optionName', $optname);
            $query = $ci->db->get();
            return $query->row()->optionValue;
        } else {
            return null;
        }
    }
}

function check_option($optname){
    $ci =& get_instance();
    $ci->db->select('count(*) AS total');
    $ci->db->from( $ci->db->dbprefix('options') );
    $ci->db->where("optionName='{$optname}'");
    $query = $ci->db->get();
    return $query->row()->total;
}

function set_option($option, $value = ''){
    $ci =& get_instance();
    $ci->db->set('optionValue', $value);
    $ci->db->where('optionName', $option);
    return $ci->db->update( $ci->db->dbprefix('options') );
}

function add_option($option, $value = ''){
    $ci =& get_instance();
    $data = array(
            'optionName' => $option,
            'optionValue' => $value
    );
    return $ci->db->insert( $ci->db->dbprefix('options'), $data); 
}

function delete_option($option){
    $ci =& get_instance();
    return $ci->db->delete( $ci->db->dbprefix('options'), array('optionName' => $option));; 
}

function loginCP(){
    $ci =& get_instance();
    $ci->load->helper('cookie');
    $create_cp_code = "[[[". AUTH_SALT."]]]>>2ad68f5saa>>".base_url();
    return sha1($create_cp_code).'||'.get_cookie('sz_token');
}

/**************** Social media ********************/
function get_social_url($social=''){
    $social_url_opt = get_option('socialmediaurl');

    $array_social_url = unserialize($social_url_opt);

    if(empty($social_url_opt)){
        $social_url = false;
    } else {
        $social_url = ( empty($array_social_url[$social]) ) ? '' : $array_social_url[$social];
    }
    return $social_url;
}

/**************** Templating location ********************/
function template_root($themeroot = null){
    $mainroot = get_option('template').'/main';
    if(!empty($themeroot)){ $mainroot = $mainroot.'/'.$themeroot; }
    return $mainroot;
}

function web_assets($rootassets = null){
    $assets = base_url('assets');
    if(!empty($rootassets)){ $assets = $assets.'/'.$rootassets; }
    return $assets;
}

function web_path( $themeroot = null ){
    $mainroot = V_BASE_PATH . DIRECTORY_SEPARATOR . get_option('template');
    if(!empty($themeroot)){ $mainroot = $mainroot.'/'.$themeroot; }
    return $mainroot;
}

function admin_root($themeroot = null){
    $adminroot = 'admin';
    if(!empty($themeroot)){ $adminroot = $adminroot.'/'.$themeroot; }
    return $adminroot;
}

function admin_assets($rootassets = null){
    $adm_assets = web_assets('admin');
    if(!empty($rootassets)){ $adm_assets = $adm_assets.'/'.$rootassets; }
    return $adm_assets;
}

function admin_url($rootaccess = null){
    $ci =& get_instance();
    
    $adm_url = base_url() . $ci->config->item('admin_slug');
    if(!empty($rootaccess)){ $adm_url = $adm_url.'/'.$rootaccess; }
    return $adm_url;
}

/**************** Files dir URL ********************/
function files_url($dir_uri = '') {    
    $files_url = base_url("storage/files/".$dir_uri);
        return $files_url;
}

function images_url($dir_uri = '') {
    $images_url = base_url("storage/images/".$dir_uri);
        return $images_url;
}

/**************** web information ********************/
function web_info($info = '') {
    switch( $info ) {
        case 'home' :
        case 'url' :
            $output = base_url();
            break;
        case 'deskripsi':
            $output = get_option('sitedescription');
            break;
        case 'tagline':
            $output = get_option('tagline');
            break;
        case 'php_support':
            $output = get_option('phpsupport');
            break;
        case 'php_versi':
            if( SYSTEM_INFO_LOCKED == FALSE ){ $sysfo = phpversion(); } else { $sysfo = ''; }
            $output = $sysfo;
            break;
        case 'mysql_versi':
            if( SYSTEM_INFO_LOCKED == FALSE ){ $sysfo = mysql_get_server_info(); } else { $sysfo = ''; }
            $output = $sysfo;
            break;
        case 'keyword':
            $output = get_option('sitekeywords');
            break;
        case 'robots':
            $output = get_option('robots');
            break;
        case 'rss_url':
            $output = base_url()."/rss.xml";
            break;
        case 'version':
            $output = CMS_VERSION;
            break;
        case 'nama':
        default:
            $output = get_option('sitename');
            break;
    }
    return $output;
}


/**************** Head web ********************/
function web_head_properties($opt = array()){
    $ci =& get_instance();

    $view = empty($opt['meta_keyword'])?"":"<meta name=\"keywords\" content=\"".$opt['meta_keyword']."\" />\n";
    $view .= empty($opt['meta_description'])?"":"<meta name=\"description\" content=\"".$opt['meta_description']."\" />\n";
    $view .= empty($opt['meta_robots'])?"":"<meta name=\"robots\" content=\"".$opt['meta_robots']."\"/>\n";

    $view .= empty($opt['meta_ogimage'])?"":"<meta property=\"og:image\" content=\"".$opt['meta_ogimage']."\"/>\n";
    $view .= empty($opt['meta_ogtitle'])?"":"<meta property=\"og:title\" content=\"".$opt['meta_ogtitle']."\"/>\n";
    $view .= empty($opt['meta_ogtype'])?"":"<meta property=\"og:type\" content=\"".$opt['meta_ogtype']."\"/>\n";
    $view .= empty($opt['meta_ogdescription'])?"":"<meta property=\"og:description\" content=\"".$opt['meta_ogdescription']."\"/>\n";
    $view .= empty($opt['meta_ogurl'])?"":"<meta property=\"og:url\" content=\"".$opt['meta_ogurl']."\"/>\n";
    $view .= empty($opt['meta_ogsitename'])?"":"<meta property=\"og:site_name\" content=\"".$opt['meta_ogsitename']."\"/>\n";

    $view .= empty($opt['meta_articlesection'])?"":"<meta property=\"article:section\" content=\"".$opt['meta_articlesection']."\" />\n";

    $view .= empty($opt['meta_twtimg'])?"":"<meta name=\"twitter:image:src\" content=\"".$opt['meta_twtimg']."\"/>\n";
    $view .= empty($opt['meta_twttitle'])?"":"<meta name=\"twitter:title\" content=\"".$opt['meta_twttitle']."\"/>\n";
    $view .= empty($opt['meta_twtdescription'])?"":"<meta name=\"twitter:description\" content=\"".$opt['meta_twtdescription']."\"/>\n";
    $view .= empty($opt['meta_twtcard'])?"":"<meta name=\"twitter:card\" content=\"".$opt['meta_twtcard']."\"/>\n";
    $view .= empty($opt['meta_twtsite'])?"":"<meta name=\"twitter:site\" content=\"".$opt['meta_twtsite']."\"/>\n";
    $view .= empty($opt['meta_twtcreator'])?"":"<meta name=\"twitter:creator\" content=\"".$opt['meta_twtcreator']."\"/>\n";

    $view .= "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"".web_info('nama')." &raquo; News Feed\" href=\"".base_url()."rss.xml\" />\n";

    $view .= empty($opt['web_canonical'])?"":"<link rel=\"canonical\" href=\"".$opt['web_canonical']."\" />\n";

    return $view;
}

function favicon_img_url(){
    $favicon_data = get_option('favicon');
    
    if($favicon_data!=''){
        $array_fav = unserialize($favicon_data);
        $url = images_url()."/".$array_fav['directory']."/".$array_fav['filename'];
    } else {
        $url = base_url()."favicon.ico";
    }

    return $url;
}

function the_favicon($display = true){
    // Tampilkan
    if ( $display ){        
        echo "\n\n".'<link rel="icon" href="'.favicon_img_url().'" type="image/x-icon">'."\n";
        echo '<link rel="shortcut icon" href="'.favicon_img_url().'" type="image/x-icon">'."\n";
    }
    else {      
        return "\n\n".'<link rel="icon" href="'.favicon_img_url().'" type="image/x-icon">'."\n";
        return '<link rel="shortcut icon" href="'.favicon_img_url().'" type="image/x-icon">'."\n";
    }
}

function logo_url($_size=NULL){

    $url = base_url()."logo.png"; 

    if(check_option('weblogo')){
        $logo_data = get_option('weblogo');

        $array_logo = unserialize($logo_data);
        
        $image = "medium_".$array_logo['filename'];
        if($_size != NULL){
            $image = $_size."_".$array_logo['filename'];
        }

        $url = images_url()."/".$array_logo['directory']."/".$image;
    }

    return $url;
}

function modalDelete($idModal = null, $content ='', $urldestination = ''){
    $ci =& get_instance();
    $ci->load->library('assetsloc');

    if( !empty($idModal) AND !empty($content) AND !empty($urldestination) ){
        
        $data = '<!-- Modal -->
        <div class="modal fade" id="'.$idModal.'" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="width:400px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">'.t('delete').'</h5>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">'.t('close').'</span></button>
                    </div>
                    <div class="modal-body text-center">
                        <p>'. t('deleteconfirm').'</p>
                        '.$content.'
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">'.t('cancel').'</button>
                        <a class="btn btn-danger btn-sm" href="'.$urldestination.'"><i class="icon_trash_alt"></i> '.t('delete').'</a>
                    </div>
                </div><!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- End Modal -->';

        $ci->assetsloc->place_element_to_footer($data);

    } else {
        return false;
    }
}