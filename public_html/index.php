<?php 

// Parse the list of modules from the docs folder
require_once("../Spyc.php");
$md = file_get_contents('../multiqc/docs/README.md');
$md_parts = explode('---', $md, 3);
$modules = [];
if(count($md_parts) == 3){
  $pages = spyc_load($md_parts[1]);
  if(isset($pages['MultiQC Modules'])){
    foreach($pages['MultiQC Modules'] as $sect_name => $sect){
      foreach($sect as $fn){
        $mod_md = file_get_contents('../multiqc/docs/'.trim($fn));
        $mod_md_parts = explode('---', $mod_md, 3);
        if(count($mod_md_parts) == 3){
          $yaml = spyc_load($mod_md_parts[1]);
          $yaml['docs_url'] = 'docs/#'.strtolower(str_replace(' ', '-', $yaml['Name']));
          $yaml['section'] = $sect_name;
          $modules[] = $yaml;
        }
      }
    }
  }
}


?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>MultiQC</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="images/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="fonts/font-mfizz.css">
    <link rel="stylesheet" href="css/styles.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body id="mqc_homepage">

    <div class="header">
      
      <!-- Static navbar -->
      <nav class="navbar navbar-default navbar-inverse navbar-static-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand visible-xs" href="#">MultiQC</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
              <p class="navbar-text hidden-xs hidden-sm"><a href="https://github.com/ewels/MultiQC/releases" class="navbar-link">Current version: v0.5</a></p>
              <li class="active"><a href="#">Home</a></li>
              <li><a href="docs/">Docs</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Example Reports <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li class="dropdown-header">Analysis Types</li>
                  <li><a href="#">Whole Genome</a></li>
                  <li><a href="examples/rna-seq/multiqc_report.html">RNA-Seq</a></li>
                  <li><a href="examples/bs-seq/multiqc_report.html">Bisulfite</a></li>
                  <li class="dropdown-header">Report Variants</li>
                  <li><a href="#">Many Samples</a></li>
                  <li><a href="#">Directory Names</a></li>
                </ul>
              </li>
              <li><a href="https://www.github.com/ewels/MultiQC">GitHub</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </nav>
      
      <div class="container">
        <div class="row">
          <div class="col-md-8">
            <h1>
              <object type="image/svg+xml" title="MultiQC" data="images/MultiQC_logo.svg">
						    <img src="images/MultiQC_logo.png">
					    </object>
            </h1>
            <p class="lead">Aggregate results from bioinformatics analyses across many samples into a single report</p>
            <p>MultiQC searches a given directory for analysis logs and compiles a HTML report.
              It's a general use tool, perfect for summarising the output from numerous bioinformatics tools.</p>
            
            <div class="row videos-row">
              <div class="col-md-6">
                <div class="embed-responsive embed-responsive-16by9 homepage-header-video">
                  <iframe id="multiqc-introduction" class="embed-responsive-item" src="https://www.youtube.com/embed/BbScv9TcaMg?rel=0&amp;showinfo=0" allowfullscreen></iframe>
                  <iframe id="multiqc-installation" style="display: none;" class="embed-responsive-item" src="https://www.youtube.com/embed/BbScv9TcaMg?rel=0&amp;showinfo=0" allowfullscreen></iframe>
                </div>
              </div>
              <div class="col-md-6">
                <ul class="homepage-video-chooser">
                  <li><a href="#multiqc-introduction" class="active">Introduction to MultiQC <em>(1:19)</em></a></li>
                  <li><a href="#multiqc-installation">Installing MultiQC <em>(1:19)</em></a></li>
                  <li><a href="#multiqc-installation">Using MultiQC <em>(1:19)</em></a></li>
                  <li><a href="#multiqc-installation">MultiQC Reports <em>(1:19)</em></a></li>
                </ul>
              </div>
            </div>
            
          </div>
          <div class="col-md-4" id="header-buttons">
            <a class="btn btn-block btn-lg btn-primary" href="https://www.github.com/ewels/MultiQC">
              <i class="fa fa-github fa-lg"></i> GitHub
            </a>
            <a class="btn btn-block btn-lg btn-primary" href="https://pypi.python.org/pypi/multiqc">
              <i class="icon-python fa-lg"></i>  Python Package Index
            </a>
            <a class="btn btn-block btn-lg btn-primary" href="docs">
              <i class="fa fa-book fa-lg"></i> Documentation
            </a>
            <button type="button" class="btn btn-block btn-lg btn-primary" data-toggle="modal" data-target="#mqc-supported-tools-modal">
              <i class="fa fa-bar-chart"></i> <?php echo count($modules); ?> supported tools
            </button>
            <a class="visible-xs visible-sm btn btn-block btn-lg btn-primary" href="examples/rna-seq/multiqc_report.html">
              <i class="glyphicon glyphicon-search"></i> Example Report
            </a>
            <div class="panel panel-primary" id="quick_install">
              <div class="panel-heading">
                <i class="fa fa-terminal"></i> Quick Install <br>
              </div>
              <div class="panel-body">
                <pre id="pip"><code >pip install multiqc    <span class="comment"># Install</span>
multiqc .              <span class="comment"># Run</span></code></pre>
<pre id="conda" style="display:none;"><code>conda install -c bioconda multiqc
multiqc .</code></pre>
<pre id="manual" style="display:none;"><code>git clone https://github.com/ewels/MultiQC.git
python setup.py install
multiqc .</code></pre>
                <div class="btn-group btn-group-justified btn-group-xs install-switcher" role="group">
                  <a href="#pip" class="btn active">pip</a>
                  <a href="#conda" class="btn">conda</a>
                  <a href="#manual" class="btn">manual</a>
                </div>
              </div>
            </div>
            <p class="sub-panel">Need a little more help? <a href="docs">See the full installation instructions</a>.</small></p>
            
          </div>
        </div>
        
      </div> <!-- end of header -->
    </div>
    
    <!-- Demo Reports -->
    <div class="container">
      
      <div id="iframe_browser" class="hidden-xs hidden-sm">
        <div id="iframe_browser_header">
          <div id="iframe_browser_buttons"><span></span><span></span><span></span></div>
          <span id="iframe_browser_title">MultiQC Example Reports</span>
          <ul id="iframe_browser_tabs">
            <li><a href="examples/hi-c/multiqc_report.html">Hi-C</a></li>
            <li><a href="examples/bs-seq/multiqc_report.html">Bisulfite Seq</a></li>
            <li><a href="examples/wgs/multiqc_report.html">Whole-Genome Seq</a></li>
            <li class="active"><a href="examples/rna-seq/multiqc_report.html">RNA-Seq</a></li>
          </ul>
        </div>
        <iframe src="examples/rna-seq/multiqc_report.html"></iframe>
      </div>
      
    </div>
    
    <div class="container"><div class="content_block">
      <p class="content-lead">Ever spent ages collecting reports and wading through log file output?<br>
          Here's the answer to your frustrations...</p>

			<section>
				<div class="row">
          <div class="col-md-8">
            <h3>Visualise statistics from your pipeline</h3>
				    <p>MultiQC collects numerical stats from each module at the top the report, so that you can track how your data behaves as it proceeds through your analysis.</p>
            <a class="btn btn-lg btn-default">View Example Report</a>
          </div>
          <div class="col-md-4 text-center">
            <img class="img-circle img-thumbnail" src="images/general_stats.png" alt="General Statistics" />
          </div>
        </div>
      </section>
        
			<section>
				<div class="row">
          <div class="col-md-8">
            <h3>Plot all of your samples together</h3>
				    <p>Visualizing your samples together allows detailed comparison, not possible by scanning one report after another.</p>
            <div class="btn-group">
              <button type="button" class="btn btn-lg btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Example Reports <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                <li class="dropdown-header">Analysis Types</li>
                <li><a href="#">Whole Genome</a></li>
                <li><a href="examples/rna-seq/multiqc_report.html">RNA-Seq</a></li>
                <li><a href="examples/bs-seq/multiqc_report.html">Bisulfite</a></li>
                <li class="dropdown-header">Report Variants</li>
                <li><a href="#">Many Samples</a></li>
                <li><a href="#">Directory Names</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-4 text-center">
            <img class="img-circle img-thumbnail" src="images/overlay_plot.png" alt="FastQC GC Overlay Plot" />
          </div>
        </div>
      </section>

			<section>
				<div class="row">
          <div class="col-md-8">
            <h3>Supports your favourite tools</h3>
				    <p>MultiQC comes supports many common bioinformatics tools out of the box. If you're missing something,
              just create an issue on GitHub to request it - if you have an example log file it's usually pretty fast.</p>
            <button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#mqc-supported-tools-modal">
              View available Modules
            </button>
          </div>
          <div class="col-md-4 text-center">
            <div class="img-circle img-thumbnail">
              <div class="tool-list">
                <ul class="list-inline">
                  <?php foreach($modules as $mod){
                    echo '<li>'.$mod['Name'].'</li>';
                  } ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>
      
      <section>
				<div class="row">
          <div class="col-md-8">
            <h3>Extensible and documented</h3>
				    <p>Want to use this to do something fancy? MultiQC is structured to allow easy extension and customisation
               with plugin hooks, a submodule framework and simple templating. Everything is well documented, with step
               by step instructions for writing your new tool.</p>
            <a class="btn btn-default btn-lg" href="docs">Read the docs</a>
          </div>
          <div class="col-md-4 text-center">
            <img class="img-circle img-thumbnail" src="images/documentation.png" alt="MultiQC Documentation" />
          </div>
        </div>
      </section>
      
      <section>
				<ul class="feature-icons">
					<li><span class="fa fa-lg fa-terminal"></span>Simple installation</li>
					<li><span class="fa fa-lg fa-search"></span>Search any directory</li>
					<li><span class="fa fa-lg fa-bar-chart"></span>View report in a web browser</li>
					<li><span class="fa fa-lg fa-share-alt"></span>Zip file for easy sharing</li>
					<li><span class="fa fa-lg fa-code"></span>Extensible &amp; well documented</li>
				</ul>
      </section>


    	<section class="focus-section">
  			<h2>Install from the <a href="https://pypi.python.org/pypi/multiqc">Python Package Index</a> or
        <a href="https://bioconda.github.io/">Bioconda</a></h2>
  			<p>To install MultiQC, simply run <code>pip install multiqc</code> on the command line.<br>
          If you use conda, you can run <code>conda install -c bioconda multiqc</code> instead.<br>
          See the <a href="docs/#installation">installation instructions</a> for more help.</p>
        <p>
          <a href="docs" class="btn btn-default btn-lg"><i class="fa fa-book fa-lg"></i> Documentation</a>
    			<a target="_blank" href="https://github.com/ewels/MultiQC/" class="btn btn-default btn-lg"><i class="fa fa-github"></i> View on GitHub</a>
    			<a target="_blank" href="https://pypi.python.org/pypi/multiqc" class="btn btn-default btn-lg"><i class="icon-python fa-lg"></i> View on PyPI</a>
        </p>
    	</section>
          
    </div></div> <!-- /content /container -->
    
    <footer id="footer">
      <div class="container">
        <p>Created by Phil Ewels:
          <a target="_blank" href="https://github.com/ewels"><i class="fa fa-github"></i> ewels</a> |
          <a target="_blank" href="https://twitter.com/tallphil"><i class="fa fa-twitter"></i> tallphil</a> |
          <a target="_blank" href="https://se.linkedin.com/in/philewels">LinkedIn</a> | 
          <a target="_blank" href="https://www.researchgate.net/profile/Philip_Ewels">ResearchGate</a>
        </p>
        <a target="_blank" href="http://www.scilifelab.se" class="scilife-footer">
          <img src="images/SLL_logo_blue_white.png">
        </a>
      </div>
    </footer>
    
    <!-- Supported tools modal -->
    <div class="modal fade" id="mqc-supported-tools-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">MultiQC: Supported Tools</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-info">
              MultiQC currently supports <?php echo count($modules); ?> bioinformatics tools, listed below.
              If you would like another to be added, please <a href="https://github.com/ewels/MultiQC/issues" class="alert-link">open an issue</a>.
            </div>
            <ul class="list-inline mod-list-list">
              <li class="mod-list pre-alignment">Pre-alignment tools</li>
              <li class="mod-list aligners">Alignment tools</li>
              <li class="mod-list post-alignment">Post-alignment tools</li>
            </ul>
            <p class="text-muted"><em><span class="fa fa-book"></span> &nbsp;Click the tool name to go to the MultiQC documentation for that tool.</em></p>
            <table class="table table-condensed">
              <tr>
                <th>Tool Name</th>
                <th>Description</th>
              </tr>
              <?php foreach($modules as $mod){
                echo '<tr><td class="mod-list '.strtolower($mod['section']).'"><a href="'.$mod['docs_url'].'">'.$mod['Name'].'</a></td><td><small>'.$mod['Description'].'</small></td></tr>';
              } ?>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>


    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/homepage.js"></script>
    
    <!-- Google Analytics -->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-68098153-1', 'auto');
      ga('send', 'pageview');

    </script>
  </body>
</html>
