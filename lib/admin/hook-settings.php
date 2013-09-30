<?php
/**
 * This file handles the creation of the Hooks admin menu.
 */


/**
 * Registers a new admin page, providing content and corresponding menu item
 * for the Hooks Settings page.
 *
 * @since 1.8.0
 */
class ExMachina_Admin_Hook_Settings extends ExMachina_Admin_Boxes {

	/**
	 * Create an admin menu item and settings page.
	 *
	 * @since 1.8.0
	 *
	 * @uses EXMACHINA_HOOK_SETTINGS_FIELD settings field key
	 *
	 */
	function __construct() {

		$page_id = 'hook-settings';

		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'exmachina',
				'page_title'  => __( 'Action Hook Settings', 'exmachina' ),
				'menu_title'  => __( 'Action Hooks', 'exmachina' )
			)
		);

		$page_ops = array(
			'screen_icon' => 'plugins',
		);

		$settings_field = EXMACHINA_HOOK_SETTINGS_FIELD;

		$default_settings = array(

			//* Wordpress Hooks
			'wp_head' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'wp_footer' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			//* Internal Hooks
			'exmachina_pre' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_pre_framework' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_init' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_setup' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			//* Document Hooks
			'exmachina_doctype' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_title' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_meta' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_before' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_after' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			//* Header hooks
			'exmachina_before_header' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_header' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_header_right' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_after_header' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'exmachina_site_title' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_site_description' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			//* Content Hooks
			'exmachina_before_content_sidebar_wrap' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_after_content_sidebar_wrap' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'exmachina_before_content' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_after_content' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			//* Loop Hooks
			'exmachina_before_loop' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_loop' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_after_loop' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'exmachina_after_endwhile' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_loop_else' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			//* HTML5 Entry Hooks
			'exmachina_before_entry' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_entry_header' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_entry_content' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_entry_footer' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_after_entry' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			//* xHTML Entry Hooks
			'exmachina_before_post' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_after_post' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'exmachina_before_post_title' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_post_title' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_after_post_title' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'exmachina_before_post_content' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_post_content' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_after_post_content' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			//* Comment Hooks
			'exmachina_before_comments' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_comments' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_list_comments' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_after_comments' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'exmachina_before_pings' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_pings' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_list_pings' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_after_pings' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'exmachina_before_comment' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_comment' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_after_comment' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'exmachina_before_comment' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_after_comment' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'exmachina_before_comment_form' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_comment_form' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_after_comment_form' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			//* Sidebar Hooks
			'exmachina_before_sidebar' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_sidebar' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_after_sidebar' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'exmachina_before_sidebar_widget_area' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_after_sidebar_widget_area' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'exmachina_before_sidebar_alt' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_sidebar_alt' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_after_sidebar_alt' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'exmachina_before_sidebar_alt_widget_area' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_after_sidebar_alt_widget_area' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'exmachina_before_footer' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_footer' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_after_footer' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			//* Admin Hooks
			'exmachina_import_export_form' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_export' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_import' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_theme_settings_metaboxes' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'exmachina_upgrade' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

		);

		//* Create the page */
		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

	}

	/**
	 * Load the necessary scripts for this admin page.
	 *
	 * @since 1.8.0
	 *
	 */
	function scripts() {

		//* Load parent scripts as well as ExMachina admin scripts */
		parent::scripts();
		exmachina_load_admin_js();

	}

	/**
 	 * Register meta boxes on the Hooks Settings page.
 	 *
 	 * @since 1.8.0
 	 *
 	 */
	function metaboxes() {

		add_meta_box( 'exmachina-hook-settings-wp-hooks', __( 'WordPress Hooks', 'exmachina' ), array( $this, 'wp_hooks_box' ), $this->pagehook, 'main' );
		add_meta_box( 'exmachina-hook-settings-document-hooks', __( 'Document Hooks', 'exmachina' ), array( $this, 'document_hooks_box' ), $this->pagehook, 'main' );
		add_meta_box( 'exmachina-hook-settings-header-hooks', __( 'Header Hooks', 'exmachina' ), array( $this, 'header_hooks_box' ), $this->pagehook, 'main' );
		add_meta_box( 'exmachina-hook-settings-content-hooks', __( 'Content Hooks', 'exmachina' ), array( $this, 'content_hooks_box' ), $this->pagehook, 'main' );
		add_meta_box( 'exmachina-hook-settings-loop-hooks', __( 'Loop Hooks', 'exmachina' ), array( $this, 'loop_hooks_box' ), $this->pagehook, 'main' );

		if ( current_theme_supports( 'html5' ) )
			add_meta_box( 'exmachina-hook-settings-entry-hooks', __( 'Entry Hooks', 'exmachina' ), array( $this, 'html5_entry_hooks_box' ), $this->pagehook, 'main' );
		else
			add_meta_box( 'exmachina-hook-settings-post-hooks', __( 'Post/Page Hooks', 'exmachina' ), array( $this, 'post_hooks_box' ), $this->pagehook, 'main' );

		add_meta_box( 'exmachina-hook-settings-comment-list-hooks', __( 'Comment List Hooks', 'exmachina' ), array( $this, 'comment_list_hooks_box' ), $this->pagehook, 'main' );
		add_meta_box( 'exmachina-hook-settings-ping-list-hooks', __( 'Ping List Hooks', 'exmachina' ), array( $this, 'ping_list_hooks_box' ), $this->pagehook, 'main' );
		add_meta_box( 'exmachina-hook-settings-comment-hooks', __( 'Single Comment Hooks', 'exmachina' ), array( $this, 'comment_hooks_box' ), $this->pagehook, 'main' );
		add_meta_box( 'exmachina-hook-settings-comment-form-hooks', __( 'Comment Form Hooks', 'exmachina' ), array( $this, 'comment_form_hooks_box' ), $this->pagehook, 'main' );
		add_meta_box( 'exmachina-hook-settings-sidebar-hooks', __( 'Sidebar Hooks', 'exmachina' ), array( $this, 'sidebar_hooks_box' ), $this->pagehook, 'main' );
		add_meta_box( 'exmachina-hook-settings-footer-hooks', __( 'Footer Hooks', 'exmachina' ), array( $this, 'footer_hooks_box' ), $this->pagehook, 'main' );

	}

	function wp_hooks_box() {

		exmachina_hooks_form_generate( array(
			'hook' => 'wp_head',
			'desc' => __( 'This hook executes immediately before the closing <code>&lt;/head&gt;</code> tag.', 'exmachina' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'wp_footer',
			'desc' => __( 'This hook executes immediately before the closing <code>&lt;/body&gt;</code> tag.', 'exmachina' )
		) );

		submit_button( __( 'Save Changes', 'exmachina' ), 'primary' );

	}

	function document_hooks_box() {

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_title',
			'desc' => __( 'This hook executes between the main document <code>&lt;title&gt;&lt;/title&gt;</code> tags.', 'exmachina' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_meta',
			'desc' => __( 'This hook executes in the document <code>&lt;head&gt;</code>.<br /> It is commonly used to output <code>META</code> information about the document.', 'exmachina' ),
			'unhook' => array( 'exmachina_load_favicon' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_before',
			'desc' => __( 'This hook executes immediately after the opening <code>&lt;body&gt;</code> tag.', 'exmachina' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_after',
			'desc' => __( 'This hook executes immediately before the closing <code>&lt;/body&gt;</code> tag.', 'exmachina' )
		) );

		submit_button( __( 'Save Changes', 'exmachina' ), 'primary' );

	}

	function header_hooks_box() {

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_before_header',
			'desc' => __( 'This hook executes immediately before the header (outside the <code>#header</code> div).', 'exmachina' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_header',
			'desc' => __( 'This hook outputs the default header (the <code>#header</code> div)', 'exmachina' ),
			'unhook' => array( 'exmachina_do_header' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_after_header',
			'desc' => __( 'This hook executes immediately after the header (outside the <code>#header</code> div).', 'exmachina' )
		) );

		submit_button( __( 'Save Changes', 'exmachina' ), 'primary' );

	}

	function content_hooks_box() {

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_before_content_sidebar_wrap',
			'desc' => __( 'This hook executes immediately before the div block that wraps the content and the primary sidebar (outside the <code>#content-sidebar-wrap</code> div).', 'exmachina' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_after_content_sidebar_wrap',
			'desc' => __( 'This hook executes immediately after the div block that wraps the content and the primary sidebar (outside the <code>#content-sidebar-wrap</code> div).', 'exmachina' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_before_content',
			'desc' => __( 'This hook executes immediately before the content column (outside the <code>#content</code> div).', 'exmachina' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_after_content',
			'desc' => __( 'This hook executes immediately after the content column (outside the <code>#content</code> div).', 'exmachina' )
		) );

		submit_button( __( 'Save Changes', 'exmachina' ), 'primary' );

	}

	function loop_hooks_box() {

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_before_loop',
			'desc' => __( 'This hook executes immediately before all loop blocks.<br /> Therefore, this hook falls outside the loop, and cannot execute functions that require loop template tags or variables.', 'exmachina' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_loop',
			'desc' => __( 'This hook executes both default and custom loops.', 'exmachina' ),
			'unhook' => array( 'exmachina_do_loop' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_after_loop',
			'desc' => __( 'This hook executes immediately after all loop blocks.<br /> Therefore, this hook falls outside the loop, and cannot execute functions that require loop template tags or variables.', 'exmachina' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_after_endwhile',
			'desc' => __( 'This hook executes after the <code>endwhile;</code> statement.', 'exmachina' ),
			'unhook' => array( 'exmachina_posts_nav' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_loop_else',
			'desc' => __( 'This hook executes after the <code>else :</code> statement in all loop blocks. The content attached to this hook will only display if there are no posts available when a loop is executed.', 'exmachina' ),
			'unhook' => array( 'exmachina_do_noposts' )
		) );

		submit_button( __( 'Save Changes', 'exmachina' ), 'primary' );

	}

	function html5_entry_hooks_box() {

		exmachina_hooks_form_generate(array(
			'hook' => 'exmachina_before_entry',
			'desc' => __( 'This hook executes before each entry in all loop blocks (outside the entry markup element).', 'exmachina' )
		) );

		exmachina_hooks_form_generate(array(
			'hook' => 'exmachina_entry_header',
			'desc' => __( 'This hook executes before the entry content. By default, it outputs the entry title and meta information.', 'exmachina' )
		) );

		exmachina_hooks_form_generate(array(
			'hook' => 'exmachina_entry_content',
			'desc' => __( 'This hook, by default, outputs the entry content.', 'exmachina' )
		) );

		exmachina_hooks_form_generate(array(
			'hook' => 'exmachina_entry_footer',
			'desc' => __( 'This hook executes after the entry content. By Default, it outputs entry meta information.', 'exmachina' )
		) );

		exmachina_hooks_form_generate(array(
			'hook' => 'exmachina_after_entry',
			'desc' => __( 'This hook executes after each entry in all loop blocks (outside the entry markup element).', 'exmachina' )
		) );

		submit_button( __( 'Save Changes', 'exmachina' ), 'primary' );

	}

	function post_hooks_box() {

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_before_post',
			'desc' => __( 'This hook executes before each post in all loop blocks (outside the <code>post_class()</code> div).', 'exmachina' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_after_post',
			'desc' => __( 'This hook executes after each post in all loop blocks (outside the <code>post_class()</code> div).', 'exmachina' ),
			'unhook' => array( 'exmachina_do_author_box' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_before_post_title',
			'desc' => __( 'This hook executes immediately before each post/page title within the loop.', 'exmachina' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_post_title',
			'desc' => __( 'This hook outputs the post/page title.', 'exmachina' ),
			'unhook' => array( 'exmachina_do_post_title' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_after_post_title',
			'desc' => __( 'This hook executes immediately after each post/page title within the loop.', 'exmachina' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_before_post_content',
			'desc' => __( 'This hook executes immediately before the <code>exmachina_post_content</code> hook for each post/page within the loop.', 'exmachina' ),
			'unhook' => array( 'exmachina_post_info' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_post_content',
			'desc' => __( 'This hook outputs the content of the post/page, by default.', 'exmachina' ),
			'unhook' => array( 'exmachina_do_post_image', 'exmachina_do_post_content' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_after_post_content',
			'desc' => __( 'This hook executes immediately after the <code>exmachina_post_content</code> hook for each post/page within the loop.', 'exmachina' ),
			'unhook' => array( 'exmachina_post_meta' )
		) );

		submit_button( __( 'Save Changes', 'exmachina' ), 'primary' );

	}

	function comment_list_hooks_box() {

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_before_comments',
			'desc' => __( 'This hook executes immediately before the comments block (outside the <code>#comments</code> div).', 'exmachina' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_comments',
			'desc' => __( 'This hook outputs the comments block, including the <code>#comments</code> div.', 'exmachina' ),
			'unhook' => array( 'exmachina_do_comments' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_list_comments',
			'desc' => __( 'This hook executes inside the comments block, inside the <code>.comment-list</code> OL. By default, it outputs a list of comments associated with a post via the <code>exmachina_default_list_comments()</code> function.', 'exmachina' ),
			'unhook' => array( 'exmachina_default_list_comments' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_after_comments',
			'desc' => __( 'This hook executes immediately after the comments block (outside the <code>#comments</code> div).', 'exmachina' )
		) );

	}

	function ping_list_hooks_box() {

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_before_pings',
			'desc' => __( 'This hook executes immediately before the pings block (outside the <code>#pings</code> div).', 'exmachina' ),
			'unhook' => array( 'exmachina_do_pings' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_pings',
			'desc' => __( 'This hook outputs the pings block, including the <code>#pings</code> div.', 'exmachina' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_list_pings',
			'desc' => __( 'This hook executes inside the pings block, inside the <code>.ping-list</code> OL. By default, it outputs a list of pings associated with a post via the <code>exmachina_default_list_pings()</code> function.', 'exmachina' ),
			'unhook' => array( 'exmachina_default_list_pings' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_after_pings',
			'desc' => __( 'This hook executes immediately after the pings block (outside the <code>#pings</code> div).', 'exmachina' )
		) );

		submit_button( __( 'Save Changes', 'exmachina' ), 'primary' );

	}

	function comment_hooks_box() {

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_before_comment',
			'desc' => __( 'This hook executes immediately before each individual comment (inside the <code>.comment</code> list item).', 'exmachina' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_after_comment',
			'desc' => __( 'This hook executes immediately after each individual comment (inside the <code>.comment</code> list item).', 'exmachina' )
		) );

		submit_button( __( 'Save Changes', 'exmachina' ), 'primary' );

	}

	function comment_form_hooks_box() {

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_before_comment_form',
			'desc' => __( 'This hook executes immediately before the comment form, outside the <code>#respond</code> div.', 'exmachina' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_comment_form',
			'desc' => __( 'This hook outputs the entire comment form, including the <code>#respond</code> div.', 'exmachina' ),
			'unhook' => array( 'exmachina_do_comment_form' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_after_comment_form',
			'desc' => __( 'This hook executes immediately after the comment form, outside the <code>#respond</code> div.', 'exmachina' )
		) );

		submit_button( __( 'Save Changes', 'exmachina' ), 'primary' );

	}

	function sidebar_hooks_box() {

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_before_sidebar',
			'desc' => __( 'This hook executes immediately before the primary sidebar column (outside the <code>#sidebar</code> div).', 'exmachina' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_sidebar',
			'desc' => __( 'This hook outputs the content of the primary sidebar, including the widget area output.', 'exmachina' ),
			'unhook' => array( 'exmachina_do_sidebar' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_after_sidebar',
			'desc' => __( 'This hook executes immediately after the primary sidebar column (outside the <code>#sidebar</code> div).', 'exmachina' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_before_sidebar_widget_area',
			'desc' => __( 'This hook executes immediately before the primary sidebar widget area (inside the <code>#sidebar</code> div).', 'exmachina' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_after_sidebar_widget_area',
			'desc' => __( 'This hook executes immediately after the primary sidebar widget area (inside the <code>#sidebar</code> div).', 'exmachina' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_before_sidebar_alt',
			'desc' => __( 'This hook executes immediately before the alternate sidebar column (outside the <code>#sidebar-alt</code> div).', 'exmachina' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_sidebar_alt',
			'desc' => __( 'This hook outputs the content of the secondary sidebar, including the widget area output.', 'exmachina' ),
			'unhook' => array( 'exmachina_do_sidebar_alt' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_after_sidebar_alt',
			'desc' => __( 'This hook executes immediately after the alternate sidebar column (outside the <code>#sidebar-alt</code> div).', 'exmachina' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_before_sidebar_alt_widget_area',
			'desc' => __( 'This hook executes immediately before the alternate sidebar widget area (inside the <code>#sidebar-alt</code> div).', 'exmachina' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_after_sidebar_alt_widget_area',
			'desc' => __( 'This hook executes immediately after the alternate sidebar widget area (inside the <code>#sidebar-alt</code> div).', 'exmachina' )
		) );

		submit_button( __( 'Save Changes', 'exmachina' ), 'primary' );

	}

	function footer_hooks_box() {

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_before_footer',
			'desc' => __( 'This hook executes immediately before the footer (outside the <code>#footer</code> div).', 'exmachina' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_footer',
			'desc' => __( 'This hook, by default, outputs the content of the footer (inside the <code>#footer</code> div).', 'exmachina' ),
			'unhook' => array( 'exmachina_do_footer' )
		) );

		exmachina_hooks_form_generate( array(
			'hook' => 'exmachina_after_footer',
			'desc' => __( 'This hook executes immediately after the footer (outside the <code>#footer</code> div).', 'exmachina' )
		) );

		submit_button( __( 'Save Changes', 'exmachina' ), 'primary' );

	}

}

add_action( 'exmachina_admin_menu', 'exmachina_add_hooks_settings_menu' );
/**
 * Instantiate the class to create the menu.
 *
 * @since 1.8.0
 */
function exmachina_add_hooks_settings_menu() {

	new ExMachina_Admin_Hook_Settings;

}