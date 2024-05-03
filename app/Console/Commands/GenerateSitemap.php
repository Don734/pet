<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Handbook;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically Generate an XML Sitemap';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $sitemap = Sitemap::create();

        // Home page
        $sitemap->add(
            Url::create(route('home'))
                ->setPriority(1)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        );

        // Categories index page
        $sitemap->add(
            Url::create(route('categories.index'))
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        );

        // Categories show pages
        $categories = Category::all();
        foreach ($categories as $category) {
            $sitemap->add(
                Url::create(route('categories.show', ['slug' => $category->slug]))
                    ->setPriority(0.6)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        }

        // Handbooks index page
        $sitemap->add(
            Url::create(route('handbooks.index'))
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        );

        // Handbooks show pages
        $handbooks = Handbook::all();
        foreach ($handbooks as $handbook) {
            $sitemap->add(
                Url::create(route('handbooks.show', ['id' => $handbook->id]))
                    ->setPriority(0.7)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
