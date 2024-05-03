<?php
namespace App\Services;

use App\Models\Category;
use App\Models\Client;
use App\Models\Handbook;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class TwoGisParserService
{
    /**
     * The API key for 2GIS API.
     */
    const apiKey = '8cf19be9-e827-4dbd-b8d5-c03ded921c09';

    /**
     * Get the city ID based on its name.
     *
     * @param string $city The name of the city.
     * @return int|null The city ID or null if not found.
     */
    public function getCityId($city)
    {
        $response = Http::get('https://catalog.api.2gis.com/2.0/region/search', [
            'q' => $city,
            'key' => self::apiKey,
        ]);

        $cityApi = $response->json();

        if (empty($cityApi['result']['items'][0]['id'])) {
            return null;
        }

        return $cityApi['result']['items'][0]['id'];
    }

    /**
     * Get the rubric ID based on the city ID and rubric queue.
     *
     * @param int $cityId The ID of the city.
     * @param string $queue The rubric queue.
     * @return int|null The rubric ID or null if not found.
     */
    public function getRubricId($cityId, $queue)
    {
        $response = Http::get('https://catalog.api.2gis.com/2.0/catalog/rubric/search', [
            'region_id' => $cityId,
            'q' => $queue,
            'key' => self::apiKey,
        ]);

        $rubricApi = $response->json();

        if (empty($rubricApi['result']['items'][0]['id'])) {
            return null;
        }

        return $rubricApi['result']['items'][0]['id'];
    }

    /**
     * Get items based on rubric and city IDs.
     *
     * @param int $rubricId The ID of the rubric.
     * @param int $cityId The ID of the city.
     * @return array|null The array of items or null if not found.
     */
    public function getItems($rubricId, $cityId, $start_page)
{
    $currentPage = $start_page;
    $maxPages = 100; // Максимальное количество страниц для проверки
    $allItems = [];

    do {
        // Получаем информацию о текущей странице
        $response = Http::get('https://catalog.api.2gis.com/3.0/items', [
            'rubric_id' => $rubricId,
            'region_id' => $cityId,
            'radius' => '40000',
            'fields' => 'items.external_content,items.contact_groups,items.full_address_name,items.point',
            'key' => self::apiKey,
            'page' => $currentPage,
        ]);

        $itemsApi = $response->json();

        // Если нет элементов, выходим из цикла
        if (empty($itemsApi['result']['items'])) {
            break;
        }

        // Объединяем элементы с общим массивом
        $allItems = array_merge($allItems, $itemsApi['result']['items']);

        // Переходим к следующей странице
        $currentPage++;
    } while ($currentPage <= $maxPages);

    return $allItems;
}

    /**
     * Store data from items along with a category.
     *
     * @param array $items The array of items.
     * @param Category $category The category to associate.
     * @return void
     */
    public function storeData($items, $category)
    {
        foreach ($items as $item) {
            
            $phoneContact = collect($item['contact_groups'][0]['contacts'])->firstWhere('type', 'phone');
            $emailContact = collect($item['contact_groups'][0]['contacts'])->firstWhere('type', 'email');

            $data = [
                'title' => $item['name'] ?? '',
                'description' => $item['ads']['article'] ?? '',
                'address' => !empty($item['full_address_name']) ? $item['full_address_name'] : (!empty($item['address_name']) ? $item['address_name'] : ''),
                'phone' => optional($phoneContact)['value'] ?? '',
            ];

            if (!empty($item['point']['lat']) && !empty($item['point']['lon'])) {
                $data['coord_x'] = $item['point']['lon'];
                $data['coord_y'] = $item['point']['lat'];
            }

            $data['slug'] = Str::slug($data['title']);

            $images = collect($item['external_content'])->where('type', 'photo_album')
                ->pluck('main_photo_url')
                ->filter();

            $userData = [
                'type' => 'partner',
                'phone' => optional($phoneContact)['value'] ?? '',
                'email' => optional($emailContact)['value'] ?? '',
                'name' => optional($emailContact)['value'] ?? 'user_' . Str::random(64),
                'password' => Hash::make(optional($emailContact)['value'] ?? Str::random(64)),
                'confirmation_token' => Str::random(64),
            ];

            $user = Client::updateOrCreate(['email' => $userData['email'] ?? null], $userData);

            $handbook = Handbook::updateOrCreate($data);

            $images->each(function ($imageUrl) use ($handbook) {
                if (!empty($imageUrl)) {
                    $handbook->addMediaFromUrl($imageUrl)
                        ->toMediaCollection('images');
                }
            });

            $handbook->client()->associate($user)->save();
            $handbook->category()->associate($category)->save();
        }
    }
}
