<?php
function chart_data($values) {

  // Port of JavaScript from http://code.google.com/apis/chart/
  // http://james.cridland.net/code
  
  // First, find the maximum value from the values given
  
  $maxValue = max($values);
  
  // A list of encoding characters to help later, as per Google's example
  $simpleEncoding = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
   
  $chartData = "s:";
    for ($i = 0; $i < count($values); $i++) {
      $currentValue = $values[$i];
  
      if ($currentValue > -1) {
        $chartData.=substr($simpleEncoding,61*($currentValue/$maxValue),1);      
      }
        else {
        $chartData.='_';
        }
    }
  
  // Return the chart data - and let the Y axis to show the maximum value
  return $chartData."&chxt=y&chxl=0:|0|".$maxValue;
} // chart_data


function chart_data_multiple($values_arrs) {
  
  $chartData_arr = array();
  $maxValue_arr  = array();
  
  // loop through all arrays
  
  foreach ($values_arrs as $values)
  {
  
    // First, find the maximum value from the values given
    
    $maxValue = max($values);
    
    // A list of encoding characters to help later, as per Google's example
    $simpleEncoding = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
     
    $chartData = "";
      for ($i = 0; $i < count($values); $i++) {
        $currentValue = $values[$i];
    
        if ($currentValue > -1) {
          $chartData.=substr($simpleEncoding,61*($currentValue/$maxValue),1);                    
        }
          else {
          $chartData.='_';
          }
      }
      $chartData_arr[] = $chartData;
      $maxValue_arr[]  = $maxValue;
  } // foreach $values_arrs
  
  // prepare return string

  $return_str = "s:";  
  foreach($chartData_arr as $chartData)
  {
    $return_str .= $chartData . ",";
  }
  // drop last ","
  $return_str = substr($return_str,0,strlen($return_str)-1);

  // set markers
  $return_str .= "&chm=";
  // N,FF0000,-1,,12|N,000000,0,,12,,c|
  // <marker_type>,<color>,<series_index>,<which_points>,<size>,<z_order>,<placement>
    
  $fontsize = 11;
  $seriesindex = 0;
  $colorhex = "000000";  
  foreach($chartData_arr as $chartData)
  {
    if ($seriesindex == 1) $colorhex = "FF0000";    
    $return_str .= "N*cEUR*,".$colorhex.",".$seriesindex.",,".$fontsize.",,hte|";
    $seriesindex++;
  }
  // drop last "|"
  $return_str = substr($return_str,0,strlen($return_str)-1);  
  
  return $return_str;
} // chart_data_multiple 


function chart_data_text($values_arrs) {
  
  $chartData_arr = array();
  $maxValue_arr  = array();
  
  // loop through all arrays
  
  
  foreach ($values_arrs as $values)
  {
  
    // First, find the maximum value from the values given
    
    $maxValue = max($values);
    
    // A list of encoding characters to help later, as per Google's example
    $simpleEncoding = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
     
    $chartData = "";
      for ($i = 0; $i < count($values); $i++) {
        $currentValue = $values[$i];
    
        if ($currentValue > -1) {
          //$chartData.=substr($simpleEncoding,61*($currentValue/$maxValue),1);          
          $chartData.=$currentValue;
        }
          else {
          $chartData.='_';
          }
      }
      $chartData_arr[] = $chartData;
      $maxValue_arr[]  = $maxValue;
  } // foreach $values_arrs
  
  
  // prepare return string
  

  
  // ##### ALTERNATIV t mit custom scaling testen!!!
  
  $return_str = "t:";  
  $minmax = "";
  $maxmax = 0;
  //$minmin = 0;
  foreach ($values_arrs as $values)
  {
    $return_str .= implode(",", $values) . "|";    
    if (max($values) > $maxmax) $maxmax = max($values);
    //if (min($values) < $minmin) $minmin = max($minmin);
    $minmax .= "0,".$maxmax.",";
  }
  // drop last "|"
  $return_str = substr($return_str,0,strlen($return_str)-1);
  // drop last ","
  $minmax = substr($minmax,0,strlen($minmax)-1);
  $return_str .= "&chds=" . $minmax;
  
  // #### /ALTERNATIV  
  
  // set markers
  $return_str .= "&chm=";
  // N,FF0000,-1,,12|N,000000,0,,12,,c|
  // <marker_type>,<color>,<series_index>,<which_points>,<size>,<z_order>,<placement>
    
  $fontsize = 11;
  $seriesindex = 0;  
  $colorhex = "000000";
  foreach($chartData_arr as $chartData)
  {    
    if ($seriesindex == 1) $colorhex = "FFFFFF";    
    $return_str .= "N,".$colorhex.",".$seriesindex.",,".$fontsize.",,hbe|";
    $seriesindex++;
  }
  // drop last "|"
  $return_str = substr($return_str,0,strlen($return_str)-1);  
  
  return $return_str;
} // chart_data_text 

?>