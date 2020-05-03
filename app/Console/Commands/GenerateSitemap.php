<?php

namespace App\Console\Commands;

use App\Article;
use App\ArticleCategory;
use App\ArticleSeries;
use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
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
    protected $description = 'Generate the sitemap';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sitemap = SitemapGenerator::create(config('app.url'))->getSitemap();

        $sitemap->add(
            Url::create(route('about'))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.9)
        );

        $sitemap->add(
            Url::create(route('contact'))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                ->setPriority(0.9)
        );

        $sitemap->add(
            Url::create(route('blog.articles.index'))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.7)
        );

        $sitemap->add(
            Url::create(route('blog.categories.index'))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.7)
        );

        $sitemap->add(
            Url::create(route('blog.series.index'))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.7)
        );

        Article::all()->each(function (Article $article) use ($sitemap): void {
            $url = Url::create($article->showRoute())
                ->setLastModificationDate($article->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(1);

            $sitemap->add($url);
        });

        ArticleCategory::all()->each(function (ArticleCategory $category) use ($sitemap): void {
            $url = Url::create($category->showRoute())
                ->setLastModificationDate($category->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.8);

            $sitemap->add($url);
        });

        ArticleSeries::all()->each(function (ArticleSeries $series) use ($sitemap): void {
            $url = Url::create($series->showRoute())
                ->setLastModificationDate($series->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.8);

            $sitemap->add($url);
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
