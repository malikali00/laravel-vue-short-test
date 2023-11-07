<template>

    <div class="wrapper">
        <Sidebar />
        <Header />
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>150</h3>
                                    <p>Company</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <router-link to="/company" class="small-box-footer">
                                    More info <i class="fas fa-arrow-circle-right"></i>
                                </router-link>
                            </div>
                        </div>

                        <div class="col-lg-6 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>44</h3>
                                    <p>Employee</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <router-link to="/employee" class="small-box-footer">
                                    More info <i class="fas fa-arrow-circle-right"></i>
                                </router-link>

                            </div>
                        </div>

                    </div>

                </div>
            </section>
        </div>
    </div>

</template>

<script>
import Header from "../views/ui/Header.vue";
import Sidebar from "../views/ui/Sidebar.vue";

import { useRouter } from "vue-router"
import { useStore } from 'vuex'

export default{
    components: {Sidebar, Header},
    setup(){
        const router = useRouter();
        const store = useStore();

        function logout(){
            store.dispatch('removeToken');
            router.push({name:'Home'})
        }

        return {
            logout
        }
    }
}
</script>
