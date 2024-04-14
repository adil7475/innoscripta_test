import React from "react";
import {NavLink} from "react-router-dom";

export const Navigation = () => {
    return (
        <div className="side-navbar active-nav d-flex flex-wrap flex-column justify-content-between" id="sidebar">
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
    )
}