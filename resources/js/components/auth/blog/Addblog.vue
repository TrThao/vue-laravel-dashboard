<template>
    <div>

        <div class="container mt-4">
            <h2>Tạo bài viết mới</h2>
            <router-link class="button" to="/blog">Danh sách bài viết</router-link>
            <form @submit.prevent="submitPost">
                <div class="form-group">
                    <label for="title">Tiêu đề:</label>
                    <input type="text" class="form-control" v-model="form.title" id="title" placeholder="Enter title">
                    <span class="text-danger" v-if="errors.title">{{ errors.title }}</span>
                </div>
                <div class="form-group">
                    <label for="content">Nội dung:</label>
                    <textarea class="form-control" v-model="form.content" id="content" rows="8"
                        placeholder="Enter content"></textarea>
                    <span class="text-danger" v-if="errors.content">{{ errors.content }}</span>
                </div>
                <div class="form-group">
                    <label for="image">Ảnh:</label>
                    <input type="file" class="form-control-file" @change="onChange" id="image">
                    <span class="text-danger" v-if="errors.image">{{ errors.image }}</span>
                </div>
                <div class="form-group">
                    <label for="category">thuộc danh mục:</label>
                    <select class="form-control" v-model="form.category_id" id="category">
                        <option v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                    <span class="text-danger" v-if="errors.category_id">{{ errors.category_id }}</span>
                </div>
                <button type="submit" class="btn btn-primary">Hoàn tất</button>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';

export default {
    name: 'BlogTemplate',

    setup() {
        const form = ref({
            title: '',
            content: '',
            image: null,
            category_id: '',
        });
        const errors = ref({
            title: '',
            content: '',
            image: '',
            category_id: '',
        });
        const router = useRouter();
        const categories = ref([]);

        const loadCategories = async () => {
            try {
                const response = await axios.get('/api/category');
                categories.value = response.data;
            } catch (error) {
                console.error('Error loading categories:', error);
            }
        };

        onMounted(() => {
            loadCategories();
        });

        const submitPost = async () => {
            errors.value = {};

            if (!form.value.title) {
                errors.value.title = 'Title is required';
            }
            if (!form.value.content) {
                errors.value.content = 'Content is required';
            }
            if (!form.value.image) {
                errors.value.image = 'Image is required';
            } else if (!['image/jpeg', 'image/png', 'image/gif'].includes(form.value.image.type)) {
                errors.value.image = 'Invalid image format. Please upload a JPEG, PNG, or GIF image.';
            }
            if (!form.value.category_id) {
                errors.value.category_id = 'Category is required';
            }

            if (Object.keys(errors.value).length > 0) {
                return;
            }

            const formData = new FormData();
            formData.append('title', form.value.title);
            formData.append('content', form.value.content);
            formData.append('image', form.value.image);
            formData.append('category_id', form.value.category_id);

            try {
                const response = await axios.post('/api/create/blog', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });
                if (response.status === 201) {
                    alert('Bài viết đã được thêm thành công!');
                    router.push({ name: 'blog' });
                }
            } catch (error) {
                console.error('Error submitting post:', error);
            }
        };

        const onChange = (event) => {
            form.value.image = event.target.files[0];
        };

        return {
            form,
            errors,
            submitPost,
            onChange,
            categories,
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


<!-- router.push({ name: 'Dashboard' }); -->