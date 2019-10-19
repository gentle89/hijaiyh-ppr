<!doctype html>
<html lang="en">
<head>
    <title>Premium PHP Redirect - HijaIyh</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="<?=base_url();?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url();?>/assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?=base_url();?>/assets/css/bsadmin.css">
</head>
<body>

<nav class="navbar navbar-expand navbar-dark bg-danger">
    <a class="sidebar-toggle text-light mr-3"><i class="fa fa-bars"></i></a>

    <a class="navbar-brand" href="#"><i class="fa fa-link"></i> HijaIyh:PPR:3</a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item ">
                <a class="nav-link " href="<?=base_url('auth/destroy');?>" >
                    <i class="fa fa-log-out"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</nav>

<div class="d-flex">
    <nav class="sidebar bg-dark">
        <ul class="list-unstyled">
            <li><a href="<?=base_url('hijaiyh/panel.html');?>"><i class="fa fa-fw fa-home"></i> Dashboard</a></li>
            <li><a href="<?=base_url('hijaiyh/shortlink/all.html');?>"><i class="fa fa-fw fa-list"></i> All shortlink</a></li>
            <li><a href="<?=base_url('hijaiyh/shortlink/new.html');?>"><i class="fa fa-fw fa-link"></i> New Shortlink</a></li>
            <li><a href="<?=base_url('feature/index.html');?>"><i class="fa fa-fw fa-fire"></i>Features</a></li>
            <li><a href="<?=base_url('hijaiyh/blockers');?>"><i class="fa fa-fw fa-bug"></i> Blockers</a></li>
            <li><a href="<?=base_url('hijaiyh/profile.html');?>"><i class="fa fa-fw fa-users"></i> Users</a></li>
            
    </nav>