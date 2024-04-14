type Link = {
    url: string|null,
    label: string,
    active: boolean
}
export type PaginationMetadata = {
    current_page: number,
    from: number,
    last_page: number,
    links: Link[],
    path: string,
    per_page: number,
    to: number,
    total: number
}