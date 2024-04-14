import { useAxios } from "../../hooks/use-axios";
import { preferenceRequestParams } from "../../utils/utils";
import { updatePreferences } from '../../services/preferences/preferences-storage'
import { useSetRecoilState } from "recoil";
import {loader} from "../../store/loader/loader";
import {Categories, Authors, Sources} from "../../store/preferences/preferences";


export const usePreferences = () => {
    const { get, put } = useAxios()
    const setLoader = useSetRecoilState(loader)
    const setCategories = useSetRecoilState(Categories)
    const setSources = useSetRecoilState(Sources)
    const setAuthors = useSetRecoilState(Authors)

    const getCategories = async (search: string, loadedOptions: any, page: any) => {
        try {
            const {page: currentPage} = page
            const data: any = await get(`/categories?name=${search}&page=${currentPage}`)
            return {
                options: data.data.map((source: {id: number, name: string}) => ({
                    value: source.id,
                    label: source.name
                })),
                hasMore: currentPage < data.meta.last_page,
                additional: {
                    page: page + 1
                }
            }
        } catch (error) {
            throw error
        }
    }

    const getSources = async (search: string, loadedOptions: any, page: any) => {
        try {
            const {page: currentPage} = page
            const data: any = await get(`/sources?name=${search}&page=${currentPage}`)
            return {
                options: data.data.map((source: {id: number, name: string}) => ({
                    value: source.id,
                    label: source.name
                })),
                hasMore: currentPage < data.meta.last_page,
                additional: {
                    page: page + 1
                }
            }
        } catch (error) {
            throw error
        }
    }

    const getAuthors = async (search: string, loadedOptions: any, page: any) => {
        try {
            const {page: currentPage} = page
            const data: any = await get(`/authors?name=${search}&page=${currentPage}`)
            return {
                options: data.data.map((source: {id: number, name: string}) => ({
                    value: source.id,
                    label: source.name
                })),
                hasMore: currentPage < data.meta.last_page,
                additional: {
                    page: page + 1
                }
            }
        } catch (error) {
            throw error
        }
    }

    const updateSetting = async (category: any, source: any, author: any) => {
        try {
            setLoader(true)
            const categories = preferenceRequestParams(category)
            const sources = preferenceRequestParams(source)
            const authors = preferenceRequestParams(author)

            await put(`/settings`, {categories, authors, sources})

            //Update preference in localStorage
            updatePreferences(category, source, author)

            //update preference in recoil
            setCategories(category)
            setSources(source)
            setAuthors(author)
        } catch (error) {
            console.error('Error:', error)
        } finally {
            setLoader(false)
        }
    }

    return {
        getCategories,
        getSources,
        getAuthors,
        updateSetting
    }
}