<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleSeries;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected const SITEMAP_FILE_NAME = 'sitemap.xml';

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

    protected Sitemap $sitemap;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->sitemap = SitemapGenerator::create(config('app.url'))->getSitemap();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->addPagesToSitemap();
        $this->addBlogPagesToSitemap();
        $this->addBlogArticlesToSitemap();
        $this->addBlogCategoriesToSitemap();
        $this->addBlogSeriesToSitemap();

        $this->sitemap->writeToFile(
            public_path(self::SITEMAP_FILE_NAME)
        );
    }

    protected function addPagesToSitemap(): void
    {
        $this->sitemap->add(
            Url::create(route('about'))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.9)
        );

        $this->sitemap->add(
            Url::create(route('contact'))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                ->setPriority(0.9)
        );
    }

    protected function addBlogPagesToSitemap(): void
    {
        $this->sitemap->add(
            Url::create(route('blog.articles.index'))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.7)
        );

        if (ArticleCategory::hasPublished('articles')->count()) {
            $this->sitemap->add(
                Url::create(route('blog.categories.index'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.7)
            );
        }

        if (ArticleSeries::hasPublished('articles')->count()) {
            $this->sitemap->add(
                Url::create(route('blog.series.index'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.7)
            );
        }
    }

    protected function addBlogArticlesToSitemap(): void
    {
        Article::published()
            ->each(function (Article $article): void {
                $url = Url::create($article->showRoute())
                    ->setLastModificationDate($article->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(1);

                $this->sitemap->add($url);
            });
    }

    protected function addBlogCategoriesToSitemap(): void
    {
        ArticleCategory::hasPublished('articles')
            ->each(function (ArticleCategory $category): void {
                $url = Url::create($category->showRoute())
                    ->setLastModificationDate($category->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.8);

                $this->sitemap->add($url);
            });
    }

    protected function addBlogSeriesToSitemap(): void
    {
        ArticleSeries::hasPublished('articles')
            ->each(function (ArticleSeries $series): void {
                $url = Url::create($series->showRoute())
                    ->setLastModificationDate($series->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.8);

                $this->sitemap->add($url);
            });
    }
}
