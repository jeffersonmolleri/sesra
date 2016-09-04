<?php
class sfXtraAdapter
{

  protected
  $sourceWidth,
  $sourceHeight,
  $sourceMime,
  $maxWidth,
  $maxHeight,
  $scale,
  $inflate,
  $quality,
  $source,
  $thumb;

  /**
   * Stores function names for each image type
   */
  protected $imgCreators = array(
    'image/jpeg'  => 'imagejpeg',
    'image/pjpeg' => 'imagejpeg',
    'image/png'   => 'imagepng',
    'image/gif'   => 'imagegif',
  );
  
  /**
   * List of accepted image types based on MIME
   * descriptions that this adapter supports
   */
  protected $imgTypes = array(
    'image/jpeg',
    'image/pjpeg',
    'image/png',
    'image/gif',
  );

  /**
   * Stores function names for each image type
   */
  protected $imgLoaders = array(
    'image/jpeg'  => 'imagecreatefromjpeg',
    'image/pjpeg' => 'imagecreatefromjpeg',
    'image/png'   => 'imagecreatefrompng',
    'image/gif'   => 'imagecreatefromgif',
  );

  public function __construct($maxWidth, $maxHeight, $scale, $inflate, $quality, $options)
  {
    if (!extension_loaded('gd'))
    {
      throw new Exception ('GD not enabled. Check your php.ini file.');
    }
    $this->maxWidth = $maxWidth;
    $this->maxHeight = $maxHeight;
    $this->scale = $scale;
    $this->inflate = $inflate;
    $this->quality = $quality;
    $this->options = $options;
    
    if (!isset ($options['handler']))
    {
      $this->options['handler'] = 'resample';
    }
  }
  
  public function loadFile($thumbnail, $image)
  {
    $imgData = @GetImageSize($image);

    if (!$imgData)
    {
      throw new Exception(sprintf('Could not load image %s', $image));
    }

    if (in_array($imgData['mime'], $this->imgTypes))
    {
      $loader = $this->imgLoaders[$imgData['mime']];
      if(!function_exists($loader))
      {
        throw new Exception(sprintf('Function %s not available. Please enable the GD extension.', $loader));
      }

      $this->source = $loader($image);
      $this->sourceWidth = $imgData[0];
      $this->sourceHeight = $imgData[1];
      $this->sourceMime = $imgData['mime'];
      $thumbnail->initThumb($this->sourceWidth, $this->sourceHeight, $this->maxWidth, $this->maxHeight, $this->scale, $this->inflate);

      // resample or resize or fix
      $this->thumb = call_user_func(array($this, $this->options['handler']), $this->source, $thumbnail->getThumbWidth(), $thumbnail->getThumbHeight());

      return true;
    }
    else
    {
      throw new Exception(sprintf('Image MIME type %s not supported', $imgData['mime']));
    }
  }
  
  public function save($thumbnail, $thumbDest, $targetMime = null)
  {
    if($targetMime !== null)
    {
      $creator = $this->imgCreators[$targetMime];
    }
    else
    {
      $creator = $this->imgCreators[$thumbnail->getMime()];
    }

    if ($creator == 'imagejpeg')
    {
      imagejpeg($this->thumb, $thumbDest, $this->quality);
    }
    else
    {
      $creator($this->thumb, $thumbDest);
    }
  }
  
  public function freeSource()
  {
    if (is_resource($this->source))
    {
      imagedestroy($this->source);
    }
  }

  public function freeThumb()
  {
    if (is_resource($this->thumb))
    {
      imagedestroy($this->thumb);
    }
  }

  public function getSourceMime()
  {
    return $this->sourceMime;
  }
  
  
  /**
   * PRIVATE METHODS
   */

  /**
   * Redimensiona imagem preservando proporções
   *
   * @param string $filename
   * @param integer $width
   * @param integer $height
   * @param integer $quality
   * @param boolean $force
   * @return false | stream JPEG Data
   *
   * @uses GD
   */
  protected function resample($image, $width, $height, $quality = 60, $force = false, $unsharp = false)
  {
    // Get new dimensions
    if ($this->sourceWidth <= $width && $this->sourceHeight <= $height && !$force) {// no resampling needed
      return $image;
    }

    if (!list($width, $height) = $this->calcProportionalDimensions($this->sourceWidth, $this->sourceHeight, $width, $height)) {
      if ($width && ($this->sourceWidth < $this->sourceHeight)) {
        $width = ($height / $this->sourceHeight) * $this->sourceWidth;
      } else {
        $height = ($width / $this->sourceWidth) * $this->sourceHeight;
      }
    }

    // Resample
    $image_p = imagecreatetruecolor($width, $height);
//    $image = imagecreatefromstring(file_get_contents($filename));
    if (imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $this->sourceWidth, $this->sourceHeight)) {
      if ($unsharp) {
        $image_buffer = $this->UnsharpMask($image_p, 200, 0.5, 1);
      } else {
        $image_buffer = $image_p;
      }
    } else {
      $image_buffer = $image;
    }
//    imagedestroy($image_p);
//    imagedestroy($image);

    return $image_buffer;
  }

  /**
   * Gera thumbnail de uma imagem a partir do centro
   *
   * @param string $filename
   * @param integer $width
   * @param integer $height
   * @param integer $quality
   * @return false | stream JPEG Data
   *
   * @uses GD
   */
  protected function resize($image_original, $width, $height = null, $quality = 75)
  {
    if ($height == null) {
      $height = $width;
    }

    $image_thumb = imagecreatetruecolor($width, $height);

    $pn = $width / $height;
    $po = $this->sourceWidth / $this->sourceHeight;
    $nw = $width;
    $nh = $height;
    $off_w = 0;
    $off_h = 0;

    if($po > $pn) {
      $nw = ($height / $this->sourceHeight) * $this->sourceWidth;
      $off_w = (($nw-$width)/2) / ($height / $this->sourceHeight);
    } else {
      $nh = ($width / $this->sourceWidth) * $this->sourceHeight;
      $off_h = (($nh-$height)/2) / ($width / $this->sourceWidth);
    }

    if(imagecopyresampled($image_thumb, $image_original, 0, 0, $off_w, $off_h, $nw, $nh, $this->sourceWidth, $this->sourceHeight)) {
      $image_buffer = $image_thumb;
    } else {
      $image_buffer = $image_original;
    }
//    imagedestroy($image_thumb);
//    imagedestroy($image_original);

    return $image_buffer;
  }

  protected function fix ($filename, $width, $height, $quality = 60, $bgColor = '#FFFFFF')
  {
    $_im = false;
    $_nW = $width;
    $_nH = $height;
    $_im = $this->resample($filename, $width, $height, $quality);
    $ow = $this->sourceWidth;
    $oh = $this->sourceHeight;
    list($_nW, $_nH) = $this->calcProportionalDimensions($ow,$oh,$_nW,$_nH);

    if (($_nW == $width) && ($_nH == $height)) {
      return $_im;
    }

//    $_im = imagecreatefromstring($_im);
    $_fx = imagecreatetruecolor($width, $height);
    list($_r,$_g,$_b) = $this->getRgbFromHex($bgColor);
    imagefill($_fx, 0, 0, imagecolorallocate($_fx,$_r,$_g,$_b));

    $_x = 0;
    $_y = 0;
    if ($width > $_nW) {
      $_x = round(($width - $_nW)/2);
    }
    if ($height > $_nH) {
      $_y = round(($height - $_nH)/2);
    }
    //    	if(imagecopymerge($_fx, $_im, $_x, $_y, 0, 0, $_nW, $_nH, 100)) {
    if(imagecopy($_fx, $_im, $_x, $_y, 0, 0, $_nW, $_nH)) {
      $image_buffer = $_fx;
    } else {
      $image_buffer = $filename;
    }
//    imagedestroy($_im);
//    imagedestroy($_fx);

    return $image_buffer;
  }

  /**
   * Calcula novas dimensões proporcionais para imagem
   *
   * @param integer $width_orig
   * @param integer $height_orig
   * @param integer $width
   * @param integer $height
   * @return array
   */
  protected function calcProportionalDimensions ($width_orig, $height_orig, $width, $height)
  {
    if($width_orig <= $width && $height_orig <= $height) {
      return array($width_orig, $height_orig);
    }

    if ($width_orig <= $width) {
      $width_orig = ($height / $height_orig) * $width_orig;
      $height_orig = $height;
    } else {
      $height_orig = ($width / $width_orig) * $height_orig;
      $width_orig = $width;
    }

    return $this->calcProportionalDimensions($width_orig, $height_orig, $width, $height);
  }

  /**
   * Retrieve information about the currently installed GD library
   *
   * @return array
   */
  protected function getInfo()
  {
    return gd_info();
  }

  /**
   * Transforma notação de cor hexa para array decimal
   *
   * @param string $color_hex
   * @return array
   */
  protected function getRgbFromHex($color_hex)
  {
    return array_map('hexdec', explode('|', wordwrap(substr($color_hex, 1), 2, '|', 1)));
  }



  /*

  New:
  - In version 2.1 (February 26 2007) Tom Bishop has done some important speed enhancements.
  - From version 2 (July 17 2006) the script uses the imageconvolution function in PHP
  version >= 5.1, which improves the performance considerably.


  Unsharp masking is a traditional darkroom technique that has proven very suitable for
  digital imaging. The principle of unsharp masking is to create a blurred copy of the image
  and compare it to the underlying original. The difference in colour values
  between the two images is greatest for the pixels near sharp edges. When this
  difference is subtracted from the original image, the edges will be
  accentuated.

  The Amount parameter simply says how much of the effect you want. 100 is 'normal'.
  Radius is the radius of the blurring circle of the mask. 'Threshold' is the least
  difference in colour values that is allowed between the original and the mask. In practice
  this means that low-contrast areas of the picture are left unrendered whereas edges
  are treated normally. This is good for pictures of e.g. skin or blue skies.

  Any suggenstions for improvement of the algorithm, expecially regarding the speed
  and the roundoff errors in the Gaussian blur process, are welcome.

  */

  protected function UnsharpMask($img, $amount, $radius, $threshold)    {

    ////////////////////////////////////////////////////////////////////////////////////////////////
    ////
    ////                  Unsharp Mask for PHP - version 2.1
    ////
    ////    Unsharp mask algorithm by Torstein H�nsi 2003-06.
    ////             thoensi_at_netcom_dot_no.
    ////               Please leave this notice.
    ////
    ///////////////////////////////////////////////////////////////////////////////////////////////



    // $img is an image that is already created within php using
    // imgcreatetruecolor. No url! $img must be a truecolor image.

    // Attempt to calibrate the parameters to Photoshop:
    if ($amount > 500)    $amount = 500;
    $amount = $amount * 0.016;
    if ($radius > 50)    $radius = 50;
    $radius = $radius * 2;
    if ($threshold > 255)    $threshold = 255;

    $radius = abs(round($radius));     // Only integers make sense.
    if ($radius == 0) {
      return $img; imagedestroy($img); break;        }
      $w = imagesx($img); $h = imagesy($img);
      $imgCanvas = imagecreatetruecolor($w, $h);
      $imgBlur = imagecreatetruecolor($w, $h);


      // Gaussian blur matrix:
      //
      //    1    2    1
      //    2    4    2
      //    1    2    1
      //
      //////////////////////////////////////////////////


      if (function_exists('imageconvolution')) { // PHP >= 5.1
        $matrix = array(
        array( 1, 2, 1 ),
        array( 2, 4, 2 ),
        array( 1, 2, 1 )
        );
        imagecopy ($imgBlur, $img, 0, 0, 0, 0, $w, $h);
        imageconvolution($imgBlur, $matrix, 16, 0);
      }
      else {

        // Move copies of the image around one pixel at the time and merge them with weight
        // according to the matrix. The same matrix is simply repeated for higher radii.
        for ($i = 0; $i < $radius; $i++)    {
          imagecopy ($imgBlur, $img, 0, 0, 1, 0, $w - 1, $h); // left
          imagecopymerge ($imgBlur, $img, 1, 0, 0, 0, $w, $h, 50); // right
          imagecopymerge ($imgBlur, $img, 0, 0, 0, 0, $w, $h, 50); // center
          imagecopy ($imgCanvas, $imgBlur, 0, 0, 0, 0, $w, $h);

          imagecopymerge ($imgBlur, $imgCanvas, 0, 0, 0, 1, $w, $h - 1, 33.33333 ); // up
          imagecopymerge ($imgBlur, $imgCanvas, 0, 1, 0, 0, $w, $h, 25); // down
        }
      }

      if($threshold>0){
        // Calculate the difference between the blurred pixels and the original
        // and set the pixels
        for ($x = 0; $x < $w; $x++)    { // each row
          for ($y = 0; $y < $h; $y++)    { // each pixel

            $rgbOrig = ImageColorAt($img, $x, $y);
            $rOrig = (($rgbOrig >> 16) & 0xFF);
            $gOrig = (($rgbOrig >> 8) & 0xFF);
            $bOrig = ($rgbOrig & 0xFF);

            $rgbBlur = ImageColorAt($imgBlur, $x, $y);

            $rBlur = (($rgbBlur >> 16) & 0xFF);
            $gBlur = (($rgbBlur >> 8) & 0xFF);
            $bBlur = ($rgbBlur & 0xFF);

            // When the masked pixels differ less from the original
            // than the threshold specifies, they are set to their original value.
            $rNew = (abs($rOrig - $rBlur) >= $threshold)
            ? max(0, min(255, ($amount * ($rOrig - $rBlur)) + $rOrig))
            : $rOrig;
            $gNew = (abs($gOrig - $gBlur) >= $threshold)
            ? max(0, min(255, ($amount * ($gOrig - $gBlur)) + $gOrig))
            : $gOrig;
            $bNew = (abs($bOrig - $bBlur) >= $threshold)
            ? max(0, min(255, ($amount * ($bOrig - $bBlur)) + $bOrig))
            : $bOrig;



            if (($rOrig != $rNew) || ($gOrig != $gNew) || ($bOrig != $bNew)) {
              $pixCol = ImageColorAllocate($img, $rNew, $gNew, $bNew);
              ImageSetPixel($img, $x, $y, $pixCol);
            }
          }
        }
      }
      else{
        for ($x = 0; $x < $w; $x++)    { // each row
          for ($y = 0; $y < $h; $y++)    { // each pixel
            $rgbOrig = ImageColorAt($img, $x, $y);
            $rOrig = (($rgbOrig >> 16) & 0xFF);
            $gOrig = (($rgbOrig >> 8) & 0xFF);
            $bOrig = ($rgbOrig & 0xFF);

            $rgbBlur = ImageColorAt($imgBlur, $x, $y);

            $rBlur = (($rgbBlur >> 16) & 0xFF);
            $gBlur = (($rgbBlur >> 8) & 0xFF);
            $bBlur = ($rgbBlur & 0xFF);

            $rNew = ($amount * ($rOrig - $rBlur)) + $rOrig;
            if($rNew>255){$rNew=255;}
            elseif($rNew<0){$rNew=0;}
            $gNew = ($amount * ($gOrig - $gBlur)) + $gOrig;
            if($gNew>255){$gNew=255;}
            elseif($gNew<0){$gNew=0;}
            $bNew = ($amount * ($bOrig - $bBlur)) + $bOrig;
            if($bNew>255){$bNew=255;}
            elseif($bNew<0){$bNew=0;}
            $rgbNew = ($rNew << 16) + ($gNew <<8) + $bNew;
            ImageSetPixel($img, $x, $y, $rgbNew);
          }
        }
      }
      imagedestroy($imgCanvas);
      imagedestroy($imgBlur);

      return $img;
  }
}