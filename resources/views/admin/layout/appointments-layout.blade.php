@include('admin/imports/head')
<title>@yield('title')</title>
<div id="app">
    <div v-if="fullscreenLoading" class="fullscreen-loading">
        <div class="spinner-heart" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <span class="spinner-text">Loading...</span>
    </div>
@include('admin/imports/nav')
    @yield('header')
    <!-- sidebar -->
    <div class="container-fluid page-wrapper">
@include('admin/imports/sidebar')
        @yield('sidebar')
    </div>
</div>
@include('admin/imports/body')

<script>
    // Vue.use(ElementUI, { locale: 'en' });
    // console.log(Vue);
    ELEMENT.locale(ELEMENT.lang.en);
    new Vue({
        el: '#app',
        data() {
            return {
                fullscreenLoading: true,
                page: 1,
                pageSize: 10,
                topLabel: "top",
                leftLabel: "left",
                direction: 'btt',
                loadButton: false,
                status: true,
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
                    }, {
                        value: 'status',
                        label: 'Status'
                    }],
                tableData: [],
                tableLoad: false,
            };
        },
        created() {
            this.getData()
        },
        mounted() {
            this.getData();
            setTimeout(() => {
                this.fullscreenLoading = false
            }, 1000)
        },
            watch: {
                searchValue(value) {
                    if (value == "" || value == "identification" || value == "name" || value == "status") {
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
                        return data.section.toLowerCase().includes(this.searchID.toLowerCase());
                    })
                    .filter((data) => {
                        return data.status.toLowerCase().includes(this.searchContact.toLowerCase());
                    })
                    .slice(this.pageSize * this.page - this.pageSize, this.pageSize * this.page)
            }
        },

        methods: {
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
            getData() {
                axios.post("{{route('fetchStudent')}}")
                    .then(response => {
                        console.log(response.data);
                        if (response.data.error) {
                            this.tableData = [];
                            this.tableDataErr = response.data.error;
                            console.log(this.tableDataErr);
                        } else {
                            this.tableData = response.data;
                            this.checkIdentification = response.data.map(res => res.identification);
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
        },
    });
</script>