<?php

/**
 * Template Name: Contact
 */
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

$templates = array( 'pages/contact.twig' );

Timber::render( $templates, $context );