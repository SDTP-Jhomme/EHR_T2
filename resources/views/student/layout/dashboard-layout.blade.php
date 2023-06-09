<title>@yield('title')</title>
<script>
    ELEMENT.locale(ELEMENT.lang.en);
    new Vue({
        el: '#app',
        data() {
            return {
                fullscreenLoading: true,
            };
        },
        created() {

        },
        mounted() {
            setTimeout(() => {
                this.fullscreenLoading = false
            }, 2000)
        },
        methods: {
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