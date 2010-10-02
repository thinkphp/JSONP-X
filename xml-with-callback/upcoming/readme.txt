Another interesting YQL feature: XML with callback (JSON-P-X)

YQL
---
1) Get following list from Twitter.com
select * 
from html 
where url="http://twitter.com/thinkphp" 
and xpath = "//div[@id='following_list']"

2) Get talks conferences from christian heilmann
select * 
from html 
where url="http://www.wait-till-i.com/talks-and-conference-participation/" 
and xpath="//ul" limit 1

3) Get recent posts from yahoo developer network
select * from html where url="http://developer.yahoo.net/blog/archives/2009/07/fun_with_placemaker.html"
and xpath="//div[@id=\'widgets-recent-posts-3\']" limit 1

4) Get recent link from ydn
select * from html where url="http://developer.yahoo.net/blog/archives/2009/07/fun_with_placemaker.html" 
and xpath="//div[@id=\'widgets-delicious-widget-4\']" limit 1

5)Get upcoming conferences from ydn.com
select * from html where url="http://developer.yahoo.net/blog/archives/2009/07/fun_with_placemaker.html" 
and xpath="//div[@id=\'widgets-upcoming-widget-4\']" limit 1

6) Get recent post from yui blog
select * from html where url="http://yuiblog.com/" 
and xpath="//div[@id=\'recent_posts\']" limit 1