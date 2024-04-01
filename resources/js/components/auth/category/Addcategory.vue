<template>
    <div class="container mt-4">
        <h2>Thêm danh mục</h2>
        <router-link class="button" to="/category">Danh sách danh mục</router-link>
        <form @submit.prevent="submitPost">
            <div class="form-group">
                <label for="title">Danh mục:</label>
                <input type="text" class="form-control" v-model="form.name" id="title" placeholder="Enter Category">
                <span class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="content">Mô tả:</label>
                <textarea class="form-control" id="content" v-model="form.description" rows="8"
                    placeholder="Enter content"></textarea>
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
    name: 'Category',
    setup() {
        const router = useRouter();
        const form = ref({
            name: '',
            description: '',
        });
        const errors = ref({
            name: '',
            description: '',

        });

        const submitPost = async () => {
            errors.value = {};

            // Kiểm tra các trường dữ liệu
            if (!form.value.name) {
                errors.value.name = 'Name is required';
            }
            if (!form.value.description) {
                errors.value.description = 'Descripton is required';
            }

            // Nếu có lỗi, dừng lại và không gửi request
            if (Object.keys(errors.value).length > 0) {
                return;
            }

            // Tạo FormData để gửi dữ liệu và ảnh
            const formData = new FormData();
            formData.append('name', form.value.name);
            formData.append('description', form.value.description);


            // Gửi dữ liệu thông qua axios
            try {
                const response = await axios.post('/api/create/category', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });
                if (response.status === 201) {
                    alert('Danh mục đã được thêm thành công!');
                    router.push({ name: 'category' });
                }
            } catch (error) {
                console.error('Error submitting post:', error);
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
