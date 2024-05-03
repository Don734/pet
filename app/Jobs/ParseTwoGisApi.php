<?php

namespace App\Jobs;

use App\Services\TwoGisParserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\JsonResponse;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseTwoGisApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $city;
    protected $category;
    protected $start_page;

    /**
     * Create a new job instance.
     *
     * @param string $city The name of the city.
     * @param \App\Models\Category $category The category associated with the parsing.
     */
    public function __construct($city, $category, $start_page)
    {
        $this->city = $city;
        $this->category = $category;
        $this->start_page = $start_page + 1;
    }

    /**
     * Execute the job.
     *
     * @param TwoGisParserService $parserService The instance of the TwoGisParserService.
     * @return array|JsonResponse The response array or a JsonResponse in case of errors.
     */
    public function handle(TwoGisParserService $parserService)
    {
        $queue = $this->category->name;

        $cityId = $parserService->getCityId($this->city);
        if(empty($cityId)){
            return response()->json('Город не найден', 404);
        }

        $rubricId = $parserService->getRubricId($cityId, $queue);
        if(empty($rubricId)){
            return response()->json('Для указанного региона нет подходящих рубрик', 404);
        }

        $items = $parserService->getItems($rubricId, $cityId, $this->start_page);

        if(empty($items)){
            return response()->json('Для указанного региона нет объектов в указанной рубрике', 404);
        }

        $parserService->storeData($items, $this->category);

        return [
            'total_records_processed' => count($items),
            'message' => 'Данные успешно обработаны и сохранены.',
        ];
    }
}
