sales_stats
===========

This backend module extends administration view with some basic sales statistics grouped by month. In addition to this, revenue numbers are visualized by a column chart using Google Chart API.

Originally registered: 2010-11-09 by floko and orca on former OXID projects.

Installation
===========

1. Copy the content of copy_this into your OXID root directory (no files will be overwritten)
2. Emtpy the tmp directory of your OXID installation
3. You will find the module within the OXID admin on the left under "fk Dashboard".

ENJOY!

Changelog
=========

Module fk_dashboard

Legend
---------

 * -> Security Fix
 # -> Bug Fix
 + -> Addition
 ^ -> Change
 - -> Removed
 ! -> Note

-------------------- 0.6 stable [2011-03-29] by Marc Würth (development@orca-services.ch) -------------------
 -	Removed cust_lang.php, not needed anymore
 ^	Changed menu navigation
 #	fixed English translation (mix up & renamed)
 #	fixed German translation (mix up & renamed)
 -	Removed debugging statements
 -	Removed  currency
 +	Added currecy & currency formatting from OXID settings
 +	Added CHANGELOG.txt
 +	Added INSTALL.txt
 -	Removed changes.txt

-------------------- 0.5 stable [2011-02-15] -------------------
^	File admin/fk_dashboard.php: Line 7 (modified) protected $_sCountQ = "SELECT SUM(OXTOTALORDERSUM) FROM `oxorder` WHERE OXSTORNO = 0 ";
^	File admin/fk_dashboard.php: Line 53ff (added the following at the end of mysql query)AND OXSTORNO = 0
^	File out/admin/tpl/fk_dashboard.tpl: Changed version number in footer (to 0.5) 

-------------------- 0.4 stable [2010-11-08] -------------------
!	initial release: http://www.oxid-esales.com/forum/showthread.php?t=7484&highlight=Verkaufsstatistik

