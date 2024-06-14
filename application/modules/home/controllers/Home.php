<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public function index()
	{
		//DH original : redirect(base_url('admin'));
		redirect(base_url('dashboard'));
	}

	public function site_lang($site_lang) {
		echo $site_lang;
		echo '<br>';
		echo 'you will be redirected to :'.$_SERVER['HTTP_REFERER'];
		$language_data = array(
			'site_lang' => $site_lang
		);

		$this->session->set_userdata($language_data);
		if ($this->session->userdata('site_lang')) {
			echo 'user session language is = '.$this->session->userdata('site_lang');
		}
		redirect($_SERVER['HTTP_REFERER']);

		exit;
	}
}
