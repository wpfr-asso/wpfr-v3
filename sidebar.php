<div id="sidebar1" class="sidebar">
	<ul>
		<?php //if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : ?>
		
		<li class="subscriptions"><h2>S'abonner</h2>
			<ul>
				<li><a href="feed:http://www.wordpress-fr.net/feed" title="Flux RSS des articles">Flux RSS des articles</a></li>
				<li><a href="feed:http://www.wordpress-fr.net/comments/feed" title="Flux RSS des commentaires">Flux RSS des commentaires</a></li>
			</ul>
			<div class="feedburner">
				<a href="http://feeds.feedburner.com/WordpressFrancophone"><img src="http://feeds.feedburner.com/~fc/WordpressFrancophone?bg=971A1F&amp;fg=FFFFFF&amp;anim=0" height="26" width="88" style="border:0" alt="" /></a>
				
				<form class="feedburner_mails" action="http://www.feedburner.com/fb/a/emailverify" method="post" target="popupwindow" onsubmit="window.open('http://www.feedburner.com/fb/a/emailverifySubmit?feedId=632149', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
					<div>
						Via email:<br />
						<input type="text" style="width:140px" name="email"/>
						<input type="hidden" value="http://feeds.feedburner.com/~e?ffid=632149" name="url"/>
						<input type="hidden" value="WordPress Francophone" name="title"/>
						<input type="hidden" name="loc" value="fr_FR"/>
						<input type="submit" value="S'abonner" />
					</div>
				</form>
			</div>
		</li>
	
		<?php wp_list_categories('child_of=1&show_count=1&title_li=<h2>Catégories</h2>'); ?>
		
		<?php //endif; ?> 
	</ul>
</div>

<div id="sidebar2" class="sidebar">
	<ul>
		<?php // if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : ?>

		<li class="tag_cloud"><h2>Méta</h2>
			<?php if( function_exists('wp_tag_cloud') ) wp_tag_cloud('number=30'); ?>
		</li>

		<li class="archives"><h2>Archives</h2>
			<ul>
				<?php wp_get_archives('type=monthly&show_post_count=1&limit=12'); ?>
			</ul>
		</li>
		
		<li>
			<script type="text/javascript"><!--
			google_ad_client = "ca-pub-8404696132017531";
			/* Sidebar Site */
			google_ad_slot = "6355488257";
			google_ad_width = 160;
			google_ad_height = 600;
			//-->
			</script>
			<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
		</li>
		<?php //endif; ?> 
	</ul>
</div>