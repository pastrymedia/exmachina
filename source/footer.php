<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Footer Template
 * footer.php
 *
 * @todo bring in actual markup
 * @todo look into structural wrap
 *
 * Template file for displaying the theme footer
 * @link http://codex.wordpress.org/Theme_Development#Footer_.28footer.php.29
 *
 * @package <[THEME NAME]>
 * @subpackage Templates
 * @author Machina Themes | @machinathemes
 * @copyright Copyright (c) 2013, Machina Themes
 * @license http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link http://www.machinathemes.com/themes/<[theme-name]>
 */

exmachina_structural_wrap( 'site-inner', 'close' );
echo '</div>'; //* end .site-inner or #inner

do_action( 'exmachina_before_footer' );
do_action( 'exmachina_footer' );
do_action( 'exmachina_after_footer' );

echo '</div>'; //* end .site-container or #wrap

do_action( 'exmachina_after' );
wp_footer(); //* we need this for plugins
?>
</body>
</html>