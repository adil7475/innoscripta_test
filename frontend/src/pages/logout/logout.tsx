import {useEffect} from "react";
import {useNavigate} from "react-router-dom";
import {removeToken} from "../../services/authentication/authentication";
import {removePreferences} from "../../services/preferences/preferences-storage";
import {useResetRecoilState} from "recoil";
import {Categories, Sources, Authors} from "../../store/preferences/preferences";

export const Logout = () => {
    const navigate = useNavigate()
    const resetCategories = useResetRecoilState(Categories)
    useEffect(() => {
        //Remove Auth Token
        removeToken()
        //Remove Preferences
        removePreferences()
        resetCategories()
        //Navigate to login
        navigate('/login')
    }, []);

    return null
}