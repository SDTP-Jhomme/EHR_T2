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
                isAntigen: [],
                isCbc: [],
                isUrinalysis: [],
                isXray: [],
                isFecalysis: [],
                isVaccine: [],
                isCbc:[],
                antigenSect:[],
                viewStudent:[],
                student_data:[],
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
            this.getID()
            this.getData()
            this.fetchAntigen()
            this.fetchCbc()
            this.fetchUrinalysis()
            this.fetchFecalysis()
            this.fetchVaccine()
            this.fetchXray()
        },
        mounted() {
            setTimeout(() => {
                this.fullscreenLoading = false
            }, 2000)
        },
        methods: {
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
            fetchXray() {
                axios.post("{{route('fetchXray')}}")
                    .then(response => {
                        console.log(response.data);
                        if (response) {
                            this.isXray = response.data;
                        } else {
                            console.error(500);
                        }
                    })
                    .catch(error => {
                        console.error(error.response.data);
                    });
            },
            fetchVaccine() {
                axios.post("{{route('fetchVaccine')}}")
                    .then(response => {
                        if (response) {
                            this.isVaccine = response.data;
                        } else {
                            console.error(500);
                        }
                    })
                    .catch(error => {
                        console.error(error.response.data);
                    });
            },
            fetchFecalysis() {
                axios.post("{{route('fetchFecalysis')}}")
                    .then(response => {
                        if (response) {
                            this.isFecalysis = response.data;
                        } else {
                            console.error(500);
                        }
                    })
                    .catch(error => {
                        console.error(error.response.data);
                    });
            },
            fetchUrinalysis() {
                axios.post("{{route('fetchUrinalysis')}}")
                    .then(response => {
                        if (response) {
                            this.isUrinalysis = response.data;
                        } else {
                            console.error(500);
                        }
                    })
                    .catch(error => {
                        console.error(error.response.data);
                    });
            },
            fetchAntigen() {
                axios.post("{{route('fetchAntigen')}}")
                    .then(response => {
                        if (response) {
                            this.isAntigen = response.data;
                        } else {
                            console.error(500);
                        }
                    })
                    .catch(error => {
                        console.error(error.response.data);
                    });
            },
            fetchCbc() {
                axios.post("{{route('fetchCbc')}}")
                    .then(response => {
                        console.log(response.data);
                        if (response) {
                            this.isCbc = response.data;
                        } else {
                            console.error(500);
                        }
                    })
                    .catch(error => {
                        console.error(error.response.data);
                    });
            },
            getData() {
                axios.post("{{route('fetchStudent')}}")
                    .then(response => {
                        if (response.data.error) {
                            this.tableData = [];
                        } else {
                            this.student_data = response.data;
                            this.tableData = response.data;
                            console.log(this.tableData);
                            this.checkIdentification = response.data.map(res => res.identification);
                        }
                    })
                    .catch(error => {
                        console.error(error.response);
                    });
            },
            getID() {
                axios.post("{{route('department-fetch')}}")
                    .then(response => {
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