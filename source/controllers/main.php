<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
/************************************************/
  public function _remap()
  {


    switch($this->uri->segment(1)){
      case "home":
        $this->index();
        break;
      default:
        $this->index();
        break;
    }

    return true;
  }



  public function index()
  {
    $this->load->view('home');
    return true;
  }


}
