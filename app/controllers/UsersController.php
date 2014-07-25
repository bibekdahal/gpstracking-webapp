<?php

class UsersController extends BaseController {
	protected $layout = "layouts.main";

	public function getIndex() {		
		if (Auth::check())
		    return Redirect::to('home');
		$this->layout->title = "Home";
		$this->layout->active = "Home";
		$this->layout->styles = "";
		$this->layout->content = View::make('home', array('show_map'=>false, 'show_login'=>true));
	}

	public function postIndex() {
		if (Auth::attempt(array('email'=>Input::get('email'), 'password'=>Input::get('password')), Input::has('remember')))
		    return Redirect::to('index')->with('message', 'You are now logged in! ');
		else
		    return Redirect::to('index')
		        ->with('message', 'Your username/password combination was incorrect'.Hash::make('testpass'))
		        ->withInput();
	}

}
