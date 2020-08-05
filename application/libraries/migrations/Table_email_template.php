<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_email_template {
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
		$schema = $this->CI->schema->create_table('email_template');
        $schema->increments('tId', ['length' => '10']);
        $schema->string('tName');
        $schema->text('tEmail', ['type' => 'MEDIUMTEXT']);
        $schema->text('tEmailbak', ['type' => 'MEDIUMTEXT']);
        $schema->run();
	}

	public function seeder(){
		$arr = [
			[
				'tId' => '1',
				'tName' => 'Customer - Informasi Pembayaran',
				'tEmail' => '<p>Bapak/Ibu {MEMBERNAME},<br />Dengan Hormat , Kami menerima pesanaan Poin dengan Nomor Invoice {INVOICE}.<br />------------------------------------------------------------<br />Lakukan pembayaran senilai {GRANDTOTAL} ke salah satu rekening:<br /><br />{BANK}<br />------------------------------------------------------------<br />Agar poin anda cepat diproses, konfirmasi pembayaran anda via sms/email.</p><p>Ke:</p><p>{SYSTEMMAIL}</p><p>{SYSTEMPHONE}</p><p><br />Pembayaran harus sesuai dengan yang tertera: {GRANDTOTAL} (Tidak dibulatkan).<br />Jika harus dibulatkan, informasikan ke kami melalui SMS/EMAIL, atau tulis pada kolom keterangan : {INVOICE} saat melakukan konfirmasi.<br /><br />Terima kasih atas kepercayaan anda pada {SYSTEMNAME}<br /><br />{SIGNATURE}<br /><br /><br />DETAIL ORDER:<br /><br />Customer Name : {MEMBERNAME}<br />Email : {MEMBEREMAIL}<br />Mobile Phone : {MEMBERTEL}<br />Order Date : {ORDERDATE}<br /><br />Your order:<br /><br />{ORDERPOINTDETAIL}<br /><br />Detail Pembayaran:<br />Kode Transaksi: {CODEID}<br />Total: {ORDERTOTAL}<br />----------------------------------------<br />Grand Total : {GRANDTOTAL}</p>',
				'tEmailbak' => 'Mr/Mrs/Miss {MEMBERNAME}, <br /><span lang="en">Dear Sirs , We have received your order with invoice numbers</span>&nbsp;{INVOICE}. <br />------------------------------------------------------------ <br /><span lang="en">Please make a payment of</span>&nbsp;{GRANDTOTAL} <span lang="en">to one of the accounts</span>:<br />{STORERECNAME} <br /><br />------------------------------------------------------------ <br /><span lang="en">In order to your order can be processed and delivered faster, confirm your payment via SMS/Email</span>. <br />Confirm your order via menu order and click the <strong>order confirmation</strong> button on the order that you have paid.<br /><br /><span lang="en">We hope you make a payment according to the total</span>&nbsp;{GRANDTOTAL} (<span lang="en">unrounded</span>). <br /><span lang="en">If it should be rounded</span>,&nbsp;<span lang="en">please inform us via SMS or email,</span> or write information coloumn at: {INVOICE} <br /><br /><span lang="en">Payments received no later than</span>: {ORDEREXP} <br /><span lang="en">After we receive your payment, your order will be handling and we will send it .</span>&nbsp;<br /><span lang="en">Receipt number will be informed via email after we send the package so that you can tracking.</span>&nbsp;<br /><br /><span lang="en">To cancel this order , click the <strong>Cancel</strong> button in the order you want to cancel. </span><br /><br /><span lang="en">Thank you for shopping at</span>&nbsp;{SITEURL} <br /><br />{SIGNATURE} <br /><br /><br />DETAIL ORDER: <br /><br />Customer Name : {MEMBERNAME} <br />Email : {MEMBEREMAIL} <br />Mobile Phone : {MEMBERTEL} <br />Order Date : {ORDERDATE} <br /><br />Your order: <br /><br />{ORDERDETAIL} <br /><br /><br />Your order will be sent to: <br />{MEMBERRECNAME} <br />{MEMBERADD} <br />{MEMBERTOWN} <br /><br />Shipping Method : {SHIPMETHOD} <br />Special Info : {MEMBERMSG} <br /><br />Detail Cost<br />Subtotal : {SUBTOTAL} <br />Tax({TAX}%) : {TAXAMOUNT} <br />Discount: {DISCOUNT} <br />Transaction Code: {CODEID} <br />Shipping Cost : {SHIPPRICE} <br />Shipping Cost Discount: {DISCOUNTSHIP} <br />---------------------------------------- <br />Grand Total : {GRANDTOTAL}'
			],
			[
				'tId' => '2',
				'tName' => 'Order Reminder',
				'tEmail' => 'Mr/Mrs/Miss {MEMBERNAME},<br />Dear Sir,<br /><span lang="en">This email is a reminder of your order with an invoice number</span>&nbsp;{INVOICE}.<br />&nbsp;------------------------------------------------------------ <br /><br />Please make a payment of&nbsp;{GRANDTOTAL},- o one of the accounts: <br /><br />{STORERECNAME} <br /><br />------------------------------------------------------------ <br />Your order details can be seen at the bottom of this email or click here:<br />{VERIFYCODE}<br />In order to your order can be processed and delivered faster, confirm your payment via SMS/Email.<br />Confirm yout order from the following link:<br />{ORDERCONFIRMATION}<br />We hope you make a payment according to the total {GRANDTOTAL} (unrounded).<br />If it should be rounded, please inform us via SMS or email, or write information coloumn at: {INVOICE}<br /><br />Payments received no later than: {ORDEREXP}<br />After we receive your payment, your order will be handling and we will send it . <br />Receipt number will be informed via email after we send the package so that you can tracking. <br /><br /><br />Thank you for shopping at {SITEURL}<br /><br />{SIGNATURE}',
				'tEmailbak' => 'Mr/Mrs/Miss {MEMBERNAME},<br />Dear Sir,<br /><span lang="en">This email is a reminder of your order with an invoice number</span>&nbsp;{INVOICE}.<br />&nbsp;------------------------------------------------------------ <br /><br />Please make a payment of&nbsp;{GRANDTOTAL},- o one of the accounts: <br /><br />{STORERECNAME} <br /><br />------------------------------------------------------------ <br />Your order details can be seen at the bottom of this email or click here:<br />{VERIFYCODE}<br />In order to your order can be processed and delivered faster, confirm your payment via SMS/Email.<br />Confirm yout order from the following link:<br />{ORDERCONFIRMATION}<br />We hope you make a payment according to the total {GRANDTOTAL} (unrounded).<br />If it should be rounded, please inform us via SMS or email, or write information coloumn at: {INVOICE}<br /><br />Payments received no later than: {ORDEREXP}<br />After we receive your payment, your order will be handling and we will send it . <br />Receipt number will be informed via email after we send the package so that you can tracking. <br /><br /><br />Thank you for shopping at {SITEURL}<br /><br />{SIGNATURE}'
			],
			[
				'tId' => '3',
				'tName' => 'Payment Received',
				'tEmail' => 'Mr/Mrs/Ms {MEMBERNAME}, <br />With respect, <br /><br />We would like to inform you that your payment for the invoice number {INVOICE} has been received <br />on {CHECKRECDATE}. We have checked our account and with this fully ensure that your payment has been received. <br /><br />We are currently preparing the products you ordered and will be sent as soon as possible. <br />If your order has been sent, we will re-send email notifications.<br /><br />Thank you for payments you make and of course on your TRUST in&nbsp;{SITEURL}. <br /><br />{SIGNATURE}',
				'tEmailbak' => 'Mr/Mrs/Ms {MEMBERNAME}, <br />With respect, <br /><br />We would like to inform you that your payment for the invoice number {INVOICE} has been received <br />on {CHECKRECDATE}. We have checked our account and with this fully ensure that your payment has been received. <br /><br />We are currently preparing the products you ordered and will be sent as soon as possible. <br />If your order has been sent, we will re-send email notifications.<br /><br />Thank you for payments you make and of course on your TRUST in&nbsp;{SITEURL}. <br /><br />{SIGNATURE}'
			],
			[
				'tId' => '4',
				'tName' => 'Package Delivery Information',
				'tEmail' => 'Mr/Mrs/Ms {MEMBERNAME}, <br />With Respect, <br /><br />We would like to inform you that your order in {SITEURL} has been processed. Products that we have sent you a message with the following information: <br />{SENTINFO} <br />{DIGITALPRODUCTLINK} <br /><br />Please inform us as soon as the order is received. Call us back if you have not received your order until the deadline. <br /><br />- <span id="result_box" lang="en"><span class="hps">If</span> <span class="hps">you are satisfied</span> <span class="hps">with</span> <span class="hps">our service and products</span><span>,</span> <span class="hps">please</span> <span class="hps">write</span> <span class="hps">a testimonial</span> <span class="hps">to</span> <span class="hps">reply to</span> <span class="hps">this email</span></span>. <br />- If you are not satisfied, submit your complaint. Your complaint must be delivered within max 1 week from when the order is received. <br /><br />Thanks for the order and the trust to us! <br /><br /><br />{SIGNATURE}',
				'tEmailbak' => 'Mr/Mrs/Ms {MEMBERNAME}, <br />With Respect, <br /><br />We would like to inform you that your order in {SITEURL} has been processed. Products that we have sent you a message with the following information: <br />{SENTINFO} <br />{DIGITALPRODUCTLINK} <br /><br />Please inform us as soon as the order is received. Call us back if you have not received your order until the deadline. <br /><br />- <span id="result_box" lang="en"><span class="hps">If</span> <span class="hps">you are satisfied</span> <span class="hps">with</span> <span class="hps">our service and products</span><span>,</span> <span class="hps">please</span> <span class="hps">write</span> <span class="hps">a testimonial</span> <span class="hps">to</span> <span class="hps">reply to</span> <span class="hps">this email</span></span>. <br />- If you are not satisfied, submit your complaint. Your complaint must be delivered within max 1 week from when the order is received. <br /><br />Thanks for the order and the trust to us! <br /><br /><br />{SIGNATURE}'
			],
			[
				'tId' => '5',
				'tName' => 'Order Delete',
				'tEmail' => 'Mr/Mrs/Ms {MEMBERNAME}, <br />With Respect, <br /><br />We would like to inform that your order invoice number&nbsp;{INVOICE} has abort. The reason for cancellation due to one of the following reasons:<br />- You do not transfer until the payment due.<br />- Email data or the address you provide is invalid. <br />- You order two times or more.<br />-&nbsp;The other reason. <br /><br />You can order the products you ordered back to visit our website at&nbsp;{SITEURL} . <br />We beg your understanding on this matter and apologize if it has caused inconvenience. <br />Thank you for your attention.<br /><br /><br />{SIGNATURE}',
				'tEmailbak' => 'Bapak/Ibu {MEMBERNAME},<br/>Dengan hormat, <br/><br/>Kami ingin menginformasikan bahwa pesanan Anda dengan nomor invoice {INVOICE} telah kami batalkan.<br/> Alasan pembatalan karena salah satu sebab berikut ini:<br/><br/> - Anda tidak melakukan transfer sampai batas waktu pembayaran. <br/> - Data email atau alamat yang Anda berikan tidak valid.<br/> - Anda memesan 2 kali atau lebih.<br/> - Alasan lainnya.<br/><br/>Anda dapat memesan kembali produk yang Anda pesan dengan mengunjungi website kami di {SITEURL}	.<br/>Kami memohon pengertian dari Bapak/Ibu atas hal ini dan memohon maaf jika telah menimbulkan ketidaknyamanan.<br/>Terima kasih atas perhatian Anda!<br/><br/>{SIGNATURE}'
			],
			[
				'tId' => '6',
				'tName' => 'Payment Confirmation',
				'tEmail' => 'The customer informs that a payment the following data have been paid: <br /><br />Number of Invoice : {INVOICE} <br />Nama : {MEMBERNAME} <br />Email : {MEMBEREMAIL} <br />Transfer To : {PAYMENTBANK} <br />Nominal : {TRANSFERAMOUNT} <br />Transfer Date : {TRANSFERDATE} <br /><br />Information: {NOTES} <br /><br /><br />{SIGNATURE}',
				'tEmailbak' => 'The customer informs that a payment the following data have been paid: <br /><br />Number of Invoice : {INVOICE} <br />Nama : {MEMBERNAME} <br />Email : {MEMBEREMAIL} <br />Transfer To : {PAYMENTBANK} <br />Nominal : {TRANSFERAMOUNT} <br />Transfer Date : {TRANSFERDATE} <br /><br />Information: {NOTES} <br /><br /><br />{SIGNATURE}'
			],
			[
				'tId' => '7',
				'tName' => 'Customer - Verify Email Change',
				'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px"><tbody><tr><td>{HEADER}</td></tr><tr><td><p>Dear Bapak/Ibu {MEMBERNAME},<br /><br />Anda telah melakukan permintaan perubahan alamat email anda di {SYSTEMNAME}.<br />Verify your email by clicking this link :<br /><br />{EMAILCHANGEVERIFYURL}<br /><br />(Copy and paste the link above into your browser if it can not click)<br /><br />Thank You.</p><p><strong>Abaikan email ini jika anda tidak merasa melakukan aktifitas ini</strong>.</p></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}</td></tr><tr><td>Dear,<br /><br /><span lang="en">You have changed your email on </span>{SYSTEMNAME}. <br /> <span lang="en">Verify your email by clicking this link :</span><br /><br /> {EMAILCHANGEVERIFYURL} <br /><br />(<span lang="en">Copy and paste the link above into your browser if it can not click</span>) <br /><br /> Thank You.<br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '8',
				'tName' => 'Member - Verifikasi Email (Welcome)',
				'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px"><tbody><tr><td>{HEADER}</td></tr><tr><td><p><br />Anda telah bergabung di {SYSTEMNAME}.<br />Silahkan verifikasi akun anda dengan meng-klik link dibawah ini agar anda dapat masuk ke sistem kami:<br /><br /><a href="{VERIFYLINK}">{VERIFYLINK}</a><br /><br />(Copy paste link jika tidak bisa diklik)</p><p>Terima kasih.<br />&nbsp;</p></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px"><tbody><tr><td>{HEADER}</td></tr><tr><td>With respect,<br /><br />Thanks for joining us on {SYSTEMNAME}.<br />Verify your email by clicking this link :<br /><br /><a href="{VERIFYLINK}">{VERIFYLINK}</a><br /><br />(Copy and paste the link above into your browser if it can not click)<br /><br />This link will expire within 1 hour. You can request verification email on customer area.<br />&nbsp;</td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '9',
				'tName' => 'Customer - Reset Password',
				'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px"><tbody><tr><td>{HEADER}</td></tr><tr><td>With respect,<br /><br />Thanks for joining us on {SYSTEMNAME}.<br />Verify your email by clicking this link :<br /><br /><a href="{VERIFYLINK}">{VERIFYLINK}</a><br /><br />(Copy and paste the link above into your browser if it can not click)<br /><br />This link will expire within 1 hour. You can request verification email on customer area.<br />&nbsp;</td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table><table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}</td></tr><tr><td>Mr/Mrs/Ms {CUSTOMERNAME}, <br /> With respect, <br /><br /> Your password has been successfully changed. <br /> From now on, you have to log in using your email and your new password. <br /><br /> Thank You. <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}</td></tr><tr><td>Mr/Mrs/Ms {CUSTOMERNAME},<br /><span id="result_box" class="short_text" lang="en"><span class="hps">With</span> <span class="hps">respect</span></span>,<br /><br /> <span lang="en">Your password has been successfully changed.</span><br /><span lang="en">From now on, you have to log in using your email and your new password.</span><br /><br /> Thank You. <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '10',
				'tName' => 'Customer - Selamat Datang (Admin)',
				'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px"><tbody><tr><td>{HEADER}<br />&nbsp;</td></tr><tr><td>Bapak/Ibu {MEMBERNAME},<br /><br />Terima kasih telah mendaftar di {SYSTEMNAME}.<br />Silahkan set password anda melalui link dibawah ini:<br />{FORGOTPASSWORDLINK}<br /><br />(copy link diatas ke browser jika tidak bisa di klik)<br /><br />&nbsp;</td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>With respect, <br /><br /> Thanks for joining us on {SYSTEMNAME}. <br /> Click the link below to login: <br /><br /> {FORGOTPASSWORDLINK} <br /><br /> (Copy and paste the link above into your browser if it can not click) <br /><br /> You can reset your password via FORGOT PASSWORD features. <br /><br /> Terima kasih. <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '11',
				'tName' => 'Supplier - Welcome',
				'tEmail' => '<table style="width: 800px; height: 287px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr style="height: 22px;">
		<td style="height: 22px; width: 796px;">{SITELOGO}</td>
		</tr>
		<tr style="height: 243px;">
		<td style="height: 243px; width: 796px;">
		<p><br />Anda telah bergabung di {SITENAME}.<br />Silahkan verifikasi akun anda dengan meng-klik link dibawah ini agar anda dapat masuk ke sistem kami:<br /><br /><a href="http://warungkita/wk_admin2020/{VERIFYREG}">{VERIFYREG}</a><br /><br />(Copy dan paste link pada web browser jika tidak bisa diklik)</p>
		<p>Terima kasih.<br />&nbsp;</p>
		</td>
		</tr>
		<tr style="height: 22px;">
		<td style="height: 22px; width: 796px;">{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>',
				'tEmailbak' => '<table style="width: 800px; height: 287px;" border="0" cellspacing="0" cellpadding="0" align="center">
		<tbody>
		<tr style="height: 22px;">
		<td style="height: 22px; width: 796px;">{SITELOGO}</td>
		</tr>
		<tr style="height: 243px;">
		<td style="height: 243px; width: 796px;">
		<p><br />Anda telah bergabung di {SITENAME}.<br />Silahkan verifikasi akun anda dengan meng-klik link dibawah ini agar anda dapat masuk ke sistem kami:<br /><br /><a href="http://warungkita/wk_admin2020/{VERIFYREG}">{VERIFYREG}</a><br /><br />(Copy dan paste link pada web browser jika tidak bisa diklik)</p>
		<p>Terima kasih.<br />&nbsp;</p>
		</td>
		</tr>
		<tr style="height: 22px;">
		<td style="height: 22px; width: 796px;">{SIGNATURE}</td>
		</tr>
		</tbody>
		</table>'
			],
			[
				'tId' => '12',
				'tName' => 'Customer - Forgot Password',
				'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px"><tbody><tr><td>{HEADER}</td></tr><tr><td>Bapak/Ibu {MEMBERNAME},<br />Dengan hormat,<br /><br />Anda atau orang lain telah melakukan permintaan reset password melalui fitur LUPA PASSWORD.<br />Jika anda ingin benar-benar melakukan reset password, klik link dibawah ini:<br /><br />{FORGOTPASSWORDLINK}<br />&nbsp;</td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}</td></tr><tr><td>Bapak/Ibu {MEMBERNAME},<br /> Dengan hormat,<br /><br /> Anda atau seseorang telah melakukan request untuk melakukan reset password melalui fasilitas LUPA PASSWORD.<br />Password anda yang lama belum berubah. Jika anda ingin melakukan reset, lakukan langkah berikut: <br /><br /> {FORGOTPASSWORDLINK} <br /><br />Jika link diatas tidak bisa di-klik, silahkan copy dan paste link ke browser anda. <br /><br /> Masa berlaku link ini hanya 60 Menit.<br /> Abaikan email ini jika anda tidak merasa pernah melakukan permohonan reset password.<br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '13',
				'tName' => 'Supplier - Forgot Password',
				'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}</td></tr><tr><td>Mr/Mrs/Ms {SUPPLIERNAME}, <br />With respect, <br /><br /> You or someone has done a request to reset the password through PASSWORD FORGOT facilities. <br /> Your old password has not been changed. If you want to do a reset, do the following: <br /><br /> {SUPPLIERFORGOTPASSWORDLINK} <br /><br /> If the link above does not work in clicking, please copy and paste the link into your browser. <br /><br /> This link will expire within 1 hour. Ignore this message if you did not have to do a password reset request. <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}</td></tr><tr><td>Mr/Mrs/Ms {SUPPLIERNAME}, <br />With respect, <br /><br /> You or someone has done a request to reset the password through PASSWORD FORGOT facilities. <br /> Your old password has not been changed. If you want to do a reset, do the following: <br /><br /> {SUPPLIERFORGOTPASSWORDLINK} <br /><br /> If the link above does not work in clicking, please copy and paste the link into your browser. <br /><br /> This link will expire within 1 hour. Ignore this message if you did not have to do a password reset request. <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '14',
				'tName' => 'Supplier - Verify Email Change',
				'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}</td></tr><tr><td>Dear,<br /><br /><span lang="en">You have changed your email on </span>{SYSTEMNAME}. <br /> <span lang="en">Verify your email by clicking this link :</span><br /><br /> {SUPPLIEREMAILCHANGEVERIFYURL} <br /><br />(<span lang="en">Copy and paste the link above into your browser if it can not click</span>) <br /><br /> Thank You.<br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}</td></tr><tr><td>Dear,<br /><br /><span lang="en">You have changed your email on </span>{SYSTEMNAME}. <br /> <span lang="en">Verify your email by clicking this link :</span><br /><br /> {EMAILCHANGEVERIFYURL} <br /><br />(<span lang="en">Copy and paste the link above into your browser if it can not click</span>) <br /><br /> Thank You.<br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '15',
				'tName' => 'Customer - Reset Password Success',
				'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px"><tbody><tr><td>{HEADER}</td></tr><tr><td>Bapak/Ibu {MEMBERNAME},<br />Dengan Hormat,<br /><br />Password anda sukses diganti.<br />Sekarang anda dapat login menggunakan password baru anda.<br /><br />Terima kasih.<br />&nbsp;</td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}</td></tr><tr><td>Bapak/Ibu {SUPPLIERNAME},<br />Dengan hormat,<br /><br /> Password anda telah berhasil diubah. <br /> Mulai saat ini, anda harus login menggunakan email dan password baru anda. Gunakan kembali fitur FORGOT PASSWORD jika anda kembali lupa password. <br /><br /> Terima kasih. <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '16',
				'tName' => 'Supplier - Verify Email',
				'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}</td></tr><tr><td><span id="result_box" class="short_text" lang="en"><span class="hps">With</span> <span class="hps">respect</span></span>,<br /><br /> Thanks for joining us on {SYSTEMNAME}. <br /> Verify your email by clicking this link : <br /><br /> {SUPPLIEREMAILVERIFYURL} <br /><br /> (<span lang="en">Copy and paste the link above into your browser if it can not click</span>) <br /><br /><span lang="en">This link will expire within 1 hour. You can request verification email on customer area.</span><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}</td></tr><tr><td><span id="result_box" class="short_text" lang="en"><span class="hps">With</span> <span class="hps">respect</span></span>,<br /><br /> Thanks for joining us on {SYSTEMNAME}. <br /> Verify your email by clicking this link : <br /><br /> {SUPPLIEREMAILVERIFYURL} <br /><br /> (<span lang="en">Copy and paste the link above into your browser if it can not click</span>) <br /><br /><span lang="en">This link will expire within 1 hour. You can request verification email on customer area.</span><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '17',
				'tName' => 'Purchase Order Information to Supplier',
				'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SUPPLIERNAME}, <br /><br /> You have a new purchase order with article number {ARTICLENUMBER}.<br />Please visit your supplier area: <br /><br /> {SUPPLIERAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SUPPLIERNAME}, <br /><br /> You have a new purchase order with article number {ARTICLENUMBER}.<br />Please visit your supplier area: <br /><br /> {SUPPLIERAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '18',
				'tName' => 'Quotation Information to Owner',
				'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br /> You have a new quotation with article number {ARTICLENUMBER}.<br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br /> You have a new quotation with article number {ARTICLENUMBER}.<br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '19',
				'tName' => 'Customer - Receipt',
				'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="5" align="center"><tbody><tr><td colspan="2" align="center">{HEADER}</td></tr><tr><td colspan="2" align="center"><strong style="font-size: 24px;">RECEIPT</strong><br /><br /></td></tr><tr><td valign="top" width="35%">Number</td><td valign="top">:&nbsp;{KWITANSINUMBER}</td></tr><tr><td valign="top">Received From</td><td valign="top">:&nbsp;{MEMBERNAME}</td></tr><tr><td valign="top">In Payment for</td><td>:&nbsp;</td></tr><tr><td colspan="2">{DETAILKWITANSI}</td></tr><tr><td>Amount</td><td>: {GRANDTOTAL}</td></tr><tr><td colspan="2">&nbsp;<br /><br /><br /></td></tr><tr><td colspan="2" align="left"><hr /><div style="font-size: 10px; color: #999999;">{ADDITIONALINFO}</div></td></tr><tr><td colspan="2" align="left">&nbsp;<br /><br />{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="5" align="center"><tbody><tr><td colspan="2" align="center">{HEADER}</td></tr><tr><td colspan="2" align="center"><strong style="font-size: 24px;">RECEIPT</strong><br /><br /></td></tr><tr><td valign="top" width="35%"><em>Number</em></td><td valign="top">:&nbsp;{KWITANSINUMBER}</td></tr><tr><td valign="top"><em>Received From</em></td><td valign="top">:&nbsp;{MEMBERNAME}</td></tr><tr><td valign="top"><em>The SUM of</em></td><td>:&nbsp;<em>{TERBILANG} Rupiah</em></td></tr><tr><td valign="top"><em>In Payment for</em></td><td>:&nbsp;</td></tr><tr><td colspan="2">{DETAILKWITANSI}</td></tr><tr><td><em>Amount</em></td><td>:&nbsp;Rp {GRANDTOTAL}</td></tr><tr><td colspan="2">&nbsp;<br /><br /><br /></td></tr><tr><td colspan="2" align="left"><hr /><div style="font-size: 10px; color: #999999;">{PAYMENTINFO}</div></td></tr></tbody></table>'
			],
			[
				'tId' => '20',
				'tName' => 'Re-Order PO Information',
				'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SUPPLIERNAME}, <br /><br /> You have re-order PO with article number {ARTICLENUMBER}.<br />Please visit your supplier area:<br /><br /> {SUPPLIERAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SUPPLIERNAME}, <br /><br /> You have re-order PO with article number {ARTICLENUMBER}.<br />Please visit your supplier area:<br /><br /> {SUPPLIERAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '21',
				'tName' => 'Purchase Order Has Been Revised to Supplier',
				'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SUPPLIERNAME}, <br /><br />Purchase order has been revised by Owner with article number {ARTICLENUMBER}.<br />Please visit your supplier area: <br /><br /> {SUPPLIERAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SUPPLIERNAME}, <br /><br />Purchase order has been revised by Owner with article number {ARTICLENUMBER}.<br />Please visit your supplier area: <br /><br /> {SUPPLIERAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '22',
				'tName' => 'Purchase Order Has Been Revised to Owner',
				'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br />Purchase order has been revised by Owner with article number {ARTICLENUMBER}.<br />Please visit your supplier area: <br /><br /> {ADMINAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br />Purchase order has been revised by Owner with article number {ARTICLENUMBER}.<br />Please visit your supplier area: <br /><br /> {ADMINAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '23',
				'tName' => 'Owner - New Custom Design Information',
				'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br /> You have a new custom design from customer with design name <strong>{DESIGNNAME}</strong>.<br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br /> You have a new design from customer with design name {DESIGNNAME}.<br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '24',
				'tName' => 'Supplier - New Design Information',
				'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {MEMBERNAME}, <br /><br /> You have a new design from {SYSTEMNAME} with design name <strong>{DESIGNNAME}</strong>.<br />Please visit your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {MEMBERNAME}, <br /><br /> You have a new design from {SYSTEMNAME} with design name {DESIGNNAME}.<br />Please visit your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '25',
				'tName' => 'Reminder of approval new PO to Supplier',
				'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SUPPLIERNAME}, <br /><br />We reminded You that You have a new purchase order with article number {ARTICLENUMBER}.<br />Please visit your supplier area:<br /><br /> {SUPPLIERAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SUPPLIERNAME}, <br /><br />We reminded You that You have a new purchase order with article number {ARTICLENUMBER}.<br />Please visit your supplier area:<br /><br /> {SUPPLIERAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '26',
				'tName' => 'Reminder of approval new PO to Owner',
				'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br />The system reminded You that You have a new purchase order with article number {ARTICLENUMBER}.<br />Please visit your supplier area:<br /><br /> {ADMINAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br />The system reminded You that You have a new purchase order with article number {ARTICLENUMBER}.<br />Please visit your supplier area:<br /><br /> {ADMINAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '27',
				'tName' => 'Supplier - Approve New Design',
				'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br /> You have an <strong>approved</strong> new design from {MEMBERNAME} with design name <strong>{DESIGNNAME}</strong>.<br />Please check your admin area: <br /><br /> {ADMINAREALINK} <br /><br />thank you.<br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {MEMBERNAME}, <br /><br /> You have a new design from {SYSTEMNAME} with design name {DESIGNNAME}.<br />Please visit your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '28',
				'tName' => 'Supplier - Sending New Design',
				'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br /> Your new design&nbsp;<strong>{DESIGNNAME}</strong> has been sending by {MEMBERNAME}.<strong><br /><br /></strong>Please check your admin area: <br /><br /> {ADMINAREALINK} <br /><br />thank you.<br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {MEMBERNAME}, <br /><br /> You have a new design from {SYSTEMNAME} with design name {DESIGNNAME}.<br />Please visit your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '29',
				'tName' => 'Owner - Custom Design Deleted By Customer',
				'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br /> One of a new custom design has been canceled by each customer with design name <strong>{DESIGNNAME}</strong>.<br /><br />Thank You.<br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br /> You have a new design from customer with design name {DESIGNNAME}.<br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '30',
				'tName' => 'Owner - Pembayaran Order Poin Diterima',
				'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px"><tbody><tr><td>{HEADER}<br />&nbsp;</td></tr><tr><td><p>Yang Terhormat {MEMBERNAME},<br /><br />Kami telah menerima pembayaran atas pesanan <strong>POIN</strong> anda dengan nomor invoice: #{INVOICE}</p><p>Secara otomaris poin anda telah ditambahkan.<br /><br />Terima kasih.<br /><br />&nbsp;</p></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {MEMBERNAME}, <br /><br /> You have a new design from {SYSTEMNAME} with design name {DESIGNNAME}.<br />Please visit your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '31',
				'tName' => 'Supplier - Notification for create PO from Quotation',
				'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SUPPLIERNAME}, <br /><br />We reminded You, that You have a new purchase order ({ARTICLENUMBER}) from quotation ({ARTICLENUMBER2}).<br /><br />Please visit your supplier area:<br /><br /> {SUPPLIERAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SUPPLIERNAME}, <br /><br />We reminded You, that You have a new purchase order ({ARTICLENUMBER}) from quotation ({ARTICLENUMBER2}).<br /><br />Please visit your supplier area:<br /><br /> {SUPPLIERAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '32',
				'tName' => 'Owner - Inactive Customer',
				'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br /> Customer with customer code {MEMBERCODE} and customer name {MEMBERNAME} is in active. Because he did not shop more than 1 month<br /><br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br /> Customer with customer code {MEMBERCODE} and customer name {MEMBERNAME} is in active. Because he did not shop more than 1 month<br /><br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '33',
				'tName' => 'Owner - Customer is not Spending More than 2 Weeks',
				'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br /> Customer with customer code {MEMBERCODE} and customer name {MEMBERNAME} did not shop more than 2 weeks.<br /><br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br /> Customer with customer code {MEMBERCODE} and customer name {MEMBERNAME} did not shop more than 2 weeks.<br /><br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '34',
				'tName' => 'Owner - Quotation request from new design',
				'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {MEMBERNAME}, <br /><br /> You have an <strong>requested</strong> quotation of new design from {SYSTEMNAME} with design name <strong>{DESIGNNAME}</strong>.<br />Please check your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br />thank you.<br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {MEMBERNAME}, <br /><br /> You have a new design from {SYSTEMNAME} with design name {DESIGNNAME}.<br />Please visit your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '35',
				'tName' => 'Coba Email Template',
				'tEmail' => '<p>Assalamualaikum Wr Wb Yaa</p>',
				'tEmailbak' => '<p>Assalamualaikum Wr Wb</p>'
			],
			[
				'tId' => '36',
				'tName' => 'Email Customer Baru Dari Facebook',
				'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px"><tbody><tr><td>{HEADER}<br />&nbsp;</td></tr><tr><td>Bapak/Ibu {MEMBERNAME},<br /><br />Terima kasih telah mendaftar di {SYSTEMNAME}.<br />Kami senang Anda telah bergabung bersama kami. silahkan pilih menu masakan lezat dari kami<br /><br />&nbsp;</td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px"><tbody><tr><td>{HEADER}<br />&nbsp;</td></tr><tr><td>Bapak/Ibu {MEMBERNAME},<br /><br />Terima kasih telah mendaftar di {SYSTEMNAME}.<br />Kami senang Anda telah bergabung bersama kami. silahkan pilih menu masakan lezat dari kami<br /><br />&nbsp;</td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			],
			[
				'tId' => '37',
				'tName' => 'Pemberitahuan Pesan Baru',
				'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px"><tbody><tr><td>{HEADER}</td></tr><tr><td><p>Bapak/Ibu {MEMBERNAME},<br />Dengan hormat,<br /><br />Anda menerima pesan baru dari {SENDER}, cek segera siapa tahu ada rezeki dari allah :)<br />&nbsp;</p><p><a href="{INBOXANSWERLINK}"><input name="Balas" type="button" value="Balas" /></a></p></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>',
				'tEmailbak' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px"><tbody><tr><td>{HEADER}</td></tr><tr><td><p>Bapak/Ibu {MEMBERNAME},<br />Dengan hormat,<br /><br />Anda menerima pesan baru dari {SENDER}, cek segera siapa tahu ada rezeki dari allah :)<br />&nbsp;</p><p><input name="Balas" type="button" value="Balas" /></p></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
			]
		];
		return $arr;
	}

}

