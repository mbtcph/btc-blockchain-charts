<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Btcdb_model extends CI_Model {


/***********************************************************************/

  public function get_stats_daily_by_year($year = "")
  {
    $tmp_return = $return = array();
    $tmp_year = "";
    $tmp_month = "";
    $tmp_day = array();
    $tmp_sql = array();


    if(!$year) $year = date("Y");
    $date_selected = $year."-01-01";

    $start_date = new DateTime($date_selected);
    $start_date = $start_date->format('Y-m-d');

    $end_date = new DateTime($date_selected);
    $end_date->modify('+1 year');
    $end_date = $end_date->format('Y-m-d');


    $date_range = $this->get_between_days($start_date, $end_date);

    foreach($date_range as $date_item){
      $date_parts = $this->get_date_parts($date_item);

      $return[''.$date_parts['year'].'-'.$date_parts['month'].'-'.$date_parts['day'].''] = array();
      $return[''.$date_parts['year'].'-'.$date_parts['month'].'-'.$date_parts['day'].'']['year'] = $date_parts['year'];
      $return[''.$date_parts['year'].'-'.$date_parts['month'].'-'.$date_parts['day'].'']['month'] = $date_parts['month'];
      $return[''.$date_parts['year'].'-'.$date_parts['month'].'-'.$date_parts['day'].'']['day'] = $date_parts['day'];

      $return[''.$date_parts['year'].'-'.$date_parts['month'].'-'.$date_parts['day'].'']['tx_count'] = "0";
      $return[''.$date_parts['year'].'-'.$date_parts['month'].'-'.$date_parts['day'].'']['total_amount'] = "0";

      if($tmp_month!=$date_parts['month']){
        $tmp_month = $date_parts['month'];
        $tmp_year = $date_parts['year'];
        $tmp_day = array();
      }

      //$tmp_day[] = $date_parts['day'];

      //$tmp_sql[$tmp_year.'-'.$tmp_month] = " ( `year` = '".$tmp_year."' AND `month` = '".$tmp_month."'  AND `day` IN ('".implode("','",$tmp_day) ."'))";
    }

    $tmp_return = $this->get_stats_daily($year);


    foreach($tmp_return as $row){
      $return[''.$row['year'].'-'.$row['month'].'-'.$row['day'].'']['tx_count'] = $row['tx_count'];
      $return[''.$row['year'].'-'.$row['month'].'-'.$row['day'].'']['total_amount'] = $row['total_amount'];
    }

    return $return;
  }
/***********************************************************************/

  public function get_stats_daily($year = "", $month = "", $day = "")
  {


    if(!$year) $year = date("Y");


    $this->db->where("year", $year );
    $this->db->order_by('year', "ASC");
    $this->db->order_by('month', "ASC");
    $this->db->order_by('day', "ASC");


    $query = $this->db->get('stats_btc_tx_daily');

    if(!$query->num_rows()) return array();
    return $query->result_array();

  }
/***********************************************************************/


  function get_between_days($sStartDate, $sEndDate)
  {
    $aDays[] = $sStartDate;
    $sCurrentDate = $sStartDate;

    while($sCurrentDate < $sEndDate){
      $tmp_date = new DateTime($sCurrentDate);
      $tmp_date->modify('+1 day');
      $sCurrentDate = $tmp_date->format('Y-m-d');
      $aDays[] = $sCurrentDate;
    }
    return $aDays;
  }
/******************************************************************************/
  function get_date_parts($date = '')
  {
    if(!$date) return false;

    preg_match("/([0-9]*)-([0-9]*)-([0-9]*)/", $date, $date_parts);

    if(!$date_parts) return false;
    $result = array();
    $result['year'] = (int)$date_parts[1];
    $result['month'] = (int)$date_parts[2];
    $result['day'] = (int)$date_parts[3];

    return $result;
  }
/******************************************************************************/
/******************************************************************************/
}

