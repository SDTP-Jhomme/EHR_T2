<title>@yield('title')</title>
<script>
    ELEMENT.locale(ELEMENT.lang.en);
    new Vue({
        el: '#app',
        data() {
            return {
                id: "",
                loadButton:false,
                changePass: false,
                checkPass: false,
                currentPassword: "",
                newPassword: "",
                confirmPassword: "",
                currentPassErr: "",
                newPassErr: "",
                confirmPassErr: "",
                errors: true,
                profile: false,
                fetchData:[],
                fullscreenLoading: true,
                teacher_data: [],
                backToHome:false,
                tableData: [],
                tableLoad: false,
                showAllData: false,
                page: 1,
                pageSize: 10,
                searchValue: "",
                searchNull: "",
                searchName: "",
                searchID: "",
                options: [{
                    value: 'identification',
                    label: 'Identifiaction No.'
                }, {
                    value: 'name',
                    label: 'Name'
                }],
                viewStudent:[],
                isCbc:[],
                viewDialog:false,
            };
        },
        watch:{
            searchValue(value) {
                if (value == "" || value == "identification" || value == "name") {
                    this.searchNull = '';
                    this.searchID = '';
                    this.searchName = '';
                }
            },
            showAllData(value) {
                if (value == true) {
                    this.page = 1;
                    this.pageSize = this.tableData.length
                } else {
                    this.pageSize = 10
                }
            },
        },
        computed: {
            usersTable() {
                return this.tableData
                    .filter((data) => {
                        return data.name.toLowerCase().includes(this.searchName.toLowerCase());
                    })
                    .filter((data) => {
                        return data.identification.toLowerCase().includes(this.searchID.toLowerCase());
                    })
                    .slice(this.pageSize * this.page - this.pageSize, this.pageSize * this.page)
            }
        },
        created() {
            this.getData()
            this.nurseData()
        },
        mounted() {
            setTimeout(() => {
                this.fullscreenLoading = false
            }, 2000)
            if (window.location.pathname !== " /medical-records/cbc") {
                localStorage.clear()
                this.backToHome = true;
            }
        },
        methods: {
            profileClose() {
                this.profile = false;
            },
            cancelUpdatePassword() {
                this.checkPass = false
                this.changePass = false
                this.newPassword = ""
                this.confirmPassword = ""
                this.currentPassword = ""
            },
            checkPassword() {
                this.currentPassErr = ""
                if (!this.currentPassword) {
                    this.currentPassErr = "Current password is required!"
                } else {
                    const checkPassword = new FormData();
                    checkPassword.append("id", this.id)
                    checkPassword.append("currentPassword", this.currentPassword)
                    axios.post("{{ route('checkNursePass') }}", checkPassword)
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
                        return;
                    } else {
                        this.errors = false;
                    }
                    if (this.newPassword == this.currentPassword) {
                        this.newPassErr = "You have entered your current password!";
                        this.errors = true;
                        return;
                    } else {}
                }
                if (!this.errors) {
                    this.loadButton = true;
                    const newPassword = new FormData();
                    newPassword.append("id", this.id)
                    newPassword.append("newPassword", this.newPassword)
                    axios.post("{{ route('updateNursePassword') }}", newPassword)
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
                                    this.changePass = false;
                                }, 500)
                            }
                        })
                }
            },
            resetPassword() {
                this.newPassword = ""
                this.confirmPassword = ""
            },
            nurseData() {
                axios.post("{{ route('nurse-fetch') }}")
                    .then(response => {
                        if (response) {
                            this.fetchData = response.data;
                            this.id = response.data[0].id;
                            console.log(this.id);
                        }
                    })
                    .catch(error => {
                        console.error(error.response);
                    });
            },
            handleView(index, row) {
                this.viewStudent = row;
                this.viewDialog = true;
            },
            closeViewDialog() {
                this.viewDialog = false;
            },
            changeColumn(selected) {
                this.searchNull = ""
                this.searchName = ""
                this.searchID = ""
            },
            setPage(value) {
                this.page = value
            },
            getData() {
                axios.post("{{route('fetchCbc')}}")
                    .then(response => {
                        if (response.data.error) {
                            this.tableData = [];
                        } else {
                            this.isCbc = response.data;
                            this.tableData = response.data;
                            console.log(this.tableData);
                            this.checkIdentification = response.data.map(res => res.identification);
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