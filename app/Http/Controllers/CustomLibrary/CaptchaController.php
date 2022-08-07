<?php

namespace App\Http\Controllers\CustomLibrary;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CaptchaController extends Controller
{
    public static function generate($textColor,$backgroundColor,$imgWidth,$imgHeight,$noiceLines=0,$noiceDots=0,$noiceColor='#888'){
		$text= str_random(5);
		$fontPath = storage_path('app/captcha_font/Merriweather-Regular.ttf');
		$fontSize = $imgHeight * 0.6;
		$angle = rand(-5,5);

		$image = \Image::canvas($imgWidth,$imgHeight, $backgroundColor);

		if($noiceLines>0){
			for( $i=0; $i<$noiceLines; $i++ ) {
				$x1 = mt_rand(0,$imgWidth);
				$x2 = mt_rand(0,$imgWidth);
				$y1 = mt_rand(0,$imgHeight);
				$y2 = mt_rand(0,$imgHeight);

				$image->line($x1, $y1, $x2, $y2, function ($draw) use($noiceColor) {
				    $draw->color($noiceColor);
				});
			}
		}

		if($noiceDots>0){
			for( $i=0; $i<$noiceDots; $i++ ) {
				$image->ellipse(1, 1, mt_rand(0,$imgWidth), mt_rand(0,$imgHeight),  function ($draw) use($noiceColor) {
				    $draw->background($noiceColor);
				});
			}
		}


		list($x, $y) = static::ImageTTFCenter($image->getCore(), $text, $fontPath, $fontSize, $angle);

		$image->text($text, $x, $y, function($font) use($fontPath,$fontSize,$textColor,$angle) {
		    $font->file($fontPath);
		    $font->size($fontSize);
		    $font->color($textColor);
		    $font->angle($angle);
		});

		$image->rectangle(0, 0, $imgWidth-1, $imgHeight-1, function ($draw) use($textColor) {
		    $draw->background('rgba(255, 255, 255, 0)');
		    $draw->border(1, $textColor);
		});

		$image_data = (string) $image->encode('data-url');
		$image->destroy();

		session(['captchaKeyData' => $text,'captchaImgData' => $image_data]);

		return (object) array('captchaImgData' => $image_data);
	}

	public static function destroy(){
		if(session()->has('captchaImgData')){
			session()->forget('captchaImgData');
			session()->forget('captchaKeyData');
			return true;
		}else{
			return false;
		}
	}

	public static function regenerate(){
		if(session()->has('captchaImgData')){
			return static::generate();
		}else{
			return false;
		}
	}

	protected static function ImageTTFCenter($image, $text, $font, $size, $angle)
	{
		$xi = imagesx($image);
		$yi = imagesy($image);
		$box = imagettfbbox($size, $angle, $font, $text);
		$xr = abs(max($box[2], $box[4]))-20;
		$yr = abs(max($box[5], $box[7]));
		$x = intval(($xi - $xr) / 2);
		$y = intval(($yi + $yr) / 2);
		return array($x,$y);
	}
}
