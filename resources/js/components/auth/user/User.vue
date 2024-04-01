<template>
    <div class="container">
        <h1>Danh sách người dùng</h1>
        <div class="sidebar">

        </div>
        <div class="main-content">

            <div class="user-list">
                <table class="centered-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Mật khẩu</th>
                            <th>created_at</th>
                            <th>updated_at</th>
                            <th>Vai trò</th>
                            <th>Quản lý</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" :key="user.id">
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>*********</td>
                            <td>{{ user.created_at }}</td>
                            <td>{{ user.updated_at }}</td>
                            <span v-for="role in user.roles" :key="role.id" class="badge badge-dark">{{ role.name ||
                            'Chưa có' }}</span>
                            <td class="btn-action">
                                <router-link class="edit-link btn" :to="{ name: 'useredit', params: { id: user.id } }">
                                    <i class="fas fa-edit"></i>
                                </router-link>
                                <button class="delete-button btn" @click="deleteuser(user.id)"><i
                                        class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
        <div class="sidebar">
        </div>
    </div>

</template>


<script>
import axios from 'axios';
export default {
    data() {
        return {
            users: '',
        }
    },
    methods: {
        async deleteuser(id) {
            try {
                await axios.delete(`api/user/${id}`);
                this.users = this.users.filter(user => user.id !== id);

            } catch (error) {
                console.error('Error deleting user:', error);
            }
        }
    },

    async created() {
        try {
            const response = await axios.get('/api/user');
            this.users = response.data;
            console.log(response)
        } catch (error) {
            console.error('Lỗi :', error);
        }
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

.user-list {
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

.delete-button {
    background-color: #ff0d00;
    color: #fff;
    border: none;
    border-radius: 4px;
    text-decoration: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.delete-button:hover {
    background-color: rgb(243, 80, 80);
    color: black;
    cursor: pointer;
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
</style>
