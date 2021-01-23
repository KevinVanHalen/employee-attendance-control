<template>
    <div>
        <template v-if="!currentUser">
            
        </template>
        <template v-else>
            <menu-control-asistencia></menu-control-asistencia>
        </template>
    </div>
</template>

<script>
import MenuControlAsistencia from './MenuControlAsistencia'

export default {
    name: 'app-header',
    components: {
        MenuControlAsistencia
    },
    computed: {
        currentUser() {
            return this.$store.getters.getUser
        }
    }
}
</script>