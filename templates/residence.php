<?php
/**
 * Template Name: Résidence
 *
 * @package ResidencesChoisille
 */

$context         = Timber::get_context();
$context['post'] = new TimberPost();

$templates = array( 'pages/residence.html.twig' );

Timber::render( $templates, $context );
