type Source = {
    id: number,
    name: string
}
type Categories = {
    id: number,
    name: string
}
type Authors = {
    id: number,
    name: string
}
type Settings = {
    sources: Source[],
    categories: Categories[],
    authors: Authors[]
}

type User = {
    id: number,
    name: string,
    email: string,
    settings: Settings
}

export type LoginResponseModel = {
    data: {
        user: User
        access_token: string
    },
    message: string,
    status: 'success' | 'fail'
}

export type RegisterResponseModel = {
    data: {access_token: string},
    message: string,
    status: 'success' | 'fail'
}