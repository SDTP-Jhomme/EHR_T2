<title>@yield('title')</title>

<script>
    ELEMENT.locale(ELEMENT.lang.en);
    new Vue({
        el: '#app',
        data() {
            return {
                type: "password",
                nurseIdentification: "",
                studentIdentification: "",
                email: "",
                password: "",
                userErr: "",
                passErr: "",
                fullscreenLoading: true,
                studentLogin: true,
                teacherLogin: false,
                nurseLogin: false,
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
            nurse_Login() {
                this.userErr = ""
                this.passErr = ""
                var data = new FormData()
                data.append("identification", this.nurseIdentification)
                data.append("password", this.password)
                axios.post("{{route('nurse-loginPost')}}", data)
                    .then(response => {
                        if (response.data.error) {
                            console.log(response.data.error);
                            this.userErr = response.data.adminErr
                            this.passErr = response.data.passErr
                            setTimeout(() => {
                                this.userErr = response.data.adminErr
                            }, 2000)
                            setTimeout(() => {
                                this.passErr = response.data.passErr
                            }, 2000)
                        } else {
                            this.$notify({
                                title: 'Success',
                                message: 'Successfully logged in!',
                                type: 'success',
                                position: 'top-left',
                                showClose: false
                            });
                            this.fullscreenLoading = true;
                            setTimeout(() => {
                                window.location.href = "{{route('nurse-dashboard')}}"
                            }, 1000)
                        }
                    })
                    .catch(error => {
                        // Handle error response
                        console.error(error.response.data);
                        // this.$message.error("Cannot submit the form. Please check the error(s).")
                        return false;
                    });
                // Simulate a loading delay
                setTimeout(() => {
                    this.fullscreenLoading = false;
                }, 2000);
            },
            teacher_Login() {
                this.userErr = ""
                this.passErr = ""
                var data = new FormData()
                data.append("email", this.email)
                data.append("password", this.password)
                data.append("remember", this.remember)  
                axios.post("{{route('department-loginPost')}}", data)
                    .then(response => {
                        if (response.data.error) {
                            this.userErr = response.data.userErr
                            this.passErr = response.data.passErr
                            setTimeout(() => {
                                this.userErr = response.data.userErr
                            }, 2000)
                            setTimeout(() => {
                                this.passErr = response.data.passErr
                            }, 2000)
                        } else {
                            this.$notify({
                                title: 'Success',
                                message: 'Successfully logged in!',
                                type: 'success',
                                position: 'top-left',
                                showClose: false
                            });
                            setTimeout(() => {
                                window.location.href = "{{route('department-dashboard')}}"
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
            student_Login() {
                this.userErr = ""
                this.passErr = ""
                var data = new FormData()
                data.append("identification", this.studentIdentification)
                data.append("password", this.password)
                data.append("remember", this.remember)  
                axios.post("{{route('student-loginPost')}}", data)
                    .then(response => {
                        if (response.data.error) {
                            this.userErr = response.data.studentErr
                            this.passErr = response.data.passErr
                            setTimeout(() => {
                                this.userErr = response.data.studentErr
                            }, 2000)
                            setTimeout(() => {
                                this.passErr = response.data.passErr
                            }, 2000)
                        } else {
                            this.$notify({
                                title: 'Success',
                                message: 'Successfully logged in!',
                                type: 'success',
                                position: 'top-left',
                                showClose: false
                            });
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