<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title;?> </title>
    <link href="<?php echo base_url();?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>css/admin.css" rel="stylesheet">
    <link ref="stylesheet" href="<?php echo base_url();?>font-awesome/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js" integrity="sha256-F6h55Qw6sweK+t7SiOJX+2bpSAa3b/fnlrVCJvmEj1A=" crossorigin="anonymous"></script>
</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url();?>">PHP CodeIgniter Sample</a>
            </div>
            <div class="navbar-collapse collapse">
                
                    <ul class="nav navbar-nav">
                        <?php if (isset($_SESSION["userid"])) {?>
                            <li><a href="<?php echo base_url();?>products">Products</a></li>
                            <li><a href="<?php echo base_url();?>account/change_pass">Change password</a></li>
                            <li><a href="<?php echo base_url();?>account/list">Administrators</a></li>
                        <?php } else { ?>
                            <li><a href="<?php echo base_url();?>account/register">Register</a></li>
                        <?php } ?>
                    </ul>
            <ul class="nav navbar-nav navbar-right">
        <li>
            <?php if (isset($_SESSION["userid"])) {?><a href="<?php echo base_url();?>account/logout">Logout</a>
            <?php } else { ?> <a href="<?php echo base_url();?>account/login">Login</a> <?php } ?>
        </li>
        </ul>
 
            </div>
        </div>
    </div>
    <div class="container body-content">