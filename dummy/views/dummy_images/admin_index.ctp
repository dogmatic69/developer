<?php
/* 
	 * Short Description / title.
	 * 
	 * Overview of what the file does. About a paragraph or two
	 * 
	 * Copyright (c) 2010 Carl Sutton ( dogmatic69 )
	 * 
	 * @filesource
	 * @copyright Copyright (c) 2010 Carl Sutton ( dogmatic69 )
	 * @link http://www.infinitas-cms.org
	 * @package {see_below}
	 * @subpackage {see_below}
	 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
	 * @since {check_current_milestone_in_lighthouse}
	 * 
	 * @author {your_name}
	 * 
	 * Licensed under The MIT License
	 * Redistributions of files must retain the above copyright notice.
*/
?>
<div class="table dashboard">
	<h1>Dynamic Dummy Image Generator</h1>
	<cite>by <a href="#about">Russell Heimlich</a> (<a href="http://www.twitter.com/kingkool68">@kingkool68</a>)</cite>
	<div id="preview">
		<?php 
			$image = $this->Html->image('/dummy_image/900x200/000/fff/text:Infinitas');
			echo $image, '<br/>',
				'$this->Html->image(\'/dummy_image/900x200/000/fff/text:Infinitas\');', '<br/>',
				htmlspecialchars($image);
		?>
	</div>
</div>
<div class="dashboard">
	<h1 id="size">Size</h1>
	<p>width x height</p>
	<ul>
		<li>
			Height is optional, if no height is specified the image will be a square.
		</li>
		<li><strong>Must</strong> be the first option in the url</li>
		<li>
			<?php
				$image = $this->Html->image('/dummy_image/100/text:Infinitas');
				echo $image, '<br/>',
					'$this->Html->image(\'/dummy_image/100/text:Infinitas\');', '<br/>',
					htmlspecialchars($image);
			?>
		</li>
	</ul>
</div>

<div class="dashboard">
	<h1 id="color">Colors</h1>
	<p>background color / text color</p>
	<ul>
		<li>Colors are represented as hex codes (#ffffff is white)</li>
		<li>The first color is always the background color and the second color is the text color.</li>
		<li>The background color is optional and defaults to gray (#cccccc)</li>
		<li>The text color is optional and defaults to black (#000000)</li>
		<li>There are shortcuts for colors
			<ul>
				<li>3 digits will be expanded to 6, <span class="example">09f</span> becomes <span class="example">0099ff</span></li>
				<li>2 digits will be expanded to 6, <span class="example">ef</span> becomes <span class="example">efefef</span></li>
				<li>1 digit will be repeated 6 times, <span class="example">c</span> becomes <span class="example">cccccc</span> Note: a single 0 will not work, use 00 instead.</li>
			</ul>
		</li>
		<li>Standard image sizes are also available. See the <a href="#standards">complete list</a>.
			<ul>
				<li>					
					<?php
						$image = $this->Html->image('/dummy_image/qvga');
						echo $image, '<br/>', htmlspecialchars($image);
					?>
				</li>
				<li>
					<?php
						$image = $this->Html->image('/dummy_image/skyscraper/f0f/f');
						echo $image, '<br/>', htmlspecialchars($image);
					?>
				</li>
			</ul>
		</li>
	</ul>
</div>

<div class="dashboard">
	<h1 id="format">Image Formats</h1>
	<p>.gif, .jpg, .png</p>
	<ul>
		<li>Adding an image file extension will render the image in the proper format</li>
		<li>Image format is optional and the default is a gif</li>
		<li>jpg and jpeg are the same</li>
		<li>The image extension can go at the end of any option in the url
			<ul>
				<li><a href="http://dummyimage.com/300.png/09f/fff" target="_blank" class="example correct">http://dummyimage.com/300.png/09f/fff</a></li>
				<li><a href="http://dummyimage.com/300/09f.png/fff" target="_blank" class="example correct">http://dummyimage.com/300/09f.png/fff</a></li>
				<li><a href="http://dummyimage.com/300/09f/fff.png" target="_blank" class="example correct">http://dummyimage.com/300/09f/fff.png</a></li>
			</ul>
		</li>
	</ul>
</div>

<div class="dashboard">
	<h1 id="text">Custom Text</h1>
	<p>&amp;text=Hello+World</p>
	<ul>
		<li>Custom text can be entered using a query string at the very end of the url.</li>
		<li>This is optional, default is the image dimensions (<span class="example">300&times;250</span>)</li>
		<li>a-z (upper and lowercase), numbers, and most symbols will work just fine.</li>
		<li>Spaces become +
			<ul>
				<li><a href="http://dummyimage.com/200x300&text=dummyimage.com+rocks!" target="_blank" class="example correct">http://dummyimage.com/200x300&amp;text=dummyimage.com+rocks!</a></li>
			</ul>
		</li>
		<li>The font used is from the freely available <a href="http://mplus-fonts.sourceforge.jp" target="_blank">M+ Font Project</a></li>
	</ul>
</div>

<div class="table">
	<table class="listing" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th>Keyword</th>
				<th>Shortcuts</th>
				<th>Dimensions</th>
				<th>Regular Expression</th>
			</tr>
		</thead>
		<tbody>
			<tr><td><a href="http://dummyimage.com/mediumrectangle">mediumrectangle</a></td>
				<td><a href="http://dummyimage.com/medrect">medrect</a></td>
				<td>300&times;250</td>
				<td>^(med)\w+(rec\w+)</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/squarepopup">squarepopup</a></td>
				<td><a href="http://dummyimage.com/sqrpop">sqrpop</a></td>
				<td>250&times;250</td>
				<td>^(s\w+pop)</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/verticalrectangle">verticalrectangle</a></td>
				<td><a href="http://dummyimage.com/vertrec">vertrec</a></td>
				<td>240&times;400</td>
				<td>^(ver)\w+(rec)</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/largerectangle">largerectangle</a></td>
				<td><a href="http://dummyimage.com/lrgrec">lrgrec</a></td>
				<td>336&times;280</td>
				<td>^(large|lrg)(rec)</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/rectangle">rectangle</a></td>
				<td><a href="http://dummyimage.com/rec">rec</a></td>
				<td>180&times;150</td>
				<td> ^(rec)</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/popunder">popunder</a></td>
				<td><a href="http://dummyimage.com/pop">pop</a></td>
				<td>720&times;300</td>
				<td>^(pop)</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/fullbanner">fullbanner</a></td>
				<td><a href="http://dummyimage.com/fullban">fullban</a></td>
				<td>468&times;60</td>
				<td>^(f\w+ban)</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/halfbanner">halfbanner</a></td>
				<td><a href="http://dummyimage.com/halfban">halfban</a></td>
				<td>234&times;60</td>
				<td>^(h\w+ban)</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/microbar">microbar</a></td>
				<td><a href="http://dummyimage.com/mibar">mibar</a></td>
				<td>88&times;31</td>
				<td>^(m\w+bar)</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/button1">button1</a></td>
				<td><a href="http://dummyimage.com/but1">but1</a></td>
				<td>120&times;90</td>
				<td>^(b\w+1)</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/button2">button2</a></td>
				<td><a href="http://dummyimage.com/but2">but2</a></td>
				<td>120&times;60</td>
				<td>^(b\w+2)</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/verticalbanner">verticalbanner</a></td>
				<td><a href="http://dummyimage.com/vertban">vertban</a></td>
				<td>120&times;240</td>
				<td>^(ver\w+ban)</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/squarebutton">squarebutton</a></td>
				<td><a href="http://dummyimage.com/sqrbut">sqrbut</a></td>
				<td>125&times;125</td>
				<td>^(s\w+but)</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/leaderboard">leaderboard</a></td>
				<td><a href="http://dummyimage.com/leadbrd">leadbrd</a></td>
				<td>728&times;90</td>
				<td>^(lea\w+rd)</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/wideskyscraper">wideskyscraper</a></td>
				<td><a href="http://dummyimage.com/wiskyscrpr">wiskyscrpr</a></td>
				<td>60&times;600</td>
				<td>^(w\w+sk\w+r)</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/skyscraper">skyscraper</a></td>
				<td><a href="http://dummyimage.com/skyscrpr">skyscrpr</a></td>
				<td>120&times;600</td>
				<td>^(sk\w+r)</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/halfpage">halfpage</a></td>
				<td><a href="http://dummyimage.com/hpge">hpge</a></td>
				<td>300&times;600</td>
				<td>^(h\w+g)</td>
			</tr>
		</tbody>
	</table>
</div>

<div class="table">
	<table class="listing" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th>Keyword</th>
				<th>Dimensions</th>
			</tr>
		</thead>
		<tbody>
			<tr><td><a href="http://dummyimage.com/cga">cga</a></td>
				<td>320x200</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/qvga">qvga</a></td>
				<td>320x240</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/vga">vga</a></td>
				<td>640x480</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/wvga">wvga</a></td>
				<td>800x480</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/svga">svga</a></td>
				<td>800x480</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/wsvga">wsvga</a></td>
				<td>1024x600</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/xga">xga</a></td>
				<td>1024x768</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/wxga">wxga</a></td>
				<td>1280x800</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/wsxga">wsxga</a></td>
				<td>1440x900</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/wuxga">wuxga</a></td>
				<td>1920x1200</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/wqxga">wqxga</a></td>
				<td>2560x1600</td>
			</tr>
		</tbody>
	</table>
</div>

<div class="table">
	<table class="listing" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th>Keyword</th>
				<th>Dimensions</th>
			</tr>
		</thead>
		<tbody>
			<tr><td><a href="http://dummyimage.com/ntsc">ntsc</a></td>
				<td>720x480</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/pal">pal</a></td>
				<td>768x576</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/hd720">hd720</a></td>
				<td>1280x720</td>
			</tr>
			<tr><td><a href="http://dummyimage.com/hd1080">hd1080</a></td>
				<td>1920x1080</td>
			</tr>
		</tbody>
	</table>
</div>