<style type="text/css">
      .ana-cont{
            background-color: #fff;
            border-radius: 5px;
            border:1px solid #ccc;
            padding: 25px;
      }
      .Chartjs{
            background-color: #fff;
            border-radius: 10px;
            margin-bottom: 30px;
      }
      .Chartjs h3{
            font-size: 17px;
            margin-top: 0;
            text-transform: uppercase;
      }
      .Chartjs h3>small{display: block; color:#aaa; text-transform: uppercase;}
      .ActiveUsers{display: inline-block;color: #888;font-weight: normal;}
      .ViewSelector2{
            display: table;
            width: 100%;
            table-layout: fixed;
      }
      .ViewSelector2-item{
            display: table-cell;
            width: 33.33% !important;
            padding: 5px;
      }
      .ViewSelector2-item>label{
            display: block;
            font-size: 15px;
      }
      .ViewSelector2-item>.FormField{
            width: 100%;
            padding: 5px;
            border-radius: 3px;
            border-color: #ccc;
            outline: none;
      }
      #view-name{
            font-size: 20px;
      }
      #embed-api-auth-container{color: #888}
</style>
<script>
(function(w,d,s,g,js,fs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
  js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
}(window,document,'script'));
var ACCESS_TOKEN_FROM_SERVICE_ACCOUNT = '<?=$access_token?>';
</script>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Google Analytic
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Google Analytic</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">


      <div class="ana-cont">
        <header>
          <div id="embed-api-auth-container"></div>
          <div class="row">
            <div class="col-xs-6">
              <div id="view-name"></div>
            </div>
            <div class="col-xs-6 text-right">
              <div id="active-users-container"></div>
            </div>
            <div class="col-xs-12 hidden">
              <div id="view-selector-container"></div>
            </div>
          </div>
        </header>
        <hr>
        <div class="row">
          <div class="col-sm-6">
            <div class="Chartjs">
              <h3>This Week vs Last Week <small>by sessions</small></h3>
              <figure class="Chartjs-figure" id="chart-1-container"></figure>
              <ol class="Chartjs-legend" id="legend-1-container"></ol>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="Chartjs">
              <h3>This Month vs Last Month <small>by sessions</small></h3>
              <figure class="Chartjs-figure" id="chart-2-container"></figure>
              <ol class="Chartjs-legend" id="legend-2-container"></ol>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="Chartjs">
              <h3>Top Operating System <small>by users<small></h3>
              <figure class="Chartjs-figure" id="chart-3-container"></figure>
              <ol class="Chartjs-legend" id="legend-3-container"></ol>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="Chartjs">
              <h3>Top Cities <small>by users</small></h3>
              <figure class="Chartjs-figure" id="chart-4-container"></figure>
              <ol class="Chartjs-legend" id="legend-4-container"></ol>
            </div>
          </div>
        </div>
        </small>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<!-- This demo uses the Chart.js graphing library and Moment.js to do date
     formatting and manipulation. -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <!-- Include the ViewSelector2 component script. -->
    <script src="<?=base_url()?>plugins/ga-dev/build/javascript/embed-api/components/view-selector2.js"></script>
    <!-- Include the DateRangeSelector component script. -->
    <script src="<?=base_url()?>plugins/ga-dev/build/javascript/embed-api/components/date-range-selector.js"></script>
    <!-- Include the ActiveUsers component script. -->
    <script src="<?=base_url()?>plugins/ga-dev/build/javascript/embed-api/components/active-users.js"></script>
    <!-- Include the CSS that styles the charts. -->
    <link rel="stylesheet" href="<?=base_url()?>plugins/ga-dev/src/css/chartjs-visualizations.css">
    <script type="text/javascript" src="<?=base_url()?>js/analytics.js"></script>