<?php

namespace App\Controllers;

class Home extends BaseController
{
	/*
	* This displays main page after someone enteres the website.
	* From here users should be able to register or log in to website.
	*/
	public function index()
	{
		echo view('Views/templates/header');
		echo view('Views/home/menu');
		echo view('Views/templates/footer');
	}
}
