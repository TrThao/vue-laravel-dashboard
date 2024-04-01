<template>
    <div class="container">
        <h1>Tất cả bài viết</h1>
        <router-link class="button" to="/blog/create" v-if="getToken"> Tạo bài viết</router-link>
        <div class="row row-cols-1 row-cols-md-4">
            <div class="col mb-4" v-for="(blog, index) in blogs" :key="index">
                <div class="card">
                    <img :src="blog.image" class="card-img-top" alt="">
                    <div class="card-body">
                        <h5 class="card-title">{{ shortenedTitle(blog.title) }}</h5>
                        <p class="card-text">{{ shortenedContent(blog.content) }}</p>
                        <div>
                            <span v-if="categories.length > 0">
                                {{ getCategoryName(blog.category_id) }}
                            </span>
                            <router-link :to="{ name: 'blogedit', params: { id: blog.id } }"
                                class="btn btn-link text-primary">
                                <i class="fas fa-edit"></i>
                            </router-link>
                            <button class="delete-button btn" @click="deleteBlog(blog.id)"><i
                                    class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <router-view></router-view>
</template>

<script>
import { mapGetters } from 'vuex';
import axios from 'axios';
export default {
 
    computed: {
        ...mapGetters(['getToken'])
    },
    data() {

        return {
            blogs: [],
            categories: [],
        }
    },
    methods: {
        shortenedTitle(title) {
            if (title.length > 30) {
                return title.substring(0, 30) + '...';
            }
            return title;
        },
        shortenedContent(content) {
            if (content.length > 80) {
                return content.substring(0, 80) + '...';
            }
            return content;
        },
        async deleteBlog(id) {
            try {
                await axios.delete(`/api/blog/${id}`);
                this.blogs = this.blogs.filter(blog => blog.id !== id);
            } catch (error) {
                console.error('Error deleting blog:', error);
            }
        },
        async fetchData() {
            try {
                const response = await axios.get('/api/blog');
                console.log(response)
                this.blogs = response.data;
            } catch (error) {
                console.error('Error fetching blogs:', error);
            }
        },
        async fetchCategories() {
            try {
                const response = await axios.get('/api/category');
                console.log(response);
                this.categories = response.data;
            } catch (error) {
                console.error('Error fetching categories:', error);
            }
        },

        getCategoryName(categoryId) {
            const category = this.categories.find(cat => cat.id === categoryId);
            return category ? category.name : '';
        },
    },
    created() {
        this.fetchData();
        this.fetchCategories();

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
