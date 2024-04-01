<template>
    <div class="container mt-4">
        <h2>Đổi mật khẩu</h2>
        <form @submit.prevent="SubmitForm">
            <div class="form-group">
                <label for="oldPassword">Mật khẩu cũ:</label>
                <input type="password" class="form-control" id="oldPassword" v-model="oldPassword"
                    placeholder="Nhập mật khẩu cũ" required>
                <span class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="newPassword">Mật khẩu mới :</label>
                <input type="password" class="form-control" id="newPassword" v-model="newPassword"
                    placeholder="Nhập mật khẩu mới" required>
                <span class="text-danger"></span>
            </div>
            <button type="submit" class="btn btn-primary">Hoàn tất</button>
        </form>
    </div>
</template>

<script>
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

export default {
    setup() {
        const user = ref(null);
        const route = useRoute();
        const router = useRouter();

        // Lấy ID của người dùng từ route parameter
        const userId = route.params.id;

        // Truy vấn dữ liệu của người dùng từ cơ sở dữ liệu
        axios.get(`/api/user/${userId}`)
            .then(response => {
                // Lưu thông tin của người dùng vào biến user
                user.value = response.data;
            })
            .catch(error => {
                console.error('Error:', error);
            });

        const SubmitForm = async () => {
            try {
                // Thực hiện logic để cập nhật mật khẩu
                // Sử dụng thông tin của người dùng từ biến user
                // Ví dụ: user.value.name, user.value.email, ...

                // Tiến hành gửi yêu cầu cập nhật mật khẩu tới server
                await axios.post(`/api/changepassword/user/${userId}`, {
                    // Dữ liệu cần gửi, ví dụ:
                    // old_password: oldPassword.value,
                    // new_password: newPassword.value
                });

                // Điều hướng người dùng sau khi hoàn tất
                router.push('/user');
            } catch (error) {
                console.error('Error:', error);
            }
        };

        return { user, SubmitForm };
    }
}

</script>
