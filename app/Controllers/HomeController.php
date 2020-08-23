<?php

namespace App\Controllers;

class HomeController extends BaseController
{
	/*
	* This displays main page after someone enteres the website.
	* From here users should be able to register or log in to website.
	*/
	public function index()
	{
		$session = session();
		if ($session->get('id') != null) {
			//If user is logged in, redirect him to his main page.
			return redirect('user');
		}

		echo view('Views/templates/header');
		echo view('Views/home/menu');
		echo view('Views/templates/footer');
	}
}
