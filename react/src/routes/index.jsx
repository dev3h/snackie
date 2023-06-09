import { createBrowserRouter } from "react-router-dom";
import Login from "../views/customer-views/auth-views/login";
import Register from "../views/customer-views/auth-views/register";
import { Home } from "../views/customer-views/app-views";

const router = createBrowserRouter([
    // #region Customer Routes
    {
        path: "/login",
        element: <Login />,
    },
    {
        path: "/register",
        element: <Register />,
    },
    {
        path: "/*",
        element: <Home />,
    },
    // #endregion
]);

export default router;
