<?php
	
class History extends Eloquent {
	protected $table = 'history';
	protected $fillable = array('phone_id', 'local_id', 'latitude', 'longitude', 'speed', 'direction', 'time');

	public function user() {
		$this->belongsTo('User');
	}

	public function images() {
		return $this->hasMany('Image', 'history_id');
	}
}