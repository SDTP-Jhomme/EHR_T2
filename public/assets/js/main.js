import { createApp } from 'vue';
import { Field, Form, ErrorMessage, defineRule, configure } from 'vee-validate';
import { required, email } from '@vee-validate/rules';

defineRule('required', required);
defineRule('email', email);

const app = createApp(App);
app.component('Field', Field);
app.component('Form', Form);
app.component('ErrorMessage', ErrorMessage);

// Configure VeeValidate
configure({
  validateOnInput: true,
});

app.mount('#app');
