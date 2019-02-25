<?php
/**
 * Template Name: Mentions légales
 *
 * @package Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */

$context         = Timber::get_context();
$context['post'] = new TimberPost();

$templates = array( 'pages/legal-mentions.html.twig' );

Timber::render( $templates, $context );
