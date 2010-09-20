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

	class DummyImagesController extends DummyAppController {
		public $name = 'DummyImages';

		public $uses = array();

		/**
		 * Dynamic Dummy Image Generator - DummyImage.com
		 * Copyright (c) 2010 Russell Heimlich
		 *
		 * Permission is hereby granted, free of charge, to any person obtaining a copy
		 * of this software and associated documentation files (the "Software"), to deal
		 * in the Software without restriction, including without limitation the rights
		 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
		 * copies of the Software, and to permit persons to whom the Software is
		 * furnished to do so, subject to the following conditions:
		 *
		 * The above copyright notice and this permission notice shall be included in
		 * all copies or substantial portions of the Software.
		 *
		 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
		 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
		 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
		 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
		 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
		 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
		 * THE SOFTWARE.
		 */
		public function image() {
			Configure::write('debug', 0);
			App::import('Vendor', 'Dummy.DummyImageColor', array('file' => 'dummy_image'.DS.'dummy_image_color.php'));			
			
			$this->DummyImageColorBackground = new DummyImageColor();
			$this->DummyImageColorBackground->set_hex(isset($this->params['pass'][1]) ? $this->params['pass'][1] : 'ccc');

			//Find the foreground color which is always after the 3rd param.

			$this->DummyImageColorForeground = new DummyImageColor();
			$this->DummyImageColorForeground->set_hex(isset($this->params['pass'][2]) ? $this->params['pass'][2] : '000');

			$file_format = isset($this->params['url']['ext']) ? $this->params['url']['ext'] : 'png';

			//Find the image dimensions
			$this->params['pass'][0] = isset($this->params['pass'][0]) ? $this->params['pass'][0] : '200x200';
			$dimensions = explode('x',$this->params['pass'][0]); 
			$height = $width = preg_replace('/[^\d]/i', '',$dimensions[0]);
			if (isset($dimensions[1]) && $dimensions[1]) {
				$height = preg_replace('/[^\d]/i', '',$dimensions[1]);
			}

			/**
			 * limit the size
			 */
			if ($width * $height >= 16000000) { 
				exit;
			}

			$text_angle = 0; //I don't use this but if you wanted to angle your text you would change it here.

			/**
			 * If you want to use a different font simply upload the true type font
			 * (.ttf) file to the same directory as this PHP file and set the $font
			 * variable to the font file name. I'm using the M+ font which is free for
			 * distribution -> http://www.fontsquirrel.com/fonts/M-1c
			 */
			$font = App::pluginPath('Dummy') . 'vendors' . DS . 'dummy_image' . DS . 'mplus-1c-medium.ttf';


			$img = imageCreate($width, $height); //Create an image.
			$bg_color = imageColorAllocate($img, $this->DummyImageColorBackground->get_rgb('r'), $this->DummyImageColorBackground->get_rgb('g'), $this->DummyImageColorBackground->get_rgb('b'));
			$fg_color = imageColorAllocate($img, $this->DummyImageColorForeground->get_rgb('r'), $this->DummyImageColorForeground->get_rgb('g'), $this->DummyImageColorForeground->get_rgb('b'));
			unset($this->DummyImageColorBackground, $this->DummyImageColorForeground);

			$text = isset($this->params['named']['text']) ? $this->params['named']['text'] : $width.' x '.$height;
			$text = preg_replace('/\|/i', "\n", $text);

			//Ric Ewing: I modified this to behave better with long or narrow images and condensed the resize code to a single line.
			//$fontsize = max(min($width/strlen($text), $height/strlen($text)),5); //scale the text size based on the smaller of width/8 or hieght/2 with a minimum size of 5.

			$fontsize = max(min($width/strlen($text) * 1.15, $height * 0.5) ,5);

			$textBox = $this->__imagettfbbox_t($fontsize, $text_angle, $font, $text); //Pass these variable to a function that calculates the position of the bounding box.

			$textWidth = ceil( ($textBox[4] - $textBox[1]) * 1.07 ); //Calculates the width of the text box by subtracting the Upper Right "X" position with the Lower Left "X" position.

			$textHeight = ceil( (abs($textBox[7])+abs($textBox[1])) * 1 ); //Calculates the height of the text box by adding the absolute value of the Upper Left "Y" position with the Lower Left "Y" position.

			$textX = ceil( ($width - $textWidth)/2 ); //Determines where to set the X position of the text box so it is centered.
			$textY = ceil( ($height - $textHeight)/2 + $textHeight ); //Determines where to set the Y position of the text box so it is centered.

			imageFilledRectangle($img, 0, 0, $width, $height, $bg_color); //Creates the rectangle with the specified background color. http://us2.php.net/manual/en/function.imagefilledrectangle.php

			imagettftext($img, $fontsize, $text_angle, $textX, $textY, $fg_color, $font, $text);	 //Create and positions the text http://us2.php.net/manual/en/function.imagettftext.php

			header('Content-type: image/'.$file_format); //Set the header so the browser can interpret it as an image and not a bunch of weird text.

			//Create the final image based on the provided file format.
			switch ($file_format) {
				case 'gif':
					imagegif($img);
					break;

				case 'png':
					imagepng($img);
					break;

				case 'jpg':
					imagejpeg($img);
					break;

				case 'jpeg':
					imagejpeg($img);
					break;
			}
			
			imageDestroy($img);//Destroy the image to free memory.
			exit;
		}
		
		//Ruquay K Calloway http://ruquay.com/sandbox/imagettf/ made a better function to find the coordinates of the text bounding box so I used it.
		private function __imagettfbbox_t($size, $text_angle, $fontfile, $text) {
			// compute size with a zero angle
			$coords = imagettfbbox($size, 0, $fontfile, $text);

			// convert angle to radians
			$a = deg2rad($text_angle);

			// compute some usefull values
			$ca = cos($a);
			$sa = sin($a);
			$ret = array();

			// perform transformations
			for($i = 0; $i < 7; $i += 2) {
				$ret[$i] = round($coords[$i] * $ca + $coords[$i+1] * $sa);
				$ret[$i+1] = round($coords[$i+1] * $ca - $coords[$i] * $sa);
			}
			return $ret;
		}

		public function admin_index() {

		}
	}