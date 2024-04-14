import {useAxios} from "../../hooks/use-axios";
import {useSetRecoilState} from "recoil";
import {loader} from "../../store/loader/loader";
import {serverErrors} from "../../store/server-error/server-error";
import {useNavigate} from "react-router-dom";
import {RegisterResponseModel} from "@/types/authentication";
import {setToken} from "../authentication/authentication";
import {setPreferences} from "../../services/preferences/preferences-storage";

export const useRegisterAPI = () => {
    const setLoader = useSetRecoilState(loader)
    const setServerErrors = useSetRecoilState(serverErrors)
    const navigate = useNavigate()
    const {post} = useAxios()

    const Register = async (name: string, email: string, password: string) => {
        try {
            setLoader(true)
            const data: RegisterResponseModel = await post(`/register`, {
                name,
                email,
                password
            })

            setToken(data.data.access_token)
            setPreferences(data.data.user.settings)
            navigate('/app/feeds')
        } catch (error: any) {
            if (error?.status === 422) {
                setServerErrors(error.data.errors)
            }
            console.error('Error: ', error)
        } finally {
            setLoader(false)
        }
    }

    return {Register}
}