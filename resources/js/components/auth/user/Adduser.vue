<template>
    <div class="container">
        <h1>Thêm người dùng</h1>
        <div class="row justify-content-center">

            <div class="col-sm-6 mt-4">
                <p class="text-danger" v-for="error in errors" :key="error">
                    <span v-for="err in error" :key="err">{{ err }}</span>
                </p>
                <form @submit.prevent="register">
                    <div class="form-group">
                        <label for="name">Tên :</label>
                        <input type="text" class="form-control" id="name" v-model="form.name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email :</label>
                        <input type="email" class="form-control" id="email" v-model="form.email">
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu :</label>
                        <input type="password" class="form-control" id="password" v-model="form.password">
                    </div>
                    <div class="form-group">
                        <label for="c_password">Confirm Password :</label>
                        <input type="password" class="form-control" id="c_password" v-model="form.c_password">
                    </div>
                    <button type=" submit" class="btn btn-primary">Hoàn tất</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router';
import { useStore } from 'vuex'

export default {
    setup() {
        const router = useRouter();
        const store = useStore();
        let form = reactive({
            name: '',
            email: '',
            password: '',
            c_password: ''
        });
        let errors = ref([])
        const register = async () => {
            await axios.post('/api/create/user', form).then(res => {
                if (res.data.success) {
                    store.dispatch('setToken', res.data.data.token);
                    router.push({ name: 'user' });
                }
            }).catch(e => {
                // errors.value = e.response.data.message;
                console.log(e)

            })
        }
        return {
            form,
            register,
            errors
        };
    }
}
</script>
<style scoped>
h1 {
    display: flex;
    justify-content: center;
}
</style>