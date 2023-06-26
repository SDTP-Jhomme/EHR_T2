<title>@yield('title')</title>
@include('nurse/imports/body')
<script>
    ELEMENT.locale(ELEMENT.lang.en);
    new Vue({
        el: '#app',
        data() {
            return {
                fullscreenLoading: true,
                cbcCount:"",
                countAntigen:"",
                countXray:"",
                countfecal:"",
                countUrine:"",
                countVaccine:"",
                jan: {},
                feb: {},
                mar: {},
                apr: {},
                may: {},
                jun: {},
                jul: {},
                aug: {},
                sep: {},
                oct: {},
                nov: {},
                dec: {}
            };
        },
        created() {
            this.getCbc()
            this.getAntigen()
            this.getXray()
            this.getFecal()
            this.getUrine()
            this.getVaxx()

        },
        mounted() {
            this.getDataByMonth();
            this.getChartData();
            setTimeout(() => {
                this.fullscreenLoading = false
            }, 1000)
        },
        methods: {
            getCbc() {
                axios.post("{{route('countCbc')}}")
                    .then(response => {
                        this.cbcCount = response.data;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            getAntigen() {
                axios.post("{{route('countAntigen')}}")
                    .then(response => {
                        this.countAntigen = response.data;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            getXray() {
                axios.post("{{route('countXray')}}")
                    .then(response => {
                        this.countXray = response.data;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            getFecal() {
                axios.post("{{route('countfecal')}}")
                    .then(response => {
                        this.countfecal = response.data;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            getUrine() {
                axios.post("{{route('countUrine')}}")
                    .then(response => {
                        this.countUrine = response.data;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            getVaxx() {
                axios.post("{{route('countVaccine')}}")
                    .then(response => {
                        this.countVaccine = response.data;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            getDataByMonth() {
                axios.get("{{ route('getDataByMonth') }}")
                    .then(response => {
                    const data = response.data.total;
                    this.renderChart(data);
                    console.log(data);
                    })
                    .catch(error => {
                    console.error(error.response.data);
                    });
                },
                renderChart(data) {
                const monthNames = [
                    'January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'October', 'November', 'December'
                ];
                const months = monthNames;
                const counts = new Array(12).fill(0); // Initialize an array of counts with zeros

                // Populate counts for available months from the response
                data.forEach(item => {
                    counts[item.month - 1] = item.count;
                });

                const chartData = {
                    labels: months,
                    datasets: [
                    {
                        label: 'Monthly Registered Students',
                        data: counts,
                        backgroundColor: 'rgba(121, 113, 234, 0.757)',
                        borderColor: 'rgba(121, 113, 234, 0.757)',
                        borderWidth: 1,
                    }
                    ],
                    options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                        beginAtZero: true,
                        // Configure the y-axis options such as ticks, labels, etc.
                        },
                        x: {
                        grid: {
                            display: false
                        },
                        offset: true,
                        ticks: {
                            autoSkip: false,
                            maxRotation: 0,
                            minRotation: 0
                        }
                        }
                    },
                    plugins: {
                        legend: {
                        display: false
                        }
                    },
                    layout: {
                        padding: {
                        left: 10,
                        right: 10,
                        top: 10,
                        bottom: 10
                        }
                    },
                    barPercentage: 1, // Adjust the width of bars (value between 0 and 1)
                    categoryPercentage: 0.9
                    }
                };
                const ctx = this.$refs.chartCanvas.getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: chartData,
                    options: {
                    responsive: true,
                    maintainAspectRatio: false
                    }
                });
            },
            getChartData() {
                axios.get("{{ route('getChartData') }}")
                    .then(response => {
                        const data = response.data;
                        this.renderPie(data);
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            renderPie(data) {
                const ctx = this.$refs.chartPie.getContext('2d');
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: data.labels,
                        datasets: [
                            {
                                data: data.values,
                                backgroundColor: data.colors
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            },
            logout() {
                this.fullscreenLoading = true
                axios.post("{{route('nurse-logout')}}")
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