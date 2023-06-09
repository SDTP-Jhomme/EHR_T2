<title>@yield('title')</title>
<script>
    ELEMENT.locale(ELEMENT.lang.en);
    new Vue({
        el: '#app',
        data() {
            return {
                fullscreenLoading: true,
                student_data: [],
                avatar:""
            };
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
                axios.post("{{route('student-fetch')}}")
                    .then(response => {
                        if (response) {
                            this.student_data = response.data
                            console.log(this.student_data)
                        }
                })
                .catch(error => {
                    console.error(error.response);
                });
            },
            logout() {
                    this.fullscreenLoading = true
                    axios.post("{{route('studentLogout')}}")
                        .then(response => {
                            console.log(response);
                            if (response.data.message) {
                                localStorage.clear();
                                this.$notify({
                                    title: 'Success',
                                    message: 'Successfully logged out!',
                                    type: 'success'
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