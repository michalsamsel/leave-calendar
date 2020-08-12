<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		echo view('Views/templates/header');
		echo view('Views/home/menu');
		echo view('Views/templates/footer');
	}
}
