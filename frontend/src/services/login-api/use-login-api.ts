import { useAxios } from "../../hooks/use-axios";
import { useSetRecoilState } from "recoil";
import { useNavigate } from 'react-router-dom';
import { serverErrors } from "../../store/server-error/server-error";
import { loader as loading } from "../../store/loader/loader";
import {setToken} from "../authentication/authentication";
import {setPreferences} from "../preferences/preferences-storage";
import {LoginResponseModel} from "@/types/authentication";

export const useLoginAPI = () => {
    const setLoader = useSetRecoilState(loading)
    const setServerErrors = useSetRecoilState(serverErrors)
    const navigate = useNavigate()
    const { post } = useAxios()

    const login = async (email: string, password: string) => {
        try {
            setLoader(true)
            const data: LoginResponseModel = await post(`/login`, {
                'email': email,
                'password': password
            })
            setToken(data.data.access_token)
            setPreferences(data.data.user.settings)
            navigate('/app/feeds')
        } catch(error: any) {
            if (error?.status === 422) {
                setServerErrors(error.data.errors)
            }
            console.error('Error: ', error)
        } finally {
            setLoader(false)
        }
    }

    return { login }
}