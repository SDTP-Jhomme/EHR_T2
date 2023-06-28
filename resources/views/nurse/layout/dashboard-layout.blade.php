<title>@yield('title')</title>
@include('nurse/imports/body')
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
                fullscreenLoading: true,
                profile: false,
                fetchData:[],
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
            this.nurseData()

        },
        mounted() {
            this.getDataByMonth();
            this.getChartData();
            setTimeout(() => {
                this.fullscreenLoading = false
            }, 1000)
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