<?php

namespace App\Http\Controllers;

use MoveMoveIo\DaData\Facades\DaDataAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\Models\City;

class CityController extends Controller
{
    public function setRegion($region)
    {
        $cities = City::get();
        return view('components.location-cities', ['region' => $region, 'cities' => $cities]);
    }

    public function setCity($city)
    {
        Cookie::queue('selected_city', $city, 60*24*7); // сохраним город на неделю

        return redirect()->back();
    }

    public function backToRegion()
    {
        $cities = City::get();
        return view('components.location-regions', ['cities' => $cities]);
    }

    public function geolocateExample(Request $request)
    {
        try {
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            if ($latitude && $longitude) {
                $dadata = DaDataAddress::geolocate($latitude, $longitude, 1);
    
                // Проверяем, существует ли ключ "suggestions" и не пуст ли он
                if (isset($dadata['suggestions']) && !empty($dadata['suggestions'])) {
                    // Получаем первый элемент массива "suggestions"
                    $firstSuggestion = $dadata['suggestions'][0];
                    // dd($firstSuggestion);
    
                    // Проверяем, существует ли ключ "data" в первом элементе
                    if (isset($firstSuggestion['data'])) {
                        // Получаем значение "city" из массива "data"
                        $city = $firstSuggestion['data']['city'];
                        $region = $firstSuggestion['data']['region'] . " " . $firstSuggestion['data']['region_type_full'];
                        $district = $firstSuggestion['data']['federal_district'];
                        // Проверка, существует ли город с таким именем
                        $existingCity = City::where('name', $city)->first();

                        if ($existingCity) {
                            // Город уже существует, используйте его
                            $selectedCity = $existingCity;
                        } else {
                            // Город не найден, создайте новый
                            $selectedCity = new City();
                            $selectedCity->name = $city;
                            $selectedCity->slug = Str::slug($city);
                            $selectedCity->region = $region;
                            $selectedCity->district = $district;
                            $selectedCity->save(); // Сохранение нового города в базе данных
                        }
    
                        Cookie::queue('selected_city', $selectedCity->slug, 60*24*7); // сохраним город на неделю

                        return redirect()->route('home');
                    } else {
                        return redirect()->route('home');
                    }
                } else {
                    return redirect()->route('home');
                }
            } else {
                return redirect()->route('home');
            }
        } catch (\Exception $e) {
            return redirect()->route('home');
        }
    }
}
