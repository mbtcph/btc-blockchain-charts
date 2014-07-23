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
    $page_data = array();


    $this_year = date("Y");
    $date_selected = $this_year."-01-01";

    $end_date = new DateTime($date_selected);
    $end_date->modify('-1 year');
    $past_year = $end_date->format('Y');

    $page_data['this_year'] = $this_year;
    $page_data['past_year'] = $past_year;

    $page_data['year_block_now'] = $this->Btcdb_model->get_stats_daily_by_year($this_year);
    $page_data['year_block_prev'] = $this->Btcdb_model->get_stats_daily_by_year($past_year);

    $this->load->view('home', $page_data);
    return true;
  }


}
