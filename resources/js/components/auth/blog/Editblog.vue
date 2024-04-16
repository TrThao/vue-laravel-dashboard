<template>
    <div>
        <div class="container mt-4">
            <h2>Sửa bài viết</h2>
            <form @submit.prevent="submitForm">
                <div class="form-group">
                    <label for="title">Tiêu đề:</label>
                    <input type="text" class="form-control" v-model="blog.title" id="title" placeholder="Enter title">
                    <span class="text-danger">{{ errors.title }}</span>
                </div>
                <div class="form-group">
                    <label for="content">Nội dung:</label>
                    <textarea class="form-control" id="content" v-model="blog.content" rows="8"
                        placeholder="Enter content"></textarea>
                    <span class="text-danger">{{ errors.content }}</span>
                </div>
                <div class="form-group">
                    <label for="image">Ảnh:</label>
                    <div>
                        <img v-if="blog.image" class="image-preview" :src="'/' + blog.image" alt="Current Image">
                        <span v-else>No Image</span>
                    </div>
                    <input type="file" class="form-control-file" @change="onChange" id="image">
                    <span class="text-danger">{{ errors.image }}</span>
                </div>
                <div class="form-group">
                    <label for="category">Thuộc danh mục:</label>
                    <select class="form-control" v-model="blog.category_id" id="category">
                        <option v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Hoàn tất</button>
            </form>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRoute, useRouter } from 'vue-router';

export default {
    setup() {
        const blog = ref({ id: '', title: '', content: '', image: '', category_id: '' });
        const errors = ref({ title: '', content: '', image: '' });
        const categories = ref([]);

        const route = useRoute();
        const router = useRouter();

        const submitForm = async () => {
            // Clear previous errors
            errors.value = {};

            // Validate form fields
            if (!blog.value.title) {
                errors.value.title = 'Title is required';
            }
            if (!blog.value.content) {
                errors.value.content = 'Content is required';
            }

            // If there are errors, stop form submission
            if (errors.value.title || errors.value.content) {
                return;
            }

            // Prepare form data
            const formData = new FormData();
            formData.append('title', blog.value.title);
            formData.append('content', blog.value.content);
            formData.append('category_id', blog.value.category_id);
            if (blog.value.image) {
                formData.append('image', blog.value.image);
            }

            try {
                await axios.post(`/api/blog/${blog.value.id}`, formData);
                router.push('/blog');
            } catch (error) {
                console.error("Error submitting form:", error);
            }
        };

        const fetchCategories = async () => {
            try {
                const response = await axios.get('/api/category');
                categories.value = response.data; // Lưu danh sách categories vào biến categories
            } catch (error) {
                console.error('Error fetching categories:', error);
            }
        };

        const onChange = (event) => {
            const file = event.target.files[0];
            if (file) {
                blog.value.image = file;
            }
        };

        onMounted(async () => {
            try {
                const response = await axios.get(`/api/blog/${route.params.id}`);
                blog.value.id = response.data.id;
                blog.value.title = response.data.title;
                blog.value.content = response.data.content;
                blog.value.image = response.data.image;
                blog.value.category_id = response.data.category_id;
            } catch (error) {
                console.error("Error fetching blog data:", error);
            }

            // Fetch categories
            fetchCategories();
        });

        return { blog, errors, submitForm, onChange, categories };
    }
};

</script>

<style scoped>
.image-preview {
    width: 200px;
    height: auto;
    max-height: 200px;
    margin-bottom: 10px;
}
</style>