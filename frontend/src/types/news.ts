type Category = {
    id: number,
    name: string
}

type Author = {
    id: number,
    name: string
}

type Source = {
    id: number,
    name: string
}

export type NewsType = {
    id: number,
    title: string,
    description: string,
    category: Category | null,
    source: Source | null,
    author: Author | null,
    published_at: string,
    image_url: string | null
}