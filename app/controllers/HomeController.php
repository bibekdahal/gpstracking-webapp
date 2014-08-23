<?php

class HomeController extends BaseController {
	protected $layout = "layouts.main";
	
	public function __construct()
    {
        $this->beforeFilter('auth');
    }

	public function getIndex()
	{
		$this->layout->title = "Home";
		$this->layout->active = "Home";
		$this->layout->styles = "";
		$history = Auth::user()->history()->get()->sort(function($a, $b)
	    {
	        $a = $a->time;
	        $b = $b->time;
	        if ($a === $b) return 0;
	        return ($a > $b) ? -1 : 1;
	    });
		$this->layout->content = View::make('home', array('show_map'=>true, 'show_login'=>false,
			'history'=>$history));
	}
	
	public function getLogout()
	{
		Auth::logout();
		return Redirect::to('index');
	}
}