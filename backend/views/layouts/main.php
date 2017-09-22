<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\DashboardAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;

DashboardAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style type="text/css">
        .treeview.menu-open>a{
                border-left-color: #3c8dbc !important;
        }
    </style>
      <link rel="icon" href="favicon.ico" type="image/ico">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<?php $this->beginBody() ?>

<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo Yii::$app->homeUrl;?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>SLL</b>C</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>SLL </b>Coffee</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?= Yii::$app->user->identity->name; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->

              <li class="user-header">
                <img src="<?php echo Yii::$app->request->baseUrl. '/dist/img/user2-160x160.jpg' ?>" class="img-circle" alt="User Image">

                <p>
                  <?= ucfirst(Yii::$app->user->identity->name); ?> - <?= ucfirst(Yii::$app->user->identity->name); ?>
                  <small>Member since Nov. 2017</small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <!-- <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div> -->
                <div class="pull-right btn btn-default btn-flat">
                  <?= Html::a('Logout', ['site/logout'], ['data' => ['method' => 'post']]) ?>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <div class="col-md-1"></div>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo Yii::$app->request->baseUrl. '/dist/img/user2-160x160.jpg' ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?= Yii::$app->user->identity->name; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->

      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-download"></i> <span>Import</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="<?php echo Url::to(['invoice/index']);?>"><i class="fa fa-circle-o"></i> Invoice</a></li>
            <li><a href="<?php echo Url::to(['expenses/index']);?>"><i class="fa fa-circle-o"></i> Expenses</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i>
            <span>User</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo Url::to(['user-role/index']);?>"><i class="fa fa-circle-o"></i> User Role</a></li>
            <li><a href="<?php echo Url::to(['user/index']);?>"><i class="fa fa-circle-o"></i> User</a></li>
            <li><a href="<?php echo Url::to(['permission/index']);?>"><i class="fa fa-circle-o"></i> Permission</a></li>
          </ul>
        </li>
        <!-- <li>
          <a href="pages/widgets.html">
            <i class="fa fa-th"></i> <span>Widgets</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span>
          </a>
        </li> -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i>
            <span>Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i>Log
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo Url::to(['log-user/index']);?>"><i class="fa fa-circle-o"></i>log User</a></li>
                <li><a href="<?php echo Url::to(['log-event/index']);?>"><i class="fa fa-circle-o"></i>log Event</a></li>
              </ul>
            </li>
            <li><a href="<?php echo Url::to(['invoice-quantity/index']);?>"><i class="fa fa-circle-o"></i> Customer Quantity</a></li>
            <li><a href="<?php echo Url::to(['invoice-performance/index']);?>"><i class="fa fa-circle-o"></i> Customer Performance</a></li>
            <li><a href="<?php echo Url::to(['customer/index']);?>"><i class="fa fa-circle-o"></i> Customer</a></li>
            <li><a href="<?php echo Url::to(['boiler/index']);?>"><i class="fa fa-circle-o"></i> Boiler</a></li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

        <section class="content">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
          <?= $content ?>
        </section>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">

  </footer>

  <div class="control-sidebar-bg"></div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<script type="text/javascript">
    /*$(function(){
        $('.treeview').click(function(){
        $('.treeview.active').removeClass('active');
        $(this).addClass('active');
        });
    });*/
</script>
