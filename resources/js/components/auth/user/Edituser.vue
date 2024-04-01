<template>
    <div class="container mt-4">
        <h2>Sửa người dùng</h2>
        <form @submit.prevent="submitForm">
            <div class="form-group">
                <label for="name">Tên:</label>
                <input type="text" class="form-control" v-model="user.name" id="name" placeholder="Enter Name">
                <span class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" class="form-control" v-model="user.email" id="email" placeholder="Enter Email">
                <span class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="text" class="form-control" v-model="user.password" id="password"
                    placeholder="Enter Password">
                <span class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="role">Vai trò:</label>
                <select class="form-control" v-model="selectedRole" id="role">
                    <option v-for="(role, index) in roles" :key="index" :value="role.id">
                        {{ role.name }}
                    </option>
                </select>
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
        const user = ref({ id: null, name: '', email: '', password: '' });
        const roles = ref([]);
        const route = useRoute();
        const selectedRole = ref([]);
        user.value.id = route.params.id;

        const router = useRouter();
        const submitForm = async () => {
            const selectedRoleIds = selectedRole.value;
            console.log(selectedRoleIds);
            try {
                await axios.post(`/api/user/${user.value.id}`, { ...user.value, role_id: selectedRoleIds });
               
                router.push('/user');
            } catch (error) {
                console.error("Error submitting form:", error);
            }
        };

        const fetchRoles = async () => {
            try {
                const res = await axios.get('/api/roles');
                roles.value = res.data;
            } catch (error) {
                console.error('Error fetching roles:', error);
            }
        };

        onMounted(async () => {
            try {
                const response = await axios.get(`/api/user/${user.value.id}`);
                user.value.name = response.data.name;
                user.value.email = response.data.email;
                selectedRole.value = response.data.role_id;
            } catch (error) {
                console.error("Error", error);
            }
        });

        // Gọi fetchRoles để lấy danh sách vai trò khi component được mounted
        fetchRoles();

        return { user, roles, submitForm, selectedRole };
    }
}
</script>
