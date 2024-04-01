<template>
    <Nav />
    <router-view></router-view>
</template>

<script>
// Đường dẫn tương đối đến tệp Navbar.vue
import Nav from '../pages/Navbar.vue'


export default {
    name: 'App',
    components: {
        Nav,

    },
}
</script>

<style scoped></style>
