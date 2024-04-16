import { createRouter, createWebHistory } from 'vue-router';
import store from '../store/index.js'
import Home from '../pages/Home.vue';
import Login from '../pages/Login.vue';
import Register from '../pages/Register.vue';
import Dashboard from '../pages/Dashboard.vue';
import Blog from '../components/auth/blog/Blog.vue'
import CreateBlog from '../components/auth/blog/Addblog.vue'
import CreateCategory from '../components/auth/category/Addcategory.vue'
import Category from '../components/auth/category/Category.vue'
import Editcategory from '../components/auth/category/Editcategory.vue'
import Editblog from '../components/auth/blog/Editblog.vue'
import CreateUser from '../components/auth/user/Adduser.vue'
import User from '../components/auth/user/User.vue'
import Edituser from '../components/auth/user/Edituser.vue'
import changePass from '../components/auth/changePassword.vue'
import Roles from '../components/admin/role/Role.vue'
import EditRole from '../components/admin/role/EditRole.vue'
import CreateRoles from '../components/admin/role/AddRole.vue'
import Permissions from '../components/admin/permission/Permission.vue'
import Editpermission from '../components/admin/permission/Editpermission.vue'
import Createpermissions from '../components/admin/permission/Addpermiss.vue'



// import { useStore } from 'vuex'
//  const store = useStore();
const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: { requiresAuth: false }
  },
  {
    path: '/register',
    name: 'Register',
    component: Register,
    meta: { requiresAuth: false }
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: Dashboard,
    meta: { requiresAuth: true }
  },
  {
    path: '/blog',
    name: 'blog',
    component: Blog,

  },
    {
    path: '/blog/create',
    name: 'create_blog',
    component: CreateBlog,
    meta: { requiresAuth: true },
    permissions:'category-create'
  },
    {
    path: '/blog/edit/:id',
    name: 'blogedit',
    component: Editblog,
    meta: { requiresAuth: true }
  },
     {
    path: '/category/create',
    name: 'create_category',
    component: CreateCategory,
    meta: { requiresAuth: true }
  },
    {
    path: '/category',
    name: 'category',
    component: Category,
    meta: { requiresAuth: true }
  },
    {
    path: '/category/edit/:id',
    name: 'categoryedit',
    component: Editcategory,
    meta: { requiresAuth: true }
  },
   {
    path: '/user',
    name: 'user',
    component: User,
    meta: { requiresAuth: true }
  },
      {
    path: '/user/create',
    name: 'create_user',
    component: CreateUser,
    meta: { requiresAuth: true }
  },
     {
    path: '/user/edit/:id',
    name: 'useredit',
    component: Edituser,
    meta: { requiresAuth: true }
  },
{
    path: '/user/changepass',
    name: 'changepass',
    component: changePass,
    meta: { requiresAuth: true }
},
  {
    path: '/roles',
    name: 'roles',
    component: Roles,
    meta: { requiresAuth: true }
  },
   {
    path: '/role/edit/:id',
    name: 'rolesedit',
    component: EditRole,
    meta: { requiresAuth: true }
  },
       {
    path: '/roles/create',
    name: 'create_roles',
    component: CreateRoles,
    meta: { requiresAuth: true }
  },
   {
    path: '/permissions',
    name: 'permissions',
    component: Permissions,
    meta: { requiresAuth: true }
  },
    {
    path: '/permission/edit/:id',
    name: 'permissionedit',
    component: Editpermission,
    meta: { requiresAuth: true }
  },
  // {
  //   path: '/permissions',
  //   name: 'AdminOnlyRoute',
  //  component: Editpermission,
  //   meta: {
  //       requiresAuth: true
  //   }
  // },
   {
    path: '/permissions/create',
    name: 'create_permissions',
    component: Createpermissions,
    meta: { requiresAuth: true }
  },

];

const router = createRouter({
 history: createWebHistory(),
  routes
});



router.beforeEach((to, from, next) => {
  const user = store.getters.getUser;
  const token = store.getters.getToken;

  console.log(user);

  if (to.meta.requiresAuth && !token) {
    next({ name: 'Login' });
  } else {
    next();
  }
});

export default router;

