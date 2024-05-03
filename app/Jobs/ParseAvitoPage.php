<?php

namespace App\Jobs;

use App\Services\AvitoParserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class ParseAvitoPage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $page;
    protected $category;

    public function __construct($page, $category)
    {
        $this->page = $page;
        $this->category = $category;
    }

    public function handle(AvitoParserService $avitoParserService)
    {
        $response = Http::withOptions([
            'proxy' => 'http://ac86a295a7:586a9ac8c2@95.31.211.120:30890'
        ])->get(AvitoParserService::BASE_URL . $this->category->parse_link . '?p=' . $this->page);
        $initPage = $response->body();
        $crawler = new Crawler($initPage);
        $parsedData = $avitoParserService->getCards($crawler);
        $avitoParserService->createHandbooks($parsedData, $this->category);
    }
}
