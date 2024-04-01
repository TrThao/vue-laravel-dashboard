<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 mt-4">
                <p class="text-danger" v-if="error">{{ error }}</p>
                <form @submit.prevent="login">

                    <div class="form-group">
                        <label for="email">Email :</label>
                        <input type="email" class="form-control" id="email" v-model="form.email">
                    </div>
                    <div class="form-group">
                        <label for="c_password">Mật khẩu :</label>
                        <input type="password" class="form-control" id="password" v-model="form.password">
                    </div>
                    <button type=" submit" class="btn btn-primary">Login</button>
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
            email: '',
            password: '',
        });
        let error = ref('')
        const login = async () => {
            await axios.post('/api/login', form).then(res => {
                if (res.data.success) {
                    console.log(res);
                    store.dispatch('setToken', res.data.data.token)
                    alert('Đăng nhập thành công');
                    router.push({ name: 'Home' });
                }
                else {
                    error.value = res.data.message;
                }

            });
        }
        return {
            form,
            login,
            error
        };
    }
}
</script>