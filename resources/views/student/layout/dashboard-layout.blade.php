<title>@yield('title')</title>
<script>
    ELEMENT.locale(ELEMENT.lang.en);
    new Vue({
        el: '#app',
        data() {
            return {
                datePickerOptions: {
                    disabledDate(date) {
                        return date < new Date()
                    }
                },
                cbcResult:false,
                antigenResult:false,
                vaxxResult:false,
                urineResult:false,
                xrayResult:false,
                fecalResult:false,
                fullscreenLoading: true,
                loadButton: false,
                openAppointmentDialog:false,
                student_data: [],
                avatar:"",
                error:true,
                id:"",
                isAntigen: [],
                isCbc: [],
                isUrinalysis: [],
                isXray: [],
                isFecalysis: [],
                isVaccine: [],
                backToHome:false,
                dialogVisible:false,
                medOptions: [{
                value: 'Heppa B Antigen',
                label: 'Heppa B Antigen'
                }, {
                value: 'Heppa B Vaccine',
                label: 'Heppa B Vaccine'
                }, {
                value: 'Urinalysis',
                label: 'Urinalysis'
                }, {
                value: 'Fecalysis',
                label: 'Fecalysis'
                }, {
                value: 'Chest X-ray',
                label: 'Chest X-ray'
                },{
                value: 'Complete Blood Count',
                label: 'Complete Blood Count'
                }],
                request:{
                    appointment:"",
                    date:null
                }
            };
        },
        computed: {
        },
        created() {
            this.getID()
            this.fetchCbc()
            this.fetch_Antigen()
            this.fetch_Urinalysis()
            this.fetch_Xray()
            this.fetch_Fecalysis()
            this.fetch_Vaccine()
        },
        mounted() {
            this.getID();
            setTimeout(() => {
                this.fullscreenLoading = false
            }, 2000)
        },
        methods: {
            fetchCbc() {
                axios.post("{{route('fetch_Cbc')}}")
                    .then(response => {
                        console.log(response);
                        if (response) {
                            this.isCbc = response.data;
                        }
                    })
                    .catch(error => {
                        console.error(error.response);
                    });
            },
            fetch_Antigen() {
                axios.post("{{route('fetch_Antigen')}}")
                    .then(response => {
                        console.log(response);
                        if (response) {
                            this.isAntigen = response.data;
                        }
                    })
                    .catch(error => {
                        console.error(error.response);
                    });
            },
            fetch_Urinalysis() {
                axios.post("{{route('fetch_Urinalysis')}}")
                    .then(response => {
                        if (response) {
                            this.isUrinalysis = response.data;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            fetch_Xray() {
                axios.post("{{route('fetch_Xray')}}")
                    .then(response => {
                        if (response) {
                            this.isXray = response.data;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            fetch_Fecalysis() {
                axios.post("{{route('fetch_Fecalysis')}}")
                    .then(response => {
                        if (response) {
                            this.isFecalysis = response.data;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            fetch_Vaccine() {
                axios.post("{{route('fetch_Vaccine')}}")
                    .then(response => {
                        if (response) {
                            this.isVaccine = response.data;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            getID() {
                axios.post("{{route('student-fetch')}}")
                    .then(response => {
                        if (response) {
                            this.student_data = response.data;
                            this.avatar = response.data[0].avatar;
                            this.id = response.data[0].id;
                        } else {
                            console.error(500);
                        }
                })
                .catch(error => {
                    console.error(error.response);
                });
            },
            reqAppointment(request){
                if(this.request.appointment == ""){
                    this.$message.error("Please select atleast one appointment to proceed!")
                    this.error =true;
                }else if(this.request.date == null){
                    this.$message.error("Please set your date and time for request!")
                    this.error =true;
                }
                else{
                    this.loadButton = true;
                    const appointment = new Date(this.request.date);
                    const hour = appointment.getHours();
                    const minute = appointment.getMinutes();
                    const amPm = hour >= 12 ? 'PM' : 'AM';
                    const hour12 = hour % 12 || 12;
                    const appointmentFormat = appointment.getFullYear() + "-" + ((appointment.getMonth() + 1) > 9 ? '' : '0') + (appointment.getMonth() + 1) + "-" + (appointment.getDate() > 9 ? '' : '0') + appointment.getDate()+
                    ' ' +
                    (hour12 > 9 ? '' : '0') +
                    hour12 +
                    ':' +
                    (minute > 9 ? '' : '0') +
                    minute +
                    ' ' +
                    amPm;

                    var newData = new FormData()
                    newData.append("student_id", this.id)
                    newData.append("section", this.request.appointment);
                    newData.append("request_date", appointmentFormat);
                    axios.post("{{route('storeReq')}}", newData)
                        .then(response => {
                            if (response.data) {
                                this.tableLoad = true;
                                setTimeout(() => {
                                    this.$message({
                                        message: 'Your Request has been sent successfully!',
                                        type: 'success'
                                    });
                                    this.tableLoad = false;
                                    this.getID();
                                    setTimeout(() => {
                                        this.openAppointmentDialog = false
                                    }, 500)
                                }, 1500);
                                this.resetFormData();
                                this.loadButton = false
                            }
                        })
                        .catch(error => {
                            console.error(error.response);
                        });
                }
            },
            resetFormData() {
                this.request = []
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
            }
        },
    });
</script>