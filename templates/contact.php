<?php
/**
 * Template Name: Contact
 *
 * @package ResidencesChoisille
 */

$context         = Timber::get_context();
$context['post'] = new TimberPost();

$templates = array( 'pages/contact.html.twig' );

Timber::render( $templates, $context );
