<?php

/**
 * Template Name: Home
 */
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

$templates = array( 'pages/home.twig' );

Timber::render( $templates, $context );