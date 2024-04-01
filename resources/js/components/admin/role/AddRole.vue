<template>
    <div class="container mt-4">
        <h2>Thêm vai trò</h2>
        <form @submit.prevent="submitPost">
            <div class="form-group">
                <label for="title">Vai trò:</label>
                <input type="text" class="form-control" v-model="form.name" id="title" placeholder="Enter Vai trò">
                <span class="text-danger"></span>
            </div>
            <button type="submit" class="btn btn-primary">Hoàn tất</button>
        </form>
    </div>
</template>
<script>
import { useRouter } from 'vue-router';
import axios from 'axios';
import { ref } from 'vue';

export default {
    name: 'RoleAdd',
    setup() {
        const router = useRouter();
        const form = ref({
            name: '',
        });
        const errors = ref({
            name: '',
        });

        const submitPost = async () => {
            errors.value = {};

            // Kiểm tra các trường dữ liệu
            if (!form.value.name) {
                errors.value.name = 'Name is required';
            }

            // Nếu có lỗi, dừng lại và không gửi request
            if (Object.keys(errors.value).length > 0) {
                return;
            }

            // Gửi dữ liệu thông qua axios
            try {
                const response = await axios.post('/api/create/roles', form.value);
                console.log('Role added:', response.data);
                alert('Vai trò đã được thêm thành công!');
                router.push({ name: 'roles' });
            } catch (error) {
                console.error('Lỗi khi thêm vai trò:', error);
                alert('Đã xảy ra lỗi khi thêm vai trò. Vui lòng thử lại sau.');
            }
        };

        return {
            form,
            errors,
            submitPost,
        };
    },
};
</script>
<style scoped>
.button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.button:hover {
    background-color: #0056b3;
}
</style>
