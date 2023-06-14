<title>@yield('title')</title>
<script>
    ELEMENT.locale(ELEMENT.lang.en);
    new Vue({
         el: '#app',
        data() {
            return {
                student_data: [],
                fullscreenLoading: true,
                backToHome: false,
                avatar: "",
                id:"",
                error: true,
                loadButton: false,
                checkPass: false,
                currentPassword: "",
                newPassword: "",
                confirmPassword: "",
                currentPassErr: "",
                newPassErr: "",
                confirmPassErr: "",
                errors: true,
                checkIdentification: [],
                
            }
;
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
            if (window.location.pathname !== " /profile") {
                localStorage.clear()
                this.backToHome = true;
            }
        },
        methods: {
            getID() {
                axios.post("{{route('student-fetch')}}")
                    .then(response => {
                        if (response) {
                            this.student_data = response.data;
                            this.avatar = response.data[0].avatar;
                            this.id = response.data[0].id;
                            console.log(this.id);
                        } else {
                            console.error(500);
                        }
                })
                .catch(error => {
                    console.error(error.response);
                });
            },
            checkPassword() {
                this.currentPassErr = ""
                if (!this.currentPassword) {
                    this.currentPassErr = "Current password is required!"
                } else {
                    const checkPassword = new FormData();
                    checkPassword.append("id",  this.id)
                    checkPassword.append("currentPassword", this.currentPassword)
                    axios.post("{{route('checkPass')}}", checkPassword)
                        .then(res => {
                            if (res) {
                                console.log(res);
                                if (res.data.error) {
                                    this.currentPassErr = res.data.message;
                                } else {
                                    this.checkPass = true;
                                }
                            }
                        })
                }
            },
            updatePassword() {
                this.newPassErr = ""
                this.confirmPassErr = ""
                if (!this.newPassword) {
                    this.newPassErr = "New password is required!"
                } else {
                    if (this.newPassword.length < 8) {
                        this.newPassErr = "Password should atleast eight(8) characters!"
                    }
                    if (this.newPassword == this.currentPassword) {
                        this.newPassErr = "You have entered your current password!";
                    }
                }
                if (!this.confirmPassword) {
                    this.confirmPassErr = "Confirm password is required!"
                }
                if (this.newPassword && this.confirmPassword) {
                    if (this.newPassword.length < 8) {
                        this.newPassErr = "Password should atleast eight(8) characters!";
                        this.errors = true;
                        return;
                    } else {
                        this.errors = false;
                    }
                    if (this.newPassword != this.confirmPassword) {
                        this.confirmPassErr = "Password does not match!";
                        this.errors = true;
                    } else {
                        this.errors = false;
                    }
                    if (this.newPassword == this.currentPassword) {
                        this.newPassErr = "You have entered your current password!";
                        this.errors = true;
                    } else {
                    }
                }
                if (!this.errors) {
                    this.loadButton = true;
                    const newPassword = new FormData();
                    newPassword.append("id", this.id)
                    newPassword.append("newPassword", this.newPassword)
                    axios.post("{{route('updatePassword')}}", newPassword)
                        .then(res => {
                            if (res) {
                                setTimeout(() => {
                                    this.$message({
                                        message: 'Password has been updated successfully!',
                                        type: 'success'
                                    });
                                    this.currentPassword = ""
                                    this.newPassword = ""
                                    this.confirmPassword = ""
                                    this.checkPass = false;
                                    this.loadButton = false;
                                }, 500)
                            }
                        })
                }
            },
            resetPassword() {
                this.newPassword = ""
                this.confirmPassword = ""
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