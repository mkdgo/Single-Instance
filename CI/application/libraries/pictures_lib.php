<?php
class Pictures_lib {
	private $_CI;
	public function __construct() {
		$this->_CI = & get_instance();
		$this->_CI->load->library('wideimage/WideImage');
	}
	function resize($image, $width, $height, $mode = 'normal') {
		if (!$image) {
			return '';
		}
		
		$upload_config = $this->_CI->config->load('upload', TRUE);
		$upload_path = $this->_CI->config->item('upload_path', 'upload');
		$image_path = $this->_CI->config->item('image_path', 'upload');
		$default_image = $this->_CI->config->item('default_image', 'upload');

		
		$image_name = $image;
		$orig_image = $upload_path . $image_name;
		if (!file_exists($orig_image)) {
			// get from constants the default image and resize it then
			$image_name = $default_image;
		}
		$resizedImageSource = $width . 'x' . $height . '_' . $image_name;
		if (file_exists($image_path . $resizedImageSource)) {
			return ltrim($image_path, '.') . $resizedImageSource;
			die();
		}
		if ($mode != 'inside' && isset($width) && isset($height)) {
			$new_image = WideImage::load($upload_path . $image_name)
					->resize($width, $height, 'outside')
					->crop('center', 'top', $width, $height)
					->saveToFile($image_path . $resizedImageSource);
		} else {
			$new_image = WideImage::load($upload_path . $image_name)
					->resize($width, $height, 'outside')
					->saveToFile($image_path . $resizedImageSource);
		}
		chmod($image_path . $resizedImageSource, 0644);
		return ltrim($image_path, '.') . $resizedImageSource;
	}
}