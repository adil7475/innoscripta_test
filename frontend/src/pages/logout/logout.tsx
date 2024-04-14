import React, {useEffect} from "react";
import {removeToken} from "../../services/authentication/authentication";
import {useNavigate} from "react-router-dom";
import {removePreferences} from "../../services/preferences/preferences-storage";

export const Logout = () => {
    const navigate = useNavigate()

    useEffect(() => {
        removeToken()
        removePreferences()
        navigate('/login')
    }, []);

    return null
}