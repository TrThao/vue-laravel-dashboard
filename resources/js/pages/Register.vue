<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 mt-4">
                <p class="text-danger" v-for="error in errors" :key="error">
                    <span v-for="err in error" :key="err">{{ err }}</span>
                </p>
                <form @submit.prevent="register">
                    <div class="form-group">
                        <label for="name">Name :</label>
                        <input type="text" class="form-control" id="name" v-model="form.name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address :</label>
                        <input type="email" class="form-control" id="email" v-model="form.email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password :</label>
                        <input type="password" class="form-control" id="password" v-model="form.password">
                    </div>
                    <div class="form-group">
                        <label for="c_password">Confirm Password :</label>
                        <input type="password" class="form-control" id="c_password" v-model="form.c_password">
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router';
import axios from 'axios'; // Import axios library
export default {
    setup() {
        const router = useRouter();
        let form = reactive({
            name: '',
            email: '',
            password: '',
            c_password: ''
        });
        let errors = ref([])
        const register = async () => {
            try {
                const res = await axios.post('/api/register', form);
                if (res.data.success) {
                    alert('Đăng kí thành công');
                    router.push({ name: 'Login' });
                }
            } catch (e) {

                console.log(e)
            }
        }
        return {
            form,
            register,
            errors
        };
    }
}
</script>
