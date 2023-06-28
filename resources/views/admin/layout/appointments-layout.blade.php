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
                reqDialog: false,
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
        },
        mounted() {
            setTimeout(() => {
                this.fullscreenLoading = false
            }, 1000)
        },
        watch: {
            searchValue(value) {
                if (value == "" || value == "identification" || value == "name" || value == "med_status" ||
                    value == "yearandsection") {
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
                        return data.yearandsection.toLowerCase().includes(this.searchYrandSect
                        .toLowerCase());
                    })
                    .slice(this.pageSize * this.page - this.pageSize, this.pageSize * this.page)
            }
        },

        methods: {
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
        },
    });
</script>
