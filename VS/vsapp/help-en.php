<?php
$vsapp = new SimpleXMLElement( file_get_contents('../vsapp.xml') );
$lang  = 'en';
$menu  = array(
  'home'       => '<em>' . $vsapp['name'] . '</em> Documentation',
  'versionlog' => 'Version history',
  'screenshot' => 'Screenshots',
);
$screenshots = array();


?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>Aide</title>
  <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
  <style>.tab-pane { padding:5px;} .doc{margin-top:5px;}</style>
</head>
<body>
  <div class="doc">

    <ul id="myTab" class="nav nav-tabs"><?php
      $c = 'active';
      foreach ($menu as $id => $title) {
        echo '<li class="' . $c . '"><a href="#' . $id . '" data-toggle="tab">' . $title . '</a></li>';
        $c = '';
      }
    ?></ul>

    <div class="tab-content">

      <div class="tab-pane fade in active" id="home">
        <div class="row-fluid">
          <div class="span8"><?php
          foreach ( $vsapp->description as $description) {
            $l = (isset($description->{$lang})) ? $lang : 'en';
            echo str_replace( array('<![CDATA[',']]>') , '' , $description->{$l}->asXML() );
          }
          ?></div>
          <div class="span4" style="border-left:1px solid #ccc;padding:5px;"><?php
          echo (isset($vsapp['name']))  ? '<b>Name </b>: ' . $vsapp['name'] . '<br/>' : '';
          echo (isset($vsapp['version'])) ? '<b>Version </b>: ' . $vsapp['version'] . '<br/>' : '';
          echo (isset($vsapp['author'])) ? '<b>Author </b>: ' . $vsapp['author'] . '<br/>' : '';
          echo (isset($vsapp['url'])) ? '<b>URL </b>: <a href="' . $vsapp['url'] . '">' . $vsapp['url'] . '</a><br/>' : '';
          echo (isset($vsapp->compatibility['min-vsos-version'])) ? '<b>Require VSOS </b>: ' . $vsapp->compatibility['min-vsos-version'] . '<br/>' : '';
          ?></div>
        </div>
      </div>

      <div class="tab-pane fade" id="versionlog">
        <ul><?php
        foreach ( $vsapp->versions->version as $version ) {
          $l = (isset($version->{$lang})) ? $lang : 'en';
          echo '<li><h4>version ' . $version['name'] . '</h4>' . str_replace( array('<![CDATA[',']]>') , '' , $version->{$l}->asXML() ) . '</li>';
        }
        ?></ul>
      </div>

      <div class="tab-pane fade" id="screenshot">
        <div id="myCarousel" class="carousel slide">
          <div class="carousel-inner"><?php
            $c = 'active';
            $s = count($screenshots);
            foreach ($screenshots as $id => $title) {
              echo '<div class="item ' . $c . '">
                <img src="screenshot_' . $id . '.png" alt="">
                <div class="carousel-caption">
                 <h4>Screenshot #' . $id . '/' .$s . '</h4>
                 <p>' . $title . '</p>
                </div>
              </div>';
              $c = '';
            }
          ?></div>
          <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
          <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
        </div>
      </div>

    </div>
  </div>

  <script src="js/jquery-1.9.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>