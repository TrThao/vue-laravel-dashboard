<template>
    <div class="container">
        <div class="sidebar">
            <h1>Danh sách danh mục</h1>
            <router-link class="button" to="/category/create">Tạo danh mục</router-link>
        </div>
        <div class="main-content">
            <!-- Nội dung của cột chính -->
            <div class="category-list">
                <table class="centered-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên</th>
                            <th>Mô tả</th>
                            <th>Quản lí</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cate in categorys" :key="cate.id">
                            <td>{{ cate.id }}</td>
                            <td>{{ cate.name }}</td>
                            <td>{{ cate.description }}</td>
                            <td class="btn-action">
                                <router-link class="edit-link btn"
                                    :to="{ name: 'categoryedit', params: { id: cate.id } }"> <i class="fas fa-edit"></i>
                                </router-link>
                                <button class="delete-button btn" @click="deleteCategory(cate.id)"><i
                                        class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="sidebar">
            <!-- Nội dung của cột sidebar thứ hai -->
        </div>
    </div>
</template>


<script>
import axios from 'axios';
export default {
    data() {
        return {
            categorys: [],
        }
    },
    methods: {
        async deleteCategory(id) {
            try {
                await axios.delete(`api/category/${id}`);
                this.categorys = this.categorys.filter(category => category.id !== id);
            } catch (error) {
                console.error('Error deleting category:', error);
            }
        }
    },
    async created() {
        try {
            const response = await axios.get('/api/category');
            console.log(response)
            this.categorys = response.data;
        } catch (error) {
            console.error('Lỗi :', error);
        }
    }

}
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

.category-list {
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
