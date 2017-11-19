<?php

add_action( 'customize_register', 'frmtcn_customize_contact' );

/**
 * Contact
 * 
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function frmtcn_customize_contact( $wp_customize ) {
	
	/**
	 * Add contact section
	 */
	$wp_customize->add_section( 
		'contact', 
		array(
			'title' 		=> __( 'Coordonnées', 'frmtcn' ),
			'description'	=> __( 'Réglages des coordonnées', 'frmtcn' ),
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
			'label'     	=> __( 'Adresse', 'frmtcn' ),
			'description'	=> __( 'Indiquer l\'adresse postale', 'frmtcn'),
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
			'label'         => __( 'Adresses emails', 'frmtcn' ),
			'description'   => __( 'Indiquer les adresses emails de contact du site séparées par des virgules', 'frmtcn'),
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
		   'label'         => __( 'Numéro de téléphone', 'frmtcn' ),
		   'description'   => __( 'Indiquer le numéro de téléphone', 'frmtcn'),
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
			'label'     	=> __( 'Facebook', 'frmtcn' ),
			'description'	=> __( 'Indiquer l\'URL du compte Facebook', 'frmtcn'),
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
			'label'     	=> __( 'Twitter', 'frmtcn' ),
			'description'	=> __( 'Indiquer l\'URL du compte Twitter', 'frmtcn'),
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
			'label'         => __( 'Instagram', 'frmtcn' ),
			'description'   => __( 'Indiquer l\'URL du compte Instagram', 'frmtcn'),
			'section'       => 'contact',
			'settings'      => 'instagram',
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
			'label'         => __( 'Pinterest', 'frmtcn' ),
			'description'   => __( 'Indiquer l\'URL du compte Pinterest', 'frmtcn'),
			'section'       => 'contact',
			'settings'      => 'pinterest',
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
			'label'         => __( 'YouTube', 'frmtcn' ),
			'description'   => __( 'Indiquer l\'URL du compte YouTube', 'frmtcn'),
			'section'       => 'contact',
			'settings'      => 'youtube',
		) 
	);
}
