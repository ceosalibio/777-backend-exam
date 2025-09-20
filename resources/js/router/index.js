import { createRouter, createWebHistory } from 'vue-router'
import Login from '../pages/Login.vue'
import Employees from '../pages/EmployeesIndex.vue'

const routes = [
  { path: '/login', component: Login, meta: { guest: true } },
  { path: '/employees', component: Employees, meta: { auth: true } },
  { path: '/:catchAll(.*)', redirect: '/employees' }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')
  if (to.meta.auth && !token) return next('/login')
  if (to.meta.guest && token) return next('/employees')
  next()
})

export default router
