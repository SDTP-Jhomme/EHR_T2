<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="<?php echo asset('storage/assets/css/style.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo asset('storage/assets/css/bootstrap.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo asset('storage/assets/fontawesome/css/all.min.css') ?>">
<title>@yield('title')</title>

<div id="app" v-loading.fullscreen.lock="fullscreenLoading">
    @yield('content')
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
                identification: "",
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
                data.append("identification", this.identification)
                data.append("password", this.password)
                axios.post("{{route('student-loginPost')}}", data)
                    .then(response => {
                        if (response.data.error) {
                            console.log(response.data.error);
                            this.userErr = response.data.studentErr
                            this.passErr = response.data.passErr
                            setTimeout(() => {
                                this.userErr = response.data.studentErr
                            }, 2000)
                            setTimeout(() => {
                                this.passErr = response.data.passErr
                            }, 2000)
                        } else {
                            setTimeout(() => {
                                window.location.href = "{{route('student-dashboard')}}"
                            }, 1000)
                        }
                    })
                    .catch(error => {
                        // Handle error response
                        console.error(error);
                        // this.$message.error("Cannot submit the form. Please check the error(s).")
                        return false;
                    });
                // Simulate a loading delay
                setTimeout(() => {
                    this.fullscreenLoading = false;
                }, 2000);
            },
        },
    });
</script>