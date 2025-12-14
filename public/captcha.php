<?php
session_start();

$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
$captcha_text = '';
for ($i = 0; $i < 6; $i++) {
    $captcha_text .= $chars[rand(0, strlen($chars) - 1)];
}
$_SESSION['captcha'] = $captcha_text;

// Image parameters
$width = 220;
$height = 80;
$image = imagecreatetruecolor($width, $height);

// Background gradient
$start_color = [rand(200, 255), rand(200, 255), rand(200, 255)];
$end_color = [rand(150, 200), rand(150, 200), rand(150, 200)];
for ($y = 0; $y < $height; $y++) {
    $r = (int)($start_color[0] + ($end_color[0] - $start_color[0]) * ($y / $height));
    $g = (int)($start_color[1] + ($end_color[1] - $start_color[1]) * ($y / $height));
    $b = (int)($start_color[2] + ($end_color[2] - $start_color[2]) * ($y / $height));
    $line_color = imagecolorallocate($image, $r, $g, $b);
    imageline($image, 0, $y, $width, $y, $line_color);
}

// Noise lines and curves
for ($i = 0; $i < 8; $i++) {
    $line_color = imagecolorallocate($image, rand(50, 150), rand(50, 150), rand(50, 150));
    imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $line_color);

    $cx = [rand(0, $width), rand(0, $width), rand(0, $width), rand(0, $width)];
    $cy = [rand(0, $height), rand(0, $height), rand(0, $height), rand(0, $height)];
    for ($t = 0; $t <= 1; $t += 0.01) {
        $xt = (1 - $t) ** 3 * $cx[0] + 3 * (1 - $t) ** 2 * $t * $cx[1] + 3 * (1 - $t) * $t ** 2 * $cx[2] + $t ** 3 * $cx[3];
        $yt = (1 - $t) ** 3 * $cy[0] + 3 * (1 - $t) ** 2 * $t * $cy[1] + 3 * (1 - $t) * $t ** 2 * $cy[2] + $t ** 3 * $cy[3];
        imagesetpixel($image, (int)$xt, (int)$yt, $line_color);
    }
}

// Random dots
for ($i = 0; $i < 400; $i++) {
    $dot_color = imagecolorallocate($image, rand(100, 255), rand(100, 255), rand(100, 255));
    imagesetpixel($image, rand(0, $width), rand(0, $height), $dot_color);
}

// Fonts
$fonts = [
    __DIR__ . '/../app/fonts/arial.ttf',
    __DIR__ . '/../app/fonts/times.ttf',
    __DIR__ . '/../app/fonts/verdana.ttf'
];

$angle_range = 30;
$x = 15;
$font_size_range = [24, 32];

// Render letters on a temporary image for distortion
$letter_image = imagecreatetruecolor($width, $height);
imagecopy($letter_image, $image, 0, 0, 0, 0, $width, $height);
imagecolortransparent($letter_image, imagecolorallocate($letter_image, 0,0,0));

for ($i = 0; $i < strlen($captcha_text); $i++) {
    $char = $captcha_text[$i];
    $angle = rand(-$angle_range, $angle_range);
    $y = rand($height / 2 + 10, $height - 10);
    $font_size = rand($font_size_range[0], $font_size_range[1]);
    $text_color = imagecolorallocate($letter_image, rand(0, 120), rand(0, 120), rand(0, 120));
    $font_file = $fonts[array_rand($fonts)];
    imagettftext($letter_image, $font_size, $angle, $x, $y, $text_color, $font_file, $char);
    $x += rand(28, 36);
}

// Apply wave distortion
$distorted = imagecreatetruecolor($width, $height);
imagecopy($distorted, $image, 0, 0, 0, 0, $width, $height);
for ($x_pos = 0; $x_pos < $width; $x_pos++) {
    for ($y_pos = 0; $y_pos < $height; $y_pos++) {
        $offset_x = (int)(sin($y_pos / 10) * 5); // horizontal wave
        $offset_y = (int)(cos($x_pos / 10) * 5); // vertical wave
        $color = imagecolorat($letter_image, $x_pos, $y_pos);
        if (($x_pos + $offset_x) >=0 && ($x_pos + $offset_x) < $width && ($y_pos + $offset_y) >=0 && ($y_pos + $offset_y) < $height) {
            imagesetpixel($distorted, $x_pos + $offset_x, $y_pos + $offset_y, $color);
        }
    }
}

// Output distorted image
header("Content-Type: image/png");
imagepng($distorted);
imagedestroy($image);
imagedestroy($letter_image);
imagedestroy($distorted);
