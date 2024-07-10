import { createRouter, createWebHistory } from "vue-router";

import invoiceIndex from '../components/invoices/index.vue';
import invoiceNew from '../components/invoices/new.vue';
import invoiceShow from '../components/invoices/show.vue';
import invoiceEdit from '../components/invoices/edit.vue';

import productIndex from '../components/products/index.vue';
import productNew from '../components/products/new.vue';
import productShow from '../components/products/show.vue';
import productEdit from '../components/products/edit.vue';

import customerIndex from '../components/customers/index.vue';
import customerNew from '../components/customers/new.vue';
import customerShow from '../components/customers/show.vue';
import customerEdit from '../components/customers/edit.vue';

import stockIndex from '../components/stocks/index.vue';
import notFound from '../components/NotFound.vue';

const routes = [
    {
        path:'/invoices',
        component: invoiceIndex
    },
    {
        path:'/invoice/new',
        component: invoiceNew
    },
    {
        path:'/invoice/show/:id',
        component: invoiceShow,
        props: true
    },
    {
        path:'/invoice/edit/:id',
        component: invoiceEdit,
        props: true
    },
    {
        path:'/products',
        component: productIndex
    },
    {
        path:'/product/new',
        component: productNew
    },
    {
        path:'/product/show/:id',
        component: productShow,
        props: true
    },
    {
        path:'/product/edit/:id',
        component: productEdit,
        props: true
    },
    {
        path:'/customers',
        component: customerIndex
    },
    {
        path:'/customer/new',
        component: customerNew
    },
    {
        path:'/customer/show/:id',
        component: customerShow,
        props: true
    },
    {
        path:'/customer/edit/:id',
        component: customerEdit,
        props: true
    },
    {
        path:'/stocks',
        component: stockIndex
    },
    {
        path: '/:pathMatch(.*)*',
        component: notFound
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router