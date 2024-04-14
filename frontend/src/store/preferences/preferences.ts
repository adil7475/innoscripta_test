import { atom } from 'recoil'

export const Categories = atom({
    key: 'categories',
    default: JSON.parse(localStorage.getItem('categories')! ?? '[]')
})

export const Sources = atom({
    key: 'sources',
    default: JSON.parse(localStorage.getItem('sources')! ?? '[]')
})

export const Authors = atom({
    key: 'authors',
    default: JSON.parse(localStorage.getItem('authors')! ?? '[]')
})