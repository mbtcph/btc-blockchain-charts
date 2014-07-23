<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$data_tx_now = $data_amount_now = array();
$data_tx_prev = $data_amount_prev = array();

$day_start = "";
$day_end = "";

if( @is_array($year_block_now) ) {
  foreach($year_block_now as $row){


    $data_tx_now[] =  @floatval( ereg_replace("[^-0-9\.]","",$row['tx_count']?$row['tx_count']:0) ) ;
    $data_amount_now[] =  @floatval( ereg_replace("[^-0-9\.]","",$row['total_amount']?$row['total_amount']:0) ) ;

  }
}

if( @is_array($year_block_prev) ) {
  foreach($year_block_prev as $row){

    $data_tx_prev[] =  @floatval( ereg_replace("[^-0-9\.]","",$row['tx_count']?$row['tx_count']:0) ) ;
    $data_amount_prev[] =  @floatval( ereg_replace("[^-0-9\.]","",$row['total_amount']?$row['total_amount']:0) ) ;

  }
}


?>
<div style="width:100%;color:#333333;margin-top:100px;">

  <div style="width:90%;margin:auto;text-align:center;">
    <h2 style="color:red;">Data collection is still in progress...</h2>
  </div>
  <div style="width:90%;margin:auto;">
    <h2>Bitcoin Blockchain Transactions</h2>

    <div style="width:100%;margin:auto;height:600px;" id="blockchain_chart">&nbsp;</div>

    <h2>Bitcoin Blockchain Transaction Amounts</h2>
    <div style="width:100%;margin:auto;height:600px;" id="blockchain_amount_chart">&nbsp;</div>

  </div>


</div>






<script>

$(function() {

  $.jqplot.config.enablePlugins = true;

  $.jqplot.sprintf.thousandsSeparator = ',';

  var graph_data = new Array();
  var series_label = new Array();


  graph_data.push([<?= implode(',',$data_tx_now) ?>]); series_label.push( { label: 'Year <?= @($this_year) ?>', rendererOptions: { smooth: true } } );
  graph_data.push([<?= implode(',',$data_tx_prev) ?>]); series_label.push( { label: 'Year <?= @($past_year) ?>', rendererOptions: { smooth: true } } );

  var plot_hourly1 = $.jqplot('blockchain_chart', graph_data, {
      axesDefaults: {
        labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
        tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
        tickOptions: {
          angle: -90,
          fontSize: '10px'
        }
      },
      axes: {
        xaxis: {
          label: "Timeline",
          pad: 0
        },
        yaxis: {
          label: "Transactions",
          pad: 0
        }
      },
      seriesColors: [ "orange", "#6699cc"],
      seriesDefaults: {
        showMarker:false,
        pointLabels:{ show:false, location:'sw', ypadding:5, hideZeros:true, formatString: "PhP %'.2f" }
      },
      highlighter: {
        show: false,
        sizeAdjust: 7.5
      },
      cursor: {
        show: false
      },
      series: series_label,
      legend: { show:true, placement: 'insideGrid', location: 'nw' }
    });




  var graph_data = new Array();
  var series_label = new Array();

  graph_data.push([<?= implode(',',$data_amount_now) ?>]); series_label.push( { label: 'Year <?= @($this_year) ?>', rendererOptions: { smooth: true } } );
  graph_data.push([<?= implode(',',$data_amount_prev) ?>]); series_label.push( { label: 'Year <?= @($past_year) ?>', rendererOptions: { smooth: true } } );

  var plot_hourly1 = $.jqplot('blockchain_amount_chart', graph_data, {
      axesDefaults: {
        labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
        tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
        tickOptions: {
          angle: -90,
          fontSize: '10px'
        }
      },
      axes: {
        xaxis: {
          label: "Timeline",
          pad: 0
        },
        yaxis: {
          label: "Amount",
          pad: 0
        }
      },
      seriesColors: [ "orange", "#6699cc"],
      seriesDefaults: {
        showMarker:false,
        pointLabels:{ show:false, location:'sw', ypadding:5, hideZeros:true, formatString: "PhP %'.2f" }
      },
      highlighter: {
        show: false,
        sizeAdjust: 7.5
      },
      cursor: {
        show: false
      },
      series: series_label,
      legend: { show:true, placement: 'insideGrid', location: 'nw' }
    });


});

</script>
