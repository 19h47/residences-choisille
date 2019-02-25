<?php

add_action( 'customize_register', 'rsdn' );

/**
 * Contact
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function rsdn( $wp_customize ) {

	/**
	 * Add contact section
	 */
	$wp_customize->add_section(
		'contact',
		array(
			'title' 		=> __( 'Coordonnées', 'rsdn' ),
			'description'	=> __( 'Réglages des coordonnées', 'rsdn' ),
		)
	);

	/**
	 * Add Contact settings and controls in related section
	 */
	$wp_customize->add_setting(
		'address',
		array(
			'type'      => 'option',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'address',
		array(
			'label'     	=> __( 'Adresse', 'rsdn' ),
			'description'	=> __( 'Indiquer l\'adresse postale', 'rsdn'),
			'type'      	=> 'textarea',
			'section'   	=> 'contact',
			'settings'  	=> 'address',
		)
	);

	/**
	 * Email address
	 */
	$wp_customize->add_setting(
		   'email_addresses',
		   array(
		   'type'      => 'option',
		   'transport' => 'postMessage',
	   )
	);

	$wp_customize->add_control(
		'email_addresses',
		array(
			'label'         => __( 'Adresses emails', 'rsdn' ),
			'description'   => __( 'Indiquer les adresses emails de contact du site séparées par des virgules', 'rsdn'),
			'section'       => 'contact',
			'settings'      => 'email_addresses',
	   )
	);

	/**
	 * Phone
	 */
	$wp_customize->add_setting(
		   'phone',
		   array(
		   'type'      => 'option',
		   'transport' => 'postMessage',
	   )
	);

	$wp_customize->add_control(
	   'phone',
	   array(
		   'label'         => __( 'Numéro de téléphone', 'rsdn' ),
		   'description'   => __( 'Indiquer le numéro de téléphone', 'rsdn'),
		   'section'       => 'contact',
		   'settings'      => 'phone',
	   )
	);

	/**
	 * Facebook
	 */
	$wp_customize->add_setting(
		'facebook',
		array(
			'type'      => 'option',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'facebook',
		array(
			'label'     	=> __( 'Facebook', 'rsdn' ),
			'description'	=> __( 'Indiquer l\'URL du compte Facebook', 'rsdn'),
			'section'   	=> 'contact',
			'settings'  	=> 'facebook',
		)
	);

	/**
	 * Twitter
	 */
	$wp_customize->add_setting(
		'twitter',
		array(
			'type'      => 'option',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'twitter',
		array(
			'label'     	=> __( 'Twitter', 'rsdn' ),
			'description'	=> __( 'Indiquer l\'URL du compte Twitter', 'rsdn'),
			'section'   	=> 'contact',
			'settings'  	=> 'twitter',
		)
	);

	/**
	 * Instagram
	 */
	$wp_customize->add_setting(
		'instagram',
		array(
			'type'      => 'option',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'instagram',
		array(
			'label'       => __( 'Instagram', 'rsdn' ),
			'description' => __( 'Indiquer l\'URL du compte Instagram', 'rsdn'),
			'section'     => 'contact',
			'settings'    => 'instagram',
		)
	);

	/**
	 * Pinterest
	 */
	$wp_customize->add_setting(
		'pinterest',
		array(
			'type'      => 'option',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'pinterest',
		array(
			'label'       => __( 'Pinterest', 'rsdn' ),
			'description' => __( 'Indiquer l\'URL du compte Pinterest', 'rsdn'),
			'section'     => 'contact',
			'settings'    => 'pinterest',
		)
	);

	/**
	 * YouTube
	 */
	$wp_customize->add_setting(
		'youtube',
		array(
			'type'      => 'option',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'youtube',
		array(
			'label'       => __( 'YouTube', 'rsdn' ),
			'description' => __( 'Indiquer l\'URL du compte YouTube', 'rsdn' ),
			'section'     => 'contact',
			'settings'    => 'youtube',
		)
	);
}
