<?php
/**
 * Class ResidencesChoisille
 *
 * @package ResidencesChoisille
 */

/**
 * Autoload
 */
require_once get_template_directory() . '/vendor/autoload.php';


/**
 * Timber
 *
 * Instanciate Timber
 *
 * @see         https://github.com/timber/timber
 */
$timber = new \Timber\Timber();


/**
 * Slugify
 */
use Cocur\Slugify\Bridge\Twig\SlugifyExtension;
use Cocur\Slugify\Slugify;



/**
 * Dirname
 *
 * Tell Timber where are views
 */
Timber::$dirname = array( 'views' );


/**
 * Class ResidencesChoisille
 */
class ResidencesChoisille extends TimberSite {

	/**
	 * The name of the theme
	 *
	 * @var $theme_name
	 * @access private
	 */
	private $theme_name;


	/**
	 * The version of this theme
	 *
	 * @var $theme_version
	 * @access private
	 */
	private $theme_version;


	/**
	 * Manifest
	 *
	 * @var $theme_manifest
	 * @access private
	 */
	private $theme_manifest;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @param str $theme_name The theme name.
	 * @param str $theme_version The theme version.
	 * @access public
	 */
	public function __construct( $theme_name, $theme_version ) {

		$this->theme_name    = $theme_name;
		$this->theme_version = $theme_version;

		$this->setup();
		$this->load_dependencies();

		$this->theme_manifest = get_theme_manifest();

		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );

		parent::__construct();
	}


	/**
	 * Load dependencies description
	 *
	 * @access private
	 */
	private function load_dependencies() {

		require_once get_template_directory() . '/inc/utilities.php';
		require_once get_template_directory() . '/inc/customizer/contact.php';
		require_once get_template_directory() . '/inc/post-template.php';
		require_once get_template_directory() . '/inc/reset.php';
		require_once get_template_directory() . '/inc/acf.php';
		require_once get_template_directory() . '/inc/class-admin.php';

		if ( is_admin() ) {
			new Admin( $this->get_theme_version() );
		}
	}


	/**
	 * Add to Twig
	 *
	 * @param obj $twig Twig object.
	 * @return $twig
	 */
	public function add_to_twig( $twig ) {

		if ( function_exists( 'post_class' ) ) {
			$twig->addFunction(
				new \Twig_SimpleFunction(
					'post_class',
					function( $args = '' ) {
						return post_class( $args );
					}
				)
			);
		}

		if ( function_exists( 'body_class' ) ) {
			$twig->addFunction(
				new \Twig_SimpleFunction(
					'body_class',
					function( $args = '' ) {
						return body_class( $args );
					}
				)
			);
		}

		if ( function_exists( 'html_class' ) ) {
			$twig->addFunction(
				new \Twig_SimpleFunction(
					'html_class',
					function( $args = '' ) {
						return html_class( $args );
					}
				)
			);
		}

		$twig->addExtension( new SlugifyExtension( Slugify::create() ) );

		$twig->addFunction(
			new Twig_SimpleFunction(
				'get_theme_manifest',
				function() {
					return $this->theme_manifest;
				}
			)
		);

		return $twig;
	}


	/**
	 * Add to context
	 *
	 * @param arr $context Array context.
	 * @return  $context
	 * @access  public
	 */
	public function add_to_context( $context ) {
		global $post;

		// Menus.
		$menus = get_registered_nav_menus();
		foreach ( $menus as $menu => $value ) {
			$context['menu'][ $menu ] = new TimberMenu( $value );
		}

		// Add socials to context.
		$socials      = array();
		$socials_name = [ 'YouTube', 'Facebook' ];

		foreach ( $socials_name as $name ) {
			${ strtolower( $name ) } = array(
				'slug' => strtolower( $name ),
				'name' => $name,
				'url'  => get_option( strtolower( $name ) ),
			);

			$socials[ strtolower( $name ) ] = ${ strtolower( $name ) };
		}

		// Add $socials to $context.
		$context['contact']['socials'] = $socials;

		// Address.
		if ( get_option( 'address' ) ) {
			$context['contact']['address'] = get_option( 'address' );
		}

		// Email address.
		if ( get_option( 'email_addresses' ) ) {
			$context['contact']['email_addresses'] = array();
			$email_addresses                       = explode( ', ', get_option( 'email_addresses' ) );

			foreach ( $email_addresses as $email_address ) {
				array_push( $context['contact']['email_addresses'], $email_address );
			}
		}

		// Phone.
		if ( get_option( 'phone' ) ) {
			$context['contact']['phone'] = get_option( 'phone' );
		}

		// Permalink.
		$page_args = array();
		$pages     = get_pages( $page_args );

		foreach ( $pages as $page ) {
			// Replace `-` by `_`.
			$slug = str_replace( '-', '_', $page->post_name );

			$context['permalink'][ $slug ] = get_page_link( $page->ID );
		}
		$context['permalink']['current_url'] = get_permalink();

		// Share.
		$shares = array(
			array(
				'slug' => 'facebook',
				'name' => __( 'Partager sur Facebook' ),
				'url'  => 'https://www.facebook.com/sharer.php?u=',
			),
			array(
				'slug' => 'twitter',
				'name' => __( 'Partager sur Twitter' ),
				'url'  => 'https://twitter.com/intent/tweet?url=',
			),
			array(
				'slug' => 'google-plus',
				'name' => __( 'Partager sur Google+' ),
				'url'  => 'https://plus.google.com/share?url=',
			),
			array(
				'slug' => 'envelope',
				'name' => __( 'Partager par Mail' ),
				'url'  => 'mailto:?&amp;body=',
			),
		);

		// Shares.
		foreach ( $shares as $share ) {
			$context['contact']['shares'][ $share['slug'] ] = $share;
		}

		// Résidences.
		$residences = array(
			array(
				'field'          => 'residence_ehpad',
				'services'       => 'left',
				'description'    => __( 'EHPAD à Saint-Cyr-sur-Loire', 'rsdncschsll' ),
				'actuality'      => true,
				'our_apartments' => false,
				'pictogram'      => false,
				'menu'           => array(
					[ __( 'Notre résidence', 'rsdncschsll' ), 'notre-residence' ],
					[ __( 'Hébergement', 'rsdncschsll' ), 'hebergement' ],
					[ __( 'Nos services', 'rsdncschsll' ), 'nos-services' ],
					[ __( 'Notre actualité', 'rsdncschsll' ), 'notre-actualite' ],
				),
			),
			array(
				'field'          => 'residences_services_seniors',
				'services'       => 'right',
				'description'    => __( 'Résidences services seniors à Saint-Cyr-sur-Loire', 'rsdncschsll' ),
				'actuality'      => false,
				'our_apartments' => true,
				'pictogram'      => true,
				'menu'           => array(
					[ __( 'Notre concept', 'rsdncschsll' ), 'notre-concept' ],
					[ __( 'Notre résidence', 'rsdncschsll' ), 'notre-residence' ],
					[ __( 'Nos services', 'rsdncschsll' ), 'nos-services' ],
					[ __( 'Nos appartements', 'rsdncschsll' ), 'nos-appartements' ],
				),
			),
		);

		foreach ( $residences as $residence ) {
			$fields = get_field( $residence['field'], 'option' );

			$context[ $residence['field'] ] = array(
				'title'         => get_the_title( $fields['id'] ),
				'permalink'     => get_permalink( $fields['id'] ),
				'contact'       => get_permalink( $fields['contact'] ),
				'legal_notices' => get_permalink( $fields['legal_notice'] ),
				'recruitment'   => get_permalink( $fields['recruitment'] ),
				'active'        => get_the_id() === $fields['id'] || ( $post && $post->post_parent === $fields['id'] ),
			);

			if ( get_the_id() === $fields['id'] || ( $post && $post->post_parent === $fields['id'] ) ) {
				// Layout.
				$context['layout'] = array(
					'name'           => $residence['field'],
					'services'       => $residence['services'],
					'actuality'      => $residence['services'],
					'our_apartments' => $residence['our_apartments'],
					'services'       => $residence['services'],
					'pictogram'      => $residence['pictogram'],
					'description'    => $residence['description'],
				);

				// Form.
				$context['form']['contact']['id']     = $fields['form']['contact'];
				$context['form']['recruitment']['id'] = $fields['form']['recruitment'];

				// Menu.
				$context['menu']['page']['header'] = array();

				foreach ( $residence['menu'] as $item ) {
					array_push(
						$context['menu']['page']['header'],
						array(
							'title'     => $item[0],
							'permalink' => get_permalink( $fields['id'] ) . '#' . $item[1],
							'slug'      => $item[1],
							'active'    => get_the_id() === $fields['contact'],
						)
					);
				}

				// Contact.
				array_push(
					$context['menu']['page']['header'],
					array(
						'title'     => __( 'Contactez-nous' ),
						'permalink' => get_permalink( $fields['contact'] ),
						'slug'      => 'nous-contacter',
						'active'    => get_the_id() === $fields['contact'],
					)
				);

				$context['menu']['page']['footer'] = array(
					array(
						'title'     => __( 'Accueil', 'rsdncschsll' ),
						'permalink' => get_permalink( $fields['id'] ),
						'slug'      => 'accueil',
						'active'    => get_the_id() === $fields['id'],
					),
					array(
						'title'     => get_the_title( $fields['recruitment'] ),
						'permalink' => get_permalink( $fields['recruitment'] ),
						'slug'      => 'recrutement',
						'active'    => get_the_id() === $fields['recruitment'],
					),
					array(
						'title'     => get_the_title( $fields['legal_notice'] ),
						'permalink' => get_permalink( $fields['legal_notice'] ),
						'slug'      => 'mentions-legales',
						'active'    => get_the_id() === $fields['legal_notice'],
					),
				);
			}
		}

		$context['manifest'] = $this->theme_manifest;

		return $context;
	}


	/**
	 * Setup
	 *
	 * @access public
	 */
	public function setup() {

		/**
		 * Let WordPress manage the document title.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @see https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Register nav menus.
		register_nav_menus(
			array(
				'main' => __( 'Main' ),
			)
		);

		/**
		 * Add excerpt on page
		 *
		 * @see  https://codex.wordpress.org/Function_Reference/add_post_type_support
		 */
		add_post_type_support( 'page', 'excerpt' );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_style' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}


	/**
	 * Enqueue styles.
	 *
	 * @access public
	 */
	public function enqueue_style() {

		// Theme stylesheet.
		wp_register_style(
			$this->theme_name . '-global',
			get_template_directory_uri() . '/dist/' . $this->theme_manifest['main.css'],
			array(),
			'1.0.0'
		);

		wp_enqueue_style( $this->theme_name . '-global' );
	}


	/**
	 * Enqueue scripts
	 *
	 * @access public
	 */
	public function enqueue_scripts() {

		// Remove wp-embed script from WordPress.
		wp_deregister_script( 'wp-embed' );

		// Remove native version of jQuery and use custom CDN version instead.
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', '//code.jquery.com/jquery-3.1.1.min.js', false, '1.0.0', true );

		// Slick.
		wp_register_script(
			'slick',
			'//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);

		wp_register_script(
			$this->theme_name . '-main',
			get_template_directory_uri() . '/dist/' . $this->theme_manifest['main.js'],
			array(
				'jquery',
			),
			'1.0.0',
			true
		);

		wp_enqueue_script(
			'feature',
			'//cdnjs.cloudflare.com/ajax/libs/feature.js/1.0.1/feature.min.js',
			array(),
			'1.0.0',
			false
		);
		wp_add_inline_script(
			'feature',
			'document.documentElement.className=document.documentElement.className.replace("no-js","js"),feature.touch&&!navigator.userAgent.match(/Trident\/(6|7)\./)&&(document.documentElement.className=document.documentElement.className.replace("no-touch","touch"));'
		);

		wp_localize_script(
			$this->theme_name . '-main',
			'wp',
			array(
				'template_directory_uri' => get_template_directory_uri(),
				'base_url'               => site_url(),
				'home_url'               => home_url( '/' ),
				'ajax_url'               => admin_url( 'admin-ajax.php' ),
				'current_url'            => get_permalink(),
			)
		);

		wp_enqueue_script( 'slick' );
		wp_enqueue_script( $this->theme_name . '-main' );
	}


	/**
	 * Retrieve the version number of the theme.
	 *
	 * @since 1.0.0
	 * @return string    The version number of the plugin.
	 * @access public
	 */
	public function get_theme_version() {
		return $this->theme_version;
	}


	/**
	 * The name of the theme used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since 1.0.0
	 * @return string    The name of the plugin.
	 * @access public
	 */
	public function get_theme_name() {
		return $this->theme_name;
	}
}


/**
 * Begins execution of the theme.
 */
$theme = new ResidencesChoisille( 'rsdncschsll', '1.0.0' );
