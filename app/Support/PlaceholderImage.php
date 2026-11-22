<?php

namespace App\Support;

class PlaceholderImage
{
    /**
     * Buat (sekali) gambar placeholder gradient JPEG yang deterministik dari
     * seed, lalu kembalikan path web-nya. Demo tidak lagi bergantung pada
     * CDN eksternal seperti picsum.photos saat dijalankan lokal.
     */
    public static function generate(string $seed, int $width = 800, int $height = 450): string
    {
        $filename = str($seed)->slug()->append('.jpg')->toString();
        $path = public_path('images/news/'.$filename);

        if (! is_file($path) && ! app()->runningUnitTests()) {
            if (! extension_loaded('gd')) {
                // Tanpa ekstensi GD, seeding tetap bisa dijalankan dengan fallback ke CDN.
                return "https://picsum.photos/seed/{$seed}/{$width}/{$height}";
            }

            $directory = dirname($path);
            if (! is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            static::writeGradient($path, $width, $height, $seed);
        }

        return '/images/news/'.$filename;
    }

    /**
     * Tulis gradient dua warna vertikal; warna diturunkan dari hash seed
     * sehingga tiap artikel punya gambar berbeda yang stabil antar-seeding.
     */
    private static function writeGradient(string $path, int $width, int $height, string $seed): void
    {
        $hue = hexdec(substr(md5($seed), 0, 2)) / 255;
        [$topR, $topG, $topB] = static::hslToRgb($hue, 0.58, 0.35);
        [$bottomR, $bottomG, $bottomB] = static::hslToRgb(fmod($hue + 0.15, 1.0), 0.45, 0.70);

        $image = imagecreatetruecolor($width, $height);

        for ($y = 0; $y < $height; $y++) {
            $ratio = $y / max($height - 1, 1);
            $color = imagecolorallocate(
                $image,
                (int) round($topR + ($bottomR - $topR) * $ratio),
                (int) round($topG + ($bottomG - $topG) * $ratio),
                (int) round($topB + ($bottomB - $topB) * $ratio),
            );

            imageline($image, 0, $y, $width, $y, $color);
        }

        imagejpeg($image, $path, 82);
        imagedestroy($image);
    }

    /**
     * Konversi HSL ke RGB (0-255 per channel).
     */
    private static function hslToRgb(float $hue, float $saturation, float $lightness): array
    {
        $chroma = (1 - abs(2 * $lightness - 1)) * $saturation;
        $x = $chroma * (1 - abs(fmod($hue * 6, 2) - 1));
        $m = $lightness - $chroma / 2;

        [$r, $g, $b] = match ((int) floor($hue * 6) % 6) {
            0 => [$chroma, $x, 0.0],
            1 => [$x, $chroma, 0.0],
            2 => [0.0, $chroma, $x],
            3 => [0.0, $x, $chroma],
            4 => [$x, 0.0, $chroma],
            default => [$chroma, 0.0, $x],
        };

        return [($r + $m) * 255, ($g + $m) * 255, ($b + $m) * 255];
    }
}
