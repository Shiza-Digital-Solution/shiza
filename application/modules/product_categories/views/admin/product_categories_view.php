<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/************************************
		Register style (CSS)
************************************/
$request_css_files = array(
);
$request_style = "";
$this->assetsloc->reg_admin_style($request_css_files,$request_style);

/*******************************************
		Register Script (JavaScript)
*******************************************/
$request_script_files = array(
    'vendors/parsley/parsley.config.js',
    'vendors/parsley/parsley.min.js'
);
$request_script = "
$( document ).ready(function() {
    $('#valid').parsley();
});
";
$this->assetsloc->reg_admin_script($request_script_files,$request_script);

include V_ADMIN_PATH . "header.php";
include V_ADMIN_PATH . "sidebar.php";
include V_ADMIN_PATH . "topbar.php";
?>
<div class="row">
	<?php 
	if( !empty( $this->session->has_userdata('sukses') ) ){
		echo '<div class="col-md-12">
		<div class="alert alert-icon alert-success alert-dismissible fade show" role="alert">
			<i class="fa fa-check"></i> ' . $this->session->flashdata('sukses') . '
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fe fe-x"></i></button>
		</div>
		</div>
		';
	}
	if( !empty( $this->session->has_userdata('gagal') ) ){
		echo '<div class="col-md-12">
		<div class="alert alert-icon alert-danger alert-dismissible fade show" role="alert">
			<i class="fa fa-times"></i> ' . $this->session->flashdata('gagal') . '
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fe fe-x"></i></button>
		</div>
		</div>
		';
	}
	?>
	<?php if( is_add() ): ?>
	<div class="col-md-4">

		<div class="card">
			<div class="card-header"><h5 class="mb-0">Tambah Kategori</h5></div>

			<div class="card-body">
				<?php 
				// make tag form structure
				$tagForm = array(
					'action' 		=> admin_url( $this->uri->segment(2) . '/prosestambah'),
					'attributes' 	=> array( 'id'=>'valid' )					
				);
				
				// make input structure
				$inputs = array(
					'layout' => 'vertical',
					'inputs' => array(
						array(
							'type' => 'text',
							'label' => 'Nama Ketegori',
							'name' => 'nama',
							'required' => true,
						),
						array(
							'type' => 'textarea',
							'label' => 'Deskripsi',
							'name' => 'desc'
						),
						array(
							'type' => 'text',
							'label' => 'warna',
							'name' => 'warna',
							'required' => true,
						),
						array(
							'type' => 'submit',
							'label' => '<i class="fe fe-plus"></i> Tambah',
							'class' => 'btn-primary btn-block',
						)
					),
								
				);

				$this->formcontrol->buildForm($tagForm, $inputs);
				?>
			</div>
		</div>

	</div>
	<?php endif; ?>
	<?php if( is_view() ): ?>
	<div class="col-md-<?php if( !is_add() ){ echo '12'; } else { echo '8'; } ?>">
		
	</div>
	<?php endif; ?>
</div>
<?php
include V_ADMIN_PATH . "footer.php";
?>