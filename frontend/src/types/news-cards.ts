export type TrendingNewsCardType = {
    title: string,
    publishedAt: string,
    imageUrl: string | null
}

export type HeadlineNewsCardType = TrendingNewsCardType & {
    author: string | undefined,
    description: string
}

export type LatestNewsCardType = HeadlineNewsCardType