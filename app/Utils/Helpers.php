<?php

namespace App\Utils;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class Helpers
{
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
