import {isAuthenticated} from "../../services/authentication/authentication";
import {Navigate, useLocation} from "react-router-dom";

export const ProtectedRoute = (props: any) => {
    const location = useLocation()

    if (! isAuthenticated()) {
        return (<Navigate to="/login" state={{from: location }} replace/>)
    }

    return props.children
}