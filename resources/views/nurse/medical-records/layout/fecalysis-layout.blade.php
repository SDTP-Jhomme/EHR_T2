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
                viewStudent:[],
                isFecalysis:[],
                viewDialog:false,
                studentData:[],
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
            this.fetchData()
        },
        mounted() {
            setTimeout(() => {
                this.fullscreenLoading = false
            }, 2000)
            if (window.location.pathname !== " /medical-records/fecalysis") {
                localStorage.clear()
                this.backToHome = true;
            }
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
            getData() {
                axios.post("{{route('fetchFecalysis')}}")
                    .then(response => {
                        if (response.data.error) {
                            this.tableData = [];
                        } else {
                            this.isFecalysis = response.data;
                            this.tableData = response.data;
                            this.checkIdentification = response.data.map(res => res.identification);
                        }
                    })
                    .catch(error => {
                        console.error(error.response);
                    });
            },
            fetchData() {
                axios.post("{{route('fetchStudent')}}")
                    .then(response => {
                        if (response) {
                            this.studentData = response.data;
                            console.log(this.studentData);
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
                                    window.location.href = "{{route('department-login')}}"
                                }, 1000)
                            }
                        })
                },
        },
    });
</script>