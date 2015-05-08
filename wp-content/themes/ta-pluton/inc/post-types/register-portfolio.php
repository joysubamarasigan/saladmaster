<?php

$portfolio = new CPT( array(
    'post_type_name' => 'portfolio',
    'singular'       => __('Portfolio', 'ta-pluton'),
    'plural'         => __('Portfolios', 'ta-pluton'),
    'slug'           => 'portfolio'
),
	array(
    'supports'  => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'comments' ),
    'menu_icon' => 'dashicons-portfolio'
));

$portfolio -> register_taxonomy( array(
    'taxonomy_name' => 'portfolio_tags',
    'singular'      => __('Portfolio Tag', 'ta-pluton'),
    'plural'        => __('Portfolio Tags', 'ta-pluton'),
    'slug'          => 'portfolio-tag'
));