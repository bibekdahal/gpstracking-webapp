<?php

class HomeController extends BaseController {
	protected $layout = "layouts.main";

	public function getIndex()
	{
		if (!Auth::check())
			return Redirect::to('index');
		$this->layout->title = "Home";
		$this->layout->active = "Home";
		$this->layout->styles = "";
		$this->layout->content = View::make('home', array('show_map'=>true, 'show_login'=>false));
	}
	public function postIndex()
	{
		if (Auth::check())
			Auth::logout();
		return Redirect::to('index');
	}

}
