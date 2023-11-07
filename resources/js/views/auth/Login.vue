<template>

    <div class="container">
        <div class="row justify-content-center">
            <div class="login-box">
                <div class="login-logo">
                    <a href="#"><b>Admin</b>LTE</a>
                </div>

                <div class="card">
                    <p class="text-danger text-center" v-if="error">{{ error }}</p>
                    <div class="card-body login-card-body">
                        <p class="login-box-msg">Sign in to start your session</p>
                        <form  @submit.prevent="login">
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" placeholder="Email" v-model="form.email">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" placeholder="Password" v-model="form.password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block" @click.prevent="login">Sign In</button>
                                </div>

                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>


    </div>
</template>

<script>
import { reactive,ref } from 'vue'
import { useRouter } from "vue-router"
import { useStore } from 'vuex'
import axios from 'axios'; // Import Axios
export default{
    setup(){
        const router = useRouter()
        const store = useStore()

        let form = reactive({
            email: '',
            password: ''
        });
        let error = ref('')

        const login = async() =>{
            await axios.post('/api/login',form).then(res=>{
                if(res.data.success){
                    store.dispatch('setToken',res.data.data.token);
                    router.push({name:'Dashboard'})
                }else{
                    error.value = res.data.message;
                }
            })
        }
        return{
            form,
            login,
            error
        }
    }
}
</script>

