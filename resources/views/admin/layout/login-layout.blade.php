<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="<?php echo asset('storage/assets/css/style.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo asset('storage/assets/css/bootstrap.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo asset('storage/assets/fontawesome/css/all.min.css') ?>">
<link rel="shortcut icon" type="image/x-icon" href="<?php echo asset('storage/assets/fontawesome/svgs/regular/credit-card.svg') ?>"><!-- CSS -->
<title>@yield('title')</title>

@yield('content')
<script src="<?php echo asset('storage/assets/js/bootstrap.bundle.js') ?>"></script>
<script src="<?php echo asset('storage/assets/js/main.js') ?>"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function showPassword() {
        var passwordField = document.getElementById("password");
        var passwordToggle = document.querySelector("#password + button i");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            passwordToggle.classList.remove("fa-eye");
            passwordToggle.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            passwordToggle.classList.remove("fa-eye-slash");
            passwordToggle.classList.add("fa-eye");
        }
    }

    function login() {
        // Get the form and input elements
        const loginForm = document.getElementById("login-form");
        const usernameInput = document.getElementById("username");
        const passwordInput = document.getElementById("password");
        const usernameError = document.getElementById("username-error");
        const passwordError = document.getElementById("password-error");
        const screenLoading = document.getElementById("fullscreen-loading");

        // Add an event listener to the form submission
        loginForm.addEventListener("submit", (e) => {
            e.preventDefault();

            // Get the username and password values
            const username = usernameInput.value;
            const password = passwordInput.value;

            // Create an object with the username and password
            const data = {
                username: username,
                password: password
            };

            // Make an AJAX request using Axios
            axios
                .post(loginForm.action, data)
                .then((response) => {
                    const responseData = response.data;
                    console.log(responseData);

                    // Check for errors in the response
                    if (responseData.error) {
                        if (responseData.adminErr) {
                            usernameError.innerHTML = responseData.adminErr;
                            usernameError.style.display = "flex";
                            setTimeout(() => {
                                usernameError.innerHTML = "";
                                usernameError.style.display = "none";
                            }, 2000);
                            console.log(responseData.adminErr);
                        }
                        if (responseData.passErr) {
                            passwordError.innerHTML = responseData.passErr;
                            passwordError.style.display = "flex";
                            setTimeout(() => {
                                passwordError.innerHTML = "";
                                passwordError.style.display = "none";
                            }, 2000);
                        }
                    } else {
                        // Login successful, redirect to the dashboard or perform other actions
                        window.location.href = "{{ route('admin-dashboard') }}";
                        // screenLoading.classList.add("show-loading");
                        // setTimeout(() => {
                        //     window.location.href = "{{ route('admin-dashboard') }}";
                        //     screenLoading.classList.remove("show-loading");
                        // }, 2000);
                    }
                })
                .catch((error) => {
                    console.log(error);
                    // Handle error
                });
        });
    }
</script>