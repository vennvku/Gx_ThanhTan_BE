<?php

namespace App\Utils;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class Helpers
{

    public static function slugify(string $string): string
    {
        $a = 'àáäâãåăæąçćčđďèéěėëêęğǵḧìíïîįłḿǹńňñòóöôœøṕŕřßşśšșťțùúüûǘůűūųẃẍÿýźžż·/_,:;';
        $b = 'aaaaaaaaacccddeeeeeeegghiiiiilmnnnnooooooprrsssssttuuuuuuuuuwxyyzzz------';
        
        // Replace Vietnamese accented characters
        $string = preg_replace('/[áàảạãăắằẳẵặâấầẩẫậ]/iu', 'a', $string);
        $string = preg_replace('/[éèẻẽẹêếềểễệ]/iu', 'e', $string);
        $string = preg_replace('/[íìỉĩị]/iu', 'i', $string);
        $string = preg_replace('/[óòỏõọôốồổỗộơớờởỡợ]/iu', 'o', $string);
        $string = preg_replace('/[úùủũụưứừửữự]/iu', 'u', $string);
        $string = preg_replace('/[ýỳỷỹỵ]/iu', 'y', $string);
        $string = preg_replace('/[đ]/iu', 'd', $string);
        
        // Convert to lowercase
        $string = strtolower($string);
        
        // Replace other special characters
        $string = preg_replace('/\s+/u', '-', $string);
        
        // Replace special characters based on $a and $b
        $string = strtr($string, $a, $b);
        
        // Replace & with 'and'
        $string = str_replace('&', '-and-', $string);
        
        // Remove all other characters that are not alphanumeric, underscore or hyphen
        $string = preg_replace('/[^\w\-]+/u', '', $string);
        
        // Replace multiple hyphens with a single hyphen
        $string = preg_replace('/-+/', '-', $string);
        
        // Trim hyphens from the start and end
        $string = trim($string, '-');
        
        return $string;
    }

    public static function formatPostTime($dateTime)
    {

        Carbon::setLocale('vi');
        
        $publishedAt = Carbon::parse($dateTime);
        $now = Carbon::now();
        $difference = $now->diffInMinutes($publishedAt);

        if ($difference < 1440) {
            return $publishedAt->diffForHumans();
        } else {
            $dayOfWeek = $publishedAt->isoFormat('dddd'); 
            return $publishedAt->format('H:i'). ' ' . ucfirst($dayOfWeek). ', ' . $publishedAt->format('d/m/Y');
        }
    }

    public static function generateId(string $prefix, int $id): string
    {
        $date = Carbon::now()->format('Ymd');

        return sprintf('%s_%s_%06d', $prefix, $date, $id);
    }

    public static function generateImagePath(string $path): string
    {
        return rtrim(config('aws_config.base_url'), '/') . '/storage/uploads/' . $path;
    }

    /**
     * @param Collection $images
     * @return array<string>
     */
    public static function getImageList(Collection $images): array
    {
        $images = $images->map(static function ($image) {
            return self::generateImagePath($image['image_url']);
        })->toArray();

        if (count($images) === 0) {
            $images = [self::generateImagePath(Constants::DEFAULT_IMAGE_PATH)];
        }

        return $images;
    }
}
