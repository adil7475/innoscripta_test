import React, {useEffect, useState} from "react";
import {LatestCard} from '../../components/latest/Card'
import {Button, Container, Form, Input, Row, Col} from "reactstrap";
import NewsImage from '../../assets/images/news.jpg'
import {usePreferences} from "../../services/preferences/preferences";
import {AsyncPaginate} from "react-select-async-paginate";
import {useNewsAPI} from "../../services/news/use-news-api";
import {NewsType} from "../../types/news";
import {PaginationMetadata} from "../../types/pagination-metadata";
import {toast} from "react-toastify";

export const News = () => {
    const [keyword, setKeyword] = useState('')
    const [category, setCategory] = useState(null)
    const [source, setSource] = useState(null)
    const [publishedAt, setPublishedAt] = useState('')
    const [news, setNews] = useState<Awaited<Array<NewsType>>>([])
    const [newsMetaData, setNewsMetaData] = useState<Awaited<PaginationMetadata>>()

    const {getCategories, getSources} = usePreferences()
    const {getNews} = useNewsAPI()

    useEffect(() => {
        ( async () => {
            const {data: newsData, meta: newsMetaData} = await getNews()
            if (newsData && newsData.length) {
                setNews(newsData)
                setNewsMetaData(newsMetaData)
            }
        })()
    }, []);

    const processQueryParams = (): string => {
        let query = []
        if (keyword && keyword.length) {
            query.push({name: 'keyword', value: keyword})
        }

        if (category) {
            // @ts-ignore
            query.push({name: 'categories', value: category?.value})
        }

        if (source) {
            // @ts-ignore
            query.push({name: 'sources', value: source?.value})
        }

        if (publishedAt && publishedAt.length) {
            query.push({name: 'publishedAt', value: publishedAt})
        }

        let queryStr = ''
        query.forEach((q: {name: string, value: string}, i: number) => {
            if (q.name === 'sources' || q.name === 'categories') {
                queryStr += `${q.name}[]=${q.value}`
            } else {
                queryStr += `${q.name}=${q.value}`
            }

            if (i >= 0 && i < query.length - 1) {
                queryStr += '&'
            }
        })

        return queryStr
    }

    const validate = () => {
        return !!(keyword.length || publishedAt.length || category || source)
    }

    const handleSearch = async (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault()
        if (! validate()) {
            toast.error('Please select any fields to search.')
        }
        const queryStr = processQueryParams()
        const {data: newsData, meta: newsMetaData} = await getNews(queryStr)
        if (newsData && newsData.length) {
            setNews(newsData)
            setNewsMetaData(newsMetaData)
        }
    }

    const handleLoadMore = async () => {
        // @ts-ignore
        const page = newsMetaData?.current_page + 1
        let queryParams = `page=${page}`
        const queryStr = processQueryParams()
        if (queryStr && queryStr.length) {
            queryParams += `&${queryParams}`
        }
        const {data: newsData, meta: metaData} = await getNews(`${queryParams}`)
        if (newsData && newsData.length) {
            setNews( (oldNews) => {
                return [
                    ...oldNews,
                    ...newsData
                ]
            })
            setNewsMetaData(metaData)
        }
    }

    return (
        <div className="cstm-container active-cont">
            <div className="banner-area" style={{backgroundImage: `linear-gradient(rgba(255, 255, 255, 0.25),rgba(0, 0, 0, 0.6),rgba(0, 0, 0, 0.9)), url(${NewsImage})`}}>
                <Container className="container">
                    <Form className="row g-3" onSubmit={(e) => handleSearch(e)}>
                        <div className="col-md-12">
                            <Input
                                type="text"
                                className="form-control"
                                placeholder="Search"
                                onChange={(e) => setKeyword(e.target.value)}
                            />
                        </div>
                        <div className="col-md-3">
                            <AsyncPaginate
                                id="categories"
                                loadOptions={getCategories}
                                onChange={(e) => setCategory(e)}
                                debounceTimeout={1000}
                                additional={{page: 1}}
                                value={category}
                                placeholder="Categories"
                                isClearable
                            />
                        </div>
                        <div className="col-md-3">
                            <AsyncPaginate
                                id="source"
                                loadOptions={getSources}
                                onChange={(e) => setSource(e)}
                                debounceTimeout={1000}
                                additional={{page: 1}}
                                value={source}
                                placeholder="Sources"
                                isClearable
                            />
                        </div>
                        <div className="col-md-3">
                            <Input
                                type='date'
                                name='date'
                                placeholder='Publish Date'
                                onChange={(e) => setPublishedAt(e.target.value)}
                            />
                        </div>
                        <div className="col-md-3 col-12 ms-auto">
                            <button type="submit" className="btn btn-primary cstm-btn py-2 w-100">
                                Search
                            </button>
                        </div>
                    </Form>
                </Container>
            </div>
            <div className="posts-area">
                {
                    news && news.length ?
                        news.map( (article) => {
                            return (
                                <LatestCard
                                    key={article.id}
                                    title={article.title}
                                    publishedAt={article.published_at}
                                    imageUrl={article.image_url}
                                    author={article?.author?.name}
                                    description={article.description}
                                />
                            )
                        }) : ''
                }
                {
                    newsMetaData && newsMetaData.current_page !== newsMetaData.last_page ?
                        <Row className='text-center mt-3'>
                            <Col lg={2} md={4} sm={4}  className='mx-auto'>
                                <Button type='button' className='cstm-btn w-100' onClick={handleLoadMore}>Load More</Button>
                            </Col>
                        </Row> : <h6 className='text-center'>No More News Available</h6>
                }
            </div>
        </div>
    )
}