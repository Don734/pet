<?php
namespace App\Services;

use App\Models\Category;
use App\Models\Client;
use App\Models\Handbook;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class YandexParserService
{
    /**
     * The API key for Yandex GeoSearch API.
     */
    const apiKey = '12543da0-b993-46d3-9a7f-e82ef5c7c1a9';

    /**
     * Get organizations based on search parameters.
     *
     * @param string $query The search query.
     * @param string $type The type of organizations to search for.
     * @param float $latitude The latitude coordinate.
     * @param float $longitude The longitude coordinate.
     * @param int $radius The search radius in meters.
     * @return array|null The array of organizations or null if not found.
     */
    public function getOrganizations($category)
    {
        $response = Http::get('https://search-maps.yandex.ru/v1/', [
            'text' => $category->name,
            'type' => 'biz',
            'lang' => 'ru_RU',
            'apikey' => self::apiKey,
            'results' => 40,
        ]);

        $organizations = $response->json();
        if (empty($organizations['features'])) {
            return null;
        }

        return $organizations['features'];
    }

    /**
     * Store data from organizations along with a category.
     *
     * @param array $organizations The array of organizations.
     * @param Category $category The category to associate.
     * @return void
     */
    public function storeData($organizations, $category)
    {
        if ($organizations !== null) {
            foreach ($organizations as $item) {

                $companyMetaData = $item['properties']['CompanyMetaData'] ?? null;

                if ($companyMetaData) {

                    // Извлечение данных о телефоне
                    $phones = $companyMetaData['Phones'] ?? [];
                    $phoneContact = collect($phones)->firstWhere('type', 'phone');
                    $phoneContact = $phoneContact ? ['value' => $phoneContact['formatted']] : null;
                    
                    $randomNumber = rand(10000, 99999); // Генерируем случайное число
                    $emailContact = ['value' => 'mail' . $randomNumber . '@example.com'];

                    $coordinates = $item['geometry']['coordinates'] ?? null;
                    $coordX = null;
                    $coordY = null;

                    if ($coordinates) {
                        $coordX = $coordinates[0]; // Долгота
                        $coordY = $coordinates[1]; // Широта
                    }

                    $data = [
                        'title' => $companyMetaData['name'] ?? '',
                        'description' => $item['properties']['description'] ?? '',
                        'address' => $companyMetaData['address'] ?? '',
                        'phone' => optional($phoneContact)['value'] ?? '',
                        'coord_x' => $coordX,
                        'coord_y' => $coordY,
                    ];

                    $data['slug'] = Str::slug($data['title']);

                    if (!empty($emailContact)) {

                        $existingUser = Client::where('email', $emailContact)->first();

                        $userData = [
                            'type' => 'partner',
                            'phone' => optional($phoneContact)['value'] ?? '',
                            'email' => optional($emailContact)['value'] ?? '',
                            'name' => 'user_' . Str::random(64),
                            'password' => Hash::make(Str::random(64)),
                            'confirmation_token' => Str::random(64),
                        ];

                        if (!$existingUser) {
                            $user = Client::create($userData);
                        }
                    

                        $handbook = Handbook::updateOrCreate($data);

                        $handbook->client()->associate($user)->save();
                        $handbook->category()->associate($category)->save();
                    }
                }
            }
        }
    }
}
