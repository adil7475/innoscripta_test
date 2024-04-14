import React from 'react'
import { Outlet } from 'react-router-dom'
import {RecoilRoot} from 'recoil'
import {Navigation} from "../components/navigation/navigation";
import 'react-toastify/dist/ReactToastify.css';
import { ToastContainer } from "react-toastify";

const MainLayout = () => {
    return (
        <RecoilRoot>
            <Navigation />
            <Outlet />
            <ToastContainer />
        </RecoilRoot>
    )
}

export default MainLayout