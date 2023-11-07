<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 800px;">
        <a href="#" class="brand-link">

            <span class="brand-text font-weight-light">AdminPanel</span>
        </a>
        <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition" style="">

            <div class="os-content-glue" ></div>
            <div class="os-padding">
                <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
                    <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
                        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                            <div class="image">
                                <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                            </div>
                            <div class="info">
                                <a href="#" class="d-block">Admin</a>
                            </div>
                        </div>

                        <nav class="mt-2">
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                <li class="nav-item menu-open" >
                                    <router-link to="/dashboard" class="nav-link" :class="{ active: activeTab === 'Dashboard' }">
                                        <i class="nav-icon fas fa-tachometer-alt"></i>
                                        <p> Dashboard </p>
                                    </router-link>
                                </li>
                                <li class="nav-item" >
                                    <router-link to="/company" class="nav-link" :class="{ active: (activeTab === 'Company' || activeTab === 'AddCompany' || activeTab === 'EditCompany' ) }">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p> Companies </p>
                                    </router-link>
                                </li>

                                <li class="nav-item" >
                                    <router-link to="/employee" class="nav-link" :class="{ active: (activeTab === 'Employee' || activeTab === 'AddEmployee' || activeTab === 'EditEmployee') }">
                                        <i class="nav-icon fas fa-user"></i>
                                        <p> Employee </p>
                                    </router-link>
                                </li>

                                <li class="nav-item">
                                    <router-link to="/logout" class="nav-link" @click="logout">
                                        <i class="nav-icon fas fa-sign-out-alt"></i>
                                        <p> Logout </p>
                                    </router-link>
                                </li>

                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

        </div>
    </aside>
</template>

<script>

import { useRouter } from "vue-router";
import { useStore } from 'vuex';
import { computed  } from 'vue';

export default{
    setup(){
        const router = useRouter();
        const store = useStore();

        const activeTab = computed(() => {
            const routeName = router.currentRoute.value.name;
            console.log('Current Route Name:', routeName);
            return routeName;
        });
        function logout(){
            store.dispatch('removeToken');
            router.push({name:'Login'})
        }

        return {
            activeTab,
            logout
        }
    }
}
</script>
