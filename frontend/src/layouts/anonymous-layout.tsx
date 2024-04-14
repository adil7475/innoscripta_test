import React from 'react';
import { Outlet } from 'react-router-dom';
import { RecoilRoot } from 'recoil';

function AnonymousLayout () {
    return (
        <RecoilRoot>
            <Outlet />
        </RecoilRoot>
    );
}

export default AnonymousLayout