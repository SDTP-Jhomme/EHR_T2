
import { Field, Form, ErrorMessage, defineRule } from "vee-validate";
import { required, email } from "@vee-validate/rules";
import { configure } from "vee-validate";

// ...

configure({
    // Here you can provide configuration options for VeeValidate
});

defineRule("required", required);
defineRule("email", email);
import Vue from 'vue';
import router from './router';

const app = new Vue({
    el: '#app',
    router
});
