<?php

/**
 * Template Name: Résidence
 */
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

$templates = array( 'pages/residence.twig' );

Timber::render( $templates, $context );