<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

<title><?php echo $title; ?></title>

<style type='text/css'>
<?php $this->file(BASEPATH.'scaffolding/views/stylesheet.css'); ?>
</style>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv='expires' content='-1' />
<meta http-equiv= 'pragma' content='no-cache' />
<meta http-equiv="CACHE-CONTROL" content="NO-CACHE" />
<meta http-equiv="EXPIRES" content="Mon, 26 Jul 1997 05:00:00 GMT" />
<meta http-equiv="PRAGMA" content="NO-CACHE" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="robots" content="noindex,nofollow" />


</head>
<body>

<div id="header">
<div id="header_left">
<h3>Scaffolding:&nbsp; <?php echo $title; ?></h3>
</div>
<div id="header_right">
<?php echo anchor(array($base_uri, 'view'), $scaff_view_records); ?> &nbsp;&nbsp;|&nbsp;&nbsp;
<?php echo anchor(array($base_uri, 'add'),  $scaff_create_record); ?>
</div>
</div>

<br clear="all">
<div id="outer">