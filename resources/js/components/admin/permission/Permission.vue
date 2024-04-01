<template>
    <div class="container">
        <h1>Danh sách vai trò</h1>
        <router-link to="/permissions/create">Thêm </router-link>
        <div class="permissions-list">
            <table class="centered-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên</th>
                        <th>Quản lí</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(permission, index) in permissions" :key="permission.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ permission.name }}</td>
                        <td class="btn-action">
                            <router-link class=" btn btn-link text-primary"
                                :to="{ name: 'permissionedit', params: { id: permission.id } }">
                                <i class="fas fa-edit"></i>
                            </router-link>
                            <button class="delete-button btn" @click="deletePermission(permission.id)"><i
                                    class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
    setup() {
        const permissions = ref([]);

        const deletePermission = async (id) => {
            try {
                await axios.delete(`/api/permissions/${id}`);
                permissions.value = permissions.value.filter(permission => permission.id !== id);
                alert('Xóa thành công');
            } catch (error) {
                console.error('Lỗi khi xóa vai trò:', error);
            }
        };

        onMounted(async () => {
            try {
                const response = await axios.get('/api/permissions');
                // console.log(response);
                permissions.value = response.data;
            } catch (error) {
                console.error('Lỗi :', error);
            }
        });

        return { permissions, deletePermission };
    },
};
</script>
<style scoped>
.edit-icon {
    color: #f2f7fb;
    margin-right: 5px;
    /* Khoảng cách giữa icon và chữ */
}

.delete-icon {
    color: #ff0d00;
    margin-left: 5px;
    /* Khoảng cách giữa icon và chữ */
}

/* Thêm các hiệu ứng hover cho icon */
.edit-icon:hover,
.delete-icon:hover {
    cursor: pointer;
}

.permissions-list {
    max-width: 1200px;
    margin: 0 auto;

    background-color: #f9f9f9;
    border-radius: 8px;
}

.centered-table {
    width: 100%;
    border-collapse: collapse;
}

.centered-table th,
.centered-table td {
    text-align: left;
    padding: 8px;
}

.centered-table th {
    background-color: #5a4747;
    color: #fff;
}

.centered-table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

.centered-table tbody tr:hover {
    background-color: #ddd;
}


.edit-link {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    text-decoration: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.edit-link:hover {
    background-color: #0056b3;
    color: #fff;
    cursor: pointer;
}

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
