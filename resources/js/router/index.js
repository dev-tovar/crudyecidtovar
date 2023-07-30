import { createRouter, createWebHistory } from 'vue-router'
import AccountsComponent from '../components/AccountsComponent.vue'
import NewUserComponent from '../components/NewUserComponent.vue'

const routes = [
    {
        path: '/',
        name: 'home',
        component: AccountsComponent,
        children: [
            {
                path: 'new',
                name: 'new',
                props: true,
                meta: {
                    showModal: true
                },
                component: NewUserComponent,
            },
            {
                path: 'edit/:id',
                name: 'edit',
                props: true,
                meta: {
                    showModal: true
                },
                component: NewUserComponent,
            },
        ]
    }
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
});

export default router;