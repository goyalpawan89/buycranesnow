<!DOCTYPE html>
<html>
<head>
<?= $this->Html->charset() ?>
  <?php if($this->request->params['controller'] =='Posts' && $this->request->params['action'] == 'index')  { $scale = 3; } else { $scale = 1; } ?>

    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=<?= $scale; ?>' /> 

    <meta property="fb:app_id" content="498389210308893" />
    
    <?php if($this->request->params['controller'] == 'Posts' && $this->request->params['action'] == 'index') { 
             $description = $this->Get->get_excerpt($content->id, 125); $title = $content->name; $image = $this->Image->url($content->archive_id, 'full'); $url = $this->Get->get_url(); 
          } else { 
            $description = $blogDescription; $title = $blogName; $image = $this->Url->build('/', true).$logo; $url = $this->Url->build('/', true); 
          } ?>
    
    <meta name="description" content='<?= $description; ?>'>
    <meta property='og:url' content='<?= $url; ?>' />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="<?= $blogName; ?>" />  
    <meta property='og:title' content='<?= $title; ?>' />
    <meta property='og:description' content='<?= $description; ?>' />
    <meta property='og:image' content='<?= $image; ?>' />
    <meta name="google-site-verification" content="RmdEtesQjUJ-fsOee_mvF4nyJiY2TlXB8xV7kPXtU2Q" />

    <title><?= $blogName; ?> <?= $this->fetch('title') ?></title>
	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	 <?php
		echo $this->Html->meta('icon', $favicon);
		echo $this->Html->css('Front.crane/bootstrap.min');
		echo $this->Html->css('Front.crane/font-awesome');
		echo $this->Html->css('Front.crane/style');
		echo $this->Html->css('Front.crane/icomoon');
	?>
<?php //include_once( "includes/common-links-top.php"); ?>
</head>
<body>
<div class="page">
  <div id="wrapper">
  <!----------------1----------->
  
  <div class="content">
  <div class="container">
    <div class="row">
      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
        <div class="contacts">
          <ul>
            <li> <i class="fa fa-envelope"></i> inbox@crane-locator.com </li>
            <li> <i class="fa fa-phone"></i> +31 6 39 11 03 46 </li>
          </ul>
        </div>
      </div>
      <!--<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
          <div class="links">
            <ul>
              <li><a href="#">Register</a> | <a href="#">Login</a> </li>
            </ul>
          </div>
        </div>-->
    </div>
  </div>
</div>
<!------------2-------------->
<div class="header">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <div class="logo"><?= $this->element('Front.logo');?></div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-9 col-xs-12">
        <nav class="navbar navbar-default">
          <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
          </div>
          <div class="collapse navbar-collapse js-navbar-collapse">
            <ul class="nav navbar-nav">
              <li class="dropdown mega-dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Buy</a> </li>
              <li class="dropdown mega-dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Rent </a> </li>
              <li class="dropdown mega-dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sell </a> </li>
              <li class="dropdown mega-dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Company Finder <span class="glyphicon glyphicon-chevron-down pull-right"></span></a>
                <ul class="dropdown-menu mega-dropdown-menu row sub-item ">
                  <li class="col-sm-6">
                    <ul>
                      <li class="dropdown-header">Scope Of Operation</li>
                      <li> <a href=""> > Africa</a> </li>
                      <li> <a href=""> > Asia </a> </li>
                      <li> <a href=""> > Central America </a> </li>
                      <li> <a href=""> > Eurasian Economic Union </a> </li>
                      <li> <a href=""> > Europe</a> </li>
                      <li> <a href=""> > Middle East </a> </li>
                      <li> <a href=""> > North America </a> </li>
                      <li> <a href=""> > Oceania </a> </li>
                      <li> <a href=""> > South America </a> </li>
                    </ul>
                  </li>
                  <li class="col-sm-6">
                    <ul>
                      <li class="dropdown-header">Equipment Owners</li>
                      <li> <a href=""> > Contractor</a> </li>
                      <li> <a href=""> > Lifting</a> </li>
                      <li> <a href=""> > Manufacture</a> </li>
                      <li> <a href=""> > Official dealer</a> </li>
                      <li> <a href=""> > Offshore</a> </li>
                      <li> <a href=""> > Pilot car</a> </li>
                      <li> <a href=""> > Port</a> </li>
                      <li> <a href=""> > Rigging</a> </li>
                      <li> <a href=""> > Trading</a> </li>
                      <li> <a href=""> > Transport</a> </li>
                    </ul>
                  </li>
                  <li class="col-sm-6">
                    <ul>
                      <li class="dropdown-header">Service Providers</li>
                      <li> <a href=""> > Africa</a> </li>
                      <li> <a href=""> > Asia </a> </li>
                      <li> <a href=""> > Central America </a> </li>
                      <li> <a href=""> > Eurasian Economic Union </a> </li>
                      <li> <a href=""> > Europe</a> </li>
                      <li> <a href=""> > Middle East </a> </li>
                      <li> <a href=""> > North America </a> </li>
                      <li> <a href=""> > Oceania </a> </li>
                      <li> <a href=""> > South America </a> </li>
                    </ul>
                  </li>
                  <li class="col-sm-6">
                    <ul>
                      <li class="dropdown-header">Service Providers</li>
                      <li> <a href=""> > Africa</a> </li>
                      <li> <a href=""> > Asia </a> </li>
                      <li> <a href=""> > Central America </a> </li>
                      <li> <a href=""> > Eurasian Economic Union </a> </li>
                      <li> <a href=""> > Europe</a> </li>
                      <li> <a href=""> > Middle East </a> </li>
                      <li> <a href=""> > North America </a> </li>
                      <li> <a href=""> > Oceania </a> </li>
                      <li> <a href=""> > South America </a> </li>
                    </ul>
                  </li>
                </ul>
              </li>
              <li class="dropdown mega-dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">More </a> </li>
            </ul>
          </div>
          <!-- /.nav-collapse -->
        </nav>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <div class="links1">
          <ul>
            <li><a href="#">Advertise</a> | 
              Sign in
              <div class="sign_popup text-center">Log in to save favorites get alerts, and sync devices.</br>
                </br>
                <center>
                  <button type="button" class="btn btn-primary">Sign In</button>
                </center>
                </br>
                <center>
                  No Account ? | <a href=""> Sign Up</a>
                </center>
                <hr>
                <center>
                  <button type="button" class="btn btn-primary">Agent Sign In</button>
                </center>
                </br>
                <center>
                  No Account ? | <a href=""> Agent Sign Up</a>
                </center>
              </div>
              | <a href="#">Join</a> </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

  
<?php //echo $this->element('hedaer'); ?>
<?php //include_once( "includes/header.php"); ?>
  <!---------------------REGISTRATION SECTION--------->
  <?= $this->Flash->render(); ?>
   <?= $this->fetch('content'); ?>
  <!---------------------------->
  <!--------------- footercode ------------->
  <div class="footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <!----------->
          <div class="col-lg-3">
            <div class="logo"><?= $this->element('Front.logo');?></div>
          </div>
          <div class="col-lg-6">
            <div class="copyright">
              <label> Copyright@2016. All Rights Reserved </label>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="operation">
              <ul>
                <li class="social"> <a title="Like us in Facebook" target="_blank" href="#"> <i class="fa fa-facebook"></i> </a> <a title="Follow us on Twitter" target="_blank" href="#"> <i class="fa fa-twitter"></i> </a> <a title="Plus us on Google+" target="_blank" href="#"> <i class="fa fa-google-plus"></i> </a> <a title="Look us on LinkedIn" target="_blank" href="#"> <i class="fa fa-linkedin"></i> </a> </li>
              </ul>
            </div>
          </div>
          <!--------------->
        </div>
      </div>
    </div>
  </div>

  <!---------------------------->
</div>
</div>
<?php
    echo $this->Html->script('crane/jquery-1.11.0'); 
	echo $this->Html->script('crane/bootstrap.min'); 
?>
</body>
</html>