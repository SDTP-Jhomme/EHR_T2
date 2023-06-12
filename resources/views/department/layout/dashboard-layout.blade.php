<title>@yield('title')</title>
<script>
    ELEMENT.locale(ELEMENT.lang.en);
    new Vue({
        el: '#app',
        data() {
            return {
                fullscreenLoading: true,
                teacher_data: [],
                backToHome:false,
            };
        },
        computed: {
        },
        created() {
            this.getID()
        },
        mounted() {
            this.getID();
            setTimeout(() => {
                this.fullscreenLoading = false
            }, 2000)
        },
        methods: {
            getID() {
                axios.post("{{route('department-fetch')}}")
                    .then(response => {
                        console.log(response);
                        if (response) {
                            this.teacher_data = response.data;
                            this.avatar = response.data[0].avatar;
                        } else {
                            console.error(500);
                        }
                })
                .catch(error => {
                    console.error(error.response);
                });
            },
            logout() {
                    this.fullscreenLoading = true
                    axios.post("{{route('departmentLogout')}}")
                        .then(response => {
                            // console.log(response);
                            if (response.data.message) {
                                localStorage.clear();
                                this.$notify({
                                    title: 'Success',
                                    message: 'Successfully logged out!',
                                    type: 'success',
                                    showClose: false
                                });
                                setTimeout(() => {
                                    window.location.href = "{{route('student-login')}}"
                                }, 1000)
                            }
                        })
                },
        },
    });
</script>