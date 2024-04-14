import { createBrowserRouter } from 'react-router-dom'
import AnonymousLayout from '../layouts/anonymous-layout'
import MainLayout from '../layouts/main-layout'
import { Login } from '../pages/login/login'
import { Register } from '../pages/register/register'
import { Feeds } from '../pages/feeds/feeds'
import { News } from '../pages/news/news'
import { Setting } from '../pages/settings/setting'
import { Logout } from '../pages/logout/logout'
import {ProtectedRoute} from "../components/protected-routes/protected-route";

export const Router  = createBrowserRouter([
    {
        path: '/',
        element: <AnonymousLayout />,
        children: [
            {
                path: '/login',
                element: <Login />
            },
            {
                path: '/register',
                element: <Register />
            },
            {
                path: '/logout',
                element: <ProtectedRoute><Logout /></ProtectedRoute>
            }
        ]
    },
    {
        path: '/app',
        element: <MainLayout />,
        children: [
            {
                path: '/app/feeds',
                element: <ProtectedRoute><Feeds /></ProtectedRoute>
            },
            {
                path: '/app/news',
                element: <ProtectedRoute><News /></ProtectedRoute>
            },
            {
                path: '/app/settings',
                element: <ProtectedRoute><Setting /></ProtectedRoute>
            }
        ]
    }
])