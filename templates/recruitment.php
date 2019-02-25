<?php
/**
 * Template Name: Recrutement
 *
 * @package ResidencesChoisille
 */

$context         = Timber::get_context();
$context['post'] = new TimberPost();

$templates = array( 'pages/recruitment.html.twig' );

Timber::render( $templates, $context );
