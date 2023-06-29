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
                pendingReq:0,
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
                fetchData: [],
                reqDialog: false,
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
                searchStatus: "",
                searchYrandSect: "",
                options: [{
                    value: 'identification',
                    label: 'Identifiaction No.'
                }, {
                    value: 'name',
                    label: 'Name'
                }, {
                    value: 'med_status',
                    label: 'Medical Status'
                }, {
                    value: 'yearandsection',
                    label: 'Year and Section'
                }],
                tableData: [],
                tableLoad: false,
                reqCount: [],
                med_status: {
                    approved: 'approved',
                    rejected: 'rejected'
                }
            };
        },
        created() {
            this.approvedData()
            this.countReq()
            this.nurseData()
            this.reqData()
        },
        mounted() {
            setTimeout(() => {
                this.fullscreenLoading = false
            }, 1000)
        },
        watch: {
            searchValue(value) {
                if (value == "" || value == "identification" || value == "name" || value == "med_status" || value == "yearandsection") {
                    this.searchNull = '';
                    this.searchID = '';
                    this.searchName = '';
                    this.searchStatus = '';
                    this.searchYrandSect = '';
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
                        return data.med_status.toLowerCase().includes(this.searchStatus.toLowerCase());
                    })
                    .filter((data) => {
                        return data.yearandsection.toLowerCase().includes(this.searchYrandSect.toLowerCase());
                    })
                    .slice(this.pageSize * this.page - this.pageSize, this.pageSize * this.page)
            }
        },

        methods: {
            reqData() {
                axios.post("{{ route('countRequest') }}")
                    .then(response => {
                        console.log(response);
                        if (response) {
                            this.pendingReq = response.data.count;
                        } 
                    })
                    .catch(error => {
                        console.error(error.response);
                    });
            },
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
                this.searchStatus = ""
                this.searchYrandSect = ""
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
                axios.post("{{ route('fetchRequest') }}")
                    .then(response => {
                        console.log(response);
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
                axios.post("{{ route('countRequest') }}")
                    .then(response => {
                        this.reqCount = response.data;
                    })
                    .catch(error => {
                        console.error(error.response);
                    });
            },
            handleDone(index, row) {
                const doneReq = new FormData();
                doneReq.append('id', row.id)
                doneReq.append("med_status", "Done")
                axios.post("{{ route('doneReqStatus') }}", doneReq)
                    .then(response => {
                        if (response.data) {
                            this.loadButton = false;
                            this.tableLoad = true;
                            setTimeout(() => {
                                this.$message({
                                    message: 'Student appointment has been set to DONE!',
                                    type: 'success'
                                });
                                this.tableLoad = false;
                                this.approvedData()
                            }, 1500);
                        }
                    })
                    .catch(error => {
                        console.error(error.response.data);
                    });
            },
            handleApproved(index, row) {
                const approvedReq = new FormData();
                approvedReq.append('id', row.id)
                approvedReq.append('name', row.name)
                approvedReq.append('phone_number', row.phone_number)
                approvedReq.append('request_date', row.request_date)
                approvedReq.append("med_status", "Approved")
                axios.post("{{ route('approvedStatus') }}", approvedReq)
                    .then(response => {
                        if (response.data) {
                            this.loadButton = false;
                            this.tableLoad = true;
                            setTimeout(() => {
                                this.$message({
                                    message: 'Student appointment has been Approved!',
                                    type: 'success'
                                });
                                this.tableLoad = false;
                                this.approvedData()
                            }, 1500);
                        }
                    })
                    .catch(error => {
                        console.error(error.response.data);
                    });
            },
            handleRejected(index, row) {
                const declinedReq = new FormData();
                declinedReq.append('id', row.id)
                declinedReq.append('name', row.name)
                declinedReq.append('phone_number', row.phone_number)
                declinedReq.append('request_date', row.request_date)
                declinedReq.append("med_status", "Declined")
                axios.post("{{ route('rejectedStatus') }}", declinedReq)
                    .then(response => {
                        if (response.data) {
                            this.loadButton = false;
                            this.tableLoad = true;
                            setTimeout(() => {
                                this.$message({
                                    message: 'Student appointment has been Declined!',
                                    type: 'success'
                                });
                                this.tableLoad = false;
                                this.approvedData()
                            }, 1500);
                        }
                    })
                    .catch(error => {
                        console.error(error.response.data);
                    });
            },
            logout() {
                this.fullscreenLoading = true
                axios.post("{{ route('nurseLogout') }}")
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
                                window.location.href = "{{ route('student-login') }}"
                            }, 1000)
                        }
                    })
            }
        },
    });
</script>
