<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  
  <title><?php wp_title('|', true, 'right'); ?></title>
  
  <meta name="description" content="<?php the_field('seo_desc'); ?>">
  <meta name="keywords" content="<?php the_field('seo_keywords'); ?>">

  <meta property="og:url" content="<?php echo get_permalink(); ?>">
  <meta property="og:title" content="<?php echo get_bloginfo('name').' | '.get_bloginfo('description').' - '.get_the_title(); ?>">
  <meta property="og:image" content="/assets/img/share.png">
  <meta property="og:image:type" content="image/png">
  <meta property="og:image:width" content="400">
  <meta property="og:image:height" content="400">

  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  
  <link href="/assets/css/vendor/bootstrap.min.css" rel="stylesheet">
  <?php wp_head(); ?>

  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
  <![endif]-->
  
  <link href="http://fonts.googleapis.com/css?family=Raleway:300,600" rel="stylesheet" type="text/css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
</head>