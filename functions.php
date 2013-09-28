<?php
/*
 WARNING: This file is part of the core ExMachina Framework. DO NOT edit
 this file under any circumstances. Please do all modifications
 in the form of a child theme.
 */

/**
 * This file calls the init.php file, but only
 * if the child theme hasn't called it first.
 *
 * This method allows the child theme to load
 * the framework so it can use the framework
 * components immediately.
 *
 * This file is a core ExMachina file and should not be edited.
 *
 * @category ExMachina
 * @package  Templates
 * @author   Machina Themes
 * @license  GPL-2.0+
 * @link     http://machinathemes.com/themes/exmachina
 */

require_once( dirname( __FILE__ ) . '/lib/init.php' );
