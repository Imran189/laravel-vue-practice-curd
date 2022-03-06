import { createRouter, createWebHistory} from "vue-router";

import Home from "../components/product/Home.vue";
import notFound from "../components/notFound.vue";
import New from "../components/product/new.vue";
import productEdit from "../components/product/edit.vue";


const router = createRouter({
    history: createWebHistory(),
    routes:[
        {
            path:'/',
            name:"Home",
            component:Home
        },
        {
            path:'/product/new',
            name:"New",
            component:New
        
        },
        {
            path: '/product/edit/:id',
            component: productEdit,
            props:true
        },
        {
            path: '/:pathMatch(.*)*',
            component: notFound
        }
    ]
})
export default router