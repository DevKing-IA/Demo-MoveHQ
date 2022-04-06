<template>
    <div class="col-md-12">
        <div class="card card-container">
            <div class="row justify-content-center">
                <h3>Log in</h3>
            </div>
            <Form @submit="handleLogin" :validation-schema="schema">
                <div class="form-group">
                    <label for="email">Email</label>
                    <Field
                        name="email"
                        type="email"
                        class="form-control"
                        autocomplete=""
                    />
                    <ErrorMessage name="email" class="error-feedback" />
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <Field
                        name="password"
                        type="password"
                        class="form-control"
                        autocomplete="current-password"
                    />
                    <ErrorMessage name="password" class="error-feedback" />
                </div>

                <div class="form-group">
                    <button
                        class="btn btn-primary btn-block"
                        :disabled="loading"
                    >
                        <span
                            v-show="loading"
                            class="spinner-border spinner-border-sm"
                        ></span>
                        <span>Submit</span>
                    </button>
                </div>

                <div class="form-group">
                    <div v-if="message" class="alert alert-danger" role="alert">
                        {{ message }}
                    </div>
                </div>
            </Form>
        </div>
    </div>
</template>

<script>
import { Form, Field, ErrorMessage } from "vee-validate";
import * as yup from "yup";
import { ref } from "@vue/reactivity";
import { useStore } from "vuex";
import { useRouter } from 'vue-router';

export default {
    name: "Login",
    components: {
        Form,
        Field,
        ErrorMessage,
    },
    setup() {
        const schema = yup.object().shape({
            email: yup.string().required("Email is required!"),
            password: yup.string().required("Password is required!"),
        });
        let loading = ref(false);
        let message = ref("");
        let store = useStore();
        let router = useRouter();

        const handleLogin = (user) => {
            loading.value = true;

            store.dispatch("auth/login", user).then(
                () => {
                    router.push("/");
                },
                (error) => {
                    loading.value = false;
                    message.value =
                        (error.response &&
                            error.response.data &&
                            error.response.data.message) ||
                        error.message ||
                        error.toString();
                }
            );
        };

        return {
            loading,
            message,
            schema,
            handleLogin
        };
    },
    computed: {
        loggedIn() {
            console.log(this.$store.state.auth.loggedIn);
            return this.$store.state.auth.loggedIn;
        },
    },
    created() {
        if (this.loggedIn) {
            this.$router.push("/profile");
        }
    },
};
</script>

<style scoped>
label {
    display: block;
    margin-top: 10px;
}

.card-container.card {
    max-width: 350px !important;
    padding: 40px 40px;
}

.card {
    background-color: #f7f7f7;
    padding: 20px 25px 30px;
    margin: 0 auto 25px;
    margin-top: 50px;
    -moz-border-radius: 2px;
    -webkit-border-radius: 2px;
    border-radius: 2px;
    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
}

.profile-img-card {
    width: 96px;
    height: 96px;
    margin: 0 auto 10px;
    display: block;
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    border-radius: 50%;
}

.error-feedback {
    color: red;
}
</style>
