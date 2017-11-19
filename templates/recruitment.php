<?php

/**
 * Template Name: Recrutement
 */
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

$templates = array( 'pages/recruitment.twig' );

Timber::render( $templates, $context );