import React, {useEffect, useState} from "react";
import {HeadlineCard} from "../../components/headline/Card";
import {TrendingCard} from "../../components/trending/Card";
import {LatestCard} from "../../components/latest/Card";
import {useNewsAPI} from "../../services/news/use-news-api";
import {NewsType} from "../../types/news";

export const Feeds = () => {
    const [news, setNews] = useState<Awaited<Array<NewsType>>>([])

    const {getMyFeeds} = useNewsAPI()
    useEffect(() => {
        (async () => {
            const newsData = await getMyFeeds()
            if (newsData && newsData.length) {
                setNews(newsData)
            }
        })();
    }, []);

    return (
        <div className="cstm-container active-cont">
            <nav className="navbar top-navbar mobile-menu fixed-top bg-white">
                <a className="btn border-0" id="menu-btn">≡</a>
            </nav>

            <div className="row mb-4">
                <div className="col-md-8">
                    <div className="posts-area headlines-post">
                        <h2>Headlines</h2>
                        <div className="row">
                            <div className="mb-3 col-md-12">
                                {
                                    (news && news.length) ?
                                        <HeadlineCard
                                            title={news[0]?.title}
                                            description={news[0]?.description}
                                            author={news[0]?.author?.name}
                                            publishedAt={news[0]?.published_at}
                                            imageUrl={news[0].image_url}
                                        /> : ''
                                }
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-md-4">
                    <div className="posts-area trending-posts mb-3">
                        <h2>Trending</h2>
                        {
                            news && news.length ?
                                news.map( (article, index) => {
                                    if (index === 0 || index > 7) return
                                    return (
                                        <TrendingCard
                                            key={article.id}
                                            title={article.title}
                                            publishedAt={article.published_at}
                                            imageUrl={article.image_url}
                                        />
                                    )
                                }) : ''
                        }
                    </div>
                </div>
            </div>

            <div className="posts-area">
                <h2>Latest</h2>
                {
                    news && news.length ?
                        news.map( (article, index) => {
                            if (index < 7) return
                            return (
                                <LatestCard
                                    key={article.id}
                                    title={article.title}
                                    description={article.description}
                                    publishedAt={article.published_at}
                                    author={article?.author?.name}
                                    imageUrl={article.image_url}
                                />
                            )
                        }) : ''
                }
            </div>
        </div>
    )
}