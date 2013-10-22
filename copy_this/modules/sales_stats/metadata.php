<?php

/**

 * This backend module extends administration view with some basic sales statistics grouped by month. 
 * In addition to this, revenue numbers are visualized by a column chart using Google Chart API.
 *
 * NOTICE OF LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; version 3 of the License
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses/
 *
 * @copyright   Copyright (c) 2013 Peter Wiedeking
 * @author      floko and orca, Marc Würth, Peter Wiedeking
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)


 * Metadata version
 */
$sMetadataVersion = '0.7';
 
/**
 * Module information
 */
$aModule = array(
    'id'           => 'sales_stats',
    'title'        => 'Sales Statistik',
    'description'  => array(
                        'de'=>'basic sales statistics.',
                        'en'=>'basic sales statistics.'
                        ),
    'thumbnail'    => '',
    'version'      => '0.7',
    'author'       => 'floko and orca, Marc Würth, Peter Wiedeking',
    'url'          => 'https://github.com/OXIDprojects/sales_stats',
    'email'        => 'peter.wiedeking@abendtuete.de',
    'extend'       => array(
                        ),
    'files'        => array(
        'fk_dashboard' => 'sales_stats/application/controllers/admin/fk_dashboard.php'
                        ),
    'templates'    => array(
        'fk_dashboard.tpl' => 'sales_stats/views/admin/tpl/fk_dashboard.tpl'
                        )
	)
?>
