<template>
    <div class="container mt-4">
        <h2>Sửa thông tin vai trò</h2>
        <form @submit.prevent="SubmitForm">
            <div class="form-group">
                <label for="roleName">Vai trò:</label>
                <input type="text" class="form-control" v-model="roles.name" id="roleName" placeholder="Enter Vai trò">
                <span class="text-danger">{{ errorMessage }}</span>
            </div>
            <div class="form-group">
                <label>Quyền:</label>
                <div class="form-check" v-for="(permission, index) in Permissions" :key="index">
                    <input type="checkbox" class="form-check-input" v-model="selectedPermissions"
                        :value="permission.id">
                    <label class="form-check-label">{{ permission.name }}</label>
                </div>
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
        const roles = ref({ id: null, name: '' });
        const Permissions = ref([]);
        const selectedPermissions = ref([]);
        const errorMessage = ref('');

        const route = useRoute();
        roles.value.id = route.params.id;

        const router = useRouter();

        const SubmitForm = async () => {
            try {
                const selectedPermissionIds = selectedPermissions.value;

                await axios.post(`/api/roles/${roles.value.id}/permissions`, { permission_ids: selectedPermissionIds });
                await axios.post(`/api/update/roles/${roles.value.id}`, roles.value);
                alert('Update thành công');
                router.push('/roles');
            } catch (error) {
                errorMessage.value = error.response.data.message;
            }
        };

        const fetchPermissions = async () => {
            try {
                const response = await axios.get('/api/permissions');
                Permissions.value = response.data;

                const roleResponse = await axios.get(`/api/roles/${roles.value.id}/permissions`);
                const rolePermissions = roleResponse.data;
                selectedPermissions.value = rolePermissions.map(permission => permission.id);
            } catch (error) {
                errorMessage.value = 'Error fetching permissions';
            }
        };

        onMounted(async () => {
            try {
                const response = await axios.get(`/api/roles/${roles.value.id}`);
                roles.value.name = response.data.name;
            } catch (error) {
                errorMessage.value = 'Error fetching role';
            }
            // Gọi fetchPermissions để lấy danh sách quyền
            fetchPermissions();
        });

        return { roles, Permissions, selectedPermissions, SubmitForm, errorMessage };
    }
}
</script>
