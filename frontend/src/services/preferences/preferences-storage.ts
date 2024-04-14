type Preference = {
    id: number,
    name: string
}

type FormattedPreference = {
    value: number,
    label: string
}

export const setPreferences = (preferences: any): void => {
    const categories = formatData(preferences.categories)
    const sources = formatData(preferences.sources)
    const authors = formatData(preferences.authors)
    setCategories(categories)
    setSources(sources)
    setAuthors(authors)
}

export const updatePreferences = (categories: FormattedPreference[], sources: FormattedPreference[], authors: FormattedPreference[]) => {
    setCategories(categories)
    setSources(sources)
    setAuthors(authors)
}

export const removePreferences = () => {
    localStorage.removeItem('categories')
    localStorage.removeItem('sources')
    localStorage.removeItem('authors')
}

const setAuthors = (authors: FormattedPreference[]): void  => {
    localStorage.setItem('authors', JSON.stringify(authors))
}

const setCategories = (categories: FormattedPreference[]): void  => {
    localStorage.setItem('categories', JSON.stringify(categories))
}

const setSources = (sources: FormattedPreference[]): void  => {
    localStorage.setItem('sources', JSON.stringify(sources))
}

const formatData = (data: Preference[]): FormattedPreference[] => {
    return data.map((d: Preference) => ({
        value: d.id,
        label: d.name
    }))
}