<?php
/**
 * Class admin
 *
 * @package ResidencesChoisille
 */

/**
 * Admin class
 *
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */
class Admin {

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
	 * @param str $theme_version The theme version.
	 * @access public
	 */
	public function __construct( $theme_version ) {
		$this->theme_version = $theme_version;

		add_filter( 'admin_footer_text', array( $this, 'set_admin_footer_text' ) );
		add_filter( 'upload_mimes', array( $this, 'upload_mimes_svg' ) );
	}

	/**
	 * Set custom footer text
	 *
	 * @access public
	 * @see https://developer.wordpress.org/reference/hooks/admin_footer_text/
	 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
	 */
	public function set_admin_footer_text() {
		return __( 'Thank you for creating with <a href="http://www.19h47.fr/" target="_blank">19h47</a> and <a href="http://www.mokacreation.com/" target="_blank">MOKA Création</a>. ✌️', 'rsdncschsll' );
	}

	/**
	 * Updload mimes SVG
	 *
	 * @access public
	 * @param  arr $mimes Array of mimes type.
	 * @return arr $mimes
	 */
	public function upload_mimes_svg( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';

		return $mimes;
	}
}
