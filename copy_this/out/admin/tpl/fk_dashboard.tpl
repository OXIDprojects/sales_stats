[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign box="list"}]

<script type="text/javascript">
  /*
  if(top)
  {
    top.sMenuItem    = "[{ oxmultilang ident=FK_DASHBOARD_MENUITEM" }]";
    top.sMenuSubItem = "[{ oxmultilang ident="FK_DASHBOARD_MENUSUBITEM" }]";
    top.sWorkArea    = "[{$_act}]";
    top.setTitle();
  }
  */
</script>
<h2>[{ oxmultilang ident=FK_DASHBOARD_MENUITEM" }]</h2> 
<p>[{ oxmultilang ident=FK_DASHBOARD_ALLTIME_REV" }] = [{$total_revenue|number_format:"2":$oActCur->dec:$oActCur->thousand}] [{$oActCur->sign}]</p>  
<div>
	<img src="[{$google_chart_src}]" width="700" height="250" alt="[{ oxmultilang ident=FK_DASHBOARD_TOTAL_VAL" }]" />
</div>

<h3>[{ oxmultilang ident=FK_DASHBOARD_MENUSUBITEM" }]</h3>
<table>
	<tr>    
		<th style="padding:3px;">[{ oxmultilang ident="FK_DASHBOARD_YEAR" }]</th>
		<th style="padding:3px;">[{ oxmultilang ident="FK_DASHBOARD_MONTH" }]</th>
		<th style="padding:3px;">[{ oxmultilang ident="FK_DASHBOARD_ORDERS" }]</th>
		<th style="padding:3px;">[{ oxmultilang ident="FK_DASHBOARD_TOTAL_VAL" }]</th>
		<th style="padding:3px;">[{ oxmultilang ident="FK_DASHBOARD_AVG_VAL" }]</th>
		<th style="padding:3px;">[{ oxmultilang ident="FK_DASHBOARD_DEL_PAID" }]</th>
		<th style="padding:3px;">[{ oxmultilang ident="FK_DASHBOARD_VOUCHERS_VAL" }]</th>
	</tr>
	[{section name=resultssec loop=$stats_results}]
	[{strip}] 
	<tr bgcolor="[{cycle values="#dddddd,#ffffff"}]">
		<td style="padding:3px;">[{$stats_results[resultssec].year}]</td>
		<td style="padding:3px;">[{$stats_results[resultssec].month}]</td>
		<td style="padding:3px;">[{$stats_results[resultssec].orders}]</td>
		<td style="padding:3px;">[{if $stats_results[resultssec].totalvalue}][{$stats_results[resultssec].totalvalue|number_format:"2":$oActCur->dec:$oActCur->thousand}] [{$oActCur->sign}][{/if}]</td>
		<td style="padding:3px;">[{if $stats_results[resultssec].avgvalue}][{$stats_results[resultssec].avgvalue|number_format:"2":$oActCur->dec:$oActCur->thousand}] [{$oActCur->sign}][{/if}]</td>
		<td style="padding:3px;">[{if $stats_results[resultssec].delcostpaid}][{$stats_results[resultssec].delcostpaid|number_format:"2":$oActCur->dec:$oActCur->thousand}] [{$oActCur->sign}][{/if}]</td>
		<td style="padding:3px;">[{if $stats_results[resultssec].vouchersvalue}][{$stats_results[resultssec].vouchersvalue|number_format:"2":$oActCur->dec:$oActCur->thousand}] [{$oActCur->sign}][{/if}]</td>      
	</tr>
	[{/strip}]
	[{/section}]
</table>  
<p style="font-size:0.8em">fk Dashboard ver. 0.6</p>    
[{include file="bottomitem.tpl"}]