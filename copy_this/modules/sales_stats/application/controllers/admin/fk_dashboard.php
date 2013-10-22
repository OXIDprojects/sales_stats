<?php

class fk_dashboard extends oxAdminView
{
  protected $_sThisTemplate = 'fk_dashboard.tpl';
  
  protected $_sCountQ = "SELECT SUM(OXTOTALORDERSUM) FROM `oxorder` WHERE OXSTORNO = 0 "; 
    
  // define visible time range
  // launch of shop: (YYYY-MM-DD)
  protected $_statstart = "2013-01-01"; // TODO: get first sale, use that date
  // limit number of displayed months to:
  protected $_showlastmonths = 12;  
  
  // what values to show (corresponds to keywords in function showBasicStats)
  // function will fill these keys with values
  protected $_return_stats = array(
    "year",
    "month",
    "orders",
    "totalvalue",
    "avgvalue",
    "delcostpaid",
    "vouchersvalue",  
    //"returns",
    //"returnsvalue"  
  );

  public function render()
  {
      require_once("inc/google-chart.inc.php");
  
      function showBasicStats($date1, $date2, $return_stats)
      {                               
        $return_stats["month"] = date('F', strtotime ($date1));
        $return_stats["year"] = date('Y',  strtotime ($date1));  
      
        $date1 = $date1 . " 00:00:00";
        $date2 = $date2 . " 23:59:59";        
        
        $orders = 0;
        //$returns = 0;
        $sumvalue = 0;    
        
        // get revenue data
        $sql = "SELECT 
        COUNT(oxid) as orders,
        SUM(OXTOTALORDERSUM) as totalsum,
        AVG(OXTOTALORDERSUM) as avgsum,  
        SUM(OXVOUCHERDISCOUNT) as vouchersvalue,   
        SUM(OXDELCOST) as delcostpaid
        FROM `oxorder`
        WHERE OXORDERDATE between '".$date1."' and '".$date2."' 
        AND OXSTORNO = 0 
        ";  
		
		
        $row = oxDb::getDb(true)->Execute( $sql );
		
		if( $row != false && $row->recordCount() > 0 ) {
          while ( !$row->EOF ) {                
            $orders = $row->fields[0]; 
            $totalsum = $row->fields[1];
            $avgsum = $row->fields[2];   
            $vouchersvalue = $row->fields[3];
            $delcostpaid = $row->fields[4];    		              
            $row->moveNext();
        	}
        }
        
        $return_stats["orders"] = $orders;
        
        if ($orders > 0) 
        {    
          // Total value of orders
          $return_stats["totalvalue"] = $totalsum;    
          // Average order value 
          $return_stats["avgvalue"] = round($avgsum,2);
          // Value of all vouchers used          
          if ($vouchersvalue > 0) 
          { 
            $return_stats["vouchersvalue"] = $vouchersvalue;
          } 
          else
          {
            $return_stats["vouchersvalue"] = "";
          }
          // Sum of all delivery cost paid by customers
          if ($delcostpaid > 0) $return_stats["delcostpaid"] = $delcostpaid;
        } // if orders > 0   
        return $return_stats; 
      
      } // showBasicStats  
    
    parent::render();
    $oSmarty = oxUtilsView::getInstance()->getSmarty();
    $oSmarty->assign( "oViewConf", $this->_aViewData["oViewConf"]);
    $oSmarty->assign( "shop", $this->_aViewData["shop"]);
    
    // define time frame --------------------------     
    $results = array();
    
    //exact end date (day)
    // last day of current month
    $end = date("Y-m-d", mktime(0, 0, 0, date('m')+1, 0, date('Y')) );    
    
    $month = strtotime($this->_statstart);
    $end = strtotime($end);
    
    // assure that $month is not before time span defined by $showlastmonths
    $spanstart = mktime(0, 0, 0, date('m', $end)-$this->_showlastmonths, 1, date('Y', $end));
    
    if ($spanstart > $month) $month = $spanstart;
 
    while($month < $end)
    {
         $firstday = mktime(0, 0, 0, date('m', $month), 1, date('Y', $month));
         $lastday = mktime(0, 0, 0, date('m', $month)+1, 0, date('Y', $month));
               
         $firstday = date("Y-m-d", $firstday);
         $lastday = date("Y-m-d", $lastday);     
         
         $results[]= ( showBasicStats($firstday,$lastday,$this->_return_stats) );           
         $month = strtotime("+1 month", $month);
    }    
    // /define time frame --------------------------
    
    // pass complete result array to template:
    $this->_aViewData["stats_results"] = $results;
    
    // prepare visualization with Google Charts API ----------------------------
    $maxmonths = count($results);
    $chartrow = array();
    //$chartrowreturns = array();
    $labels_x = array();

    foreach ($this->_return_stats as $return_stat)
    {            
      for ($col = 0; $col<$maxmonths; $col++) {
          // collect main values for chart view          
          
          if ($return_stat == "month")
          {                              
            $labels_x[] = substr($results[$col][$return_stat],0,3);
          } 
          else if ($return_stat == "totalvalue")
          {      
            $chartrow[] = round(str_replace  (" €", "", $results[$col][$return_stat]));
          }
          //else if ($return_stat == "returnsvalue")
          //{      
            //$chartrowreturns[] = round(str_replace  (" €", "", $results[$col][$return_stat]));
          //}    
      } // for each col
    } // foreach return_stat        
        
    $chartrows = array();
    $chartrows[] = $chartrow;
    //$chartrows[] = $chartrowreturns;     
    //$this->_aViewData["google_chart_src"] = "http://chart.apis.google.com/chart?chs=700x250&cht=bvo&chco=006699,E3E0D6&chd=". chart_data_text($chartrows) ."&chtt=Total+Order+Values&chxt=x,y&chxl=0:|". implode("|", $labels_x) ."&chbh=30&chxr=1,0,". max($chartrow) ."&chdl=order+value|returns+value";
    $this->_aViewData["google_chart_src"] = "http://chart.apis.google.com/chart?chs=700x250&cht=bvo&chco=999999&chd=". chart_data_text($chartrows) ."&chtt=Total+Order+Values&chxt=x,y&chxl=0:|". implode("|", $labels_x) ."&chbh=30&chxr=1,0,". max($chartrow) ."&chdl=order+value";
	// /prepare visualization with Google Charts API ----------------------------

    // simple query: total revenue since launch    
    // execute query and put results into template variable    
    $this->_aViewData["total_revenue"] = oxDb::getDb()->getOne( $this->_sCountQ );
    
    return $this->_sThisTemplate;
      
  } // render
  
}
?>