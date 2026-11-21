<?php

namespace App\Support;

use App\Models\Service;

class ServiceData
{
    /**
     * @return array<string, mixed>
     */
    public static function toPublic(Service $service): array
    {
        return [
            'slug' => $service->slug,
            'title' => $service->title,
            'description' => $service->description,
            'icon' => $service->icon,
            'deliverables' => $service->deliverables ?? [],
            'benefits' => $service->benefits ?? [],
            'image' => $service->cover_url,
            'image_alt' => $service->image_alt ?? $service->title,
            'image_position' => $service->image_position ?? 'center',
        ];
    }

    /**
     * @param  iterable<int, Service>  $services
     * @return array<int, array<string, mixed>>
     */
    public static function collection(iterable $services): array
    {
        $result = [];

        foreach ($services as $service) {
            $result[] = self::toPublic($service);
        }

        return $result;
    }
}
