<template>
    <div class="container mt-4">
        <h2>Thêm vai trò</h2>
        <form @submit.prevent="SubmitForm">
            <div class="form-group">
                <label for="title">Vai trò:</label>
                <input type="text" class="form-control" v-model="permissions.name" id="title"
                    placeholder="Enter Vai trò">
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
        const permissions = ref({ id: null, name: '' });

        const route = useRoute();
        permissions.value.id = route.params.id;

        const router = useRouter();

        const SubmitForm = async () => {
            try {
                await axios.post(`/api/update/permissions/${permissions.value.id}`, permissions.value);
                router.push('/permissions');
            } catch (error) {
                console.log("Error", error);
            }
        };


        onMounted(async () => {
            try {
                const response = await axios.get(`/api/permissions/${permissions.value.id}`);
                console.log(response)
                permissions.value.name = response.data.name;
            } catch (error) {
                console.error("Error", error);
            }
        });

        return { permissions, SubmitForm };
    }
}
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
