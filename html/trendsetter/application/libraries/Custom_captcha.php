<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Custom_captcha

{

	public function generate($textColor,$backgroundColor,$imgWidth,$imgHeight,$noiceLines=0,$noiceDots=0,$noiceColor='#888')

	{

		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

		$text= substr( str_shuffle( $chars ), 0, 5);

		$font = realpath('.') .'/RanchoRegular.ttf';

		$textColor=$this->hexToRGB($textColor);

		$fontSize = $imgHeight * 0.6;

		$im = imagecreatetruecolor($imgWidth, $imgHeight);

		$textColor = imagecolorallocate($im, $textColor['r'],$textColor['g'],$textColor['b']);

		$backgroundColor = $this->hexToRGB($backgroundColor);

		$backgroundColor = imagecolorallocate($im, $backgroundColor['r'],$backgroundColor['g'],$backgroundColor['b']);

		imagefill($im,0,0,$backgroundColor);

		if($noiceLines>0){

		$noiceColor=$this->hexToRGB($noiceColor);

		$noiceColor = imagecolorallocate($im, $noiceColor['r'],$noiceColor['g'],$noiceColor['b']);

		for( $i=0; $i<$noiceLines; $i++ ) {

			imageline($im, mt_rand(0,$imgWidth), mt_rand(0,$imgHeight),

			mt_rand(0,$imgWidth), mt_rand(0,$imgHeight), $noiceColor);

		}}

		if($noiceDots>0){

		for( $i=0; $i<$noiceDots; $i++ ) {

			imagefilledellipse($im, mt_rand(0,$imgWidth),

			mt_rand(0,$imgHeight), 1, 1, $noiceColor);

		}}

		list($x, $y) = $this->ImageTTFCenter($im, $text, $font, $fontSize);

		imagettftext($im, $fontSize, rand(-5,5), $x, $y, $textColor, $font, $text);

		imagerectangle ($im, 0, 0, $imgWidth-1, $imgHeight-1, $textColor);

		ob_start();

		imagejpeg($im,NULL,50);

		$image_data = ob_get_contents ();

		ob_end_clean();

		imagedestroy($im);

		// $imagick = new Imagick();

  //   	$imagick->readImageBlob($image_data);

  //   	$imagick->waveImage(5, 50);

		return array('img'=>'<img src="data:image/jpeg;base64,'.base64_encode($image_data).'" alt="captcha">','text'=>$text);

	}

	protected function hexToRGB($colour)

	{

        if ( $colour[0] == '#' ) {

			$colour = substr( $colour, 1 );

        }

        if ( strlen( $colour ) == 6 ) {

			list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );

        } elseif ( strlen( $colour ) == 3 ) {

			list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );

        } else {

			return false;

        }

        $r = hexdec( $r );

        $g = hexdec( $g );

        $b = hexdec( $b );

        return array( 'r' => $r, 'g' => $g, 'b' => $b );

	}

	protected function ImageTTFCenter($image, $text, $font, $size, $angle = 8)

	{

		$xi = imagesx($image);

		$yi = imagesy($image);

		$box = imagettfbbox($size, $angle, $font, $text);

		$xr = abs(max($box[2], $box[4]))+5;

		$yr = abs(max($box[5], $box[7]));

		$x = intval(($xi - $xr) / 2);

		$y = intval(($yi + $yr) / 2);

		return array($x,$y);

	}

}

?>