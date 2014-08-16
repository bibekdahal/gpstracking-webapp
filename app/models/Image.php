<?php
	
class Image extends Eloquent {
	protected $fillable = array('filepath');

	public function history() {
		$this->belongsTo('History', 'history_id');
	}
}