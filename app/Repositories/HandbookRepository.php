<?php

namespace App\Repositories;


class HandbookRepository implements HandbookRepositoryInterface
{
    /**
     * Format handbook api data including images.
     *
     * @param \App\Models\Handbook $handbook
     * @return array
     */
    public function formatApiData($handbook)
    {
        $mediaUrls = $handbook->getMedia('images')->map(function ($image) {
            return $image->getUrl();
        });

        $handbookData = $handbook->toArray();
        $handbookData['images'] = $mediaUrls;

        unset($handbookData['media']);

        return $handbookData;
    }
}
