import { createWebHistory, createRouter} from "vue-router";
import home from './pages/home.vue';
import Login from "./views/auth/Login.vue";
import Dashboard from "./layouts/Dashboard.vue";
import Employee from "./layouts/Employee.vue";
import AddEmployee from "./layouts/AddEmployee.vue";
import EditEmployee from "./layouts/EditEmployee.vue";
import Company from "./layouts/Company.vue";
import AddCompany from "./layouts/AddCompany.vue";
import EditCompany from "./layouts/EditCompany.vue";
import store from './store'

const routes = [
    {
        path: '/',
        name: 'Home',
        component: home,
    },

    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta:{
            requiresAuth:false
        }
    },

    {
        path: '/dashboard',
        name: 'Dashboard',
        component: Dashboard,
        meta:{
            requiresAuth:true
        }
    },

    {
        path: '/employee',
        name: 'Employee',
        component: Employee,
        meta:{
            requiresAuth:true
        }
    },

    {
        path: '/employee/add',
        name: 'AddEmployee',
        component: AddEmployee,
        meta:{
            requiresAuth:true
        }
    },

    {
        path: '/employee/:id/edit',
        name: 'EditEmployee',
        component: EditEmployee,
        meta: {
            requiresAuth: true
        }
    },

    {
        path: '/company',
        name: 'Company',
        component: Company,
        meta:{
            requiresAuth:true
        }
    },

    {
        path: '/company/add',
        name: 'AddCompany',
        component: AddCompany,
        meta:{
            requiresAuth:true
        }
    },

    {
        path: '/company/:id/edit',
        name: 'EditCompany',
        component: EditCompany,
        meta: {
            requiresAuth: true
        }
    },

];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to,from) =>{
    if(to.meta.requiresAuth && store.getters.getToken == 0){
        return { name : 'Login'}
    }
    if(to.meta.requiresAuth == false && store.getters.getToken != 0){
        return { name : 'Dashboard'}
    }
})

export default router;
