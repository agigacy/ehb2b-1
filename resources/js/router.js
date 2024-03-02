import Vue from 'vue'
import VueRouter from 'vue-router'
import AdminPage from './components/AdminPage.vue'
import AgentPage from './components/AgentPage.vue'
import TourPage from './components/TourPage.vue'
import TourDetail from './components/TourDetail.vue'
import TourPackage from './components/TourPackage.vue'
import LoginPage from './components/LoginPage.vue'
// import RegisterPage from './components/RegisterPage.vue'
import Home from './components/Home.vue'

Vue.use(VueRouter)

const routes = [
  { path: '/admin', component: AdminPage, meta: { requiresAuth: true }},
  { path: '/tour', component: TourPage, meta: { requiresAuth: true }},
  // { path: '/tour/:id', component: TourDetail, name:TourDetail meta: { requiresAuth: true }},
  { path: '/tourpackage', component: TourPackage, meta: { requiresAuth: true }},
  { path: '/agent', component: AgentPage, meta: { requiresAuth: true }},
  { path: '/login', component: LoginPage },
  // { path: '/register', component: RegisterPage },
  { path: '/', component: Home },
  {
    path: '/tours/:id',
    name: 'TourDetail',
    component: TourDetail,
  }
  // 更多的路由...
]

const router = new VueRouter({
  mode: 'history',
  routes // short for `routes: routes`
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // 这个路由需要用户登录
    if (!localStorage.getItem('token')) {
      // 用户没有登录，重定向到登录页面
      next({
        path: '/login',
        query: { redirect: to.fullPath }
      })
    } else {
      next() // 用户已经登录，允许访问
    }
  } else {
    next() // 这个路由不需要用户登录，总是允许访问
  }
})

export default router