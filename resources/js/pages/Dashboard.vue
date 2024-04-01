<template>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar" class="bg-dark">
            <div class="sidebar-header">
            </div>
            <ul class="list-unstyled components">
                <li>
                    <router-link to="/dashboard"><i class="fa-solid fa-house"></i> Trang chủ</router-link>
                </li>
                <li>
                    <a href="#roleSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i
                            class="fa-solid fa-user"></i> Quản lí phân quyền
                    </a>
                    <ul class="collapse list-unstyled link-router" id="roleSubmenu">
                        <li>
                            <router-link to="/roles">Vai trò</router-link>
                        </li>
                        <li>
                            <router-link to="/permissions">Cho phép</router-link>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#userSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i
                            class="fa-solid fa-user"></i> Quản lí tài khoản
                    </a>
                    <ul class="collapse list-unstyled link-router" id="userSubmenu">
                        <li>
                            <router-link to="/user">Danh sách tài khoản</router-link>
                        </li>
                        <li>
                            <router-link to="/user/create">Tạo tài khoản</router-link>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#cateSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                            class="fa-solid fa-list"></i> Danh mục
                    </a>
                    <ul class="collapse list-unstyled link-router" id="cateSubmenu">
                        <li>
                            <router-link to="/category">Danh sách danh mục</router-link>
                        </li>
                        <li>
                            <router-link to="/category/create">Tạo danh mục</router-link>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#blogSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i
                            class="fa-solid fa-signs-post"></i> Blog</a>
                    <ul class="collapse list-unstyled link-router" id="blogSubmenu">
                        <li>
                            <router-link to="/blog">Posts List</router-link>
                        </li>
                        <li>
                            <router-link to="/blog/create">Create Blog</router-link>
                        </li>

                    </ul>
                </li>
            </ul>
        </nav>

    </div>
    <router-view></router-view>
</template>

<script>

export default {
    name: 'AdminDashboard',

}
</script>

<style scoped>
body {
    overflow-x: hidden;
}

.wrapper {
    display: flex;
    width: 100%;
}

#sidebar {
    min-width: 250px;
    max-width: 250px;
    min-height: 100vh;
    background-color: #343a40;
    color: #fff;
    transition: all 0.3s;
}

#sidebar.active {
    margin-left: -250px;
}

#content {
    width: 100%;
    transition: margin-left 0.3s;
}

#sidebar .sidebar-header {
    padding: 20px;
}

.link-router li {
    font-size: 13px;

}

#sidebar ul.components {
    padding: 20px 0;
}

#sidebar ul li a {
    padding: 10px 20px;
    display: block;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    /* Loại bỏ đường gạch chân */
}

#sidebar ul li a:hover {
    color: #fff;
    background-color: rgba(255, 255, 255, 0.1);
}

#sidebar ul li.active>a,
#sidebar a[aria-expanded="true"] {
    color: #fff;
    background-color: rgba(255, 255, 255, 0.2);
}

#sidebarCollapse {
    position: absolute;
    top: 10px;
    left: 230px;
    background-color: #343a40;
    border: none;
    color: white;
    cursor: pointer;
}

/* CSS cho liên kết "Blog" */
.blog-link {
    color: rgba(255, 255, 255, 0.8);
    padding: 10px 20px;
    display: block;
    text-decoration: none;
    /* Loại bỏ đường gạch chân */
}

.blog-link:hover {
    color: #fff;
    background-color: rgba(255, 255, 255, 0.1);
}
</style>