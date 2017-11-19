<?php

/**
 * Template Name: Mentions légales
 */
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

$templates = array( 'pages/legal-mentions.twig' );

Timber::render( $templates, $context );