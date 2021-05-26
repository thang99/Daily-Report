<template>
    <div class="row align-items-center">
        <div class="col-lg-6">
            <h2 class="mb-2">Sign In</h2>
            <p>To Keep connected with us please login with your personal info.</p>
            <form @submit.prevent="loginForm" method="post">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="floating-label form-group">

                            <input
                                class="floating-input form-control"
                                name="email" v-model="form.email" value="" autocomplete="email"
                                autofocus
                                type="email" placeholder=" ">

                            <label>Email</label>
                            <span class="text-danger mt-2" v-if="errors && errors.email">
                        {{ errors.email[0] }}   </span>
                        </div>

                    </div>
                    <div class="col-lg-12">
                        <div class="floating-label form-group">
                            <input class="floating-input form-control" v-model="form.password" name="password"
                                   type="password"
                                   placeholder=" ">
                            <label>Password</label>
                            <span class="text-danger mt-2"
                                  v-if="errors && errors.password">
                        {{ errors.password[0] }}   </span>
                        </div>


                    </div>


                </div>
                <button type="submit" class="btn btn-primary">Sign In</button>
                <p class="mt-3">
                    Or login with
                </p>
                <a class="google-plus" href="/login/google"> <i
                    class="lab la-google-plus-square font-size-50  text-danger"></i></a>
                <!--                <a class="facebook" href=""> <i class="lab la-facebook-square font-size-50  text-primary">-->
                <!--                    -->
                <!--                </i></a>-->

            </form>
        </div>
        <div class="col-lg-6 mb-lg-0 mb-4 mt-lg-0 mt-4">
            <img src="web_assets/images/login/01.png" class="img-fluid w-80" alt="">
        </div>
    </div>
</template>

<script>
export default {
    name: "Login",
    data() {
        return {
            form: {},
            errors: {},
            success: false,
        }
    },
    methods: {
        loginForm() {
            axios.post('/login', this.form)
                .then((res) => {
                    if (res.data.data.url) {
                        window.location.href = res.data.data.url
                    }
                })
                .catch((errors) => {
                    if (errors && errors.response.status == 422) {
                        this.errors = errors.response.data.errors;
                    }
                });
        }
    },
}
</script>

<style scoped>

</style>
