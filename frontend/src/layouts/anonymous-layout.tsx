import React, {useEffect} from 'react';
import {Outlet, useNavigate} from 'react-router-dom';
import { RecoilRoot } from 'recoil';

function AnonymousLayout () {
    const navigate = useNavigate()
    useEffect(() => {
        navigate('/login')
    }, []);

    return (
        <RecoilRoot>
            <Outlet />
        </RecoilRoot>
    );
}

export default AnonymousLayout