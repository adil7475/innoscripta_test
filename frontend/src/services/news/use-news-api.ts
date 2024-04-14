import {useRecoilValue, useSetRecoilState} from "recoil";
import {loader} from "../../store/loader/loader";
import {useAxios} from "../../hooks/use-axios";
import {NewsType} from "../../types/news";

export const useNewsAPI = () => {
    const setLoader = useSetRecoilState(loader)
    const {get} = useAxios()

    const getMyFeeds = async () => {
        try {
            setLoader(true)
            const data: any = await get(`/feeds`)
            return data.data
        } catch (error) {
            throw error
        } finally {
            setLoader(false)
        }
    }

    const getNews = async (params: string = ''): Promise<any>  => {
        try {
            let url = '/news'
            if (params.length) {
                url = `/news?${params}`
            }
            setLoader(true)
            return await get(url)
        } catch (error) {
            throw error
        } finally {
            setLoader(false)
        }
    }

    return {
        getNews,
        getMyFeeds
    }
}