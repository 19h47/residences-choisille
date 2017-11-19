<?php
/**
 * Admin class
 *
 * @author  Jérémy Levron levronjeremy@19h47.fr
 */
class Admin {

	/**
	 * The unique identifier of this theme.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this theme.
	 */
	protected $theme_name;


	/**
	 * The version of the theme.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this theme.
	 */
	private $theme_version;


	/**
	 * Construct function
	 *
	 * @access public
	 */
	public function __construct( $theme_name, $theme_version ) {
		$this->theme_name = $theme_name;
		$this->theme_version = $theme_version;

		add_filter( 'admin_footer_text', array( $this, 'set_admin_footer_text' ) );
		add_filter('upload_mimes', array( $this, 'upload_mimes_svg' ) );
	}

	/**
	 * Set custom footer text
	 *
	 * @param   string $content The content that will be printed.
	 * @see     https://developer.wordpress.org/reference/hooks/admin_footer_text/
	 * @author  Jérémy Levron levronjeremy@19h47.fr
	 */
	function set_admin_footer_text() {
		return __( 'Thank you for creating with <a href="http://www.19h47.fr/" target="_blank">19h47</a> and <a href="http://www.mokacreation.com/" target="_blank">MOKA Création</a>. ✌️', $this->theme_name );
	}


	function upload_mimes_svg( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';

		return $mimes;
	}
}