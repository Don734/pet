<?php

namespace App\Jobs;

use App\Services\YandexParserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\JsonResponse;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseYandexApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $category;

    /**
     * Create a new job instance.
     *
     * @param string $query The search query.
     * @param string $type The type of organizations to search for.
     * @param float $latitude The latitude coordinate.
     * @param float $longitude The longitude coordinate.
     * @param int $radius The search radius in meters.
     * @param \App\Models\Category $category The category associated with the parsing.
     */
    public function __construct($category)
    {
        $this->category = $category;
    }

    /**
     * Execute the job.
     *
     * @param YandexParserService $parserService The instance of the YandexParserService.
     * @return array|JsonResponse The response array or a JsonResponse in case of errors.
     */
    public function handle(YandexParserService $parserService)
    {
        $items = $parserService->getOrganizations(
            $this->category
        );

        if (empty($items)) {
            return response()->json('Для указанных параметров поиска нет результатов', 404);
        }

        $parserService->storeData($items, $this->category);

        return [
            'total_records_processed' => count($items),
            'message' => 'Данные успешно обработаны и сохранены.',
        ];
    }
}
