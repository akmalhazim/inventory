import InventoryCreate from './components/inventory/create'
import Login from './components/login'
import InventoryIndex from './components/inventory/index'
import InventoryManage from './components/inventory/manage'

export const routes = [
    {
        path: '/inventory/create',
        component: InventoryCreate,
        name: "Create Inventory",
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/auth/login',
        component: Login,
        name: "Login"
    },
    {
        path: '/inventory',
        component: InventoryIndex,
        name: "Inventory Index",
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/inventory/:id',
        component: InventoryManage,
        name: "Inventory Manage",
        meta: {
            requiresAuth: true
        }
    }

]