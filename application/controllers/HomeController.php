<?php namespace Controllers;

/**
 * Home Controller
 *
 * Central controller for all public-facing pages of Rachie.
 * 
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright 2015 - 2030 Geoffrey Okongo
 * @category Controllers
 * @package Controllers\Home
 * @link https://github.com/glivers/rachie
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 1.0.1
 */

use Rackage\View;
use Rackage\Controller;

class HomeController extends Controller {

	/**
	 * Set to true to enable method @filters in this controller
	 * 
	 * @var bool 
	 */
	public $enable_filters = false;

	/**
	 * This method loads the homepage after a Rachie installation. 
	 * 
	 * @return void
	 */
	public function getIndex()
	{

		$data['title'] 		  = $this->site_title;
		$data['request_time'] = $this->_requestTime();

		View::render('home/index',$data);
	}	
}

