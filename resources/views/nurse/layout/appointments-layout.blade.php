@include('nurse/imports/head')
<title>@yield('title')</title>
<div id="app">
    <div v-if="fullscreenLoading" class="fullscreen-loading">
        <div class="spinner-heart" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <span class="spinner-text">Loading...</span>
    </div>
@include('nurse/imports/nav')
    @yield('header')
    <!-- sidebar -->
    <div class="container-fluid page-wrapper">
@include('nurse/imports/sidebar')
        @yield('sidebar')
    </div>
</div>
@include('nurse/imports/body')

<script>
    // Vue.use(ElementUI, { locale: 'en' });
    // console.log(Vue);
    ELEMENT.locale(ELEMENT.lang.en);
    new Vue({
        el: '#app',
        data() {
            return {
                id: "",
                changePass: false,
                checkPass: false,
                currentPassword: "",
                newPassword: "",
                confirmPassword: "",
                currentPassErr: "",
                newPassErr: "",
                confirmPassErr: "",
                errors: true,
                fullscreenLoading: true,
                profile: false,
                fetchData:[],
                reqDialog:false,
                fullscreenLoading: true,
                page: 1,
                pageSize: 10,
                topLabel: "top",
                leftLabel: "left",
                direction: 'btt',
                loadButton: false,
                med_status: true,
                switch: false,
                showAllData: false,
                searchValue: "",
                searchNull: "",
                searchName: "",
                searchID: "",
                searchContact: "",
                options: [{
                    value: 'identification',
                    label: 'Identifiaction No.'
                }, {
                    value: 'name',
                    label: 'Name'
                }],
                tableData: [],
                tableLoad: false,
                reqCount: [],
                med_status:{
                    approved:'approved',
                    rejected:'rejected'
                }
            };
        },
        created() {
            this.approvedData()
            this.countReq()
            this.nurseData()
        },
        mounted() {
            setTimeout(() => {
                this.fullscreenLoading = false
            }, 1000)
        },
            watch: {
                searchValue(value) {
                    if (value == "" || value == "identification" || value == "name") {
                        this.searchNull = '';
                        this.searchID = '';
                        this.searchName = '';
                        this.searchContact = '';
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
                    .filter((data) => {
                        return data.med_status.toLowerCase().includes(this.searchContact.toLowerCase());
                    })
                    .slice(this.pageSize * this.page - this.pageSize, this.pageSize * this.page)
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
            changeColumn(selected) {
                this.searchNull = ""
                this.searchName = ""
                this.searchID = ""
                this.searchContact = ""
            },
            setPage(value) {
                this.page = value
            },
            handleSelectionChange(val) {
                this.multiID = Object.values(val).map(i => i.id)
            },
            filterHandler(value, row, column) {
                const property = column['property'];
                return row[property] === value;
            },
            approvedData() {
                axios.post("{{route('fetchRequest')}}")
                    .then(response => {
                        if (response.data.error) {
                            this.tableData = [];
                        } else {
                            this.tableData = response.data;
                        }
                    })
                    .catch(error => {
                        console.error(error.response);
                    });
            },
            countReq() {
                axios.post("{{route('countRequest')}}")
                    .then(response => {
                        this.reqCount = response.data;
                    })
                    .catch(error => {
                        console.error(error.response);
                    });
            },
            handleApproved(index, row) {
                var updateStatus = new FormData()
                updateStatus.append("id", row.id)
                updateStatus.append("med_status", "Approved")
                axios.post("{{route('approvedStatus')}}", updateStatus)
                    .then(response => {
                        if (response.data) {
                            this.loadButton = false;
                            this.tableLoad = true;
                            setTimeout(() => {
                                this.tableLoad = false;
                                if (response.data.med_status == "Approved") {
                                    this.$message({
                                        message: 'Student has been Rejected!',
                                        type: 'success'
                                    });
                                } else {
                                    this.$message({
                                        message: 'Student has been Approved!',
                                        type: 'success'
                                    });
                                }
                                window.location.reload('/nurse/appointments');
                            }, 1500)
                        }
                    })
            },
            handleRejected(index, row) {
                var updateStatus = new FormData()
                updateStatus.append("id", row.id)
                updateStatus.append("med_status", "Declined")
                axios.post("{{route('rejectedStatus')}}", updateStatus)
                    .then(response => {
                        if (response.data) {
                            this.loadButton = false;
                            this.tableLoad = true;
                            setTimeout(() => {
                                this.tableLoad = false;
                                if (response.data.med_status == "Declined") {
                                    this.$message({
                                        message: 'Student has been Aproved!',
                                        type: 'danger'
                                    });
                                } else {
                                    this.$message({
                                        message: 'Student has been Declined!',
                                        type: 'danger'
                                    });
                                }
                                window.location.reload('/nurse/appointments');
                            }, 1500)
                        }
                    })
            },
            logout() {
                this.fullscreenLoading = true
                axios.post("{{route('nurseLogout')}}")
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
            }
        },
    });
</script>