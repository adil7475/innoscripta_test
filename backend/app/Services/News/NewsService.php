<?php

namespace App\Services\News;

use App\Models\Author;
use App\Models\Category;
use App\Models\News;
use App\Models\Source;
use App\Models\User;
use App\Repositories\Baseline\BaselineRepository;
use App\Repositories\News\NewsRepository;
use App\Services\Baseline\BaselineService;

class NewsService extends BaselineService
{
    /**
     * Relationships
     *
     *  @var array
     * */
    public $relations = ['author', 'category', 'source'];

    /**
     * @param NewsRepository $repository
     */
    public function __construct(NewsRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param array $data
     * @return void
     */
    public function save(array $data): void
    {
        $newsToSave = [];
        foreach ($data as $news) {
            $source = null;
            $author = null;
            $category = null;
            if ($news['source']) {
                $source = Source::updateOrCreate(
                    ['name' => $news['source']['name']],
                    ['name' => $news['source']['name']]
                );
            }

            if ($news['author']) {
                $author = Author::updateOrCreate(
                    ['name' => $news['author']['name']],
                    ['name' => $news['author']['name']]
                );
            }

            if ($news['category']) {
                $category = Category::updateOrCreate(
                    ['name' => $news['category']['name']],
                    ['name' => $news['category']['name']]
                );
            }

            $newsToSave[] = array_merge($news['article'], [
                'source_id' => $source ? $source->id : null,
                'author_id' => $author ? $author->id : null,
                'category_id' => $category ? $category->id : null
            ]);
        }

        //Bulk insertion of News in the DB
        News::upsert($newsToSave, [
           'title',
           'description',
           'published_at',
           'author_id',
           'source_id',
           'category_id'
        ]);
    }

    public function getUserFeed(User $user)
    {
        $user->load('setting');

        $categories = $user->setting->categories;
        $sources = $user->setting->sources;
        $authors = $user->setting->authors;
        if (!is_null($categories)) {
            $categories = $categories->pluck('id');
        }

        if (!is_null($sources)) {
            $sources = $sources->pluck('id');
        }

        if (!is_null($authors)) {
            $authors = $authors->pluck('id');
        }

        $news = News::query()
            ->when($categories, function ($query) use ($categories) {
                $query->WhereIn('category_id', $categories);
            })
            ->when($sources, function ($query) use ($sources) {
                $query->orWhereIn('source_id', $sources);
            })
            ->when($authors, function ($query) use ($authors) {
                $query->orWhereIn('author_id', $authors);
            })
            ->get();

        return $news;
    }
}
