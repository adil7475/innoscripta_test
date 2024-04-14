import React, {useEffect, useState} from "react";
import {NavLink} from "react-router-dom";

export const Navigation = () => {
    const [isActive, setIsActive] = useState(false)

    const toggleSidebar = () => {
        setIsActive(!isActive)
    }

    const handleResize = () => {
        if (window.innerWidth < 1171) {
            setIsActive(false)
        } else {
            setIsActive(true)
        }
    }

    useEffect(() => {
        handleResize(); // Call the function initially

        window.addEventListener('resize', handleResize); // Listen for window resize event

        return () => {
            window.removeEventListener('resize', handleResize); // Cleanup function to remove event listener
        };
    }, []);

    return (
        <>
            <nav className="navbar top-navbar mobile-menu fixed-top bg-white">
                <a className="btn border-0" id="menu-btn" onClick={() => setIsActive(!isActive)}>≡</a>
            </nav>
            <div
                className={`side-navbar d-flex flex-wrap flex-column justify-content-between ${isActive ? 'active-nav' : ''}`}
                id="sidebar">
                <div>
                    <h3>Innoscripta</h3>
                    <ul className="nav flex-column text-white w-100">
                        <li>
                            <NavLink to={`/app/feeds`} className="nav-link">My Feeds</NavLink>
                        </li>
                        <li>
                            <NavLink to={`/app/news`} className="nav-link">News</NavLink>
                        </li>
                        <li>
                            <NavLink to={`/app/preferences`} className="nav-link">Preferences</NavLink>
                        </li>
                    </ul>
                </div>
                <ul className="nav flex-column text-white w-100 pb-2">
                    <li>
                        <NavLink to={`/logout`} className="nav-link">Logout</NavLink>
                    </li>
                </ul>
            </div>
        </>
    )
}