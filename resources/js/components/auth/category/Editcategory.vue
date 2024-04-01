<template>
    <div class="container mt-4">
        <h2>Sửa danh mục</h2>
        <form @submit.prevent="SubmitForm">
            <div class="form-group">
                <label for="title">Danh mục:</label>
                <input type="text" class="form-control" v-model="category.name" id="title" placeholder="Enter Category">
                <span class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="content">Mô tả:</label>
                <textarea class="form-control" id="content" v-model="category.description" rows="8"
                    placeholder="Enter content"></textarea>
                <span class="text-danger"></span>
            </div>
            <button type="submit" class="btn btn-primary">Hoàn tất</button>
        </form>
    </div>
</template>
<script>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

export default {
    setup() {
        const category = ref({ id: null, name: '', description: '' });

        const route = useRoute();
        category.value.id = route.params.id;

        const router = useRouter();

        const SubmitForm = async () => {
            try {
                await axios.put(`/api/category/${category.value.id}`, category.value);
                router.push('/category');
            } catch (error) {
                console.log("Error", error);
            }
        };


        onMounted(async () => {
            try {
                const response = await axios.get(`/api/category/${category.value.id}`);
                console.log(response)
                category.value.name = response.data.name;
                category.value.description = response.data.description;
            } catch (error) {
                console.error("Error", error);
            }
        });

        return { category, SubmitForm };
    }
}
</script>