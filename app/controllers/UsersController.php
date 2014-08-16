<?php

class UsersController extends BaseController {
	protected $layout = "layouts.main";

	public function getIndex() {
		return Redirect::to('login');
	}
	
	public function getLogin() {		
		if (Auth::check())
		    return Redirect::to('home');
		$this->layout->title = "Home";
		$this->layout->active = "Home";
		$this->layout->styles = "";
		$this->layout->content = View::make('home', array('show_map'=>false, 'show_login'=>true));
	}

	public function postLogin() {
		if (Auth::attempt(array('email'=>Input::get('email'), 'password'=>Input::get('password')), Input::has('remember')))
		    return Redirect::to('index')->with('message', 'You are now logged in! ');
		else
		    return Redirect::to('index')
		        ->with('message', 'Your username/password combination was incorrect')
		        ->withInput();
	}

	public function postCheckEmailPassword() {
		$count = User::where('email', '=', Input::get('email'))->count();
		if ($count==0) return "UNREGISTERED";
		if (Auth::validate(array('email'=>Input::get('email'), 'password'=>Input::get('password'))))
			return "REGISTERED AND VALID";
		return "REGISTERED BUT INVALID";
	}

	public function postRegister() {
		$user = new User;
	    $user->email = Input::get('email');
	    $user->password = Hash::make(Input::get('password'));
	    $user->save();
	    return "REGISTERED SUCCESFULLY";
	}

	public function postJson() {
		$input = Input::json();
		$userinfo = $input->get("User");
		$email = $userinfo["Email"];
		$password = $userinfo["Password"];
		if (!Auth::validate(array('email'=>$email, 'password'=>$password)))
			return "INVALID EMAIL PASSWORD";

		$user = User::where('email', '=', $email)->first();

		$history = $input->get("History");
		foreach ($history as $data) {
			$newHistory = new History(array(
				'phone_id' => $userinfo["PhoneId"],
				'local_id' => $data["Local_Id"],
				'latitude' => $data["Latitude"],
				'longitude' => $data["Longitude"],
				'speed' => $data["Speed"],
				'direction' => $data["Direction"],
				'time' => $data["Time"]
			));

			$user->history()->save($newHistory);
		}
		return "SUCCESS 101";
	}

	public function postUploadImage() {
		$email = Input::get('email');
		$password = Input::get('password');
		if (!Auth::validate(array('email'=>$email, 'password'=>$password)))
			return "INVALID EMAIL PASSWORD";

		if (!Input::file('userfile')->isValid()) return "UNSUCCESSFUL";
		$destpath = "images/".Input::get('email');
		Input::file('userfile')->move($destpath, Input::file('userfile')->getClientOriginalName());

		$user = User::where('email', '=', Input::get('email'))->first();
		$history = $user->history()->where('local_id', '=', Input::get('historyId'))->first();
		if ($history!=null) {
			$newimage = new Image(array(
				'filepath' => Input::file('userfile')->getClientOriginalName()
			));

			$history->images()->save($newimage);
			return "SUCCESS 101";
		}
		return "UNSUCCESSFUL";
	}
}
