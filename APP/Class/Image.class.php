<?php
/**
 * ͼ������
 *
 * @author Carmen <e.carmen.hyc@gmail.com>
 * 
 *
 * ������֤�룺Image::verify(���ȣ� �� ��)
 *
 * �Ӹ�ͼƬˮӡ��Image::water(ͼƬ·��, ˮӡͼ·��, ����·��)
 *
 * �Ӹ�����ˮӡ��Image::text(ͼƬ·��, ��������, ����·��)
 *
 * ��������ͼ��Image::thumb(ͼƬ·��, ��, ��, ����·��)
 *
 * ps:����·��������Ϊ�������滻ԭͼ
 * 
 * Ϊ�˼��ٲ�����������������ó�������
 * Ƕ����ʱ���ҵ�ÿ�������ĳ�ʼ���ѳ����滻�������ļ���
 * �� ThinkPHP �ɲ��� C() �������泣������
 */


/**********��֤��������**********/
//��֤�볤��
// define('VERIFY_LENGTH', 4);
// //��֤��ͼƬ���(����)
// define('VERIFY_WIDTH', 250);
// //��֤��ͼƬ�߶�(����)
// define('VERIFY_HEIGHT', 60);
// //��֤�뱳Ӱ��ɫ(16����ɫֵ)
// define('VERIFY_BGCOLOR', '#F3FBFE');
// //��֤������
// define('VERIFY_SEED', '3456789aAbBcCdDeEfFgGhHjJkKmMnNpPqQrRsStTuUvVwWxXyY');
// //��֤�������ļ�
// define('VERIFY_FONTFILE', 'font.ttf');
// //��֤�������С
// define('VERIFY_SIZE', 30);
// //��֤��������ɫ(16����ɫֵ)
// define('VERIFY_COLOR', '#444444');
// //SESSIONʶ������
// define('VERIFY_NAME', 'verify');
// //�洢��֤�뵽SESSIONʱʹ�ú���
// define('VERIFY_FUNC', 'strtolower');


/**********ˮӡ������**********/
//ˮӡͼ·��
define('WATER_IMAGE', './water.png');
//ˮӡλ��
define('WATER_POS', 9);
//ˮӡ͸����
define('WATER_ALPHA', 60);
//JPEGͼƬѹ����
define('WATER_COMPRESSION', 80);
//ˮӡ����
define('WATER_TEXT', 'HouDunWang.com');
//ˮӡ������ת��ɫ
define('WATER_ANGLE', 0);
//ˮӡ���ִ�С
define('WATER_FONTSIZE', 30);
//ˮӡ������ɫ
define('WATER_FONTCOLOR', '#670768');
//ˮӡ���������ļ�(д��������ʱ��ʹ��֧�����ĵ������ļ�)
define('WATER_FONTFILE', './font.ttf');
//ˮӡ�����ַ�����
define('WATER_CHARSET', 'UTF-8');


/**********����ͼ������**********/
//����ͼ���
define('THUMB_WIDTH', 200);
//����ͼ�߶�
define('THUMB_HEIGHT', 120);

Class Image {

	/**
	 * ������֤��
	 * @param  [Integer] $length [��֤�볤��]
	 * @param  [Integer] $width  [��֤����]
	 * @param  [Integer] $height [��֤��߶�]
	 * @return [boolean]
	 */
	Static Public function verify ($length = NULL, $width = NULL, $height = NULL) {

		//�������
		if (!self::checkCondition()) return false;

		//��ʼ������(�Ž����ʱ�ѳ������� ��ȡ�����ļ��� )
		$length = empty($length) ? C('VERIFY_LENGTH') : $length;
		$width = empty($width) ? C('VERIFY_WIDTH') : $width;
		$height= empty($height) ? C('VERIFY_HEIGHT') : $height;
		$bgColor = C('VERIFY_BGCOLOR');
		$seed = C('VERIFY_SEED');
		$fontFile = C('VERIFY_FONTFILE');
		$size = C('VERIFY_SIZE');
		$fontColor = ('VERIFY_COLOR');
		$name = C('VERIFY_NAME');
		$fn = C('VERIFY_FUNC');

		//��������ͼ��
		$verify = imagecreatetruecolor($width, $height);

		//��������ɫ
		$rgb = self::colorTrans($bgColor);
		$color = imagecolorallocate($verify, $rgb['red'], $rgb['green'], $rgb['blue']);
		imagefill($verify, 0, 0, $color);

		//д�뱳����������
		$len = strlen($seed) - 1;
		for ($i = 0; $i < 20; $i++) {
			$color = imagecolorallocate($verify, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
			imagestring($verify, 5, mt_rand(0, $width), mt_rand(0, $height), $seed[mt_rand(0, $len)], $color);
		}

		$rgb = self::colorTrans($fontColor);
		$fontColor = imagecolorallocate($verify, $rgb['red'], $rgb['green'], $rgb['blue']);


		//д����֤��
		$code = '';
		$left = ($width - $size * $length) / 2;
		$y = $height - ($height - $size) / 2;
		for ($i = 0; $i < $length; $i++) {
			$font = $seed[mt_rand(0, $len)];
			$x = $size * $i + $left;
			imagettftext($verify, $size, mt_rand(-30, 30), $x, $y, $fontColor, $fontFile, $font);
			$code .= $font;
		}
		$_SESSION[$name] = $fn($code);

		//������
		for ($i = 0, $h = $height / 2 - 2; $i < 5; $i++, $h++) {
			$color = imagecolorallocate($verify, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
			$cx = mt_rand(-10, $width + 10);
			$cy = mt_rand(-10, $height + 10);
			$cw = mt_rand(-10, $width + 10);
			$ch = mt_rand(-10, $height + 10);
			imageellipse($verify, $cx, $cy, $cw, $ch, $color);
			imageellipse($verify, $cx + 1, $cy + 1, $cw + 1, $ch + 1, $color);

			imageline($verify, 0, $h, $width, $h, $fontColor);
		}

		//����ͼ��
		header('Content-type:image/png');
		imagepng($verify);
		imagedestroy($verify);
		return true;
	}

	/**
	 * �Ӹ�ͼƬˮӡ
	 * @param  [String] $img   [ͼƬ·��]
	 * @param  [String] $water [ˮӡͼ·��]
	 * @param  [String] $save  [����·��|�������滻ԭͼ]
	 * @return [Boolean]
	 */
	Static Public function water ($img, $water = '', $save = NULL) {
		if (!self::checkCondition($img)) return false;
		
		//��ʼ������(�Ž����ʱ�ѳ������� ��ȡ�����ļ��� )
		$water = empty($water) ? WATER_IMAGE : $water;
		$pos = WATER_POS;
		$alpha = WATER_ALPHA;
		$compression = WATER_COMPRESSION;

		if (!file_exists($water)) return false;

		//ԭͼ����������
		$imgInfo = getimagesize($img);
		$imgW = $imgInfo[0];
		$imgH = $imgInfo[1];
		$imgT = self::getImageType($imgInfo[2]);

		//ˮӡͼ����������
		$waterInfo = getimagesize($water);
		$waterW = $waterInfo[0];
		$waterH = $waterInfo[1];
		$waterT = self::getImageType($waterInfo[2]);

		//ˮӡͼ����ԭͼʱ��������
		if ($imgW < $waterW || $imgH < $waterH) return false;

		//����ˮӡλ��
		$pos = self::getPosition($imgW, $imgH, $waterW, $waterH, $pos);
		$x = $pos['x'];
		$y = $pos['y'];

		//��ԭͼ��Դ
		$fn = 'imagecreatefrom' . $imgT;
		$image = $fn($img);

		//��ˮӡͼ��Դ
		$fn = 'imagecreatefrom' . $waterT;
		$water = $fn($water);

		//����ˮӡͼ
		if ($waterT == 'png') {
			imagecopy($image, $water, $x, $y, 0, 0, $waterW, $waterH);
		} else {
			imagecopymerge($image, $water, $x, $y, 0, 0, $waterW, $waterH, $alpha);
		}

		//����·��
		$save = self::savePath($save, $img);
		$fn = 'image' . $imgT;
		if ($imgT == 'jpeg') {
			$fn($image, $save, $compression);
		} else {
			$fn($image, $save);
		}

		//�ͷ���Դ
		imagedestroy($image);
		imagedestroy($water);
		return true;
	}

	/**
	 * �Ӹ�����ˮӡ
	 * @param  [String] $img  [ͼƬ·��]
	 * @param  [String] $text [��������]
	 * @param  [String] $save [����·��|�������滻ԭͼ]
	 * @return [Boolean]
	 */
	Static Public function text ($img, $text = '', $save = NULL) {
		if (!self::checkCondition($img)) return false;

		//��ʼ������(�Ž����ʱ�ѳ������� ��ȡ�����ļ��� )
		$text = empty($text) ? WATER_TEXT : $text;
		$pos = WATER_POS;
		$angle = WATER_ANGLE;
		$fontSize = WATER_FONTSIZE;
		$fontColor = WATER_FONTCOLOR;
		$fontFile = WATER_FONTFILE;
		$charset = WATER_CHARSET;
		$compression = WATER_COMPRESSION;

		//����ˮӡ����
		$waterInfo = imagettfbbox($fontSize, $angle, $fontFile, $text);
		$waterW = $waterInfo[2] - $waterInfo[0];
		$waterH = $waterInfo[1] - $waterInfo[7];

		//ԭͼ���ߡ�����
		$imgInfo = getimagesize($img);
		$imgW = $imgInfo[0];
		$imgH = $imgInfo[1];
		$type = self::getImageType($imgInfo[2]);

		//����ˮӡλ��
		$pos = self::getPosition($imgW, $imgH, $waterW, $waterH, $pos);
		$x = $pos['x'];
		$y = $pos['y'] + $fontSize / 2;

		//��ԭͼ��Դ
		$fn = 'imagecreatefrom' . $type;
		$image = $fn($img);

		//д��ˮӡ����
		$rgb = self::colorTrans($fontColor);
		$color = imagecolorallocate($image, $rgb['red'], $rgb['green'], $rgb['blue']);
		$text = iconv($charset, 'UTF-8', $text);
		imagettftext($image, $fontSize, $angle, $x, $y, $color, $fontFile, $text);

		//����·��
		$save = self::savePath($save, $img);
		$fn = 'image' . $type;
		if ($type == 'jpeg') {
			$fn($image, $save, $compression);
		} else {
			$fn($image, $save);
		}

		//�ͷ���Դ
		imagedestroy($image);
		return true;

	}

	/**
	 * ��������ͼ(�ȱ�������)
	 * @param  [String] $img    [ͼƬ·��]
	 * @param  [String] $width  [���Կ��]
	 * @param  [String] $height [���Ը߶�]
	 * @param  [String] $save   [����·��|�������滻ԭͼ]
	 * @return [Boolean]
	 */
	Static Public function thumb ($img, $width = '', $height = '', $save = NULL) {
		if (!self::checkCondition($img)) return false;

		//��ʼ������(�Ž����ʱ�ѳ������� ��ȡ�����ļ��� )
		$width = empty($width) ? THUMB_WIDTH : $width;
		$height = empty($height) ? THUMB_HEIGHT : $height;

		//ԭͼ���ߡ�����
		$imgInfo = getimagesize($img);
		$imgW = $imgInfo[0];
		$imgH = $imgInfo[1];
		$type = self::getImageType($imgInfo[2]);

		//���ű�
		$ratio = max($width / $imgW, $height / $imgH);
		//����ͼ����ԭͼ��������
		if ($ratio >= 1) return false;

		//�ȱ������ź����
		$width = floor($imgW * $ratio);
		$height = floor($imgH * $ratio);

		//��������ͼ����
		if ($type == 'gif') {
			$thumb = imagecreate($width, $height);
			$color = imagecolorallocate($thumb, 0, 255, 0);
		} else {
			$thumb = imagecreatetruecolor($width, $height);
			//PNGͼƬ͸������
			if ($type == 'png') {
				//�رջ�ɫģʽ
				imagealphablending($thumb, false);
				//����͸��ͨ��
				imagesavealpha($thumb, true);
			}
		}

		//��ԭͼ��Դ
		$fn = 'imagecreatefrom' . $type;
		$image = $fn($img);

		//ԭͼ��������ͼ������������С
		if (function_exists('imagecopyresampled')) {
			imagecopyresampled($thumb, $image, 0, 0, 0, 0, $width, $height, $imgW, $imgH);
		} else {
			imagecopyresized($thumb, $image, 0, 0, 0, 0, $width, $height, $imgW, $imgH);
		}

		//GIFͼ͸������
		if ($type == 'gif') imagecolortransparent($thumb, $color);

		//����·��
		$save = self::savePath($save, $img);
		$fn = 'image' . $type;
		$fn($thumb, $save);

		//�ͷ���Դ
		imagedestroy($image);
		imagedestroy($thumb);
		return true;

	}

	/**
	 * ͼƬ����·��
	 * @param  [String] $save [����·��]
	 * @param  [String] $img  [ԭͼ·��]
	 * @return [String]
	 */
	Static Private function savePath ($save, $img) {
		if (!$save) return $img;

		$pathInfo = pathinfo($img);
		$path = rtrim($save, '/') . '/';
		is_dir($path) || mkdir($path, 0777, true);
		return $path . time() . mt_rand(1000, 9999) . '.' . $pathInfo['extension'];
	}

	/**
	 * ����ˮӡͼλ��
	 * @param  [Integer] $IW  [ԭͼ��]
	 * @param  [Integer] $IH  [ԭͼ��]
	 * @param  [Integer] $WW  [ˮӡ��]
	 * @param  [Integer] $WH  [ˮӡ��]
	 * @param  [Integer] $pos [�Ź���λ��]
	 * @return [Array]      [x, y]
	 */
	Static Private function getPosition ($IW, $IH, $WW, $WH, $pos) {
		$x = 20;
		$y = 20;
		switch ($pos) {
			case 1 : 
				break;

			case 2 :
				$x = ($IW - $WW) / 2;
				break;

			case 3 :
				$x = $IW - $WW - 20;
				break;

			case 4 :
				$y = ($IH - $WH) / 2;
				break;

			case 5 :
				$x = ($IW - $WW) / 2;
				$y = ($IH - $WH) / 2;
				break;

			case 6 :
				$x = $IW - $WW - 20;
				$y = ($IH - $WH) / 2;
				break;

			case 7 :
				$y = $IH - $WH - 20;
				break;

			case 8 :
				$x = ($IW - $WW) / 2;
				$y = $IH - $WH - 20;
				break;

			case 9 :
				$x = $IW - $WW - 20;
				$y = $IH - $WH - 20;
				break;

			default :
				$x = mt_rand(0, $IW - $WW);
				$y = mt_rand(0, $IH - $WH);
		}

		return array('x' => $x, 'y' => $y);
	}

	/**
	 * ͼƬ����
	 * @param  [Integer] $typeNum [����ʶ���]
	 * @return [String]
	 */
	Static Private function getImageType ($typeNum) {
		switch($typeNum) {
			case 1 : 
				return 'gif';
			case 2 :
				return 'jpeg';
			case 3 :
				return 'png';
		}
	}

	/**
	 * 16����ɫֵת��ΪRGB
	 * @param  [Sting] $color [16����ɫֵ]
	 * @return [Array]        [red, green, blue]
	 */
	Static Private function colorTrans($color) {
		$color = ltrim($color, '#');
		return array(
			'red' => hexdec($color[0] . $color[1]),
			'green' => hexdec($color[2] . $color[3]),
			'blue' => hexdec($color[4] . $color[5])
			);
	}

	/**
	 * ͼ���������
	 * @return boolean
	 */
	Static Private function checkCondition ($file = NULL) {
		return is_null($file) ? extension_loaded('GD') && function_exists('imagecreatetruecolor') && function_exists('imagepng') : extension_loaded('GD') && file_exists($file);
	}
}
?>