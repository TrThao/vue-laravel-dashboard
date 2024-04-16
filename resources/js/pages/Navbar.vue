<template>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <router-link class="navbar-brand" :to="{ name: 'Home' }">Home</router-link>
        <ul class="navbar-nav ml-auto align-items-center">
            <li class="nav-item">
                <router-link class="text-white mr-2" :to="{ name: 'blog' }" v-if="!getToken">Bài Viết </router-link>
            </li>
            <li class="nav-item">
                <router-link class="text-white " :to="{ name: 'Register' }" v-if="!getToken">Đăng Kí</router-link>
            </li>
            <li class="nav-item">
                <router-link class="text-white ml-2" :to="{ name: 'Login' }" v-if="!getToken">Đăng Nhập</router-link>
            </li>


            <li class="nav-item dropdown" v-if="getToken">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Tài khoản
                </a>
                <div class="dropdown-menu custom-dropdown-menu " aria-labelledby="navbarDropdown">
                    <router-link class="dropdown-item" :to="{ name: 'Dashboard' }">Trang chủ</router-link>
                    <router-link class="dropdown-item" :to="{ name: 'changepass' }">Đổi mật khẩu</router-link>
                    <button class="dropdown-item btn btn-link" @click="logout">Đăng xuất</button>
                </div>
            </li>
        </ul>
    </nav>
</template>

<script>
import { mapGetters } from 'vuex';
import { useRouter } from 'vue-router'
import store from '../store/index'

export default {
    name: 'Navbar',
    computed: {
        ...mapGetters(['getToken'])
    },
    setup() {

        const router = useRouter();
        function logout() {

            store.dispatch('removeToken');
            router.push({ name: 'Home' })
        }

        return {
            logout
        }
    },
}
</script>

<style scoped>
.nav-link {
    position: relative;
}

.nav-item {
    display: flex;
    align-items: center;
}

.custom-dropdown-menu {
    position: absolute;
    margin-left: -50px;

}
</style>
