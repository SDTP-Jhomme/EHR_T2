<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="<?php echo asset('storage/assets/css/style.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo asset('storage/assets/css/bootstrap.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo asset('storage/assets/fontawesome/css/all.min.css') ?>">
<title>@yield('title')</title>

<div id="app">
    @yield('content')
    <div v-if="fullscreenLoading" class="fullscreen-loading">
        <div class="spinner-heart" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <span class="spinner-text">Please Wait...</span>
    </div>
</div>
<script src="<?php echo asset('storage/assets/js/bootstrap.bundle.js') ?>"></script>
<script src="<?php echo asset('storage/assets/js/main.js') ?>"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const app = new Vue({
        el: '#app',
        data() {
            return {
                type: "password",
                username: "",
                password: "",
                userErr: "",
                passErr: "",
                fullscreenLoading: true,
            };
        },
        mounted() {
            setTimeout(() => {
                this.fullscreenLoading = false
            }, 1000)
        },
        methods: {
            showPassword() {
                this.type = "text"
            },
            hidePassword() {
                this.type = "password"
            },
            login() {
                this.userErr = ""
                this.passErr = ""
                var data = new FormData()
                data.append("username", this.username)
                data.append("password", this.password)
                axios.post("{{route('admin-loginPost')}}", data)
                    .then(response => {
                        if (response.data.error) {
                            console.log(response.data.adminErr);
                            this.userErr = response.data.adminErr
                            this.passErr = response.data.passErr
                            setTimeout(() => {
                                this.userErr = response.data.adminErr
                            }, 2000)
                            setTimeout(() => {
                                this.passErr = response.data.passErr
                            }, 2000)
                        } else {
                            this.fullscreenLoading = true;
                            setTimeout(() => {
                                window.location.href = "{{route('admin-dashboard')}}"
                            }, 1000)
                        }
                    })
                // Simulate a loading delay
                setTimeout(() => {
                    this.fullscreenLoading = false;
                }, 2000);
            },
        },
    });
</script>