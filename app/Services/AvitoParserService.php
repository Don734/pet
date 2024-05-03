<?php
namespace App\Services;

use App\Jobs\ParseAvitoPage;
use App\Models\Handbook;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class AvitoParserService
{
    const BASE_URL = 'https://www.avito.ru';

    public function parseAsync($category)
    {
        $response = Http::withOptions([
            'proxy' => 'http://ac86a295a7:586a9ac8c2@95.31.211.120:30890'
        ])->get(self::BASE_URL . $category->parse_link);
        $initPage = $response->body();
        $crawler = new Crawler($initPage);
        $pages = $crawler->filter('.styles-module-listItem_last-GI_us')->count() ? (int)$crawler->filter('.styles-module-listItem_last-GI_us')->text() : 0;
        for ($page = 1; $page <= $pages; $page++) {
            ParseAvitoPage::dispatch($page, $category);
        }
    }

    public function getCards(Crawler $crawler): array
    {
        $cardData = [];
        $crawler->filter('div[data-marker="item"]')->each(function (Crawler $element) use(&$cardData) {
            try {
            $outerId = $element->attr('data-item-id');
            $cardData[$outerId] = [
                'outer_id' => $outerId,
                'outer_link' => $element->filter('a')->attr('href'),
            ];
            $url = 'https://www.avito.ru' . $cardData[$outerId]['outer_link'];
            $cardResponse = Http::withOptions([
                'proxy' => 'http://ac86a295a7:586a9ac8c2@95.31.211.120:30890'
            ])->get($url);
            $cardPage = $cardResponse->body();
            $cardCrawler = new Crawler($cardPage);
            $this->getInnerData($cardCrawler, $cardData[$outerId]);
            } catch (\Exception $e) {
                return $cardData;
            }
        });
        return $cardData;
    }

    function scrapeImages($url) {
        $images = [];
        try {
            $browserFactory = new BrowserFactory();
            $browser = $browserFactory->createBrowser(['headless' => true]);
            $page = $browser->createPage();
            $page->navigate($url)->waitForNavigation();

            $imageSelectors = '.images-preview-previewImageWrapper-RfThd';
            $imageFrames = $page->querySelectorAll($imageSelectors);
            foreach ($imageFrames as $frame) {
                $frame->click();

                sleep(2);

                $imageStyle = $page->querySelector('.image-frame-cover-lQG1h')->getPropertyValue('background-image');
                preg_match('/url\((["\']?)(.*?)\1\)/', $imageStyle, $matches);
                $images[] = $matches[2];
            }
            $browser->close();

        }catch (\Exception $e){
            echo $e->getMessage();
        }

        return $images;
    }

    protected function getInnerData(Crawler $crawler, &$data)
    {
        $data['title'] = $crawler->filter("h1")->count() ? $crawler->filter("h1")->text() : '';
        $data['description'] = $crawler->filter("div[data-marker='item-view/item-description']")->count() ? $crawler->filter("div[data-marker='item-view/item-description']")->text() : '';
        $data['address'] = $crawler->filter("span[class='style-item-address__string-wt61A']")->count() ? $crawler->filter("span[class='style-item-address__string-wt61A']")->text() : '';
        $data['coord_x'] = $crawler->filter("div[data-map-type='dynamic']")->count() ? $crawler->filter("div[data-map-type='dynamic']")->attr('data-map-lon') : '';
        $data['coord_y'] = $crawler->filter("div[data-map-type='dynamic']")->count() ? $crawler->filter("div[data-map-type='dynamic']")->attr('data-map-lat') : '';
        $data['price'] = $crawler->filter("span[data-marker='item-view/item-price']")->count() ? $crawler->filter("span[data-marker='item-view/item-price']")->text() : '';

        if($crawler->filter('.desktop-1ky5g7j')->count()){
            $data['imageUrls'] = $crawler->filter('.desktop-1ky5g7j')->each(function (Crawler $node) {
                return $node->attr('src');
            });
        }
    }

    public function createHandbooks($data, $category)
    {
        $responseData = [];
        foreach ($data as $handbookData) {
            $handbookData['slug'] = Str::slug($handbookData['title']) . '_' . $handbookData['outer_id'];
            $handbook = Handbook::updateOrCreate(['outer_link' => $handbookData['outer_link']], $handbookData);
            $handbook->category()->associate($category)->save();
            if (!empty($handbookData['imageUrls'])){
                foreach ($handbookData['imageUrls'] as $imageUrl) {
                    if (!empty($imageUrl)) {
                        $handbook->addMediaFromUrl($imageUrl)
                            ->toMediaCollection('images');
                    }
                }
            }

            $responseData[] = $handbook->toArray();
        }

        return [
            'total_records_processed' => count($responseData),
            'message' => 'Данные успешно обработаны и сохранены.',
        ];
    }

}
