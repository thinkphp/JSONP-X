<?php

        $root = 'http://query.yahooapis.com/v1/public/yql?q=';

        $yql = "use 'http://thinkphp.ro/apps/YQL/getFlickrBy%20YQLExecute/flickrlist.xml' as flickr; select * from flickr where text='beach' and location='maldive' and amount=20";

        $url = $root . urlencode($yql) .'&format=xml&diagnostics=false';

        $phpflickr = get($url);

        function get($url) {

             $ch = curl_init();

             curl_setopt($ch,CURLOPT_URL,$url);

             curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2);

             curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

             $data = curl_exec($ch);

             curl_close($ch);

             $data = preg_replace('/<\?.*\?>/','',$data);

             $data = preg_replace('/<\!--.*-->/','',$data);

             $data = preg_replace('/.*<ul>/','<ul>',$data);

             $data = preg_replace('/<\/ul>.*/','</ul>',$data);

             $data = preg_replace('//','',$data);

             return $data;
        }
      
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <title>Displaying Flickr photos by location or search term using YQL Execute Open Tables</title>
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
   <style type="text/css">
    body,html{background:#111;color:#000;}
    h1{font-size:200%;margin:0;padding:.3em;color: #32B08F;font-weight: bold}
    #bd{background:#fff url(feedburner.png) no-repeat center;border:1em solid #fff;height: auto}
    ul{width: 400px;}
    li{display: inline;}
    #ft{text-align: left;padding:1em 0;color: #32B08F;}
   </style>
   <script type="text/javascript">
   </script>
</head>
<body>
<div id="doc" class="yui-t7">

   <div id="hd" role="banner"><h1>Displaying Flickr Photos by location or search term using YQL Execute Open Table</h1></div>

   <div id="bd" role="main">

	<div class="yui-g">

            <h1>Javascript - JSON-P-X - XML with callback (XML output)</h1>
            <div id="jsflickr"></div>

<p>
<pre>YQL:

use 'http://thinkphp.ro/apps/YQL/getFlickrBy%20YQLExecute/flickrlist.xml' as flickr; 

SELECT * 

FROM flickr 

WHERE text='beach' AND location='maldive' AND amount=20
</pre></p>


            <h1>PHP</h1>
            <div id="phpflickr">
                   <?php echo$phpflickr; ?>
            </div>


            <h1>Javascript - JSON-P - JSON with callback (JSON output)</h1>
            <ul id="getjsflickr"></ul>

<p>
<pre>YQL:

SELECT farm,id,secret,owner.realname,server,title,urls.url.content 

FROM flickr.photos.info 

WHERE photo_id in 

(SELECT id 

FROM flickr.photos.search(20) 

WHERE text='beach' and license=4 and woe_id in

(SELECT woeid 

 FROM geo.places 

 WHERE text='maldive'))

</pre></p>

	</div>
   </div>

  <div id="ft" role="contentinfo"><p>Written By Adrian Statescu</p></div>

</div>

<script type="text/javascript">
        
    var flickrshow = function() {

        var target = document.getElementById('jsflickr'); 

        function init() {

        target.innerHTML = 'Loading...';    

        var root = 'http://query.yahooapis.com/v1/public/yql?q=';

        var yql = "use 'http://thinkphp.ro/apps/YQL/getFlickrBy%20YQLExecute/flickrlist.xml' as flickr; select * from flickr where text='beach' and location='maldive' and amount=20";

        var q = root + encodeURIComponent(yql) + '&format=xml&callback=flickrshow.seed';

            loadScript(q);

        };

        var loadScript = function(src) {

            var script = document.createElement('script');

                script.setAttribute('type','text/javascript');

                script.setAttribute('src',src);                

                document.getElementsByTagName('head')[0].appendChild(script);
        }

        function seed(o) {

           target.innerHTML = o.results;                 
        }

        return {init:init,seed:seed};  

    }();//doExec

    flickrshow.init(); 
        

    var flickrlist = function() {

        var target = document.getElementById('getjsflickr'); 

        function init() {

        target.innerHTML = 'Loading...';    

        var root = 'http://query.yahooapis.com/v1/public/yql?q=';

        var yql = "select farm,id,secret,owner.realname,server,title,urls.url.content from flickr.photos.info where photo_id in (select id from flickr.photos.search(20) where text='beach' and license=4 and woe_id in(select woeid from geo.places where text='maldive'))";

        var q = root + encodeURIComponent(yql) + '&format=json&callback=flickrlist.seed';

            loadScript(q);

        };

        var loadScript = function(src) {

            var script = document.createElement('script');

                script.setAttribute('type','text/javascript');

                script.setAttribute('src',src);                

                document.getElementsByTagName('head')[0].appendChild(script);
        }

        function seed(o) {

                var photos = o.query.results.photo;

                var out = '';

                for(var i=0;i<photos.length;i++) {

                    var curr = photos[i];

                    var src = 'http://farm' + curr.farm + '.static.flickr.com/' + curr.server + '/' + curr.id + '_' + curr.secret + '_s.jpg';

                    out +='<li><a href="'+curr.urls.url+'"><img src="'+src+'" alt="'+curr.title+'"></a></li>';
                }

             target.innerHTML = out;
        }

        return {init:init,seed:seed};  

    }();//doExec

    flickrlist.init(); 


</script>
</body>
</html>
