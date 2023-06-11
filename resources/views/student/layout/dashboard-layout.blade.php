<title>@yield('title')</title>
<script>
    ELEMENT.locale(ELEMENT.lang.en);
    new Vue({
        el: '#app',
        data() {
            return {
                fullscreenLoading: true,
                student_data: [],
                avatar:"",
                isAntigen: [],
                isCbc: [],
                isUrinalysis: [],
                isXray: [],
                isFecalysis: [],
                isVaccine: [],
                backToHome:false,
            };
        },
        computed: {
        },
        created() {
            this.getID()
            this.fetchCbc()
            this.fetch_Antigen()
            this.fetch_Urinalysis()
            this.fetch_Xray()
            this.fetch_Fecalysis()
            this.fetch_Vaccine()
        },
        mounted() {
            this.getID();
            setTimeout(() => {
                this.fullscreenLoading = false
            }, 2000)
        },
        methods: {
            fetchCbc() {
                axios.post("{{route('fetch_Cbc')}}")
                    .then(response => {
                        if (response) {
                            this.isCbc = response.data;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            fetch_Antigen() {
                axios.post("{{route('fetch_Antigen')}}")
                    .then(response => {
                        if (response) {
                            this.isAntigen = response.data;
                            console.log(this.isAntigen);
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            fetch_Urinalysis() {
                axios.post("{{route('fetch_Urinalysis')}}")
                    .then(response => {
                        if (response) {
                            this.isUrinalysis = response.data;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            fetch_Xray() {
                axios.post("{{route('fetch_Xray')}}")
                    .then(response => {
                        if (response) {
                            this.isXray = response.data;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            fetch_Fecalysis() {
                axios.post("{{route('fetch_Fecalysis')}}")
                    .then(response => {
                        if (response) {
                            this.isFecalysis = response.data;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            fetch_Vaccine() {
                axios.post("{{route('fetch_Vaccine')}}")
                    .then(response => {
                        if (response) {
                            this.isVaccine = response.data;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            getID() {
                axios.post("{{route('student-fetch')}}")
                    .then(response => {
                        if (response) {
                            this.student_data = response.data;
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
                    axios.post("{{route('studentLogout')}}")
                        .then(response => {
                            // console.log(response);
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